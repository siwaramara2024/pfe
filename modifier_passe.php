<?php
// Vérification si le formulaire a été soumis
if(isset($_POST['change_password'])) {
    // Vérification si tous les champs sont renseignés
    if(isset($_POST['CIN'], $_POST['currentPassword'], $_POST['newPassword'], $_POST['renewPassword'])) {
        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password_db = "";
        $dbname = "pfe";
        $connexion = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);

        // Récupération du CIN du formulaire
        $CIN = $_POST['CIN'];

        // Récupération du mot de passe actuel de l'utilisateur
        $currentPassword = $_POST['currentPassword'];

        // Récupération du nouveau mot de passe et sa confirmation
        $newPassword = $_POST['newPassword'];
        $renewPassword = $_POST['renewPassword'];

        // Vérification si le nouveau mot de passe correspond à la confirmation
        if($newPassword === $renewPassword) {
            // Requête pour vérifier si le mot de passe actuel est correct
            $stmt = $connexion->prepare("SELECT * FROM Randonneur WHERE CIN = ? AND Mot_de_passe = ?");
            $stmt->execute([$CIN, $currentPassword]);
            $user = $stmt->fetch();

            // Vérification si l'utilisateur existe et si le mot de passe actuel est correct
            if($user) {
                // Requête pour mettre à jour le mot de passe
                $updateStmt = $connexion->prepare("UPDATE Randonneur SET Mot_de_passe = ? WHERE CIN = ?");
                $updateStmt->execute([$newPassword, $CIN]);

                // Affichage d'un message de succès
                header("Location: profil_randonneur.php?CIN=$CIN");
                exit();
            } else {
                // Affichage d'un message d'erreur si le mot de passe actuel est incorrect
                echo "Mot de passe actuel incorrect.";
            }
        } else {
            // Affichage d'un message d'erreur si les nouveaux mots de passe ne correspondent pas
            echo "Les nouveaux mots de passe ne correspondent pas.";
        }
    } else {
        // Affichage d'un message d'erreur si tous les champs ne sont pas renseignés
        echo "Veuillez remplir tous les champs.";
    }
}
?>
