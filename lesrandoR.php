<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "pfe";

try {
    // Créer une nouvelle connexion PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
    
    // Configurer PDO pour générer des exceptions en cas d'erreur
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Définir le jeu de caractères en UTF-8
    $pdo->exec("SET NAMES utf8");

    // Récupérer et filtrer le paramètre CIN depuis l'URL
    $cin = $_GET['cin'];

   
} catch (PDOException $e) {
    // Gestion des erreurs de connexion ou de requête
    echo "Erreur de connexion ou de requête : " . $e->getMessage();
}
?>
<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pfe";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fonction pour récupérer les randonnées filtrées depuis la base de données
function getFilteredRandonnees($category, $governorate, $difficulty, $date, $price, $conn) {
    // Construction de la requête SQL basée sur les filtres sélectionnés
    $sql = "SELECT * FROM Randonnee WHERE 1=1";

    if ($category !== 'all') {
        $sql .= " AND LibelleC = '$category'";
    }

    if ($governorate !== 'all') {
        $sql .= " AND LibelleV = '$governorate'";
    }

    if ($difficulty !== 'all') {
        $sql .= " AND LibelleD = '$difficulty'";
    }

    if ($date !== '') {
        $sql .= " AND Date = '$date'";
    }

    if ($price !== '') {
        $sql .= " AND Prix <= $price";
    }

    // Exécuter la requête SQL
    $result = $conn->query($sql);

    if (!$result) {
        die("Error in query: " . $conn->error);
    }

    $randonnees = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $randonnees[] = $row;
        }
    }

    return $randonnees;
}

// Fonction pour récupérer le nom de l'agence à partir de son ID
function getAgenceName($agenceId, $conn) {
    $sql = "SELECT Nom FROM Agence_de_voyage WHERE ID_agence = $agenceId";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error in query: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['Nom'];
    } else {
        return "N/A"; // Si aucun résultat n'est trouvé
    }
}

function getAgenceimage($agenceId, $conn) {
    $sql = "SELECT Image FROM Agence_de_voyage WHERE ID_agence = $agenceId";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error in query: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['Image'];
    } else {
        return "N/A"; // Si aucun résultat n'est trouvé
    }
}


