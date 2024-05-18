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

// Vérifier si la CIN du randonneur a été passée en tant que paramètre dans l'URL
if(isset($_GET['cin'])) {
    $cin = $_GET['cin'];

    // Connexion à la base de données (la connexion est déjà établie, donc inutile de la refaire)
    // Supprimez cette ligne :
    // $conn = new mysqli("localhost", "root", "", "pfe");

    // Requête pour sélectionner les réservations du randonneur spécifié
    $sql = "SELECT r.Date_reservation, ra.LibelleR, ra.Date, ra.Prix FROM reservation r JOIN Randonnee ra ON r.ID_randonnee = ra.ID_randonnee WHERE r.CIN = '$cin'";
    if (isset($_GET['query'])) {
        $search_query = $_GET['query'];
        // Vous pouvez utiliser la fonction de recherche LIKE pour rechercher dans le titre1 et l'id
        $sql = "SELECT * FROM Randonnee WHERE LibelleR LIKE '%$search_query%' OR ID_randonnee = '$search_query'";
    }
    $result = $conn->query($sql);

    // Fermeture de la connexion à la base de données
    // Déplacez cette ligne après que vous avez fini d'utiliser $conn
    // $conn->close();
} else {
    echo "<p>CIN non spécifié.</p>";
}

if($result) {
    // Votre code existant ...

    // Maintenant, récupérons la dernière randonnée ajoutée
    $sql_new_randonnee = "SELECT * FROM Randonnee ORDER BY ID_randonnee DESC LIMIT 1";
    $result_new_randonnee = $conn->query($sql_new_randonnee);

    // Vérification de la réussite de la requête
    if ($result_new_randonnee) {
        $last_randonnee = $result_new_randonnee->fetch_assoc();
        
        // Si une nouvelle randonnée a été ajoutée, affichez-la dans la liste de notifications
        if($last_randonnee) {
           
        }
    } else {
        echo "Erreur lors de la récupération de la dernière randonnée ajoutée : " . $conn->error;
    }

    // Fermeture de la connexion à la base de données
    $conn->close();
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style-liste.css">
    <title>Liste des Reservations</title>
   
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
        <a class="nav-link  collapsed" href="profil_randonneur.php?CIN=<?php echo $cin;  ?>">
          <i class="bi bi-person"></i>
          <span>Profil</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link "  href="historique_reservationrandonneur.php?cin=<?php echo $cin; ?>">
          <i class="bi bi-layout-text-window-reverse"></i>
          <span>Mes Réservation</span>
        </a>
      </li>
        <!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="contact_randonneur.php?CIN=<?php echo $cin; ?>">
          <i class="bi bi-envelope"></i>
          <span>Contact</span>
        </a>
      </li><!-- End Contact Page Nav -->    
      <li class="nav-item">
        <a class="nav-link collapsed" href="../lunding page.html">
          <i class="bi bi-box-arrow-right"></i>
          <span>Déconnexion</span>
        </a>
      </li><!-- End Dashboard Nav -->                                        
    </ul>

  </aside><!-- End Sidebar-->
  
  

<main id="main" class="main" style="box-shadow: 0px 0px 20px rgba(255, 255, 255, 0.1); background-color: #fff; border: 2px solid #B1D5E2;">
    <div class=" " style="margin-bottom:40px;">
        <h1 class="" style="font-family: Century Gothic; text-align: center;margin-bottom: 40px; color: #568894;">Liste des Reservations</h1>
        <div class="form-container" style="margin-top: 40px; background-color: #ededec;">

        <table>
        <tr class="fixed-row">
            <th>Date et heure de réservation</th>
            <th>Nom de la randonnée</th>
            <th>Date de la randonnée</th>
            <th>Prix</th>
            <th>état</th>
            <th>Action</th>
            
         </tr>
        
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Date_reservation"] . "</td>";
                echo "<td>" . $row["LibelleR"] . "</td>";
                echo "<td>" . $row["Date"] . "</td>";
                echo "<td>" . $row["Prix"] . "</td>";
                // Vérifier si la date de la randonnée est passée ou à venir
        $date_randonnee = strtotime($row["Date"]);
        $aujourdhui = strtotime(date("Y-m-d"));
        if ($date_randonnee < $aujourdhui) {
            echo "<td>Passé</td>";
        } else {
            echo "<td>À venir</td>";
        }
                echo "<td><a href='supprimer_reservation.php?date_reservation=" . $row['Date_reservation'] . "'>supprimer</a></td>";

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='11'>Aucune reservation trouvée.</td></tr>";
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


