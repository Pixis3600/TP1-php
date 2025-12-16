USE `actualites`;

CREATE TABLE IF NOT EXISTS `titres` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX (`article_id`),
  CONSTRAINT `fk_titres_article` FOREIGN KEY (`article_id`) REFERENCES `articles`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `titres` (article_id, title)
SELECT id, title FROM articles WHERE id BETWEEN 1 AND 5
ON DUPLICATE KEY UPDATE title = VALUES(title);

SELECT COUNT(*) AS total_titres FROM `titres`;