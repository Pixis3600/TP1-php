<?php
$pdo = require_once 'config.php';

// Simple admin pour créer/éditer/supprimer des articles
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $stmt = $pdo->prepare('INSERT INTO articles (title, excerpt, content, date) VALUES (?, ?, ?, ?)');
        $stmt->execute([$_POST['title'], $_POST['excerpt'], $_POST['content'], $_POST['date']]);
        header('Location: articles_admin.php'); exit;
    }
    if (isset($_POST['delete'])) {
        $stmt = $pdo->prepare('DELETE FROM articles WHERE id = ?');
        $stmt->execute([$_POST['id']]);
        header('Location: articles_admin.php'); exit;
    }
}

$articles = $pdo->query('SELECT * FROM articles ORDER BY date DESC')->fetchAll();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin - Articles</title>
    <link rel="stylesheet" href="style2.css?v=<?php echo file_exists('style2.css') ? filemtime('style2.css') : time(); ?>">
    <style>form{margin-bottom:20px} input,textarea{width:100%;padding:8px;margin:4px 0;border:1px solid #ddd;border-radius:6px}</style>
</head>
<body>
<?php include 'header.php'; ?>
<div class="container">
    <h1>Admin - Articles</h1>

    <form method="post">
        <h3>Créer un article</h3>
        <input name="title" placeholder="Titre" required>
        <input name="excerpt" placeholder="Extrait">
        <textarea name="content" placeholder="Contenu" rows="6"></textarea>
        <input name="date" type="date" value="<?php echo date('Y-m-d'); ?>">
        <button class="btn" name="create">Créer</button>
    </form>

    <h3>Articles existants</h3>
    <table>
        <thead><tr><th>ID</th><th>Titre</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($articles as $a): ?>
            <tr>
                <td><?php echo $a['id']; ?></td>
                <td><?php echo htmlspecialchars($a['title']); ?></td>
                <td><?php echo htmlspecialchars($a['date']); ?></td>
                <td>
                    <a class="btn" href="article_detail.php?id=<?php echo $a['id']; ?>">Voir</a>
                    <form method="post" style="display:inline" onsubmit="return confirm('Supprimer ?')">
                        <input type="hidden" name="id" value="<?php echo $a['id']; ?>">
                        <button class="btn secondary" name="delete">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
