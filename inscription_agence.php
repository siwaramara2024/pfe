<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire et nettoyer les valeurs
    $nom_agence = htmlspecialchars($_POST['nom_agence']);
    $email_agence = htmlspecialchars($_POST['email_agence']);
    $password_agence = htmlspecialchars($_POST['password_agence']);
    $ville_agence = htmlspecialchars($_POST['city_agence']);
    $bio_agence = htmlspecialchars($_POST['bio_agence']);
    $telephone_agence = htmlspecialchars($_POST['phone']); // Ajout du numéro de téléphone
    $image_agence = "";

    // Gérer le téléchargement de l'image
    if(isset($_FILES['Image'])){
        $file_name = $_FILES['Image']['name'];
        $file_tmp = $_FILES['Image']['tmp_name'];

        // Déplacer l'image téléchargée vers le dossier de destination
        move_uploaded_file($file_tmp,"images/".$file_name);
        $image_agence = "../images/".$file_name;
    }

    // Validation des données (vous devez ajouter vos propres règles de validation)
    // Exemple : vérifier que les champs obligatoires sont remplis
    if(empty($nom_agence) || empty($email_agence) || empty($password_agence) || empty($ville_agence) || empty($telephone_agence)){
        echo "<p class='error-message'>Veuillez remplir tous les champs obligatoires.</p>";
    } else {
        // Créer la connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password_db = "";
        $dbname = "pfe";

        try {
            $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
            // Configurer PDO pour générer des exceptions en cas d'erreur
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Définir le jeu de caractères en UTF-8
            $pdo->exec("SET NAMES utf8");

            // Requête SQL pour vérifier l'existence de l'agence par son nom
            $check_sql = "SELECT ID_agence FROM Agence_de_voyage WHERE Nom = ?";
            $check_stmt = $pdo->prepare($check_sql);
            $check_stmt->execute([$nom_agence]);
            $existing_agence = $check_stmt->fetchColumn();

            if ($existing_agence) {
                // Si l'agence existe déjà, afficher un message d'erreur
                echo "<p class='error-message'>L'agence existe déjà. Veuillez utiliser un nom différent.</p>";
            } else {
                // Sinon, procéder à l'insertion
                // Requête SQL pour insérer les données dans la table Agence_de_voyage
                $sql = "INSERT INTO Agence_de_voyage (Nom, Email, Mot_de_passe, LibelleV, Bio, Image, Telephone)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $result = $stmt->execute([$nom_agence, $email_agence, $password_agence, $ville_agence, $bio_agence, $image_agence, $telephone_agence]);

                if ($result) {
                    // Redirection vers la page de profil de l'agence avec l'ID nouvellement inséré
                    $agence_id = $pdo->lastInsertId();
                    header("Location: agence/profil_agence.php?id_agence=$agence_id");
                    exit();
                } else {
                    echo "<p class='error-message'>Une erreur est survenue lors de l'inscription. Veuillez réessayer.</p>";
                }
            }
        } catch (PDOException $e) {
            // En cas d'erreur de connexion, afficher l'erreur
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
            die();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Agence de Voyage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styleconnexion.css">
</head>
<body class="form-v6">
    <div class="page-content">
        <div class="form-v6-content">
            <div class="form-left">
                <img src="images/form-v6.jpg" alt="form">
            </div>
            <form class="form-detail" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <br> 
                  
                <h1 class="titre">Inscription </h1>
               
                <p class="sous-titre">Rejoignez-nous pour élargir votre clientèle et offrir des expériences inoubliables !</p>
                <br><br>
                <div class="form-row form-row-split">
                <div class="form-col">
                    <input type="text" name="nom_agence" id="nom_agence" class="input-text" placeholder="Nom de l'agence" required="">
                </div>
                <div class="form-col">
                
                <input type="tel" name="phone" id="phone" class="input-text" placeholder="Numéro de téléphone" required maxlength="8">

<script>
document.getElementById('phone').addEventListener('input', function(event) {
    // Remplacer tout caractère non numérique par une chaîne vide
    this.value = this.value.replace(/\D/g, '');
});
</script> 
            </div></div>
            <div class="form-row form-row-split">
                <div class="form-col">
                    <input type="email" name="email_agence" id="email_agence" class="input-text" placeholder="Adresse email " required>
                </div>
                <div class="form-col">
                    <input type="password" name="password_agence" id="password_agence" class="input-text" placeholder="Mot de passe " required minlength="8">
                </div>
</div>
<div class="form-row form-row-split">
                <div class="form-col">
                    <select class="form-control custom-select" id="city_agence" name="city_agence" required="">
                        <option value="" disabled selected> Gouvernement</option>
                        <option value="Ariana">Ariana</option>
                        <option value="Gabès">Gabès</option>
                        <option value="Gafsa">Gafsa</option>
                            <option value="Jendouba">Jendouba</option>
                            <option value="Kairouan">Kairouan</option>
                            <option value="Kasserine">Kasserine</option>
                            <option value="Kébili">Kébili</option>
                            <option value="Manouba">Manouba</option>
                            <option value="Le Kef">Le Kef</option>
                            <option value="Mahdia">Mahdia</option>
                            <option value="Médenine">Médenine</option>
                            <option value="Monastir">Monastir</option>
                            <option value="Nabeul">Nabeul</option>
                            <option value="Sfax">Sfax</option>
                            <option value="Sidi Bouzid">Sidi Bouzid</option>
                            <option value="Siliana">Siliana</option>
                            <option value="Sousse">Sousse</option>
                            <option value="Tataouine">Tataouine</option>
                            <option value="Tozeur">Tozeur</option>
                            <option value="Tunis">Tunis</option>
                            <option value="Zaghouan">Zaghouan</option>
                        <!-- Ajoutez les autres options de villes ici -->
                    </select>
                </div>
                <div class="form-col">
                    <input type="text" name="bio_agence" id="bio_agence" class="input-text" placeholder="Description ">
                </div>
</div>
<br>
<div class="form-row form-row-split">
                    <div class="form-col"> Intégrez votre logo
                    <input class="input" type="file" name="Image" id="mainimg">
                    </div>
                    <br>
                <div class="form-row-last">
                    <input type="submit" name="register_agence" class="register  text-center" value="S'inscrire">
                </div>
</div>
            </form>
        </div>
    </div>
</body>
</html>
