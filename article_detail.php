<?php
$pdo = require_once 'config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT * FROM articles WHERE id = ?');
$stmt->execute([$id]);
$article = $stmt->fetch();
if (!$article) {
    header('Location: article.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $notFound ? 'Actualité introuvable' : htmlspecialchars($article['title']); ?></title>
    <link rel="stylesheet" href="<?php echo 'style2.css?v=' . (file_exists('style2.css') ? filemtime('style2.css') : time()); ?>">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <?php if ($notFound): ?>
            <h1>Actualité introuvable</h1>
            <p>Cette actualité n'existe pas ou a été supprimée.</p>
        <?php else: ?>
            <h1><?php echo htmlspecialchars($article['title']); ?></h1>
            <p class="article-date"><?php echo htmlspecialchars($article['date']); ?></p>
            <p class="article-content"><?php echo htmlspecialchars($article['content']); ?></p>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>