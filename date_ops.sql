USE `actualites`;

SELECT id, date FROM articles WHERE id = 1;

INSERT INTO articles (title, excerpt, content, date)
VALUES ('Article avec date via date_ops.sql', 'extrait', 'contenu', '2025-12-16');

UPDATE articles SET date = '2025-12-20' WHERE id = 1;

UPDATE articles SET date = '2025-12-31' WHERE id = 9999 AND date <> '2025-12-31';

SELECT id, date FROM articles WHERE id IN (1,9999);