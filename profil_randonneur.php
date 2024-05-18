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
      <a href="pagedacceilR.php?cin=<?php echo $randonneur_info['CIN']; ?>" class="logo d-flex align-items-center">
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
        <a class="nav-link  " href="profil_randonneur.php?CIN=<?php echo $randonneur_info['CIN']; ?>">
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
        <a class="nav-link collapsed" href="contact_randonneur.php?CIN=<?php echo $randonneur_info['CIN']; ?>"">
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

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

            <img src="<?php echo htmlspecialchars($image_path); ?>" alt="Profile" class="rounded-circle shadow">

              <h2><?php echo $randonneur_info['Nom']; ?></h2>
              <h3>Randonneur</h3>
              <div class="social-links mt-2">
              <a href="https://www.facebook.com/" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="https://www.instagram.com/" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="https://www.linkedin.com/" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Coordonnées</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Modifier le profil</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Changer le mot de passe</button>
                </li>

                <li class="nav-item">
    <button id="deleteAccountBtn" class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Supprimer</button>
    <script>
        document.getElementById("deleteAccountBtn").addEventListener("click", function() {
            if (confirm("Êtes-vous sûr de vouloir supprimer votre compte ?")) {
                var CIN = <?php echo json_encode($randonneur_info['CIN']); ?>;

                // Envoyer une requête AJAX pour supprimer le compte
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "supprimer_compte.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Si la suppression réussit, rediriger vers une page de confirmation ou une page d'accueil
                        window.location.href = "../inscription_randonneur.php";
                    }
                };
                xhr.send("CIN=" + CIN);
            }
        });
    </script>
</li>

 

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">Nom</h5>
                  <p class="small fst-italic"> <?php echo $randonneur_info['Nom']; ?></p>

                  <h5 class="card-title">Détails du profil</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Prénom:</div>
                    <div class=" col-lg-9 col-md-8" ><?php echo $randonneur_info['Prenom']; ?></div>
                  </div>

            
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Numéro de téléphone:</div>
                    <div class="col-lg-9 col-md-8"><?php echo $randonneur_info['Num_tel']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email:</div>
                    <div class="col-lg-9 col-md-8"><?php echo $randonneur_info['Email']; ?></div>
                  </div>
                
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Date de naissance:</div>
                    <div class="col-lg-9 col-md-8"><?php echo $randonneur_info['Date_naissance']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Gouvernement</div>
                    <div class="col-lg-9 col-md-8"><?php echo $randonneur_info['LibelleV']; ?></div>
                  </div>

                  

                </div>
               
                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form action="modifier_profilrando.php" method="POST">
                    <!--<div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <img src="../assets/img/profile-img.jpg" alt="Profile">
                        <div class="pt-2">
                          <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                          <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                        </div>
                      </div>
                    </div>-->
                    <input type="hidden" name="CIN" value="<?php echo $randonneur_info['CIN']; ?>">
                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nom</label>
                      <div class="col-md-8 col-lg-9">
                      <input type="text" id="nom" name="nom" value="<?php echo $randonneur_info['Nom']; ?>"><br><br>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="about" class="col-md-4 col-lg-3 col-form-label">Prenom</label>
                      <div class="col-md-8 col-lg-9">
                      <textarea name="prenom" class="form-control" id="about" style="height: 100px"><?php echo $randonneur_info['Prenom']; ?></textarea>
                        
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="Address" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                      <input name="email" type="email" class="form-control" id="Address" placeholder="Adresse e-mail" value="<?php echo $randonneur_info['Email']; ?>" >

                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Numéro de téléphone:</label>
                      <div class="col-md-8 col-lg-9">
                      <input name="tel" type="tel" class="form-control" id="Phone" placeholder="Numéro de téléphone (8 chiffres)" value="<?php echo $randonneur_info['Num_tel']; ?>" pattern="[0-9]{8}" maxlength="8" requi>

                      </div>
                </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    </div>
                              </form><!-- End Profile Edit Form -->

                            </div>

                            

                            <div class="tab-pane fade pt-3" id="profile-change-password">
                            <form action="modifier_passe.php" method="POST">
                <div class="row mb-3">
                <input type="hidden" name="CIN" value="<?php echo $randonneur_info['CIN']; ?>">
                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Mot de passe actuel</label>
                    <div class="col-md-8 col-lg-9">
                        <input name="currentPassword" type="password" class="form-control" id="currentPassword">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nouveau mot de passe</label>
                    <div class="col-md-8 col-lg-9">
                        <input name="newPassword" type="password" class="form-control" id="newPassword">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Retapez le nouveau mot de passe</label>
                    <div class="col-md-8 col-lg-9">
                        <input name="renewPassword" type="password" class="form-control" id="renewPassword">
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" name="change_password" class="btn btn-primary">Changer le mot de passe</button>
                </div>
            </form>


                </div>

              </div><!-- End Bordered Tabs -->

            </div>
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
  
  <script src="../assets/js/main1.js"></script>
  <script src="../assets/js/maindashboard.js"></script>

</body>

</html>