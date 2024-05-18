<?php
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_randonneur'])) {
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pfe";

    // Créer une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    // Identifiants pour le randonneur
    $email_randonneur = $_POST['email_randonneur'];
    $password_randonneur = $_POST['password_randonneur'];

    // Requête SQL pour vérifier les identifiants du randonneur
    $sql_randonneur = "SELECT * FROM Randonneur WHERE Email=? AND Mot_de_passe=?";
    $stmt = $conn->prepare($sql_randonneur);
    $stmt->bind_param("ss", $email_randonneur, $password_randonneur);
    $stmt->execute();
    $result_randonneur = $stmt->get_result();

    if ($result_randonneur->num_rows > 0) {
        // Authentification réussie pour le randonneur
        $_SESSION['type'] = 'randonneur';
        // Récupérer l'ID du randonneur
        $randonneur = $result_randonneur->fetch_assoc();
        $randonneur_id = $randonneur['CIN'];
        // Redirection vers la page de profil du randonneur avec l'ID du randonneur dans l'URL
        header("Location: randonneur/profil_randonneur.php?CIN=$randonneur_id");
        exit();
    } else {
        // Identifiants invalides pour le randonneur, afficher un message d'erreur
        $error_randonneur = "Identifiants invalides. Veuillez réessayer.";
    }

    // Fermer la connexion à la base de données
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="assets/css/styleconnexion.css">
</head>
<body class="form-v6">
    <div class="page-content">
        <div class="form-v6-content">
            <div class="form-left">
                <img src="images/form-v6.jpg" alt="form">
            </div>
            
            <form class="form-detail" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <br><br>
    <h1 class="titre">Login Randonneur</h1>
    <p class="sous-titre">Prêt à partir à l'aventure ?</p>
    <br><br>
    <!-- Formulaire de login pour le randonneur -->
    <div class="form-row">
        <input type="email" name="email_randonneur" id="email" class="input-text" placeholder="Email Randonneur" required>
    </div>
    <div class="form-row">
        <input type="password" name="password_randonneur" id="password" class="input-text" placeholder="Mot de passe Randonneur" required minlength="8">
    </div>
    <div><?php if (isset($error_randonneur)) echo "<p style='color: red;'>$error_randonneur</p>"; ?></div>

    <div class="form-row-last">
        <button type="submit" name="login_randonneur" class="register">Se connecter</button>
    </div>
</form>

    
</body>
</html>
