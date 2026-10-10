DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `full_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Demo user with hashed password (plaintext: TaskerDemo!2026)
INSERT INTO `users` (`id`, `username`, `full_name`, `email`, `password`, `created_at`) VALUES
(1, 'charles', 'Charles Lawrence Aniciete', 'charles@example.com', '$2y$12$vq1uzv3hFBlMwJyZearzy.S287fqRCkbsefAD8vu1nzh/WMfUYCi.', NOW());

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(150) NOT NULL,
  `status` VARCHAR(20) NOT NULL DEFAULT 'pending',
  `task_date` DATE NOT NULL,
  `is_archived` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tasks` (`title`, `status`, `task_date`, `is_archived`, `created_at`) VALUES
('Buy groceries (milk, eggs, and bread)', 'pending', CURDATE(), 0, NOW()),
('Morning 30-minute jog in the park', 'completed', CURDATE(), 0, NOW()),
('Water the indoor plants', 'completed', CURDATE(), 0, NOW()),
('Prepare dinner and wash the dishes', 'pending', CURDATE(), 0, NOW()),

('Do laundry and fold clothes', 'completed', DATE_SUB(CURDATE(), INTERVAL 1 DAY), 0, NOW()),
('Take out the trash and recycling bins', 'completed', DATE_SUB(CURDATE(), INTERVAL 1 DAY), 0, NOW()),
('Clean the kitchen counters and vacuum living room', 'completed', DATE_SUB(CURDATE(), INTERVAL 1 DAY), 0, NOW()),

('Pay monthly electric and water bills', 'pending', DATE_ADD(CURDATE(), INTERVAL 1 DAY), 0, NOW()),
('Schedule dentist checkup appointment', 'pending', DATE_ADD(CURDATE(), INTERVAL 1 DAY), 0, NOW()),
('Wash the car and check tire pressure', 'pending', DATE_ADD(CURDATE(), INTERVAL 2 DAY), 0, NOW());
