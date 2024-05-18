<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pfe";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupération des données du formulaire
$titre1 = $_POST['titre1'];
$paragraphe1 = $_POST['paragraphe1'];
$titre2 = $_POST['titre2'];
$paragraphe2 = $_POST['paragraphe2'];
$titre3 = $_POST['titre3'];
$paragraphe3 = $_POST['paragraphe3'];

// Traitement des fichiers uploadés
$images = $_FILES['image'];
$chemins_images = [];

foreach ($images['tmp_name'] as $index => $tmp_name) {
    $nom_fichier = $images['name'][$index];
    $chemin_destination = "../images/" . $nom_fichier;
    move_uploaded_file($tmp_name, $chemin_destination);
    $chemins_images[] = $nom_fichier;
}

// Date et heure actuelles
$date_heure_ajout = date('Y-m-d H:i:s');

// Requête SQL pour insérer les données dans la table Article
$sql = "INSERT INTO Article (titre1, paragraphe1, titre2, paragraphe2, titre3, paragraphe3, image, date_heure_ajout)
        VALUES ('$titre1', '$paragraphe1', '$titre2', '$paragraphe2', '$titre3', '$paragraphe3', '" . implode(',', $chemins_images) . "', '$date_heure_ajout')";

if ($conn->query($sql) === TRUE) {
    echo "Nouvel article ajouté avec succès !";
    header("Location: liste_articleadmin.php");
    exit; // Terminer le script après la redirection
} else {
    echo "Erreur : " . $sql . "<br>" . $conn->error;
}


// Fermeture de la connexion
$conn->close();
?>
