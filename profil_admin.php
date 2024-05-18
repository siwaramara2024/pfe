<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant qu'administrateur
if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté en tant qu'administrateur
    header("Location: login_admin.php");
    exit();
}

// Vérifier si l'ID de l'administrateur est défini dans l'URL
if (!isset($_GET['id_admin'])) {
    // Redirection vers une page d'erreur ou une autre page appropriée si l'ID n'est pas défini
    // Vous pouvez personnaliser cette redirection selon vos besoins
    header("Location: login_admin.php");
    exit();
}

// Récupérer l'ID de l'administrateur à partir de l'URL
$admin_id = $_GET['id_admin'];

// Connectez-vous à votre base de données et récupérez les autres détails de l'administrateur à l'aide de $admin_id
// Assurez-vous de remplacer les informations de connexion et de la requête par les vôtres
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pfe";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérifier si une nouvelle inscription a été effectuée
$sql = "SELECT * FROM Randonneur ORDER BY CIN DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Il y a une nouvelle inscription
    $row = $result->fetch_assoc();
    $username = $row["Nom"] . ' ' . $row["Prenom"];
    
    // Afficher la notification dans le menu de navigation
   
}
// Vérifier si une nouvelle agence a été enregistrée
$sql = "SELECT * FROM Agence_de_voyage ORDER BY ID_agence DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Il y a une nouvelle agence enregistrée
    $row = $result->fetch_assoc();
    $agency_name = $row["Nom"];}
    // Vérifier s'il y a une nouvelle réservation
$sql = "SELECT * FROM Reservation ORDER BY ID_reservation DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Il y a une nouvelle réservation
    $row = $result->fetch_assoc();
    $reservation_id = $row["ID_reservation"];
    $randonneur_cin = $row["CIN"];
    $randonnee_id = $row["ID_randonnee"];}

// Fermer la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>dashboard-agence</title>
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
      <a href="../lunding page.html" class="logo d-flex align-items-center">
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
    <a href="reservation_admin.php">
    <li class="notification-item">
        <i class="bi bi-info-circle text-primary"></i></a>
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
            <img src="../assets/img/admin.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">Admin</span>
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
                <span>Mon Profil</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
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
        <a class="nav-link " href="profil_admin.php?id_admin=1">
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
          <a class="nav-link collapsed"  href="ajout_article.php">
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
        <a class="nav-link collapsed" href="../login_admin.php">
          <i class="bi bi-box-arrow-right"></i>
          <span>Déconnexion</span>
        </a>
      </li><!-- End Dashboard Nav -->                                        
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="">
      <h1>Profil</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="../assets/img/admin.jpg" alt="Profile" class="rounded-circle shadow">

              <h2>Camp Life</h2>
              <h3>Agence de voyage</h3>
              <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
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
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">About</h5>
                  <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p>

                  <h5 class="card-title">Profil Détailes</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8">Kevin Anderson</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Company</div>
                    <div class="col-lg-9 col-md-8">Lueilwitz, Wisoky and Leuschke</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Job</div>
                    <div class="col-lg-9 col-md-8">Web Designer</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Country</div>
                    <div class="col-lg-9 col-md-8">USA</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Address</div>
                    <div class="col-lg-9 col-md-8">A108 Adam Street, New York, NY 535022</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone</div>
                    <div class="col-lg-9 col-md-8">(436) 486-3538 x29071</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8">k.anderson@example.com</div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form>
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <img src="../assets/img/admin.jpg" alt="Profile">
                        <div class="pt-2">
                          <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                          <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="fullName" type="text" class="form-control" id="fullName" value="Kevin Anderson">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                      <div class="col-md-8 col-lg-9">
                        <textarea name="about" class="form-control" id="about" style="height: 100px">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</textarea>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">Company</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="company" type="text" class="form-control" id="company" value="Lueilwitz, Wisoky and Leuschke">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Job" class="col-md-4 col-lg-3 col-form-label">Job</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="job" type="text" class="form-control" id="Job" value="Web Designer">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="country" type="text" class="form-control" id="Country" value="USA">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="address" type="text" class="form-control" id="Address" value="A108 Adam Street, New York, NY 535022">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="phone" type="text" class="form-control" id="Phone" value="(436) 486-3538 x29071">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" class="form-control" id="Email" value="k.anderson@example.com">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="twitter" type="text" class="form-control" id="Twitter" value="https://twitter.com/#">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="facebook" type="text" class="form-control" id="Facebook" value="https://facebook.com/#">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="instagram" type="text" class="form-control" id="Instagram" value="https://instagram.com/#">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="linkedin" type="text" class="form-control" id="Linkedin" value="https://linkedin.com/#">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-settings">

                  <!-- Settings Form -->
                  <form>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                      <div class="col-md-8 col-lg-9">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="changesMade" checked>
                          <label class="form-check-label" for="changesMade">
                            Changes made to your account
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="newProducts" checked>
                          <label class="form-check-label" for="newProducts">
                            Information on new products and services
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="proOffers">
                          <label class="form-check-label" for="proOffers">
                            Marketing and promo offers
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                          <label class="form-check-label" for="securityNotify">
                            Security alerts
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End settings Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form>

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control" id="currentPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                  </form><!-- End Change Password Form -->

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

</body>

</html>
        
