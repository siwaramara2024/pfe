<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pfe";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion à la base de données
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Vérifier si l'identifiant de l'article est passé en paramètre
if (!isset($_GET['id_article']) || empty($_GET['id_article'])) {
    echo "Identifiant de l'article non spécifié.";
    exit;
}

$article_id = $_GET['id_article'];

// Récupérer les informations de l'article à modifier
$stmt = $conn->prepare("SELECT * FROM Article WHERE id_article = ?");
$stmt->bind_param("i", $article_id);
$stmt->execute();
$result = $stmt->get_result();

// Vérifier si l'article existe
if ($result->num_rows === 0) {
    echo "Article non trouvé.";
    exit;
}

$row = $result->fetch_assoc();

// Initialiser les messages d'erreur et de succès
$errors = [];
$success_message = "";

// Traitement du formulaire de modification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données soumises
    $titre1 = htmlspecialchars($_POST['titre1']);
    $paragraphe1 = htmlspecialchars($_POST['paragraphe1']);
    $titre2 = htmlspecialchars($_POST['titre2']);
    $paragraphe2 = htmlspecialchars($_POST['paragraphe2']);
    $titre3 = htmlspecialchars($_POST['titre3']);
    $paragraphe3 = htmlspecialchars($_POST['paragraphe3']);
   

        // Requête SQL pour mettre à jour l'article
        $sql_update = "UPDATE Article SET titre1 = ?, paragraphe1 = ?, titre2 = ?, paragraphe2 = ?, titre3 = ?, paragraphe3 = ? WHERE id_article = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("ssssssi", $titre1, $paragraphe1, $titre2, $paragraphe2, $titre3, $paragraphe3, $article_id);

    if ($stmt->execute()) {
        $success_message = "L'article a été modifié avec succès.";
        header("Location: liste_articleadmin.php");
        exit; // Terminer le script après la redirection
    } else {
        $errors[] = "Erreur lors de la modification de l'article : " . $conn->error;
    }
}


$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

 <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">


  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

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
  <link href="../assets/css/dash article.css" rel="stylesheet">


 <style>
      body {
      background-color: transparent; /* Rendre le fond de la page transparent */
    }

    .form-container {
      height: 430px;
      background-color: transparent !important; /* Rendre le fond du conteneur transparent */
    }
    ::placeholder {
        padding: 20px; /* Ajoutez le padding désiré */
    }
    .input-text {
      width: 100%;
      border: 1px solid #B1D5E2; border-radius: 30px;" onmouseover="this.style.borderColor='#568894';" onmouseout="this.style.borderColor='#B1D5E2';; border-radius: 30px;" onmouseover="this.style.borderColor='#568894';" onmouseout="this.style.borderColor='#B1D5E2'; ; /* Ajouter une bordure autour de l'input */
      border-radius: 30px; /* Ajouter des coins arrondis à la bordure */
      padding: 10px; /* Ajouter un remplissage à l'intérieur de l'input */
      background-color: transparent; /* Rendre le fond de l'input transparent */
    }
  .form-row-split {
    display: flex;
    justify-content: space-between;
}

/* CSS pour les colonnes des champs */
.form-col {
    width: calc(50% - 20px); /* Ajustez la largeur selon vos besoins */
    margin-bottom: 20px;
}

/* CSS pour les champs d'entrée */

 
   
 </style>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
      <img src="../assets/img/logo site.png" alt="" style="width: 200px;">
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>

   </div>
   
    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
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

        

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="../assets/img/h0.png" alt="Profile" class="rounded-circle " style=" box-shadow: 0 5px 30px 0 rgba(89, 105, 63, 0.2);">
            
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Kevin Anderson</h6>
              <span>Web Designer</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
   <!-- ======= Sidebar ======= -->
   <aside id="sidebar" class="sidebar">
    

    <ul class="sidebar-nav" id="sidebar-nav">
   <li class="nav-item">
    <a class="nav-link collapsed" href="profil_admin.php?id_admin=1">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed"  href="reservation_admin.php">
      <i class="bi bi-layout-text-window-reverse"></i>
      <span>Liste des Réservation</span>
    </a>
  </li>
    <!-- End Tables Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed"  href="liste_randonneeadmin.php">
        <i class="bi bi-layout-text-window-reverse"></i>
        <span>Liste des randonnées</span>
      </a>
      </li>
    <li class="nav-item">
      <a class="nav-link collapsed"  href="liste_agenceadmin.php">
        <i class="bi bi-layout-text-window-reverse"></i>
        <span>Liste des agences</span>
      </a>
      </li>
    <li class="nav-item">
      <a class="nav-link collapsed"  href="liste_randonneuradmin.php">
        <i class="bi bi-layout-text-window-reverse"></i>
        <span>Liste des randonneurs</span>
      </a>
      </li>
    <li class="nav-item">
      <a class="nav-link "  href="ajout_article.php">
        <i class="bi bi-plus-circle"></i>
        <span>Ajouter article </span>
      </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed"  href="liste_articleadmin.php">
          <i class="bi bi-list"></i>
          <span>Liste Article</span>
        </a>
        </li>
      <li class="nav-item">
        <a class="nav-link collapsed"  href="reserrvation.php">
          <i class="bi bi-bell"></i>
          <span>Notification</span>
        </a>
        </li>
  </li><!-- End Charts Nav -->

  
  </li><!-- End Contact Page Nav -->    
  <li class="nav-item">
    <a class="nav-link collapsed" href="../login_adminnew.php">
      <i class="bi bi-box-arrow-right"></i>
      <span>Déconnexion</span>
    </a>
  </li><!-- End Dashboard Nav -->                                        
