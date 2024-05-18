<?php
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_agence'])) {
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

    // Identifiants pour l'agence de voyage
    $email_agence = $_POST['email_agence'];
    $password_agence = $_POST['password_agence'];

    // Requête SQL pour vérifier les identifiants de l'agence de voyage
    $sql_agence = "SELECT * FROM Agence_de_voyage WHERE Email=? AND Mot_de_passe=?";
    $stmt = $conn->prepare($sql_agence);
    $stmt->bind_param("ss", $email_agence, $password_agence);
    $stmt->execute();
    $result_agence = $stmt->get_result();

    if ($result_agence->num_rows > 0) {
        // Authentification réussie pour l'agence de voyage
        $_SESSION['type'] = 'agence';
        // Récupérer l'ID de l'agence
        $agence = $result_agence->fetch_assoc();
        $agence_id = $agence['ID_agence'];
        // Redirection vers la page de profil de l'agence avec l'ID de l'agence dans l'URL
        header("Location: agence/profil_agence.php?id_agence=$agence_id");
        exit();
    } else {
        // Identifiants invalides pour l'agence de voyage, afficher un message d'erreur
        $error_agence = "Identifiants invalides pour l'agence de voyage. Veuillez réessayer.";
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
    <title>Login Agence de Voyage</title>
    <link rel="stylesheet" href="assets/css/styleconnexion.css">
    <style>
        .error-message {
            color: red;
            margin-top: 5px; /* Ajustez la marge comme vous le souhaitez */
        }
    </style>
</head>
<body class="form-v6">
    
    <div class="page-content">
        <div class="form-v6-content">
            <div class="form-left">
                <img src="images/form-v6.jpg" alt="form">
            </div>
            
            <form class="form-detail" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <br><br>
                <h1 class="titre">Login Agence de Voyage</h1>
                <p class="sous-titre">Prêt à partir à l'aventure ?</p>
                <br><br>
                <!-- Formulaire de login pour l'agence de voyage -->
                <div class="form-row">
                    <input type="email" name="email_agence" id="email_agence" class="input-text" placeholder="Email Agence" required>
                </div>
                <div class="form-row">
                    <input type="password" name="password_agence" id="password_agence" class="input-text" placeholder="Mot de passe Agence" required minlength="8">
                </div>
                <div><?php if (isset($error_agence)) echo "<p class='error-message'>$error_agence</p>"; ?></div>
                <div class="form-row-last">
                    <button type="submit" name="login_agence" class="register">Se connecter</button>
                </div>
            </form>

            <?php if (isset($error_agence)) echo "<p class='error-message'>$error_agence</p>"; ?>
        </div>
    </div>
</body>
</html>