// Récupérer les données filtrées si des filtres sont appliqués, sinon récupérer toutes les randonnées
if (isset($_GET['category']) || isset($_GET['governorate']) || isset($_GET['difficulty']) || isset($_GET['date']) || isset($_GET['price'])) {
    $category = $_GET['category'] ?? 'all';
    $governorate = $_GET['governorate'] ?? 'all';
    $difficulty = $_GET['difficulty'] ?? 'all';
    $date = $_GET['date'] ?? '';
    $price = $_GET['price'] ?? '';

    $filteredRandonnees = getFilteredRandonnees($category, $governorate, $difficulty, $date, $price, $conn);
} else {
    // Si aucun filtre n'est appliqué, récupérer toutes les randonnées
    $sql = "SELECT * FROM Randonnee";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error in query: " . $conn->error);
    }

    $filteredRandonnees = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $filteredRandonnees[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/news.css">
    <!-- Slick Carousel CSS -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CDN -->
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicon.ico">
    <!-- Slick Carousel JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Title -->
    <title>Randonnées en Tunisie</title>
<style>
    .card {
            margin: 20px;
        }
       
    /* Masquer les indicateurs de pagination */
    .slick-dots {
        display: none !important;
    }
    .filtrebtn{
        background-color: #DEEF09;
        color: black;
        height: 40px;
        width: 80px;
        border-radius: 30px;
        font-weight: 600;
    }
    .card-header{
            padding:inherit !important ;
        }
        
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
<?php include('../layoutR/nav.php')?>

<body>





    <!-- HTML pour les éléments de filtrage -->
    <div class="container">
        <div class="filter-container">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                <select name="category" id="select-category" class="filter">
                    <option value="all">Catégorie</option>
                    <option value="randonnee">Randonnée</option>
                    <option value="camping">Camping</option>
                </select>

                <!-- Filtrer par gouvernorat -->
                <select name="governorate" id="select-governorate" class="filter">
                    <option value="all">Gouvernorat </option>
                            <option value="Ariana">Ariana</option>
                            <option value="Gabès">Gabès</option>
                            <option value="Jendouba">Jendouba</option>
                            <option value="Kairouan">Kairouan</option>
                            <option value="Kasserine">Kasserine</option>
                            <option value="Kébili">Kébili</option>
                            <option value="Manouba">Manouba</option>
                            <option value="Le Kef">Le Kef</option>
                            <option value="Mahdia">Mahdia</option>
                            <option value="Médenine">Médenine</option>
                            <option value="Monastir">Monastir</option>
                            <option value="Nabeul">Nabeul</option>
                            <option value="Sfax">Sfax</option>
                            <option value="Sidi Bouzid">Sidi Bouzid</option>
                            <option value="Siliana">Siliana</option>
                            <option value="Sousse">Sousse</option>
                            <option value="Tataouine">Tataouine</option>
                            <option value="Tozeur">Tozeur</option>
                            <option value="Tunis">Tunis</option>
                            <option value="Zaghouan">Zaghouan</option>
                    <!-- Ajoutez les autres options pour les gouvernorats ici -->
                </select>

                <!-- Filtrer par niveau de difficulté -->
                <select name="difficulty" id="select-difficulty" class="filter">
                    <option value="all">Difficulté </option>
                    <option value="facile">Facile</option>
                    <option value="moyenne">Moyenne</option>
                    <option value="difficile">Difficile</option>
                </select>

                <!-- Filtrer par date -->
                <input type="date" name="date" id="select-date" class="filter">

               

                <button type="submit" class="filtrebtn">Filtrer</button>
            </form>
        </div>
    </div>


    <div class="container mx-auto px-4">
        <?php
        // Affichage des randonnées filtrées
        foreach ($filteredRandonnees as $randonnee) {
        ?>
            <div class="mb-5">
                <a href="details_randonnee.php?id=<?php echo $randonnee['ID_randonnee']; ?>"> <!-- Ajout de la balise <a> pour la redirection -->

                    <div class="card"> <!-- Ajout de la classe mb-4 pour ajouter de l'espace entre les cartes -->
                        <div class="card-header">
       
                    
                        <div class="slider" style="margin-bottom: 0;">
                        <?php
                        // Affichage des randonnées filtrées
                        foreach (json_decode($randonnee['Image']) as $img) {
                        ?>
                            <div>
                                <img src="../<?php echo $img; ?>" alt="randonnee" />
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                        </div>
                        <div class="card-body">
                            <div class="user-and-tag">
                                <div class="user">
                                <img src="../<?php echo preg_replace('/\.\.\//', '', getAgenceimage($randonnee['ID_agence'], $conn), 1); ?>" alt="user" />

                                    <div class="user-info">
                                        <h5><?php echo getAgenceName($randonnee['ID_agence'], $conn); ?></h5> <!-- Modification pour afficher le nom de l'agence -->
                                        <small>Agence de voyage</small>
                                    </div>
                                </div>
                                <span class="tag <?php echo $randonnee['LibelleC'] == 'randonnée' ? 'tag-pink' : 'tag-purple'; ?>"><?php echo $randonnee['LibelleC']; ?></span>
                            </div>
                            <h4><?php echo $randonnee['LibelleR']; ?></h4>
                            <table class="info-table">
                                <tr>
                                    <td><i class="bi bi-calendar"></i> <?php echo $randonnee['Date']; ?></td>
                                    <td><i class="bi bi-clock"></i> <?php echo $randonnee['Duree']; ?> j</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-trophy"></i> <?php echo $randonnee['LibelleD']; ?></td>
                                    <td><i class="bi bi-cash"></i> <?php echo $randonnee['Prix']; ?> DT</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </a>
            </div>
        <?php
        }
        ?>
    </div>

    <!-- Script JavaScript pour le filtrage -->
    <script>
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
        // Fonction pour mettre à jour la valeur du prix
        function updatePriceValue() {
            const priceRange = document.getElementById('price-range');
            const priceValue = document.getElementById('price-value');
            priceValue.textContent = priceRange.value + ' DT';
        }
    </script>
    <script>
    $(document).ready(function(){
        $('.slider').slick({
            dots: true, // Afficher les indicateurs de pagination
            infinite: true, // Activer le défilement infini du slider
            autoplay: true, // Activer la lecture automatique du slider
            autoplaySpeed: 2000 // Durée de l'animation en millisecondes
        });
    });
</script>
<!-- JS -->
<?php include('../layoutR/le-footer.php')?>


</body>

</html>