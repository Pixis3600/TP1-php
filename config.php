<?php
// config.php
// Ce fichier est inclus par toutes les pages PHP pour initialiser la session,
// vérifier l'authentification et établir la connexion à la base de données (PDO).

// Démarre la session PHP
session_start();

// --- VÉRIFICATION DE L'AUTHENTIFICATION ---
// Récupère le nom du fichier PHP en cours d'exécution (ex: 'page3.php').
$current_page = basename($_SERVER['PHP_SELF']);

// Si la page actuelle N'EST PAS 'login.php' ET que l'utilisateur N'EST PAS connecté,
// alors on le redirige vers la page de connexion pour protéger l'accès.
if ($current_page !== 'login.php' && (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true)) {
    header('Location: login.php');
    exit;
}

// --- PARAMÈTRES DE CONNEXION À LA BASE DE DONNÉES (MySQL/MariaDB) ---
$host = '127.0.0.1'; // Adresse de l'hôte (généralement localhost)
$db   = 'voitures'; // Nom de la base de données
$user = 'webuser';     // Identifiant de l'utilisateur pour l'app web (voir instructions ci-dessous)
$pass = 'Y7k!2s9QwP#xLr3V';         // Mot de passe généré (changez-le après création si vous préférez)
$charset = 'utf8mb4'; // Encodage des caractères
$port = 3306;         // Port de la base de données

// Options PDO (PHP Data Objects) pour la configuration de la connexion
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Active les exceptions en cas d'erreur SQL
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     // Récupère les résultats sous forme de tableaux associatifs
    PDO::ATTR_EMULATE_PREPARES   => false,                // Désactive l'émulation (meilleure sécurité)
];

try {
    // Tente d'établir la connexion
    $dsn = "mysql:host=$host;charset=$charset;port=$port";
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // --- INITIALISATION DE LA BASE DE DONNÉES ET DES TABLES ---
    
    // 1. Créer la base de données 'voitures' si elle n'existe pas
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $db");
    // 2. Sélectionner la base de données pour les opérations suivantes
    $pdo->exec("USE $db");
    
    // 3. Créer la table 'marques' si elle n'existe pas
    $pdo->exec("CREATE TABLE IF NOT EXISTS marques (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // 4. Créer la table 'modeles' (les voitures) si elle n'existe pas
    $pdo->exec("CREATE TABLE IF NOT EXISTS modeles (
        id INT PRIMARY KEY AUTO_INCREMENT,
        id_marque INT NOT NULL,
        modele_voiture VARCHAR(255) NOT NULL,
        nom_voiture VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // 5. Créer la table 'articles' si elle n'existe pas
    $pdo->exec("CREATE TABLE IF NOT EXISTS articles (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        excerpt TEXT,
        content TEXT,
        date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // 6. Si la table 'articles' est vide, insérer des articles de test
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
    // En cas d'échec de la connexion (ex: MySQL non démarré), arrêter l'exécution.
    die("Erreur de connexion : " . $e->getMessage());
}

/*
 * NOTE - Création/installation de l'utilisateur 'webuser'
 * ------------------------------------------------------
 * Avant que la connexion fonctionne, vous devez créer l'utilisateur MySQL utilisé ci-dessus
 * et lui donner les droits sur la base `voitures`.
 * Stocké également dans le fichier `create_webuser.sql` à la racine du projet.
 * Exemple (PowerShell / shell) si vous avez l'accès root :
 *   mysql -u root -p < create_webuser.sql
 * Ou connectez-vous à phpMyAdmin et exécutez les commandes dans l'onglet SQL.
 */

// Retourne l'objet PDO. C'est le résultat de l'instruction `require_once`
// dans les autres fichiers (ex: `$pdo = require_once 'config.php';`).
return $pdo;