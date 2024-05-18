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

    // Vérifier si l'identifiant du randonneur est passé dans l'URL
    if(isset($_GET['CIN'])) {
     
        $CIN = $_GET['CIN'];
        
        // Requête SQL pour récupérer les informations du randonneur
        $sql = "SELECT * FROM Randonneur WHERE CIN = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$CIN]);

        // Vérifier s'il y a eu des erreurs lors de l'exécution de la requête
        $errors = $stmt->errorInfo();
        if($errors[0] !== '00000') {
            // Afficher l'erreur et arrêter l'exécution du script
            die("Erreur lors de l'exécution de la requête : " . $errors[2]);
        }

        // Récupérer les informations du randonneur
        $randonneur_info = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si des informations ont été trouvées pour ce randonneur
        if($randonneur_info) {
?>


<?php
        } else {
            echo "Aucune information trouvée pour ce randonneur.";
        }
    } else {
        echo "L'identifiant du randonneur n'a pas été spécifié dans l'URL.";
    }
} catch (PDOException $e) {
    // En cas d'erreur de connexion, afficher l'erreur
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    die();
}
$cin = $_GET['CIN'];
$stmt = $pdo->prepare("SELECT Image FROM Randonneur WHERE CIN = ?");
$stmt->execute([$CIN]);

$image_path = $stmt->fetchColumn();
if($randonneur_info) {
  // Votre code existant ...

  // Maintenant, récupérons la dernière randonnée ajoutée
  $sql_new_randonnee = "SELECT * FROM Randonnee ORDER BY ID_randonnee DESC LIMIT 1";
  $stmt_new_randonnee = $pdo->query($sql_new_randonnee);
  $last_randonnee = $stmt_new_randonnee->fetch(PDO::FETCH_ASSOC);

  // Si une nouvelle randonnée a été ajoutée, affichez-la dans la liste de notifications
  if($last_randonnee) {}}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>dashboard-randonneur</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrapA/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrapA-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxiconsA/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quillA/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/quillA/quill.bubble.css" rel="stylesheet">
  <link href="../assets/vendor/remixiconA/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatablesA/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/styledashboard.css" rel="stylesheet">

  
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="../rando_filtre.php" class="logo d-flex align-items-center">
      <img src="../assets/img/logo site.png" alt="" style="width: 200px;">
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
   </div>
   
    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Rechercher" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

<a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
  <i class="bi bi-bell"></i>
 
</a><!-- End Notification Icon -->

<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
  <li class="dropdown-header">
   Consulte tes notifications
    <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">voir tous </span></a>
  </li>
  <li>
    <hr class="dropdown-divider">
  </li>

  <li class="notification-item">
<a href="../rando_filtre.php">
  <i class="bi bi-check-circle text-success"></i>
</a>
<div>
  <h4>Nouvelle Randonnée ajoutée</h4>
  <p>Une nouvelle randonnée a été ajoutée avec le Nom : <?php echo $last_randonnee['LibelleR']; ?></p>
  <p><?php echo date('Y-m-d H:i:s'); ?></p>
</div>
</li>

</ul><!-- End Notification Dropdown Items -->

</li><!-- End Notification Nav -->

        

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="<?php echo htmlspecialchars($image_path); ?>" alt="Profile" class="rounded-circle shadow">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $randonneur_info['Nom']; ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $randonneur_info['Nom']; ?></h6>
              <span>Randonneur</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="profil_randonneur.php?CIN=<?php echo $randonneur_info['CIN']; ?>">
                <i class="bi bi-person"></i>
                <span>Mon Profil</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="../login_randonneur.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Déconnexion</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    

        <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-heading">Pages</li>
      <li class="nav-item">
        <a class="nav-link collapsed " href="profil_randonneur.php?CIN=<?php echo $randonneur_info['CIN']; ?>">
          <i class="bi bi-person"></i>
          <span>Profil</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed"  href="historique_reservationrandonneur.php?cin=<?php echo $cin; ?>">
          <i class="bi bi-layout-text-window-reverse"></i>
          <span>Mes Réservation</span>
        </a>
      </li>
        <!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link " href="contact_randonneur.php?CIN=<?php echo $randonneur_info['CIN']; ?>">
          <i class="bi bi-envelope"></i>
          <span>Contact</span>
        </a>
      </li><!-- End Contact Page Nav -->    
      <li class="nav-item">
        <a class="nav-link collapsed" href="../login_randonneur.php">
          <i class="bi bi-box-arrow-right"></i>
          <span>Déconnexion</span>
        </a>
      </li><!-- End Dashboard Nav -->                                        
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="">
      <h1>Profil</h1>
      <!--<nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>-->
    </div><!-- End Page Title -->

    <section class="section contact">

    <div class="row gy-4">

<div class="col-xl-6">

  <div class="row">
    <div class="col-lg-6">
      <div class="info-box card">
        <i class="bi bi-geo-alt"></i>
        <h3>Adresse </h3>
        <p>13 Rue saadi ,<br>Menzah 4,Tunis</p>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="info-box card">
        <i class="bi bi-telephone"></i>
        <h3>Contactez-nous</h3>
        <p>++216 31 31 31 31<br>+216 53 53 53 53</p>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="info-box card">
        <i class="bi bi-envelope"></i>
        <h3>Notre adresse </h3>
        <p>elmundo@gmail.com<br>elmundo_info@gmail.com</p>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="info-box card">
        <i class="bi bi-clock"></i>
        <h3>Horaire d'ouverture</h3>
        <p>Lundi au vendredi<br>
                De 9h00 à 17h00</p>
      </div>
    </div>
  </div>

</div>

  <div class="col-xl-6">
    <div class="card p-4">
      <form action="../forms/contact.php" method="post" class="php-email-form">
        <div class="row gy-4">

          <div class="col-md-6">
            <input type="text" name="name" class="form-control" placeholder="Votre nom" required>
          </div>

          <div class="col-md-6 ">
            <input type="email" class="form-control" name="email" placeholder="Votre Email" required>
          </div>

          <div class="col-md-12">
            <input type="text" class="form-control" name="subject" placeholder="Sujet" required>
          </div>

          <div class="col-md-12">
            <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
          </div>

          <div class="col-md-12 text-center">
            <div class="loading">Chargement en cours...</div>
            <div class="error-message"></div>
            <div class="sent-message">Message envoyé avec succée</div>

            <button type="submit">Envoyer le Message</button>
          </div>

        </div>
      </form>
    </div>

  </div>

</div>

</section>

  </main><!-- End #main -->

  

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

 

   <!-- Vendor JS Files -->
   <script src="../assets/vendor/apexchartsA/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrapA/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.jsA/chart.umd.js"></script>
  <script src="../assets/vendor/echartsA/echarts.min.js"></script>
  <script src="../assets/vendor/quillA/quill.js"></script>
  <script src="../assets/vendor/simple-datatablesA/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymceA/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-formA/validate.js"></script>

  <!--Main JS File -->
  <script src="../assets/js/maindashboard.js"></script>
  <script src="../assets/js/main1.js"></script>
</body>

</html>