USE `actualites`;

SELECT id, title FROM articles WHERE id = 1;

INSERT INTO articles (title, excerpt, content, date)
VALUES ('Titre ajouté via titre_ops.sql', 'extrait', 'contenu', '2025-12-16');

UPDATE articles SET title = 'Titre mis à jour (via titre_ops.sql)' WHERE id = 1;

INSERT INTO articles (id, title, excerpt, content, date)
VALUES (9999, 'Titre spécial #9999', 'extrait', 'contenu', '2025-12-16')
ON DUPLICATE KEY UPDATE title = VALUES(title);

SELECT id, title FROM articles WHERE id IN (1,9999);