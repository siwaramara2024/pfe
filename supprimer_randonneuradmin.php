<?php
session_start();

// Vérifier si le "cin" du randonneur à supprimer est passé en paramètre
if (!isset($_GET['cin']) || empty($_GET['cin'])) {
    echo "Le CIN du randonneur n'est pas spécifié.";
    exit;
}

$randonneur_cin = intval($_GET['cin']); // Assure que $randonneur_cin est un entier

// Fonction pour établir la connexion à la base de données
function connectDB() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pfe";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

    return $conn;
}

// Appeler la fonction pour établir la connexion
$conn = connectDB();

// Supprimer d'abord les réservations associées
$sql_delete_reservations = "DELETE FROM reservation WHERE CIN = ?";
$stmt_delete_reservations = $conn->prepare($sql_delete_reservations);
$stmt_delete_reservations->bind_param("i", $randonneur_cin);

if (!$stmt_delete_reservations->execute()) {
    echo "Erreur lors de la suppression des réservations : " . $conn->error;
    exit;
}

$stmt_delete_reservations->close();

// Maintenant que les réservations ont été supprimées, supprimer le randonneur
$sql_delete_randonneur = "DELETE FROM Randonneur WHERE CIN = ?";
$stmt_delete_randonneur = $conn->prepare($sql_delete_randonneur);
$stmt_delete_randonneur->bind_param("i", $randonneur_cin);

if ($stmt_delete_randonneur->execute()) {
    $_SESSION['success_message'] = "Le randonneur a été supprimé avec succès.";
    header("Location: liste_randonneuradmin.php");
    exit;
} else {
    echo "Erreur lors de la suppression du randonneur : " . $conn->error;
}

$stmt_delete_randonneur->close();
$conn->close();
?>
