
<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "pfe";

// Création de la connexion
$conn = new mysqli($servername, $username, $password_db, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête SQL pour récupérer les données des agences de voyage
$sql = "SELECT * FROM Agence_de_voyage";
$result = $conn->query($sql);

// Vérifier s'il y a des résultats
if ($result->num_rows > 0) {
    // Créer un tableau pour stocker les agences de voyage
    $agences = array();
    
    // Stocker les agences de voyage dans le tableau
    while($row = $result->fetch_assoc()) {
        $agences[] = $row;
    }
} else {
    echo "Aucune agence de voyage trouvée.";
}

// Fermer la connexion à la base de données
$conn->close();
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

      <!-- CSS -->
      <link rel="stylesheet" href="../assets/css/styleARTICLE.css">
      <link rel="stylesheet" href="../assets/css/dining.css">
      <link rel="stylesheet" href="../assets/css/styleL.css">
     

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

      <!-- Fonts -->
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

      <!-- Tailwind CDN -->
      <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

      <!-- Favicon -->
      <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicon.ico">
      <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicon.ico">
   

      <!-- Title -->
      <title>les Agences</title>
      <style>
      header {
            background-image: url('../assets/img/1.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh; /* Ajustez la hauteur selon vos besoins */
            padding-top: 20px; /* Si nécessaire pour espacer la barre de navigation du haut */
        }
        </style>
   </head>
   <body>

   <?php include('../layoutR/nav.php')?>

      <!-- Order Section -->
      <section class="layout_padding">
         <div class="container">
             <div class="heading_container">
                 <h2 class="temoinage">Nos Agences</h2>
                  </div>
             </div>
             </section>

      <div class="big" style="border-radius: 15px; ">
    <?php
    // Boucle sur les agences de voyages
    foreach ($agences as $agence) {
    ?>
        <article class="recipe">
            <div class="pizza-box">
            <img src="../images/<?php echo basename($agence['Image']); ?>" alt="hh">
            </div>
            <div class="recipe-content">
                <h1 class="recipe-title" style="   margin-bottom:30px;"><a href="#"><?php echo $agence['Nom']; ?></a></h1>
               
                <p class="recipe-desc">
                    <b><font color="black"><h2>Numero:</h2></font></b><?php echo $agence['Telephone']; ?><b><font color="black"><h2>Gouvernerat:</h2></font></b>
                    <?php echo $agence['LibelleV']; ?>
                </p>
                <br>
                <!-- Ajout de l'ID de l'agence dans l'URL -->
                <a href="rando_agence.php?id_agence=<?php echo $agence['ID_agence']; ?>" class="recipe-save">
                        <path d="M 6.0097656 2 C 4.9143111 2 4.0097656 2.9025988 4.0097656 3.9980469 L 4 22 L 12 19 L 20 22 L 20 20.556641 L 20 4 C 20 2.9069372 19.093063 2 18 2 L 6.0097656 2 z M 6.0097656 4 L 18 4 L 18 19.113281 L 12 16.863281 L 6.0019531 19.113281 L 6.0097656 4 z" fill="currentColor"/>
                    </svg>
                    Consulter
                </a>
            </div>
        </article>
        <br><br>
    <?php
    }
    ?>
</div>

      <!-- Footer -->
      <?php include('../layoutR/le-footer.php')?>

     
     <!-- JS -->
    
  </body>
</html>
