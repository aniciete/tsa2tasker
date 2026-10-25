# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

Individual knowledge workers, team coordinators, and students tracking daily responsibilities, task deadlines, and status progressions. Users need fast task creation, status updates, soft-deletion recovery, and authenticated profile security.

## Product Purpose

Tasks for Today (TSA2 Tasker) is a task management application engineered in CodeIgniter 4 featuring user authentication, full task CRUD, priority levels, status transitions (Pending, In Progress, Completed), and safe soft-delete recovery. Success means rapid task capture, unambiguous task status scanning, and dependable multi-user data isolation.

## Positioning

Unlike complex enterprise issue trackers or generic to-do list templates, Tasks for Today provides a straightforward, robust task management ledger built on CodeIgniter 4 with strict database isolation, server-side validation, and instant status updates.

## Operating Context

- **Environment**: Office desktop monitors, tablets, and mobile browsers.
- **Workflow**:
  1. Authenticated user reviews their daily task queue.
  2. User filters tasks by status (All, Pending, In Progress, Completed, Trashed).
  3. User creates a task with title, description, priority, and due date.
  4. User transitions task status or archives tasks via soft deletion.

## Capabilities and Constraints

- **Backend**: CodeIgniter 4 (PHP 8.2+).
- **Data Layer**: MySQL database with `tasks` and `users` tables, leveraging CodeIgniter Models with soft deletes enabled.
- **Authentication**: Session-based auth with secure password hashing (`password_hash`).
- **Views**: Clean PHP views using modern CSS cards and form controls.
- **Deployment**: Production deployment ready on InfinityFree / shared Apache hosting.

## Brand Commitments

- **Identity**: Clean productivity ledger.
- **Palette**: Warm Flame Accent (`#dd4814`), Slate Background (`#f8fafc`), Clean Card White (`#ffffff`), and Slate Borders (`#e2e8f0`).
- **Voice**: Clean, encouraging, functional, and organized.

## Evidence on Hand

- Complete CodeIgniter 4 codebase at [`/Users/charleslawrenceaniciete/Developer/tsa2tasker`](file:///Users/charleslawrenceaniciete/Developer/tsa2tasker).
- 26 passing PHPUnit tests with 122 assertions covering all authentication flows, task CRUD, and soft delete mechanics.

## Product Principles

1. **Focus on Today**: Immediate visual prominence for active tasks needing attention today.
2. **Safe Actions**: Soft delete safeguards users against accidental task loss with clear restore pathways.
3. **High Contrast Signals**: Distinct, accessible color pills for priority and status states.
4. **Ergonomic Keyboard Use**: Total keyboard access with `:focus-visible` outlines on all interactive elements.

## Accessibility & Inclusion

- Keyboard navigability with standard Tab / Shift+Tab ordering.
- Visible focus rings with high-contrast outlines (`2px solid #dd4814`).
- Minimum tap targets of 44×44px for buttons and filter controls.
