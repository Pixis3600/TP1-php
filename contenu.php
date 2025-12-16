<?php
$pdo = require_once 'config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT id, content FROM articles WHERE id = ?');
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
    <title>Contenu - Article <?php echo (int)$article['id']; ?></title>
    <link rel="stylesheet" href="<?php echo 'style.css?v=' . (file_exists('style.css') ? filemtime('style.css') : time()); ?>">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <div class="article-content contenu"><?php echo nl2br(htmlspecialchars($article['content'])); ?></div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
