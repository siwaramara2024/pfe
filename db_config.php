// db_config.php
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pfe";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("La connexion a échoué : " . mysqli_connect_error());
}
?>