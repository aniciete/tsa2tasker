<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\TaskModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\Database\Seeds\TaskerSeeder;

/**
 * @internal
 */
final class TaskWorkflowTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $seed = TaskerSeeder::class;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testPublicPagesAccessibleLoggedOut(): void
    {
        $welcome = $this->withSession([])->get('/');
        $welcome->assertOK();
        $welcome->assertSee('Welcome to Tasker!');

        $tasks = $this->withSession([])->get('tasks');
        $tasks->assertOK();
        $tasks->assertSee('All Tasks');

        $profile = $this->withSession([])->get('profile');
        $profile->assertOK();
        $profile->assertSee('Profile');

        $about = $this->withSession([])->get('about');
        $about->assertOK();
        $about->assertSee('About Tasker');
    }

    public function testWelcomeOnlyShowsTodayActiveTasks(): void
    {
        $result = $this->withSession([])->get('/');

        $result->assertOK();
        // Today active task present
        $result->assertSee('Buy groceries (milk, eggs, and bread)');
        $result->assertSee('Morning 30-minute jog in the park');

        // Archived task excluded
        $result->assertDontSee('Old archived task for testing soft deletion');

        // Other dates excluded from today
        $result->assertDontSee('Do laundry and fold clothes');
        $result->assertDontSee('Pay monthly electric and water bills');
    }

    public function testTaskListOnlyShowsActiveTasks(): void
    {
        $result = $this->withSession([])->get('tasks');

        $result->assertOK();
        // Active tasks from different dates present
        $result->assertSee('Buy groceries (milk, eggs, and bread)');
        $result->assertSee('Do laundry and fold clothes');
        $result->assertSee('Pay monthly electric and water bills');

        // Archived task excluded
        $result->assertDontSee('Old archived task for testing soft deletion');
    }

    public function testCreateTaskValidationRejectsMissingFields(): void
    {
        $result = $this->withSession([
            'user_id'   => 1,
            'username'  => 'charles',
            'full_name' => 'Charles Lawrence Aniciete',
        ])->post('tasks', [
            'title'     => '',
            'task_date' => '',
        ]);

        $result->assertRedirect();
        $this->assertNotNull(session()->getFlashdata('errors'));
    }

    public function testCreateTaskPersistsActiveRecord(): void
    {
        $today = date('Y-m-d');
        $result = $this->withSession([
            'user_id'   => 1,
            'username'  => 'charles',
            'full_name' => 'Charles Lawrence Aniciete',
        ])->post('tasks', [
            'title'     => 'Submit IT0049 TSA2 requirements',
            'task_date' => $today,
            'status'    => 'pending',
        ]);

        $result->assertRedirectTo(site_url('tasks'));
        $this->assertSame('Task created successfully.', session()->getFlashdata('message'));

        $taskModel = new TaskModel();
        $created   = $taskModel->where('title', 'Submit IT0049 TSA2 requirements')->first();

        $this->assertNotNull($created);
        $this->assertEquals(0, (int) $created['is_archived']);
        $this->assertSame('pending', $created['status']);
        $this->assertSame($today, $created['task_date']);
    }

    public function testEditTaskPrepopulatesAndUpdatesRecord(): void
    {
        $authSession = [
            'user_id'   => 1,
            'username'  => 'charles',
            'full_name' => 'Charles Lawrence Aniciete',
        ];

        // 1. Check edit form pre-population
        $editForm = $this->withSession($authSession)->get('tasks/1/edit');
        $editForm->assertOK();
        $editForm->assertSee('Buy groceries (milk, eggs, and bread)');

        // 2. Perform update
        $update = $this->withSession($authSession)->post('tasks/1', [
            'title'     => 'Buy organic groceries and fresh milk',
            'task_date' => date('Y-m-d'),
            'status'    => 'completed',
        ]);

        $update->assertRedirectTo(site_url('tasks'));
        $this->assertSame('Task updated successfully.', session()->getFlashdata('message'));

        $taskModel = new TaskModel();
        $updated   = $taskModel->find(1);

        $this->assertSame('Buy organic groceries and fresh milk', $updated['title']);
        $this->assertSame('completed', $updated['status']);
    }

    public function testSoftDeleteArchivesTaskInsteadOfRemovingRow(): void
    {
        $authSession = [
            'user_id'   => 1,
            'username'  => 'charles',
            'full_name' => 'Charles Lawrence Aniciete',
        ];

        $taskModel = new TaskModel();
        $target    = $taskModel->find(2);
        $this->assertNotNull($target);
        $this->assertEquals(0, (int) $target['is_archived']);

        // Execute soft delete action
        $delete = $this->withSession($authSession)->post('tasks/2/delete');
        $delete->assertRedirectTo(site_url('tasks'));
        $this->assertSame('Task archived successfully.', session()->getFlashdata('message'));

        // Row STILL exists in database table
        $archived = $taskModel->find(2);
        $this->assertNotNull($archived, 'Row must not be permanently deleted from table.');
        $this->assertEquals(1, (int) $archived['is_archived'], 'Flag is_archived must be set to 1.');

        // Verify it is excluded from public views
        $tasksView = $this->withSession([])->get('tasks');
        $tasksView->assertDontSee('Morning 30-minute jog in the park');

        $welcomeView = $this->withSession([])->get('/');
        $welcomeView->assertDontSee('Morning 30-minute jog in the park');
    }
}
