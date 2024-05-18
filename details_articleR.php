<?php
// Include the database configuration file
include 'db_config.php';

// Check if cin and id_article are set in the URL
if (!isset($_GET['cin']) || !isset($_GET['id_article'])) {
    die("Aucun CIN ou ID d'article spécifié dans l'URL.");
}

$cin_randonneur = $_GET['cin'];
$id_article = $_GET['id_article'];

// Prepare the SQL statement to fetch the article
$sql = "SELECT * FROM Article WHERE id_article = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "i", $id_article);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Check if any result is returned
    if (mysqli_num_rows($result) > 0) {
        // Fetch the article information
        $article_info = mysqli_fetch_assoc($result);

        // Fetch comments if any
        // Fetch comments if any
$sql_comments = "SELECT c.*, r.Nom AS nom_randonneur, r.Image AS image_randonneur
FROM Commentaire c 
INNER JOIN Randonneur r ON c.CIN = r.CIN
WHERE c.id_article = ?";

        $stmt_comments = mysqli_prepare($conn, $sql_comments);

        if ($stmt_comments) {
            mysqli_stmt_bind_param($stmt_comments, "i", $id_article);
            mysqli_stmt_execute($stmt_comments);
            $comments_result = mysqli_stmt_get_result($stmt_comments);

            // Initialize the $comments array to store comments
    $comments = [];

    if (mysqli_num_rows($comments_result) > 0) {
        while ($comment = mysqli_fetch_assoc($comments_result)) {
            // Add each comment to the $comments array
            $comments[] = $comment;
        }
    }

            mysqli_stmt_close($stmt_comments);
        }

    } else {
        echo "Aucun résultat trouvé pour cet ID.";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Erreur lors de la préparation de la requête: " . mysqli_error($conn);
}

// Check if the comment form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_comment'])) {
    // Validate and sanitize input data
    $commentaire = $_POST['commentaire'];
    // Assuming CIN is an integer, convert it to integer type
    $cin_randonneur = (int)$cin_randonneur;
    // Assuming id_article is an integer, convert it to integer type
    $id_article = (int)$id_article;

    // Check if the CIN exists in the randonneur table
    $sql_check_cin = "SELECT CIN FROM randonneur WHERE CIN = ?";
    $stmt_check_cin = mysqli_prepare($conn, $sql_check_cin);

    if ($stmt_check_cin) {
        mysqli_stmt_bind_param($stmt_check_cin, "i", $cin_randonneur);
        mysqli_stmt_execute($stmt_check_cin);
        $cin_result = mysqli_stmt_get_result($stmt_check_cin);

        if (mysqli_num_rows($cin_result) > 0) {
            // Insert the comment into the database
            $sql_insert_comment = "INSERT INTO Commentaire (id_article, CIN, commentaire, date_heure_commentaire) VALUES (?, ?, ?, NOW())";
            $stmt_insert_comment = mysqli_prepare($conn, $sql_insert_comment);

            if ($stmt_insert_comment) {
                mysqli_stmt_bind_param($stmt_insert_comment, "iis", $id_article, $cin_randonneur, $commentaire);

                if (mysqli_stmt_execute($stmt_insert_comment)) {
                    // Redirect to the same page to show the new comment
                    header("Location: single-sidebarR.php?cin=$cin_randonneur&id_article=$id_article");
                    exit();
                } else {
                    echo "Erreur lors de l'insertion du commentaire : " . mysqli_stmt_error($stmt_insert_comment);
                }

                mysqli_stmt_close($stmt_insert_comment);
            } else {
                echo "Erreur lors de la préparation de la requête d'insertion : " . mysqli_error($conn);
            }
        } else {
            echo "Le CIN fourni n'existe pas dans la table randonneur.";
        }

        mysqli_stmt_close($stmt_check_cin);
    } else {
        echo "Erreur lors de la préparation de la requête de vérification : " . mysqli_error($conn);
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifiez si la demande est pour supprimer un commentaire
    if (isset($_POST['delete_comment'])) {
        // Récupérez l'ID du commentaire à supprimer
        $comment_id = $_POST['comment_id'];

        // Préparez la requête SQL pour supprimer le commentaire
        $sql_delete_comment = "DELETE FROM Commentaire WHERE id = ?";
        $stmt_delete_comment = mysqli_prepare($conn, $sql_delete_comment);

        if ($stmt_delete_comment) {
            // Liez les paramètres et exécutez la requête
            mysqli_stmt_bind_param($stmt_delete_comment, "i", $comment_id);
            if (mysqli_stmt_execute($stmt_delete_comment)) {
                // Redirigez l'utilisateur vers la même page après la suppression
                header("Location: single-sidebarR.php?cin=$cin_randonneur&id_article=$id_article");
                exit();
            } else {
                echo "Erreur lors de la suppression du commentaire : " . mysqli_stmt_error($stmt_delete_comment);
            }

            // Fermez la déclaration
            mysqli_stmt_close($stmt_delete_comment);
        } else {
            echo "Erreur lors de la préparation de la requête de suppression : " . mysqli_error($conn);
        }
    }
}

 
// Close the connection
mysqli_close($conn);
?>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.minARTICLE.css">
    <link rel="stylesheet" href="../assets/css/all.minARTICLE.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/styleARTICLE.css">
    <style>
		.rated{
		color:yellow;
		}
		span#s1{ color:magenta;}
        .btn-like {
    background-color: transparent;
    color: #000; /* Couleur du texte par défaut */
    border: 1px solid #000;
    transition: background-color 0.3s, color 0.3s;
}

