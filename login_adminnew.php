<?php
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_admin'])) {
    // Identifiants pour l'administrateur
    $nom_admin = $_POST['nom_admin'];
    $mot_de_passe_admin = $_POST['mot_de_passe_admin'];

    // Vérification des identifiants de l'administrateur
    if ($nom_admin === "admin" && $mot_de_passe_admin === "admin") {
        // Authentification réussie pour l'administrateur
        $_SESSION['type'] = 'admin';
        // Redirection vers la page de profil de l'administrateur
        header("Location:admin/profil_admin.php?id_admin=1");
        exit();
    } else {
        // Identifiants invalides pour l'administrateur, afficher un message d'erreur
        $error_admin = "Identifiants invalides pour l'administrateur. Veuillez réessayer.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrateur</title>
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
                <h1 class="titre">Login </h1>
                <p class="sous-titre">Connectez-vous pour gérer le système.</p>
                <br><br>
                <!-- Formulaire de login pour l'administrateur -->
                <div class="form-row">
                    <input type="text" name="nom_admin" id="nom_admin" class="input-text" placeholder="Nom Administrateur" required>
                </div>
                <div class="form-row">
                    <input type="password" name="mot_de_passe_admin" id="mot_de_passe_admin" class="input-text" placeholder="Mot de passe Administrateur" >
                </div>
                <div><?php if (isset($error_admin)) echo "<p class='error-message'>$error_admin</p>"; ?></div>
                <div class="form-row-last">
                    <button type="submit" name="login_admin" class="register">Se connecter</button>
                </div>
            </form>

            <?php if (isset($error_admin)) echo "<p class='error-message'>$error_admin</p>"; ?>
        </div>
    </div>
</body>
</html>
