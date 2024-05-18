<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "pfe";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
    // Configurer PDO pour générer des exceptions en cas d'erreur
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Définir le jeu de caractères en UTF-8
    $pdo->exec("SET NAMES utf8");

    // Vérifier si l'identifiant du randonneur est passé en POST
    if(isset($_POST['CIN'])) {
        $CIN = $_POST['CIN'];
        
        // Requête SQL pour supprimer le compte du randonneur
        $sql = "DELETE FROM Randonneur WHERE CIN = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$CIN]);

        // Redirection vers une page de confirmation ou une page d'accueil
        echo "Suppression réussie";
    } else {
        echo "L'identifiant du randonneur n'a pas été spécifié.";
    }
} catch (PDOException $e) {
    // En cas d'erreur de connexion ou d'exécution de la requête, afficher l'erreur
    echo "Erreur : " . $e->getMessage();
    die();
}
?>
