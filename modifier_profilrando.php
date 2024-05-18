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

    // Vérifier si des données ont été envoyées par le formulaire
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les données du formulaire
        $CIN = $_POST['CIN'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['Email'];
        $tel = $_POST['tel'];

        // Requête SQL pour mettre à jour les informations du randonneur
        $sql = "UPDATE Randonneur SET Nom = ?, Prenom = ?, Email = ?, Num_tel = ? WHERE CIN = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $prenom, $email, $tel, $CIN]);

        // Rediriger vers la page de profil avec un message de succès
        header("Location: profil_randonneur.php?CIN=$CIN");
        exit();
    } else {
        // Rediriger vers une page d'erreur si les données n'ont pas été envoyées par le formulaire
        header("Location: erreur.php");
        exit();
    }
} catch (PDOException $e) {
    // En cas d'erreur de connexion ou de requête, afficher l'erreur
    echo "Erreur : " . $e->getMessage();
    die();
}
?>
