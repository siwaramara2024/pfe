<?php
session_start();

// Vérifier si l'ID de l'agence de voyage à supprimer est passé en paramètre
if (!isset($_GET['id_agence']) || empty($_GET['id_agence'])) {
    echo "L'ID de l'agence de voyage n'est pas spécifié.";
    exit;
}

$agence_id = intval($_GET['id_agence']); // Assure que $agence_id est un entier

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

// Supprimer d'abord les réservations associées dans la table reservation
$sql_delete_reservation = "DELETE FROM reservation WHERE ID_randonnee IN (SELECT ID_randonnee FROM randonnee WHERE ID_agence = ?)";
$stmt_reservation = $conn->prepare($sql_delete_reservation);
$stmt_reservation->bind_param("i", $agence_id);

if (!$stmt_reservation->execute()) {
    echo "Erreur lors de la suppression des réservations associées à cette agence : " . $conn->error;
    exit;
}

$stmt_reservation->close();

// Maintenant que les réservations associées ont été supprimées, supprimer les randonnées associées
$sql_delete_randonnee = "DELETE FROM randonnee WHERE ID_agence = ?";
$stmt_randonnee = $conn->prepare($sql_delete_randonnee);
$stmt_randonnee->bind_param("i", $agence_id);

if (!$stmt_randonnee->execute()) {
    echo "Erreur lors de la suppression des randonnées associées à cette agence : " . $conn->error;
    exit;
}

$stmt_randonnee->close();

// Maintenant que les randonnées associées ont été supprimées, supprimer l'agence de voyage
$sql_delete_agence = "DELETE FROM Agence_de_voyage WHERE ID_agence = ?";
$stmt_agence = $conn->prepare($sql_delete_agence);
$stmt_agence->bind_param("i", $agence_id);

if ($stmt_agence->execute()) {
    $_SESSION['success_message'] = "L'agence de voyage a été supprimée avec succès.";
    header("Location: liste_agenceadmin.php"); // Rediriger vers la page de liste des agences après la suppression
    exit;
} else {
    echo "Erreur lors de la suppression de l'agence de voyage : " . $conn->error;
}

$stmt_agence->close();
$conn->close();
?>
