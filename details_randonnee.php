<?php
// Connexion à la base de données
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

    // Vérifier si l'identifiant de la randonnée est passé dans l'URL
    if(isset($_GET['id'])) {
        $ID_randonnee = $_GET['id'];
        
        // Requête SQL pour récupérer les informations de la randonnée
        $sql = "SELECT * FROM Randonnee WHERE ID_randonnee = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$ID_randonnee]);

        // Vérifier s'il y a eu des erreurs lors de l'exécution de la requête
        $errors = $stmt->errorInfo();
        if($errors[0] !== '00000') {
            // Afficher l'erreur et arrêter l'exécution du script
            die("Erreur lors de l'exécution de la requête : " . $errors[2]);
        }

        // Récupérer les informations de la randonnée
        $randonnee_info = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si des informations ont été trouvées pour cette randonnée
        if(!$randonnee_info) {
            echo "Aucune information trouvée pour cette randonnée.";
            exit; // Arrêter l'exécution du script si aucune information n'est trouvée
        }
    } else {
        echo "L'identifiant de la randonnée n'a pas été spécifié dans l'URL.";
        exit; // Arrêter l'exécution du script si aucun identifiant de randonnée n'est spécifié dans l'URL
    }
} catch (PDOException $e) {
    // En cas d'erreur de connexion, afficher l'erreur
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Portfolio Details - Gp Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Template Main CSS File -->
    <link href="../assets/css/desc.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/styleARTICLE.css">
   
    <style>
      header {
            background-image: url('../assets/img/1.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 50vh; /* Ajustez la hauteur selon vos besoins */
            padding-top: 20px; /* Si nécessaire pour espacer la barre de navigation du haut */
        }
        </style>
</head>

<body>
<?php include('../layout/nav.php')?>


    <!-- ======= Header ======= -->

    <?php
// Connexion à la base de données
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

    // Vérifier si le formulaire de réservation a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_reservation'])) {
        // Définir une variable pour stocker les messages d'erreur
        $error_message = "";

        // Vérifier si le champ CIN et ID_randonnee sont remplis
        if (!empty($_POST['cin']) && !empty($_POST['id'])) {
            // Récupérer le CIN et l'ID de la randonnée
            $cin = $_POST['cin'];
            $randonnee_id = $_POST['id'];

            // Vérifier si le CIN existe dans la table randonneur
            $sql_check_cin = "SELECT COUNT(*) AS cin_count FROM randonneur WHERE CIN = ?";
            $stmt_check_cin = $pdo->prepare($sql_check_cin);
            $stmt_check_cin->execute([$cin]);
            $row_cin = $stmt_check_cin->fetch(PDO::FETCH_ASSOC);

            if ($row_cin['cin_count'] > 0) {
                // Le CIN existe dans la table randonneur, procéder à la vérification de la réservation
                // Vérifier si une réservation avec le même CIN et le même ID_randonnee existe déjà
                $sql_check_reservation = "SELECT COUNT(*) AS reservation_count FROM Reservation WHERE CIN = ? AND ID_randonnee = ?";
                $stmt_check_reservation = $pdo->prepare($sql_check_reservation);
                $stmt_check_reservation->execute([$cin, $randonnee_id]);
                $row_reservation = $stmt_check_reservation->fetch(PDO::FETCH_ASSOC);

                if ($row_reservation['reservation_count'] == 0) {
                    // Aucune réservation avec le même CIN et le même ID_randonnee n'existe, procéder à l'insertion
                    // Vérifier si le nombre de places disponibles est supérieur à zéro
                    $sql_check_places = "SELECT NbPersonnes FROM Randonnee WHERE ID_randonnee = ?";
                    $stmt_check_places = $pdo->prepare($sql_check_places);
                    $stmt_check_places->execute([$randonnee_id]);
                    $row_places = $stmt_check_places->fetch(PDO::FETCH_ASSOC);
                    $nb_places_disponibles = $row_places['NbPersonnes'];

                    if ($nb_places_disponibles > 0) {
                        // Insérer la réservation
                        $sql_insert_reservation = "INSERT INTO Reservation (CIN, ID_randonnee) 
                                                   VALUES (?, ?)";
                        $stmt_insert_reservation = $pdo->prepare($sql_insert_reservation);
                        $stmt_insert_reservation->execute([$cin, $randonnee_id]);

                        // Mettre à jour le nombre de places disponibles
                        $sql_update_places = "UPDATE Randonnee SET NbPersonnes = NbPersonnes - 1 WHERE ID_randonnee = ?";
                        $stmt_update_places = $pdo->prepare($sql_update_places);
                        $stmt_update_places->execute([$randonnee_id]);

                        // Redirection vers la page historique_reservation.php
                        header("Location: randonneur/historique_reservationrandonneur.php?cin=$cin");
                        exit(); // Assure que le script s'arrête ici pour éviter toute exécution supplémentaire
                    } else {
                        $error_message = "Désolé, il n'y a plus de places disponibles pour cette randonnée.";
                    }
                } else {
                    // Une réservation avec le même CIN et le même ID_randonnee existe déjà, afficher un message d'erreur
                    $error_message = "Vous avez déjà réservé cette randonnée.";
                }
            } else {
                // Le CIN n'existe pas dans la table randonneur, afficher un message d'erreur
                
                header("Location: inscription_randonneur.php");
                exit();
            }
        } else {
            // Le champ CIN ou ID_randonnee n'est pas rempli
            $error_message = "Veuillez remplir tous les champs.";
        }
    }

} catch (PDOException $e) {
    // En cas d'erreur de connexion, afficher l'erreur
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    die();
}
?>
    <main id="main">

        <!-- ======= Breadcrumbs ======= -->


        <!-- ======= Portfolio Details Section ======= -->
        <section id="portfolio-details" class="portfolio-details">
            <div class="container pb-5">
                <div class="row justify-content-center g-5">
                    <div class="col-xl-8 col-md-10 col-sm-12 ">
                        <div class="portfolio-details-slider swiper">
                            <div class="swiper-wrapper align-items-center">
                                <?php
                                // Affichage des images depuis la base de données
                                foreach (json_decode($randonnee_info['Image']) as $img) {
                                    ?>
                                    <div class="swiper-slide">
                                        <img src="../<?php echo $img; ?>" alt="randonnee" />
                                    </div>
                                <?php
                            }
                            ?>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>

                        <div class="boxe p-4 ">
                            <p placeholder="descriptipn"><?php echo $randonnee_info['Description']; ?></p>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="portfolio-info">
                            <h3><?php echo $randonnee_info['LibelleR']; ?></h3>
                            <ul>
                                <li><strong>Gouvernement</strong>: <?php echo $randonnee_info['LibelleV']; ?></li>
                                <li><strong>Date</strong>: <?php echo $randonnee_info['Date']; ?></li>
                                <li><strong>Durée</strong>: <?php echo $randonnee_info['Duree']; ?> j </li>
                                <li><strong>Prix</strong>: <?php echo $randonnee_info['Prix']; ?> DT</li>
                                <!-- $places_disponibles devrait être défini ici -->
                                <li><strong>Places </strong>:<?php echo $randonnee_info['NbPersonnes']; ?> restant</li>
                            </ul>
                        </div>

                        <div class="portfolio-description">
                            <div class="portfolio-info">
                                <h3>Caractéristiques </h3>
                                <ul>
                                    <li><strong>Catégorie</strong>: <?php echo $randonnee_info['LibelleC']; ?></li>
                                    <li><strong>Difficulté</strong>: <?php echo $randonnee_info['LibelleD']; ?></li>
                                    <li><strong>Activite</strong>: <?php echo $randonnee_info['LibelleA']; ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </section><!-- End Portfolio Details Section -->

        <!-- Formulaire de réservation -->
        <section id="reservation" class="reservation">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-title" data-aos="fade-up">
                                    <h2>Réserver cette randonnée</h2>
                                </div>
                            </div>
                        </div>
                        <form action="" method="post" >
                            <div class="row">
                                <div class="col-md-12 form-group">
                                <input type="text" class="form-control" name="cin" id="cin" placeholder="Votre CIN" pattern="[0-9]{8}" title="Votre CIN " maxlength="8" style=" border-radius:30px; height:48px; padding:10px 20px;" required >
                                </div>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $ID_randonnee; ?>">
                            <div class="text-center"><button type="submit" name='submit_reservation' style="  background-color:#DEEF09; border:none; border-radius:30px; height: 48px; font-weight:600px; ;  padding: 0 48px ; margin-top:20px ">Réserver</button></div>
                        </form>
                        <script>
    function validateCIN() {
        var cinValue = document.getElementById('cin').value;
        if (cinValue.length !== 8 || !(/^\d+$/.test(cinValue))) {
            alert("Votre CIN doit contenir exactement 8 chiffres.");
            return false;
        }
        return true;
    }
</script>
<script>
document.getElementById('cin').addEventListener('input', function(event) {
    // Remplacer tout caractère non numérique par une chaîne vide
    this.value = this.value.replace(/\D/g, '');
});
</script>
                        <!-- Affichage des messages d'erreur -->
                    <?php if (!empty($error_message)) : ?>
                        <div class="error-message"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

    </main>
   

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="../assets/vendor/aos/aos.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>
    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>
   
      <?php include('../layout/le-footer.php')?>

</body>

</html>