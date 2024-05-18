<?php 
// Vérification si l'ID de l'article est présent dans l'URL
if(isset($_GET['id_article'])) {
    // Récupération de l'ID de l'article depuis l'URL
    $id_article = $_GET['id_article'];

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pfe";

    // Création de la connexion
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Vérification de la connexion
    if (!$conn) {
        die("La connexion a échoué : " . mysqli_connect_error());
    }

    // Requête SQL pour sélectionner un article par son ID
    $sql = "SELECT * FROM Article WHERE id_article = ?";

    // Préparation de la requête
    $stmt = mysqli_prepare($conn, $sql);

    // Liaison des paramètres
    mysqli_stmt_bind_param($stmt, "i", $id_article);

    // Exécution de la requête
    mysqli_stmt_execute($stmt);

    // Récupération des résultats
    $result = mysqli_stmt_get_result($stmt);

    // Vérification si des résultats sont retournés
    if (mysqli_num_rows($result) > 0) {
        // Récupération de l'article
        $article_info = mysqli_fetch_assoc($result);

        // Affichage des informations de l'article
        //echo "Titre 1: " . $article_info["titre1"] . "<br>";
       // echo "Paragraphe 1: " . $article_info["paragraphe1"] . "<br>";
       // echo "Titre 2: " . $article_info["titre2"] . "<br>";
       // echo "Paragraphe 2: " . $article_info["paragraphe2"] . "<br>";
       // echo "Titre 3: " . $article_info["titre3"] . "<br>";
       // echo "Paragraphe 3: " . $article_info["paragraphe3"] . "<br>";
       // echo "Image: <img src='chemin/vers/repertoire/images/" . $article_info["image"] . "' alt='Image'><br>";
       // echo "Date et heure d'ajout: " . $article_info["date_heure_ajout"]. "<br>";
    } else {
        echo "Aucun résultat trouvé pour cet ID.";
    }

    // Fermeture de la requête
    mysqli_stmt_close($stmt);

    // Fermeture de la connexion
    mysqli_close($conn);
} else {
    echo "Aucun ID d'article spécifié dans l'URL.";
} ?>

 <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Arunlal Panja">
    <title>article2</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico">
     <!-- Icons -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.minARTICLE.css">
    <link rel="stylesheet" href="../assets/css/all.minARTICLE.css">
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

    <section class="layout_padding">
        <div class="container">
            <div class="heading_container">
                <h2 class="temoinage">Trouvez Votre Aventure Parfaite en Tunisie</h2>
                <p class="temoinage1 text-center-justify">Découvrez les meilleurs spots de randonnée et de camping en Tunisie. Prêt pour l'aventure ? Trouvez-la dès maintenant !</p>
            </div>
            </div>
            </section>
            <!-- HTML pour les éléments de filtrage -->
            <main>
    <!-- Main Block -->
   
        <div class="container pb-5">
            <div class="row justify-content-center g-5">
                <div class="col-xl-8 col-md-10 col-sm-12 ">
                    <article>
                        <h1 class="mb-3 temoinage">Quels sont les dangers à éviter lors d'une randonnée?</h1>
                        <p><i class="bi bi-calendar"></i> <?php echo $article_info["date_heure_ajout"]; ?></p>
                        <img class=" image  mb-3 w-100"  src="images/<?php echo $article_info['image']; ?>"alt="" >
                        <p>Ces moments doivent rester inoubliables, mais pour de bonnes raisons.</p>
                        <figure>
                            <blockquote class="blockquote">
                                <p>-Des conseils garantissant ainsi une expérience sécurisée et enrichissante en pleine nature. </p>
                            </blockquote>
                        </figure>
                        <p class="question" > «<?php echo $article_info["titre1"]; ?>»</p>
                        <ul>
                            <li class="" style="text-align: justify;"><?php echo $article_info["paragraphe1"]; ?>.</li>
                        </ul>
                        <h4 class=" sous mb-3"><?php echo $article_info["titre2"]; ?></h4>
                        <p class=" trait" style="text-align: justify;"><?php echo $article_info["paragraphe2"]; ?>.</p> 
                        <h4 class=" sous mb-3"><?php echo $article_info["titre3"]; ?></h4>
                        <p class=" trait " style="text-align: justify;"><?php echo $article_info["paragraphe3"]; ?>.</p>
                    </article>
                    <br>
                    <div class="boxe p-4 ">
                        <h2 class="py-3">Vous n'êtes pas allé au bout de la randonnée? Ce n'est pas grave!</h2>
                        <ol class="list-unstyled d-grid gap-4">
                            <li>
                                <div class="row">
                                    <div class="col-md-1"><img src="../assets/img/client.png" class="rounded me-2 h-auto w-100"></div>
                                    <div class="col-md-11">
                                        <div class="d-flex justify-content-between ps-2">
                                            <strong class="d-block">Sadok Mtir</strong>
                                            <small>17/05/2024 à 16h</small>
                                        </div>
                                        <span class="ps-2"  style="text-align: justify;">Cet article résume bien les risques en randonnée. En tant que passionné, je peux confirmer l'importance des conseils donnés pour assurer une expérience sécurisée en plein air.</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-md-1"><img src="../assets/img/client 2.jpg" class="rounded me-2 h-auto w-100"></div>
                                    <div class="col-md-11">
                                        <div class="d-flex justify-content-between ps-2">
                                            <strong class="d-block">Doua Bani</strong>
                                            <small>16/05/2024 à 15h</small>
                                        </div>
                                        <span class="ps-2"  style="text-align: justify;">En lisant cet article, je me suis senti compris en tant que randonneur. Les conseils simples mais essentiels offerts ici sont une excellente ressource pour rester en sécurité sur les sentiers.</span>
                                    </div>
                                </div>
                            </li>
                        </ol>
                       
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="position-sticky" style="top: 5rem;">
                        <aside>
                           
                            <div class="mb-4">
                                <h4 class="pb-3">Nouveauté</h4>
                            
                                <div class="card border-0 shadow-sm mb-3" >
                                    <div class="row g-0">
                                        <div class="col-4">
                                            <a href="pfe.php"><img class="rounded-start img-fluid" src="../assets/img/article.jpg"></a>
                                        </div>
                                        <div class="col-8">
                                            <div class="card-body mt-2">
                                                <h5 class="card-title" style="font-size: 15px;">Les conseils pour survivre à vos randonnées en montagne</h5>
                                                <p class="card-text"><small class="text-muted"><i class="fa-regular fa-calendar pe-2"></i> Last updated 3 mins ago</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="row g-0">
                                        <div class="col-4">
                                            <a href="#"><img class="rounded-start img-fluid" src="../assets/img/articlee.jpg"></a>
                                        </div>
                                        <div class="col-8">
                                            <div class="card-body mt-2">
                                                <h5 class="card-title" style="font-size: 15px;">Comment sortir vivant de sables mouvants</h5>
                                                <p class="card-text"><small class="text-muted"><i class="fa-regular fa-calendar pe-2"></i> Last updated 3 mins ago</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="row g-0">
                                        <div class="col-4">
                                            <a href="#"><img class="rounded-start img-fluid" src="../assets/img/articleee.jpg"></a>
                                        </div>
                                        <div class="col-8">
                                            <div class="card-body mt-2">
                                                <h5 class="card-title" style="font-size: 15px;">Les «bains de forêts» aident-ils vraiment à se sentir mieux?</h5>
                                                <p class="card-text"><small class="text-muted"><i class="fa-regular fa-calendar pe-2"></i> Last updated 3 mins ago</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer Block Start -->
  
    <!-- JavaScript Files -->
    <script src="../assets/js/jquery-3.6.4.minARTICLE.js"></script>
    <script src="../assets/js/bootstrap.bundle.minARTICLE.js"></script>
    <!-- Custom JS -->
    <script src="../assets/js/customARTICLE.js"></script>

    <?php include('../layout/le-footer.php')?>

</body>

</html>