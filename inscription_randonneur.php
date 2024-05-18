<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire et nettoyer les valeurs
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $cin = htmlspecialchars($_POST['cin']);
    $phone = htmlspecialchars($_POST['phone']);
    $date_naissance = htmlspecialchars($_POST['date_naissance']);
    $ville = htmlspecialchars($_POST['city']);
    $image_randonneur = "";


    // Gérer le téléchargement de l'image
    if(isset($_FILES['Image'])){
        $file_name = $_FILES['Image']['name'];
        $file_tmp = $_FILES['Image']['tmp_name'];

        // Définir le chemin complet vers le dossier de destination
        $destination_path = __DIR__ . "/images/" . $file_name;

        // Déplacer l'image téléchargée vers le dossier de destination
        if (move_uploaded_file($file_tmp, $destination_path)) {
            $image_randonneur = "../images/" . $file_name;
        } else {
            echo "Une erreur s'est produite lors du téléchargement de l'image.";
        }
    }


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

        // Requête SQL pour insérer les données dans la table Randonneur
        $sql = "INSERT INTO Randonneur (CIN, Nom, Prenom, Email, Mot_de_passe, Num_tel, Date_naissance, LibelleV, Image)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Préparation de la requête
        $stmt = $pdo->prepare($sql);

        // Exécution de la requête
        $result = $stmt->execute([$cin, $nom, $prenom, $email, $password, $phone, $date_naissance, $ville, $image_randonneur]);

        // Vérifiez si la requête s'est exécutée avec succès
        if ($result) {
            // Redirection après l'inscription réussie
            $CIN = $pdo->lastInsertId();
            header("Location: randonneur/profil_randonneur.php?CIN=$cin");
            exit; // Arrêter l'exécution du script après la redirection
        } else {
            // Afficher un message d'erreur
            echo "<p class='error-message'>Une erreur est survenue lors de l'inscription. Veuillez réessayer.</p>";
        }
    } catch (PDOException $e) {
        // En cas d'erreur de connexion ou d'exécution de la requête, afficher l'erreur
        echo "Erreur : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Randonneur</title>
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
                <p class="sous-titre">Rejoignez-nous pour des aventures incroyables !</p>
                <br>
                <div class="form-row form-row-split">
                <div class="form-col">
                    <input type="text" name="nom" id="nom" class="input-text" placeholder="Nom" required="">
                </div>
                <div class="form-col">
                    <input type="text" name="prenom" id="prenom" class="input-text" placeholder="Prénom" required="">
                 </div>
            </div>
                <div class="form-row form-row-split">
                    <div class="form-col">
                    <input type="text" name="cin" id="cin" class="input-text" placeholder="CIN (8 chiffres)" required pattern="[0-9]{8}" maxlength="8">
                    <script>
document.getElementById('cin').addEventListener('input', function(event) {
    // Remplacer tout caractère non numérique par une chaîne vide
    this.value = this.value.replace(/\D/g, '');
});
</script> 
                    </div>
                    <div class="form-col">
                        <input type="tel" name="phone" id="phone" class="input-text" placeholder="Numéro de téléphone" required pattern="[0-9]{8}" maxlength="8">
                        <script>
document.getElementById('phone').addEventListener('input', function(event) {
    // Remplacer tout caractère non numérique par une chaîne vide
    this.value = this.value.replace(/\D/g, '');
});
</script> 
                    </div>
                </div>
               <div class="form-row form-row-split">
                <div class="form-col">
                <input type="date" name="date_naissance" id="date_naissance" placeholder="Date de naissance" required max="<?php echo date('Y-m-d'); ?>">

                </div>
                <div class="form-col">
                    <select class="form-control custom-select" id="city" name="city" required="">
                        <option value="" disabled selected>Gouvernement</option>
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
           </div>
  <div class="form-row">
                    <input type="email" name="email" id="email" class="input-text" placeholder="Adresse email" required>
                </div>
                <div class="form-row">
                    <input type="password" name="password" id="password" class="input-text" placeholder="Mot de passe" required minlength="8">
                </div>
                <div class="form-row form-row-split">
                    <div class="form-col"> Intégrez votre logo
                    <input class="input" type="file" name="Image" id="mainimg">
                    </div>
                   
                <div class="form-row-last">
                    <input type="submit" name="register_agence" class="register  text-center" value="S'inscrire">
                </div>
</div> 
            </form>
        </div>
    </div>
</body>
</html>
