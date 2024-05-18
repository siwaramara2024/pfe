<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "pfe";

// Création de la connexion
$conn = mysqli_connect($servername, $username, $password_db, $dbname);

// Vérification de la connexion
if (!$conn) {
    die("La connexion a échoué : " . mysqli_connect_error());
}

// Requête SQL pour sélectionner tous les articles
$sql = "SELECT * FROM article";
$result = mysqli_query($conn, $sql);

// Vérification si des résultats sont retournés
if (mysqli_num_rows($result) > 0) {
    // Initialisation de la variable $articles comme un tableau vide
    $articles = array();

    // Récupération des données de chaque article et stockage dans $articles
    while ($row = mysqli_fetch_assoc($result)) {
        $articles[] = $row;
    }
} else {
    echo "Aucun article trouvé.";
}

// Fermeture de la connexion à la base de données
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Arunlal Panja">
    <title>article</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico">
     <!-- Icons -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.minARTICLE.css">
    <link rel="stylesheet" href="../assets/css/all.minARTICLE.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/styleARTICLE.css">
</head>

<body>
<?php include('../layoutR/nav.php')?>

    <section class="layout_padding">
        <div class="container">
            <div class="heading_container">
                <h2 class="temoinage">Trouvez Votre Aventure Parfaite en Tunisie</h2>
                <p class="temoinage1 text-center-justify">Découvrez les meilleurs spots de randonnée et de camping en Tunisie. Prêt pour l'aventure ? Trouvez-la dès maintenant !</p>
            </div>
            </div>
            </section>
    <main>
        <div class="container pb-5">
            <div class="row g-4 mb-4">
                <div class="col-md-6">
     
                    <div class="card text-bg-dark">
                        <img src="../assets/img/articl.jpg" class="card-img" alt="...">
                        <div class=" card-img-overlay bg-dark bg-opacity-75 p-4">
                            <h2 class="card-title"><a href="#" class="text-decoration-none link-light">Les 10 sentiers de randonnée les plus époustouflants à travers le monde</a></h2>
                            <p class="card-text"><small><i class="fa-regular fa-calendar pe-2"></i> Nov 12</small></p>
                            <p class="card-text">  Découvrez des destinations incroyables et des paysages à couper le souffle qui vous inspireront à explorer la nature.</p>
                            <a href="#" class="btn btn-dark brand-bg-color">Voir plus</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-bg-dark">
                        <img src="../assets/img/artcll.jpeg" class="card-img" alt="...">
                        <div class="card-img-overlay bg-dark bg-opacity-75 p-4">
                            <h2 class="card-title"><a href="#" class="text-decoration-none link-light">Randonnée en montagne : les règles d'or pour une aventure sécurisée</a></h2>
                            <p class="card-text"><small><i class="fa-regular fa-calendar pe-2"></i> Nov 16</small></p>
                            <p class="card-text"> Explorez les conseils essentiels pour une randonnée en montagne en toute sécurité, de la préparation à l'équipement nécessaire. </p>
                            <a href="#" class="btn btn-dark brand-bg-color">Voir plus</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="row g-4">
                    <?php
                    // Boucle pour afficher les articles
                    foreach ($articles as $article) {
                    ?>
                        <div class="col-md-6">
                            <div class="artt card shadow-sm mb-4">
                                <a href="details_articleR.php?cin=<?php echo $_GET['cin']; ?>&id_article=<?php echo $article['id_article']; ?>
"><img src="../images/<?php echo $article['image']; ?>" class="article w-100"></a>
                                <div class="card-body">
                                    <h6><?php echo $article['titre1']; ?></h6>
                                    <div class="mb-1 text-muted"><small><i class="bi bi-calendar"></i> <?php echo $article['date_heure_ajout']; ?></small></div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                  
                    </div>
                    <nav class="mt-4">
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link link-dark" href="#">1</a></li>
                            <li class="page-item" aria-current="page">
                                <a class="page-link link-dark" href="#">2</a>
                            </li>
                            <li class="page-item"><a class="page-link link-dark" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link link-dark" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-4">
                    <div class="position-sticky" style="top: 5rem;">
                        <aside>
                            <div class="mb-4">
                                <h4 class="pb-3">Les articles les plus consultés</h4>
                                <div class="card border-0 shadow-sm mb-3">
                                <a href="test.php">
                                    <div class="row g-0">
                                        <div class="col-4">
                                            <a href="articlesplusconsulte.php"><img class="rounded-start img-fluid" src="../assets/img/article.jpg"></a>
                                        </div>
                                        <div class="col-8">
                                            <div class="card-body mt-2">
                                            <h5 class="card-title" style="font-size: 15px;"><a href="articlesplusconsulte.php" style="text-decoration: none; color: inherit;">Les conseils pour survivre à vos randonnées en montagne</a></h5>
                                                <p class="card-text"><small class="text-muted"><i class="fa-regular fa-calendar pe-2"></i> Last updated 3 mins ago</small></p>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="row g-0">
                                        <div class="col-4">
                                            <a href="articlesplusconsulte.php"><img class="rounded-start img-fluid" src="../assets/img/articlee.jpg"></a>
                                        </div>
                                        <div class="col-8">
                                            <div class="card-body mt-2">
                                                <h5 class="card-title" > <a href="articlesplusconsulte.php" style="text-decoration: none; color: inherit;">Comment sortir vivant de sables mouvants </a></h5>
                                                <p class="card-text"><small class="text-muted"><i class="fa-regular fa-calendar pe-2"></i> Last updated 3 mins ago</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="row g-0">
                                        <div class="col-4">
                                            <a href="articlesplusconsulte.php"><img class="rounded-start img-fluid" src="../assets/img/articleee.jpg"></a>
                                        </div>
                                        <div class="col-8">
                                            <div class="card-body mt-2">
                                                <h5 class="card-title" ><a href="articlesplusconsulte.php" style="text-decoration: none; color: inherit;">Les «bains de forêts» aident-ils vraiment à se sentir mieux?</a></h5>
                                                <p class="card-text"><small class="text-muted"><i class="fa-regular fa-calendar pe-2"></i> Last updated 3 mins ago</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                
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
    <?php include('../layoutR/le-footer.php')?>

</body>

</html>