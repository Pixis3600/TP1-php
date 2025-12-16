USE `actualites`;

CREATE TABLE IF NOT EXISTS `dates` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` INT UNSIGNED NOT NULL,
  `date` DATE DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX (`article_id`),
  CONSTRAINT `fk_dates_article` FOREIGN KEY (`article_id`) REFERENCES `articles`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `dates` (article_id, date)
SELECT id, date FROM articles WHERE id BETWEEN 1 AND 5
ON DUPLICATE KEY UPDATE date = VALUES(date);

SELECT COUNT(*) AS total_dates FROM `dates`;