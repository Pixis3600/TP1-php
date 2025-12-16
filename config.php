<?php
session_start();

$current_page = basename($_SERVER['PHP_SELF']);

if ($current_page !== 'login.php' && (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true)) {
    header('Location: login.php');
    exit;
}

$host = '127.0.0.1';
$db   = 'actualites';
$user = 'webuser';
$pass = 'Y7k!2s9QwP#xLr3V';
$charset = 'utf8mb4';
$port = 3306;

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $dsn = "mysql:host=$host;charset=$charset;port=$port";
    $pdo = new PDO($dsn, $user, $pass, $options);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS $db");
    $pdo->exec("USE $db");

    $pdo->exec("CREATE TABLE IF NOT EXISTS marques (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS modeles (
        id INT PRIMARY KEY AUTO_INCREMENT,
        id_marque INT NOT NULL,
        modele_voiture VARCHAR(255) NOT NULL,
        nom_voiture VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS articles (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        excerpt TEXT,
        content TEXT,
        date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $count = (int)$pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
    if ($count === 0) {
        $insert = $pdo->prepare('INSERT INTO articles (title, excerpt, content, date) VALUES (?, ?, ?, ?)');
        $insert->execute(["Truc nul #1 : Le canapé qui parle", "Un canapé qui donne son avis sur la météo, testé et approuvé (ou pas).", "Ceci est un article de test vraiment nul. Il parle d\'un canapé qui raconte des blagues sans queue ni tête. Ne pas prendre au sérieux.", '2025-12-15']);
        $insert->execute(["Truc nul #2 : La chaussure volante", "Enfin des chaussures qui volent... sauf quand il pleut.", "Article de test : la chaussure volante fonctionne seulement si vous y croyez très fort. Résultats non garantis.", '2025-12-10']);
        $insert->execute(["Truc nul #3 : Le brocoli superstar", "Le brocoli qui chante en karaoké et fait sensation.", "Contenu de test : ce brocoli a gagné un concours de chant local. Les juges étaient confus mais satisfaits.", '2025-12-05']);
        $insert->execute(["Truc nul #4 : Le grille-pain philosophe", "Un grille-pain qui médite sur le sens de la vie (et du pain).", "Test : le grille-pain pose des questions existentielles à chaque tartine. Certains utilisateurs ont été émus.", '2025-11-30']);
        $insert->execute(["Truc nul #5 : L'invasion des chaussettes", "Les chaussettes ont décidé de conquérir la buanderie.", "Petit article de test : une armée de chaussettes a organisé une manifestation dans la machine à laver. Aucun disparu signalé (pour l'instant).", '2025-11-20']);
    }

} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

return $pdo;