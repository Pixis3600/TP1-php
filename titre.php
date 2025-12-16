<?php
$pdo = require_once 'config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT id, title FROM articles WHERE id = ?');
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
    <title><?php echo htmlspecialchars($article['title']); ?></title>
    <link rel="stylesheet" href="<?php echo 'style.css?v=' . (file_exists('style.css') ? filemtime('style.css') : time()); ?>">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h1 class="titre"><?php echo htmlspecialchars($article['title']); ?></h1>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