</ul>

</aside><!-- End Sidebar-->
  <main id="main" class="main" style="box-shadow: 0px 0px 20px rgba(255, 255, 255, 0.1); background-color: #fff; border: 2px solid #B1D5E2;">
    <div class="" style="margin-bottom:40px;">
        <h1 class="" style="font-family: Century Gothic; text-align: center;margin-bottom: 40px; color: #568894;">Modifier un Article</h1>
        <div class="form-container" style="margin-top: 40px; background-color: #ededec;">
            <form  method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-col form-col-split">
                        <div class="form-row">
                            <input type="text" id="titre1" name="titre1" required placeholder="Titre 1" value="<?php echo $row['titre1']; ?>" style="border: 1px solid #B1D5E2; border-radius: 30px;" onmouseover="this.style.borderColor='#568894';" onmouseout="this.style.borderColor='#B1D5E2';">
                        </div>
                        <br>
                        <div class="form-row">
                            <textarea id="paragraphe1" name="paragraphe1" required placeholder="Paragraphe 1" style="border: 1px solid #B1D5E2; border-radius: 30px;" onmouseover="this.style.borderColor='#568894';" onmouseout="this.style.borderColor='#B1D5E2';"><?php echo $row['paragraphe1']; ?></textarea>
                        </div>
                    </div>

                    <div class="form-col form-col-split">
                        <div class="form-row">
                            <input type="text" id="titre2" name="titre2" required placeholder="Titre 2" value="<?php echo $row['titre2']; ?>" style="border: 1px solid #B1D5E2; border-radius: 30px;" onmouseover="this.style.borderColor='#568894';" onmouseout="this.style.borderColor='#B1D5E2';">
                        </div>
                        <br>
                        <div class="form-row">
                            <textarea id="paragraphe2" name="paragraphe2" required placeholder="Paragraphe 2" style="border: 1px solid #B1D5E2; border-radius: 30px;" onmouseover="this.style.borderColor='#568894';" onmouseout="this.style.borderColor='#B1D5E2';"><?php echo $row['paragraphe2']; ?></textarea>
                        </div>
                    </div>

                    <div class="form-col form-col-split">
                        <div class="form-row">
                            <input type="text" id="titre3" name="titre3" required placeholder="Titre 3"value="<?php echo $row['titre3']; ?>" style="border: 1px solid #B1D5E2; border-radius: 30px;" onmouseover="this.style.borderColor='#568894';" onmouseout="this.style.borderColor='#B1D5E2';">
                        </div>
                        <br>
                        <div class="form-row">
                            <textarea id="paragraphe3" name="paragraphe3" required placeholder="Paragraphe 3" style="border: 1px solid #B1D5E2; border-radius: 30px;" onmouseover="this.style.borderColor='#568894';" onmouseout="this.style.borderColor='#B1D5E2';"><?php echo $row['paragraphe3']; ?></textarea>
                        </div>
                    </div>
                </div>

               
               
                
              <input type="submit" value="Modifier" style="border-radius: 30px; width:100px; padding: 10px 20px; float: right; color: black; background-color: #deef09; margin-top: 0; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#c0df06';" onmouseout="this.style.backgroundColor='#deef09';">
                
            </form>
        </div>
    </div>
</main>

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
  
  <script src="../assets/js/main1.js"></script>
</body>

</html>
