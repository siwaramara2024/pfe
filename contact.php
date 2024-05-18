<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="description" content="" />
<meta name="author" content="" />

<link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon">


<!-- Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">


<!-- Custom CSS -->
<link href="../assets/css/styleL.css" rel="stylesheet" />
<link href="../assets/css/responsive.css" rel="stylesheet" />

 <title>contact</title>
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


    
    <section id="contact" class="contact" >
    <div class="container">

      <div class="heading_container">
        
        <h2 class="temoinage">Contact </h2>
       
      </div>

      <div class="row"style="  border-radius: 30px;">

     

        <div class="col-lg-12">
          <form action="forms/contact.php" method="post" role="form" class="php-email-form">
            <div class="row">
              <div class="col-md-6 form-group">
                <input type="text" name="name" class="form-control" id="name" placeholder="Nom" required>
              </div>
              <div class="col-md-6 form-group mt-3 mt-md-0">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
              </div>
            </div>
            <div class="form-group mt-3">
              <input type="text" class="form-control" name="subject" id="subject" placeholder="Sujet" required>
            </div>
            <div class="form-group mt-3">
              <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
            </div>
            <div class="my-3">
              <div class="loading">Chargement</div>
              <div class="error-message"></div>
              <div class="sent-message">Votre message a été envoyé. Merci!</div>
            </div>
            <div class="text-center"><button type="submit">Envoyer</button></div>
          </form>
        </div>

      </div>

    </div>
  </section>
  
<?php include('../layout/le-footer.php')?>
  </body>
  </html>