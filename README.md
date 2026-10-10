# Tasker — Tasks for Today Management System (TSA2)

[![Framework](https://img.shields.io/badge/Framework-CodeIgniter%204.7-EF4444?style=flat-square&logo=codeigniter&logoColor=white)](https://codeigniter.com/)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat-square&logo=php&logoColor=white)](https://www.php.net/)
[![Database](https://img.shields.io/badge/Database-MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Tests](https://img.shields.io/badge/Tests-PHPUnit%2010-38B2AC?style=flat-square&logo=php&logoColor=white)](tests/)
[![License](https://img.shields.io/badge/License-MIT-blue?style=flat-square)](LICENSE)

**Tasker** is a secure, full-stack personal task management web application built with **CodeIgniter 4** and **MySQL**. Developed for **IT0049 (Web System Technologies) — Technical Summative Assessment 2 (TSA2)**, this system extends the TSA1 foundation to production-grade standards with **full CRUD workflows**, **session authentication**, **strict form validation**, **controller access filters**, and **soft deletion (archiving)**.

---

## 1. Assessment & Grading Rubrics Mapping

| Rubric Criteria | Points | Implementation Details |
| :--- | :---: | :--- |
| **Functionality & Requirements Completeness** | 35 | • Publicly accessible pages: Welcome (`/`), Task List (`/tasks`), Profile (`/profile`), About (`/about`).<br>• Authentication: Login (`/login`) with credential verification and Logout (`/logout`).<br>• Full CRUD: Create Task (`/tasks/new`), Edit Task (`/tasks/(:num)/edit`), Soft Delete (`/tasks/(:num)/delete`).<br>• Soft deletion flag (`is_archived`) safely archives records without row loss, excluding archived tasks from Welcome and Task List. |
| **Code Structure & Organization** | 20 | • Strict adherence to CodeIgniter 4 MVC conventions.<br>• Clean separation across `App\Controllers` (`Welcome`, `Tasks`, `Profile`, `About`, `Auth`), `App\Models` (`TaskModel`, `UserModel`), `App\Filters` (`AuthFilter`), and `App\Views`.<br>• Type-hinted methods, clean dependency injection, and helper scopes. |
| **Validation & Security** | 25 | • Form validation for task creation and editing (`title` required, `task_date` required).<br>• Form validation on login (`username`, `password` required).<br>• Passwords stored using `password_hash()` and verified with `password_verify()`.<br>• `AuthFilter` reliably restricts management actions and redirects unauthenticated requests to `/login` with flash error feedback.<br>• CSRF tokens (`csrf_field()`) on all state-mutating forms and output sanitization via `esc()`. |
| **Documentation & Submission Quality** | 20 | • Complete, structured GitHub repository.<br>• Comprehensive documentation covering prerequisites, local setup, test execution, and deployment.<br>• Exported SQL schema (`tasker.sql`) + database migrations and seeders.<br>• 26 automated unit and feature tests covering 100% of workflows.<br>• Automated deployment packaging script (`build-infinityfree-zip.sh`). |

---

## 2. Demo Credentials

| Role | Username | Password | Access Rights |
| :--- | :--- | :--- | :--- |
| **Demo Staff** | `charles` | `TaskerDemo!2026` | Full CRUD access to create, edit, update, and archive tasks |
| **Visitor / Guest** | *(None)* | *(None)* | Read-only public access to Welcome, Task List, Profile, About |

*Note: Passwords are automatically hashed in `tasker.sql` and the seeders via PHP's `PASSWORD_DEFAULT` (Bcrypt).*

---

## 3. Routes & Access Control Reference

| Method | Route | Controller & Method | Access Level | Description |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/` | `App\Controllers\Welcome::index` | **Public** | Dashboard rendering active tasks scheduled for today |
| `GET` | `/tasks` | `App\Controllers\Tasks::index` | **Public** | Complete directory of active tasks (actions hidden for guests) |
| `GET` | `/profile` | `App\Controllers\Profile::index` | **Public** | User account profile information |
| `GET` | `/about` | `App\Controllers\About::index` | **Public** | Application description and technical overview |
| `GET` | `/login` | `App\Controllers\Auth::login` | **Public** | Staff login form |
| `POST` | `/login` | `App\Controllers\Auth::attempt` | **Public** | Credential authentication & session creation |
| `POST` | `/logout` | `App\Controllers\Auth::logout` | **Protected** (`auth`) | Session destruction & redirect to login |
| `GET` | `/tasks/new` | `App\Controllers\Tasks::new` | **Protected** (`auth`) | Render new task creation form |
| `POST` | `/tasks` | `App\Controllers\Tasks::create` | **Protected** (`auth`) | Validate and persist newly created task |
| `GET` | `/tasks/(:num)/edit` | `App\Controllers\Tasks::edit/$1` | **Protected** (`auth`) | Render task edit form pre-populated with record |
| `POST` | `/tasks/(:num)` | `App\Controllers\Tasks::update/$1` | **Protected** (`auth`) | Validate and update existing task |
| `POST` | `/tasks/(:num)/delete` | `App\Controllers\Tasks::delete/$1` | **Protected** (`auth`) | Soft-delete (archive) task by setting `is_archived = 1` |

---

## 4. Database Architecture

### Users Table (`users`)
| Column | Type | Constraints | Description |
| :--- | :--- | :--- | :--- |
| `id` | `INT` | Primary Key, Auto Increment | Unique user identifier |
| `username` | `VARCHAR(50)` | Not Null, Unique | Staff login handle |
| `full_name` | `VARCHAR(100)` | Not Null | User display name |
| `email` | `VARCHAR(100)` | Not Null | User contact email |
| `password` | `VARCHAR(255)` | Not Null | Hashed password (`PASSWORD_DEFAULT`) |
| `created_at` | `DATETIME` | Not Null | Account creation timestamp |

### Tasks Table (`tasks`)
| Column | Type | Constraints | Description |
| :--- | :--- | :--- | :--- |
| `id` | `INT` | Primary Key, Auto Increment | Unique task identifier |
| `title` | `VARCHAR(150)` | Not Null | Task description / title |
| `status` | `VARCHAR(20)` | Not Null, Default `'pending'` | Task status (`pending` or `completed`) |
| `task_date` | `DATE` | Not Null | Scheduled execution date |
| `is_archived` | `TINYINT(1)` | Not Null, Default `0` | Soft deletion flag (`0` = active, `1` = archived) |
| `created_at` | `DATETIME` | Not Null | Record creation timestamp |

---

## 5. Local Development Setup

### 5.1 Prerequisites
- **PHP 8.2 or higher** (with `intl`, `mbstring`, `mysqli`, `sqlite3` extensions enabled)
- **Composer 2.x**
- **MySQL or MariaDB** (via XAMPP, MAMP, or standalone)

### 5.2 Clone Repository & Install Dependencies
```bash
git clone https://github.com/aniciete/tsa2tasker.git Tasker
cd Tasker
composer install
```

### 5.3 Configure Environment File
Copy the example environment configuration:
```bash
cp env.example .env
```
Ensure your database credentials in `.env` match your local MySQL configuration:
```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = 127.0.0.1
database.default.database = tasker
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### 5.4 Import Database Schema & Demo Data
Import via MySQL CLI or phpMyAdmin:
```bash
mysql -u root -p tasker < tasker.sql
```
*Alternatively, run migrations and seeds via Spark:*
```bash
php spark migrate
php spark db:seed TaskerSeeder
```

### 5.5 Start Development Server
```bash
php spark serve
```
Open your browser and navigate to: `http://localhost:8080`

---

## 6. Running Automated Tests

The test suite runs using CodeIgniter 4's in-memory SQLite database (`:memory:`), providing fast, isolated execution without touching your live MySQL database:

```bash
vendor/bin/phpunit
```

### Test Coverage Highlights:
- **`AuthWorkflowTest`**:
  - Validates login form rendering and form attributes.
  - Asserts that protected task management routes (`/tasks/new`, `/tasks/1/edit`, `/tasks/1/delete`) redirect unauthenticated visitors to `/login` with flash error feedback.
  - Verifies invalid credential rejection and error message reporting.
  - Tests valid credential authentication, session regeneration, and privileged access.
  - Verifies that passwords in the database are stored as non-plaintext cryptographic hashes.
  - Tests logout session destruction and redirect to login.
- **`TaskWorkflowTest`**:
  - Verifies public access to Welcome, Task List, Profile, and About pages.
  - Asserts Welcome view only renders active tasks scheduled for today and excludes archived tasks.
  - Asserts Task List view renders all active tasks and excludes archived tasks.
  - Tests form validation failure on empty title and scheduled date.
  - Tests successful task creation and verified persistence with `is_archived = 0`.
  - Tests task edit form pre-population and record update.
  - Tests soft-deletion behavior: verifies `is_archived` is toggled to `1`, row remains preserved in the database table, and the task is immediately excluded from public views.
- **`ModelsTest`**:
  - Validates allowed fields, primary keys, and query scopes for `UserModel` and `TaskModel`.

---

## 7. Production Deployment (InfinityFree)

An automated packaging script is provided to generate a lean production distribution archive:

### 7.1 Build Archive
```bash
./build-infinityfree-zip.sh
```
This produces `tsa2-infinityfree.zip`, excluding test directories, dev tools, and dev vendor packages.

### 7.2 InfinityFree Steps
1. In VistaPanel, create your MySQL database (e.g. `if0_xxxx_tasker`).
2. Open phpMyAdmin and import `tasker.sql`.
3. In File Manager, navigate to `htdocs/`.
4. Upload `tsa2-infinityfree.zip` and extract its contents into `htdocs/`.
5. Update `.env` with your assigned InfinityFree MySQL host (`sqlXXX.infinityfree.com`), username, and password.
6. Verify live application at your hosted domain.

---

## 8. Author & Academic Information

- **Student**: Charles Lawrence Aniciete
- **Course**: IT0049 — Web System Technologies
- **Assessment**: Technical Summative Assessment 2 (TSA2)
- **Institution**: FEU Institute of Technology — College of Computer Studies and Multimedia Arts
- **GitHub**: [@aniciete](https://github.com/aniciete)
