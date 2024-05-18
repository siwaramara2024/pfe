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

  <title>RANDO PASSER</title>
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

  <!-- Template Main CSS File -->
  <link href="../assets/css/Stylerandopasse.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/agence1.css">
   <link rel="stylesheet" href="../assets/css/news.css">
   <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <style>
    .card {
        margin: 20px;
    }
   
/* Masquer les indicateurs de pagination */
.slick-dots {
    display: none !important;
}

  .custom-btn {
    padding: 10px 20px;
    margin: 10px;
    text-decoration:solid;
    color: black; /* Text color */
    background-color: #DFEF57; /* Button background color */
    border-radius: 30px;
    border: none; /* Optional: Remove default border */
    display: inline-block; /* Ensure the element behaves like a button */
    transition: background-color 0.3s ease; /* Smooth transition for hover effect */
  }

  .custom-btn:hover {
    background-color: #c5d848; /* Darker shade for hover effect */
  }

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
  <section id="portfolio" class="portfolio">
  <div class="" data-aos="fade-up">
    <div class="section-title">
      <h2>Portfolio</h2>
      <p>Découvrez notre portfolio de randonnées</p>
    </div>
    <div class="row" data-aos="fade-up" data-aos-delay="100">
      <div class="col-lg-12 d-flex justify-content-center">
        <div>
          <a href="rando_agence.php?id_agence=<?php echo $agenceId; ?>" class="btn custom-btn"> A venir</a>
          <a href="rando_passe.php?id_agence=<?php echo $agenceId; ?>" class="btn custom-btn"> Déjà effectuée</a>
        </div>
      </div>
    </div>
  </div>
</section><!-- End Portfolio Section -->
<section id="portfolio" class="portfolio">

  
          <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
  
            <div class="col-lg-4 col-md-6 portfolio-item">
              <div class="portfolio-wrap">
                <img src="../assets/img/volet.jpg" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>El kef</h4>
                  <p>El ghaba</p>
                  <div class="portfolio-links">
                    <a href="../assets/img/volet.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox" title="App 1"><i class="bx bx-plus"></i></a>
                    <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                  </div>
                </div>
              </div>
            </div>
  
            <div class="col-lg-4 col-md-6 portfolio-item ">
              <div class="portfolio-wrap">
                <img src="../assets/img/mekla.jpg" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Tbarka</h4>
                  <p>Forret</p>
                  <div class="portfolio-links">
                    <a href="../assets/img/mekla.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox" title="Web 3"><i class="bx bx-plus"></i></a>
                    <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                  </div>
                </div>
              </div>
            </div>
  
            <div class="col-lg-4 col-md-6 portfolio-item ">
              <div class="portfolio-wrap">
                <img src="../assets/img/selfi.jpg" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Douz</h4>
                  <p>Saahara</p>
                  <div class="portfolio-links">
                    <a href="../assets/img/selfi.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox" title="App 2"><i class="bx bx-plus"></i></a>
                    <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                  </div>
                </div>
              </div>
            </div>
  
            <div class="col-lg-4 col-md-6 portfolio-item ">
              <div class="portfolio-wrap">
                <img src="../assets/img/sane.jpg" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Card 2</h4>
                  <p>Card</p>
                  <div class="portfolio-links">
                    <a href="../assets/img/sane.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox" title="Card 2"><i class="bx bx-plus"></i></a>
                    <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                  </div>
                </div>
              </div>
            </div>
  
            <div class="col-lg-4 col-md-6 portfolio-item ">
              <div class="portfolio-wrap">
                <img src="../assets/img/nar.jpg" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Gbeli</h4>
                  <p>El jbal</p>
                  <div class="portfolio-links">
                    <a href="../assets/img/nar.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox" title="Web 2"><i class="bx bx-plus"></i></a>
                    <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                  </div>
                </div>
              </div>
            </div>
  
            <div class="col-lg-4 col-md-6 portfolio-item ">
              <div class="portfolio-wrap">
                <img src="../assets/img/palestine.jpg" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Tela</h4>
                  <p>El jbal</p>
                  <div class="portfolio-links">
                    <a href="../assets/img/palestine.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox" title="App 3"><i class="bx bx-plus"></i></a>
                    <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                  </div>
                </div>
              </div>
            </div>
  
            <div class="col-lg-4 col-md-6 portfolio-item ">
              <div class="portfolio-wrap">
                <img src="../assets/img/gitar.jpg" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Beja</h4>
                  <p>Beni mtir</p>
                  <div class="portfolio-links">
                    <a href="../assets/img/gitar.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox" title="Card 1"><i class="bx bx-plus"></i></a>
                    <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                  </div>
                </div>
              </div>
            </div>
  
            <div class="col-lg-4 col-md-6 portfolio-item ">
              <div class="portfolio-wrap">
                <img src="../assets/img/ain drahem.png" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>AIN DRAHEM</h4>
                  <p>Forret</p>
                  <div class="portfolio-links">
                    <a href="../assets/img/ain drahem.png" data-gallery="portfolioGallery" class="portfolio-lightbox" title="Card 3"><i class="bx bx-plus"></i></a>
                    <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                  </div>
                </div>
              </div>
            </div>
  
            <div class="col-lg-4 col-md-6 portfolio-item ">
              <div class="portfolio-wrap">
                <img src="../assets/img/ghaba.jpg" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>WED EL KSAB</h4>
                  <p>Plage et forret</p>
                  <div class="portfolio-links">
                    <a href="../assets/img/ghaba.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox" title="Web 3"><i class="bx bx-plus"></i></a>
                    <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                  </div>
                </div>
              </div>
            </div>
  
          </div>
  
        </div>
      </section><!-- End Portfolio Section -->  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
     
     
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