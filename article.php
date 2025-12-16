<?php
$pdo = require_once 'config.php';
$articles = $pdo->query('SELECT id, title, excerpt, date FROM articles ORDER BY date DESC')->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualités</title>
    <link rel="stylesheet" href="<?php echo 'style2.css?v=' . (file_exists('style2.css') ? filemtime('style2.css') : time()); ?>">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Actualités</h1>

        <ul class="article-list">
            <?php
            $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), "/\\");
            if ($base === '.' || $base === '/' || $base === "\\") {
                $base = '';
            }
            foreach ($articles as $id => $a): ?>
                <li>
                    <a class="article-title" href="<?php echo htmlspecialchars($base . '/article_detail.php?id=' . $id); ?>"><?php echo htmlspecialchars($a['title']); ?></a>
                    <div class="article-excerpt"><?php echo htmlspecialchars($a['excerpt']); ?></div>
                    <small class="article-date"><?php echo htmlspecialchars($a['date']); ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>