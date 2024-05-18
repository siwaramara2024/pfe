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

// Vérifier si l'identifiant de l'article à supprimer est passé en paramètre
if (!isset($_GET['id_article']) || empty($_GET['id_article'])) {
    echo "Identifiant de l'article non spécifié.";
    exit;
}

$article_id = intval($_GET['id_article']); // Assure que $article_id est un entier

// Supprimer l'article
$sql_delete_article = "DELETE FROM Article WHERE id_article = ?";
$stmt_article = $conn->prepare($sql_delete_article);
$stmt_article->bind_param("i", $article_id);

if ($stmt_article->execute()) {
    $_SESSION['success_message'] = "L'article a été supprimé avec succès.";
    header("Location: liste_articleadmin.php"); // Rediriger vers la page de liste des articles après la suppression
    exit;
} else {
    echo "Erreur lors de la suppression de l'article : " . $conn->error;
}

$stmt_article->close();
$conn->close();
?>
