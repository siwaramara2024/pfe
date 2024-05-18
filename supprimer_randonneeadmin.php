<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pfe";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Vérifier si l'identifiant de la randonnée à supprimer est passé en paramètre
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Identifiant de la randonnée non spécifié.";
    exit;
}

$randonnee_id = intval($_GET['id']); // Assure que $randonnee_id est un entier

// Supprimer d'abord les réservations associées
$sql_delete_reservations = "DELETE FROM reservation WHERE ID_randonnee = ?";
$stmt_reservations = $conn->prepare($sql_delete_reservations);
$stmt_reservations->bind_param("i", $randonnee_id);

if (!$stmt_reservations->execute()) {
    echo "Erreur lors de la suppression des réservations : " . $conn->error;
    exit;
}

$stmt_reservations->close();

// Maintenant que les réservations ont été supprimées, supprimer la randonnée
$sql_delete_randonnee = "DELETE FROM Randonnee WHERE ID_randonnee = ?";
$stmt_randonnee = $conn->prepare($sql_delete_randonnee);
$stmt_randonnee->bind_param("i", $randonnee_id);

if ($stmt_randonnee->execute()) {
    $_SESSION['success_message'] = "Votre randonnée a été supprimée avec succès.";
    header("Location: liste_randonneeadmin.php");
    exit;
} else {
    echo "Erreur lors de la suppression de la randonnée : " . $conn->error;
}

$stmt_randonnee->close();
$conn->close();
?>
