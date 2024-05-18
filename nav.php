<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/header1.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
    
    <header>
        <nav class="topnav clearfix container- navbar-container navbar navbar-dark navbar-expand-sm" id="myTopnav">
       
         <a class="navbar-brand" href="pagedacceuil.php"><img src="../assets/img/logoblanc.png" alt="logo" style="width: 170px;"></a>
          <button class="navbar-toggler-custom"><span
                                   class="sr-only"></span><span class="navbar-toggler-custom-icon"></span></button>
       
         <div class="collapse-custom">
            <ul class="nav-custom" style="list-style-type:none;">
                <li>
                <a href="lesrando.php">Randonnées</a>
           </li>
           <li>
                <a href="lesagences.php">Agences</a>
           </li>
           <li>
                <a href="lesarticles.php">Articls</a>
           </li>
           <li>
                <a href="contact.php">Contact</a>
           </li>
           <li>
           <a href="../inscreption.php" class=" btn-light action-button" role="button">Inscription</a>
           </li>
           <li>
           <a href="../login.php" class="btn-light action-button"  style="border:inherit ; margin-right:-10px !important">Connexion</a>     
       
           </li>
       </ul>
       </div>
        
         
       </div>
         
       </nav>
       
       
       </header>
       <script>
        function myFunction() {
          var x = document.getElementById("myTopnav");
          if (x.className === "topnav") {
            x.className += " responsive";
          } else {
            x.className = "topnav";
          }
        }
                
        $(document).ready(function() {
            $(".navbar-toggler-custom").on("click", function() {
                var cible = $(this).next('.collapse-custom');
                cible.toggle();
            });
        });
    </script>

</body>


</html>