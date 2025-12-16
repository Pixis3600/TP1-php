<?php
$pdo = require_once 'config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT id, date FROM articles WHERE id = ?');
$stmt->execute([$id]);
$article = $stmt->fetch();
if (!$article) {
    header('Location: article.php');
    exit;
}
// Format date
$formatted = $article['date'];
try {
    $dt = new DateTime($article['date']);
    $formatted = $dt->format('d/m/Y');
} catch (Exception $e) {
    // keep raw if parse fails
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date - Article <?php echo (int)$article['id']; ?></title>
    <link rel="stylesheet" href="<?php echo 'style.css?v=' . (file_exists('style.css') ? filemtime('style.css') : time()); ?>">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <p class="article-date date" style="font-weight:700; font-size:1.1rem"><?php echo htmlspecialchars($formatted); ?></p>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
