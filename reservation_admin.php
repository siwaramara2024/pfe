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

// Sélection de toutes les réservations depuis la base de données
$sql = "SELECT * FROM reservation";

// Vérifier s'il y a une recherche en cours
if (isset($_GET['query'])) {
    $search_query = $_GET['query'];
    // Utiliser la fonction de recherche LIKE pour rechercher dans le CIN, ID_reservation et ID_randonnee
    $sql = "SELECT * FROM reservation WHERE CIN LIKE '%$search_query%'
            OR ID_reservation = '$search_query' OR ID_randonnee = '$search_query'";
}

$result = $conn->query($sql);

// Vérifier s'il y a une nouvelle inscription
$sql = "SELECT * FROM Randonneur ORDER BY CIN DESC LIMIT 1";
$result_randonneur = $conn->query($sql);

if ($result_randonneur->num_rows > 0) {
    // Il y a une nouvelle inscription
    $row = $result_randonneur->fetch_assoc();
    $username = $row["Nom"] . ' ' . $row["Prenom"];
    
    // Afficher la notification dans le menu de navigation
}

// Vérifier si une nouvelle agence a été enregistrée
$sql = "SELECT * FROM Agence_de_voyage ORDER BY ID_agence DESC LIMIT 1";
$result_agence = $conn->query($sql);

if ($result_agence->num_rows > 0) {
    // Il y a une nouvelle agence enregistrée
    $row = $result_agence->fetch_assoc();
    $agency_name = $row["Nom"];
}

// Vérifier s'il y a une nouvelle réservation
$sql = "SELECT * FROM Reservation ORDER BY ID_reservation DESC LIMIT 1";
$result_reservation = $conn->query($sql);

if ($result_reservation->num_rows > 0) {
    // Il y a une nouvelle réservation
    $row = $result_reservation->fetch_assoc();
    $reservation_id = $row["ID_reservation"];
    $randonneur_cin = $row["CIN"];
    $randonnee_id = $row["ID_randonnee"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style-liste.css">
    <title>Liste des Randonnées</title>
   
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
.fixed-row th {
        position: sticky;
        top: 0;
        z-index: 1;
        background-color: #FDFD96;
        color: black;
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
  <p>Un nouvel utilisateur s'est inscrit : <?php echo $username; ?></p>
  <p><?php echo date('Y-m-d H:i:s'); ?></p>
</div>
</li>
<li class="notification-item">
<a href="liste_agenceadmin.php">
<i class="bi bi-check-circle text-success"></i></a>
<div>
  <h4>Nouvelle inscription Agence </h4>
  <p>Une nouvelle agence de voyage s'est inscrite : <?php echo $agency_name; ?></p>
  <p><?php echo date('Y-m-d H:i:s'); ?></p>
</div>
</li>
<li class="notification-item">
<i class="bi bi-info-circle text-primary"></i>
<div>
  <h4>Nouvelle réservation</h4>
  <p>Une nouvelle réservation a été effectuée par le randonneur :<?php echo $randonneur_cin; ?> pour la randonnée Num <?php echo $randonnee_id; ?></p>
  <p> à <?php echo date('Y-m-d H:i:s'); ?></p>
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
   <aside id="sidebar" class="sidebar" >
    

    <ul class="sidebar-nav" id="sidebar-nav">
   <li class="nav-item">
    <a class="nav-link collapsed" href="profil_admin.php?id_admin=1">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

  <li class="nav-item">
    <a class="nav-link "  href="reservation_admin.php">
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
    <div class=" " style="margin-bottom:40px;">
        <h1 class="" style="font-family: Century Gothic; text-align: center;margin-bottom: 40px; color: #568894;">Liste des Réservations</h1>
        <div class="form-container" style="margin-top: 40px; background-color: #ededec;overflow-y: auto; scrollbar-width: thin;">


    <table>
        <tr class="fixed-row">
        <th>Numéro de la réservation</th>
            <th>CIN</th>
            <th>ID Randonnée</th>
            <th>Date et heure de reservation</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
             echo "<td>" . $row["ID_reservation"] . "</td>";
                echo "<td>" . $row["CIN"] . "</td>";
                echo "<td>" . $row["ID_randonnee"] . "</td>";
                echo "<td>" . $row["Date_reservation"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Aucune réservation trouvée.</td></tr>";
        }
        ?>
    </table>
        
        </div>
    </div>
</main><!-- End #main -->
</body>
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
</html>

<?php
// Fermeture de la connexion à la base de données
$conn->close();
?>