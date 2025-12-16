USE `actualites`;

SELECT id, content FROM articles WHERE id = 1;

INSERT INTO articles (title, excerpt, content, date)
VALUES ('Article avec contenu via contenu_ops.sql', 'extrait', 'Contenu inséré via script', '2025-12-16');

UPDATE articles SET content = 'Nouveau contenu (via contenu_ops.sql)' WHERE id = 1;

INSERT INTO articles (id, title, excerpt, content, date)
VALUES (9998, 'Titre #9998', 'extrait', 'Contenu pour #9998', '2025-12-16')
ON DUPLICATE KEY UPDATE content = VALUES(content);

SELECT id, content FROM articles WHERE id IN (1,9998);