<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pfe";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Récupérer l'ID de l'agence à partir de l'URL
if(isset($_GET['id_agence'])) {
    $agenceId = $_GET['id_agence'];
} else {
    // Rediriger ou afficher un message d'erreur si l'ID de l'agence n'est pas spécifié dans l'URL
    exit("ID de l'agence non spécifié dans l'URL");
}
// Fonction pour récupérer les randonnées filtrées depuis la base de données pour une agence spécifique
function getFilteredRandonneesForAgence($agenceId, $conn) {
    // Construction de la requête SQL pour récupérer les randonnées de l'agence spécifique
    $sql = "SELECT * FROM Randonnee WHERE ID_agence = $agenceId";

    // Exécuter la requête SQL
    $result = $conn->query($sql);

    if (!$result) {
        die("Error in query: " . $conn->error);
    }

    $randonnees = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $randonnees[] = $row;
        }
    }

    return $randonnees;
}

// Fonction pour récupérer les données de l'agence à partir de son ID
function getAgenceData($agenceId, $conn) {
    // Construction de la requête SQL pour récupérer les données de l'agence
    $sql = "SELECT * FROM Agence_de_voyage WHERE ID_agence = $agenceId";

    // Exécuter la requête SQL
    $result = $conn->query($sql);

    if (!$result) {
        die("Error in query: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return null; // Si aucun résultat n'est trouvé
    }
}

// Récupérer les données de l'agence
$agenceData = getAgenceData($agenceId, $conn);

// Assurez-vous de vérifier si $agenceData n'est pas null avant d'accéder à ses valeurs
if ($agenceData) {
    // Accédez aux valeurs comme ceci :
    $nomAgence = $agenceData['Nom'];
   
    // Et ainsi de suite...
} else {
    // Gérez le cas où aucune donnée d'agence n'est trouvée pour cet ID
}

// Récupérer les randonnées de l'agence spécifique
$filteredRandonnees = getFilteredRandonneesForAgence($agenceId, $conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">

     <!-- Favicon -->
     <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicon.ico">
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">


  <!-- Slick Carousel CSS -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">

   <!-- Slick Carousel JS -->
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

 <!-- Vendor CSS Files -->
 <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="../assets/vendor/card/_card.scss">

   <!-- Additional CSS Files -->
   <link rel="stylesheet" href="../assets/css/styleL.css" />
   <link rel="stylesheet" href="../assets/css/agence1.css">
   <link rel="stylesheet" href="../assets/css/news.css">
   <link  rel="stylesheet" href="../assets/css/responsive.css"/>
   <link  rel="stylesheet" href="../assets/css/header1.css"/>
  

  

   <!-- Title -->
   <title>Randonnées en Tunisie</title>
   <style>
        .card {
            margin: 20px;
        }
        .card-header{
            padding:inherit !important ;
        }
       
    /* Masquer les indicateurs de pagination */
    .slick-dots {
        display: none !important;
    }
    header {
            background-image: url('../assets/img/ar.jpg');
            background-size: cover;
            background-attachment: fixed;
            max-height: 50px;
            
          
        }

      
</style>
</head>


<body>
<?php include('../layout/nav.php')?>





      <!-- ======= Features Section ======= -->
  <section id="features" class="features">
    <div class="container" data-aos="fade-up">

      <div class="row">
        <div class="image col-lg-6" style='background-image: url("../images/<?php echo basename($agenceData['Image']); ?>");' data-aos="fade-right"></div>
        <div class="col-lg-6 d-flex justify-content-center align-items-center" data-aos="fade-left" data-aos-delay="100">
          <div class="icon-box mt-5 mt-lg-0" data-aos="zoom-in" data-aos-delay="150">
            <table class="info-tablee ">
              <tr>
                <td  colspan="3" class="nomA" ><?php echo $agenceData['Nom']?> </td>
              </tr>
              <tr>
                 <td colspan="3" class="biographie"> <?php echo $agenceData['Bio']?>  </td>
                
              </tr>
              <tr class=" les-bis">
                 <td><i class="bi bi-star-fill"></i><?php echo $agenceData['LibelleV']?></td>
                  <td><i class="bi bi-geo"></i><?php echo $agenceData['LibelleV']?></td>
                  <td><i class="bi bi-phone" ></i><?php echo $agenceData['Telephone']?></td>
              </tr>
          </table>
          
        </div>
      </div>
    </div>
  </div>
  </section><!-- End Features Section -->

  <!-- ======= Portfolio Section ======= -->
  <section id="portfolio" class="portfolio">
    <div class="" data-aos="fade-up">
      <div class="section-title" >
        <h2>Portfolio</h2>
        <p >Découvrez notre portfolio de randonnées</p>
      </div>
      <div class="row" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-12 d-flex justify-content-center">
          <ul id="portfolio-flters">
                <li data-filter="*" class="filter-active"> À venir </li>
                <li><a href="rando_passe.php?id_agence=<?php echo $agenceId; ?>" id="filter-app">Déjà effectué</a></li>
      </ul>
        </div>
      </div>

    </div>
  </section><!-- End Portfolio Section -->
    <!-- Mettre vos balises HTML ici -->

    <div class="container mx-auto px-4">
        <?php
        // Affichage des randonnées filtrées
        foreach ($filteredRandonnees as $randonnee) {
        ?>
            <div class="mb-5">
                <a href="details_randonnee.php?id=<?php echo $randonnee['ID_randonnee']; ?>"> <!-- Ajout de la balise <a> pour la redirection -->

                    <div class="card"> <!-- Ajout de la classe mb-4 pour ajouter de l'espace entre les cartes -->
                        <div class="card-header test"  >
       
                    
                        <div class="slider"  style="margin-bottom: 0;   ">
                        <?php
                        // Affichage des randonnées filtrées
                        foreach (json_decode($randonnee['Image']) as $img) {
                        ?>
                            <div>
                                <img src="../<?php echo $img; ?>"  alt="randonnee" />
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                        <div class="card-body">
                            <div class="user-and-tag">
                                <div class="user">
                                    <img src="../assets/img/h1.png" alt="user" />
                                    <div class="user-info">
                                        <h5><?php echo $agenceData['Nom']?></h5> <!-- Modification pour afficher le nom de l'agence -->
                                        <small>Agence de voyage</small>
                                    </div>
                                </div>
                                <span class="tag <?php echo $randonnee['LibelleC'] == 'randonnée' ? 'tag-pink' : 'tag-purple'; ?>"><?php echo $randonnee['LibelleC']; ?></span>
                            </div>
                            <h4><?php echo $randonnee['LibelleR']; ?></h4>
                            <table class="info-table">
                                <tr>
                                    <td><i class="bi bi-calendar"></i> <?php echo $randonnee['Date']; ?></td>
                                    <td><i class="bi bi-clock"></i> <?php echo $randonnee['Duree']; ?> j</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-trophy"></i> <?php echo $randonnee['LibelleD']; ?></td>
                                    <td><i class="bi bi-cash"></i> <?php echo $randonnee['Prix']; ?> DT</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </a>
            </div>
        <?php
        }
        ?>
    </div>


    <!-- Mettre vos scripts JavaScript ici -->
      <!-- Script JavaScript pour le filtrage -->
      <script>
        // Fonction pour mettre à jour la valeur du prix
        function updatePriceValue() {
            const priceRange = document.getElementById('price-range');
            const priceValue = document.getElementById('price-value');
            priceValue.textContent = priceRange.value + ' DT';
        }
    </script>
    <script>
    $(document).ready(function(){
        $('.slider').slick({
            dots: true, // Afficher les indicateurs de pagination
            infinite: true, // Activer le défilement infini du slider
            autoplay: true, // Activer la lecture automatique du slider
            autoplaySpeed: 2000 // Durée de l'animation en millisecondes
        });
    });
</script>
  <!-- JS -->
  <script src="../assets/js/news.js"></script>
  <script src="../assets/js/mainn.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <!--  Main JS File -->
  <script src="../assets/js/main.js"></script>
  <script>
        function myFunction() {
          var x = document.getElementById("myTopnav");
          if (x.className === "topnav") {
            x.className += " responsive";
          } else {
            x.className = "topnav";
          }
        }
                
        $(document).ready(function() {
            $(".navbar-toggler-custom").on("click", function() {
                var cible = $(this).next('.collapse-custom');
                cible.toggle();
            });
        });
    </script> 
        <?php include('../layout/le-footer.php')?>

</body>

</html>
