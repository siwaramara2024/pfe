<?php
// Connexion à la base de données (à remplacer avec vos informations de connexion)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pfe";


$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Vérifier si la date de réservation est présente dans la requête GET
if(isset($_GET['date_reservation'])) {
    $date_reservation = $_GET['date_reservation'];

    // Requête SQL pour supprimer la réservation avec la date de réservation donnée
    $sql = "DELETE FROM reservation WHERE Date_reservation = '$date_reservation'";

    if ($conn->query($sql) === TRUE) {
        echo "La réservation a été supprimée avec succès.";
    } else {
        echo "Erreur lors de la suppression de la réservation : " . $conn->error;
    }
} else {
    echo "La date de réservation n'a pas été spécifiée.";
}

// Fermer la connexion à la base de données
$conn->close();
?>