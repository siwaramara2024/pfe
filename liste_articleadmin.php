<?php
// Fonction pour établir la connexion à la base de données
function connectDB() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pfe";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

    return $conn;
}

// Appeler la fonction pour établir la connexion
$conn = connectDB();

// Sélection de toutes les randonnées depuis la base de données
$sql = "SELECT * FROM article";
if (isset($_GET['query'])) {
  $search_query = $_GET['query'];
  // Vous pouvez utiliser la fonction de recherche LIKE pour rechercher dans le titre1 et l'id
  $sql = "SELECT * FROM article WHERE titre1 LIKE '%$search_query%' OR id = '$search_query'";
}

$result = $conn->query($sql);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style-liste.css">
    <title>Liste des Articles</title>
   
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
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/styledashboard.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
 <style>
  body {
            background-color: transparent; /* Rendre le fond de la page transparent */
        }
        .table-container {
            overflow-x: auto; /* Permettre le défilement horizontal */
        }


        table {
            border-collapse: collapse;
            width: 100%;
            border-radius: 30px; /* Coins arrondis pour la table */
        }

       /* Alignement vertical du contenu de chaque cellule */
th, td {
    border: 1px solid #B1D5E2;
    padding: 8px;
    text-align: left;
    vertical-align: top; /* Alignement en haut */
}

/* Styles pour chaque colonne en mode responsif */



        th {
            background-color: #568894;width: 150px; /* Couleur de fond de l'en-tête du tableau */
            color: white; /* Couleur du texte dans l'en-tête du tableau */
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
            border: 1px solid #B1D5E2;
            border-radius: 30px;
            padding: 10px;
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
        
        /* Flexbox pour aligner les colonnes horizontalement */
        .table-container {
            display: flex;
            flex-wrap: wrap;
        }

      
    
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
      <form class="search-form d-flex align-items-center" method="GET" action="">
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
            <!--<span class="badge bg-primary badge-number"> </span>-->
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
            Consultez-vous vos notifications ?
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2"> voir tous</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

             <!-- Affichage dynamique de la notification pour la nouvelle inscription -->
    <li class="notification-item">
    <a href="liste_randonneuradmin.php">
        <i class="bi bi-check-circle text-success"></i></a>
        <div>
            <h4>Nouvelle inscription Randonneur</h4>
            <p>Un nouvel utilisateur s'est inscrit siwar</p>
            <p>2024-05-1</p>
        </div>
    </li>
    <li class="notification-item">
    <a href="liste_agenceadmin.php">
        <i class="bi bi-check-circle text-success"></i></a>
        <div>
            <h4>Nouvelle inscription Agence </h4>
            <p>Une nouvelle agence de voyage s'est inscrite : traveltodo</p>
            <p> 2024-06-08</p>
        </div>
    </li>
    <a href="reservation_admin.php">
    <li class="notification-item">
        <i class="bi bi-info-circle text-primary"></i></a>
        <div>
            <h4>Nouvelle réservation</h4>
            <p>Une nouvelle réservation a été effectuée par le randonneur :1465201 pour la randonnée Num 15</p>
            <p> à 2024-07-08</p>
        </div>
    </li>
    <li>
        <hr class="dropdown-divider">
    </li>
           

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

     
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
      <a class="nav-link collapsed "  href="ajout_article.php">
        <i class="bi bi-plus-circle"></i>
        <span>Ajouter article </span>
      </a>
      </li>
      <li class="nav-item">
        <a class="nav-link "  href="liste_articleadmin.php">
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
    <div class=" " style="margin-bottom:40px;">
        <h1 class="" style="font-family: Century Gothic; text-align: center;margin-bottom: 40px; color: #568894;">Liste des Articles</h1>
        <div class="form-container" style="margin-top: 40px; background-color: #ededec;overflow-y: auto; scrollbar-width: thin;">

        <table>
        <tr class="fixed-row">
            <th>ID</th>
            <th>Titre</th>
            <th>Date et heure d'ajout</th>
            <th>Action</th>
           
           
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id_article"] . "</td>";
                echo "<td>" . $row["titre1"] . "</td>";
                echo "<td>" . $row["date_heure_ajout"] . "</td>";
                echo "<td><a href='modifier_article.php?id_article=" . $row['id_article'] . "'>Modifier</a> | <a href='supprimer_article.php?id_article=" . $row['id_article'] . "'>Supprimer</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='11'>Aucun article trouvé.</td></tr>";
        }
        ?>
    </table>
        
        </div>
    </div>
</main><!-- End #main -->
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

<?php
// Fermeture de la connexion à la base de données
$conn->close();
?> 
