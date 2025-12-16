USE `actualites`;

CREATE TABLE IF NOT EXISTS `contenus` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` INT UNSIGNED NOT NULL,
  `content` TEXT,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX (`article_id`),
  CONSTRAINT `fk_contenus_article` FOREIGN KEY (`article_id`) REFERENCES `articles`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `contenus` (article_id, content)
SELECT id, content FROM articles WHERE id BETWEEN 1 AND 5
ON DUPLICATE KEY UPDATE content = VALUES(content);

SELECT COUNT(*) AS total_contenus FROM `contenus`;