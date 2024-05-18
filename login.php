<?php
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['type_agence'])) {
        header("Location: login_agence.php");
        exit();
    } elseif (isset($_POST['type_randonneur'])) {
        header("Location: login_randonneur.php");
        exit();
    }
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
            
            <form class="form-detail">
                <br><br>
                <h1 class="titre">Choisissez votre type</h1>
                <p class="sous-titre">Prêt à partir à l'aventure ?</p>
                <br><br>
                <div class="form-row">
              
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <button type="submit" name="type_agence" class="buttons  buttons-j" >  <a href="login_agence.php">Agence de Voyage </a></button>
        <br>
        <button type="submit" name="type_randonneur" class="buttons  buttons-j" > <a href="login_randonneur.php">Randonneur </a></button>
    </form>
</div>
</body>
</html>