.btn-like.liked {
    background-color: red; /* Couleur de fond lorsque le bouton est aimé */
    color: #fff; /* Couleur du texte lorsque le bouton est aimé */
}
		</style>
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
            <!-- HTML pour les éléments de filtrage -->
            <main>
    <!-- Main Block -->
   
        <div class="container pb-5">
            <div class="row justify-content-center g-5">
                <div class="col-xl-8 col-md-10 col-sm-12 ">
                    <article>
                        <h1 class="mb-3 temoinage">Quels sont les dangers à éviter lors d'une randonnée?</h1>
                        <p><i class="bi bi-calendar"></i> <?php echo $article_info["date_heure_ajout"]; ?></p>
                        <img class=" image  mb-3 w-100"  src="../images/<?php echo $article_info['image']; ?>"alt="" >
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
                    <div class="container mx-auto px-4">
    <?php
    // Affichage des commentaires
    foreach ($comments as $comment) {
        ?>
        <div class="mb-5">
            <div class="boxe p-4">
                <!-- Affichage des informations du commentaire -->
                <div class="row">
                    <!-- Affichage de l'image et des informations de l'auteur du commentaire -->
                    <div class="col-md-1"><img src="<?php echo $comment['image_randonneur']; ?>" class="rounded me-2 h-auto w-100"></div>
                    <div class="col-md-11">
                        <div class="d-flex justify-content-between ps-2">
                            <strong class="d-block"><?php echo $comment['nom_randonneur']; ?></strong>
                            <small><?php echo $comment['date_heure_commentaire']; ?></small>
                        </div>
                        <span class="ps-2" style="text-align: justify;"><?php echo $comment['commentaire']; ?></span>
                        <!-- Ajoutez un lien ou un bouton de suppression avec l'ID du commentaire -->
                        <form method="post" action="">
                            <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                            <button type="submit" name="delete_comment" class="btn">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

                       
                        <h4 class="py-3">Commenter</h4>
    <form method="post" action="">
        <textarea name="commentaire" class="cmnt w-100 mb-3 form-control"></textarea>
        <input type="hidden" name="id_article" value="<?php echo $id_article; ?>">
        <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">

        <input type="hidden" name="CIN" value="<?php echo $cin_randonneur; ?>">
		
        <button type="submit" name="submit_comment" class="btn  ">Envoyer</button>
    </form>
 
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
                            <button id="likeButton" class="btn btn-like">
    <i class="bi bi-heart"></i> J'aime
</button>
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
    <script>
    document.getElementById('likeButton').addEventListener('click', function() {
        var button = document.getElementById('likeButton');
        if (button.classList.contains('liked')) {
            button.classList.remove('liked');
        } else {
            button.classList.add('liked');
        }
    });
    <?php include('../layoutR/le-footer.php')?>

</script>
</body>

</html>