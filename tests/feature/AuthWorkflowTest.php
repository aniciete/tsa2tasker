<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\UserModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\Database\Seeds\TaskerSeeder;

/**
 * @internal
 */
final class AuthWorkflowTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $seed = TaskerSeeder::class;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withSession([]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testLoginPageRenders(): void
    {
        $result = $this->get('login');

        $result->assertOK();
        $result->assertSee('Staff Login');
        $result->assertSee('name="username"');
        $result->assertSee('name="password"');
    }

    public function testProtectedNewTaskRouteRedirectsLoggedOutUser(): void
    {
        $result = $this->get('tasks/new');

        $result->assertRedirectTo(site_url('login'));
        $this->assertSame('Please log in to manage tasks.', session()->getFlashdata('error'));
    }

    public function testProtectedEditTaskRouteRedirectsLoggedOutUser(): void
    {
        $result = $this->get('tasks/1/edit');

        $result->assertRedirectTo(site_url('login'));
        $this->assertSame('Please log in to manage tasks.', session()->getFlashdata('error'));
    }

    public function testProtectedDeleteTaskRouteRedirectsLoggedOutUser(): void
    {
        $result = $this->post('tasks/1/delete');

        $result->assertRedirectTo(site_url('login'));
        $this->assertSame('Please log in to manage tasks.', session()->getFlashdata('error'));
    }

    public function testInvalidCredentialsAreRejected(): void
    {
        $result = $this->post('login', [
            'username' => 'charles',
            'password' => 'wrong-password',
        ]);

        $result->assertRedirect();
        $this->assertNull(session()->get('user_id'));
        $this->assertSame('Invalid username or password.', session()->getFlashdata('error'));
    }

    public function testValidCredentialsCreateSessionAndAllowProtectedAccess(): void
    {
        $result = $this->post('login', [
            'username' => 'charles',
            'password' => 'TaskerDemo!2026',
        ]);

        $result->assertRedirectTo(site_url('/'));
        $this->assertSame(1, session()->get('user_id'));
        $this->assertSame('charles', session()->get('username'));
    }

    public function testSeededPasswordsAreStoredAsVerifiableHashes(): void
    {
        $user = (new UserModel())->where('username', 'charles')->first();

        $this->assertNotNull($user);
        $this->assertNotSame('TaskerDemo!2026', $user['password']);
        $this->assertTrue(password_verify('TaskerDemo!2026', $user['password']));
    }

    public function testLogoutDestroysSessionAndRedirectsToLogin(): void
    {
        $result = $this->withSession([
            'user_id'   => 1,
            'username'  => 'charles',
            'full_name' => 'Charles Lawrence Aniciete',
        ])->post('logout');

        $result->assertRedirectTo(site_url('login'));
        $this->assertSame('You have been logged out.', session()->getFlashdata('message'));

        $protected = $this->withSession([])->get('tasks/new');
        $protected->assertRedirectTo(site_url('login'));
    }
}
