

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
    <link href="../assets/css/footer1.css" rel="stylesheet" />

    <title>lunding-page</title>
</head>


<body>

   <header>
        <div class="overlay"></div>
        <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
            <source src="../assets/img/nw.mp4" type="video/mp4">
        </video>
        <div class="header-blue">

            <nav class=" container navbar-container navbar navbar-dark navbar-expand-md navigation-clean-search">
                <div class="container">
                    <a class="navbar-brand" href="#"><img
                            src="../assets/img/logoblanc.png" style="width: 170px;"></a>
                    <button
                        class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span
                            class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navcol-1">
                        <ul class="nav navbar-nav">
                            <li class="nav-item" role="presentation"><a class="nav-link active"
                                    href="lesrandoR.php?cin=<?php echo $_GET['cin']; ?>">Randonnée</a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link active"
                                    href="lesagencesR.php?cin=<?php echo $_GET['cin']; ?>">agences</a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link active"
                                    href="lesarticlesR.php?cin=<?php echo $_GET['cin']; ?>">Articles</a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link active" href="../site/contact.php">Contact</a></li>

                        </ul>
                       
                            <div class="wrap-action-btn">
                                <span class="navbar-text"> <a href="#" class="login">Connexion</a></span>
                                <a class="btn btn-light action-button" role="button" href="#">Inscription</a>
                            </div>
                    </div>
                </div>
            </nav>
        </div>

        <div class="container h-100">
            <div class="d-flex h-100 text-center align-items-center">
                <div class="w-100 text-white">
                    <h3 class="desc-head" >Découvrez le monde
                    </h3>
                    <h4 class="baseline " > Réservez votre aventure<br> de randonnée
                        avec El Mundo</h4>
                        <a href="#"  class="  call-to-action " style="display: inline-block;  text-align:center; margin-top: 40px;border-radius:30px ; font-weight: 550; background-color: #DFEF57; color: rgb(27, 110, 46); padding: 10px 40px; ">Réserver</a>
                     
                        </div>
                        
            </div>
        </div>
    </header> 
    <br>
    <section class="client_section layout_padding-rando">
        <div class="container" >
        <div class="heading_container">
            
            <div class="row text-center">
                <div class="col-md-8 ">
                    <h2 class="temoinage">Randonnées à venir</h2>
                    </div>
                    <div class="col-md-4 ">
                    <a href="#" class=" reserver-btn" style="background-color: #568894 !important;color: white !important;">Voir tous</a>
                    </div>
                    </div>
                    </div>
                    </div>
                    </section>
    <section class="client_section layout_padding">
        <div class="container">
            <div class="row">
              <div class="col-md-6">
                <div class="card mb-3" >
                  <div class="row no-gutters">
                    <div class="col-md-6" style="">
                      <img src="../assets/img/douz.JPEG" alt="Votre Image" class="card-img" style="border-radius: 15px !important;">
                    </div>
                    <div class="col-md-6">
                      <div class="card-body">
                        <div class="row agence" style="margin">
                          <img src="../assets/img/h0.png" alt="Image Agence" class="circular-image">
                          <h4 class="card-title" style="font-weight: 600; font-size: x-large;">Camp Life</h4>
                        </div>
                        <div class="row info">
                          <h5 class="card-text">Douz Sahara</h5>
                        </div>
                        <div class="row info">
                          <i class="bi bi-calendar"></i>
                          <span class="card-text">Date</span>
                        </div>
                        <div class="row info">
                          <i class="bi bi-geo-fill position-icon"></i>
                          <span class="card-text">Localisation</span>
                        </div><br><br>
                        <a href="#" class=" reserver-btn">Réserver</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          
          <div class="col-md-6">
            <div class="card mb-3" >
              <div class="row no-gutters">
                <div class="col-md-6" style="">
                  <img src="../assets/img/touzer.png" alt="Votre Image" class="card-img" style="border-radius: 15px !important;">
                </div>
                <div class="col-md-6">
                  <div class="card-body">
                    <div class="row agence" >
                      <img src="../assets/img/h4.png" alt="Image Agence" class="circular-image">
                      <h4 class="card-title" style="font-weight: 600; font-size: x-large;">Taha voyage</h4>
                    </div>
                    <div class="row info">
                      <h5 class="card-text">Douz Sahara</h5>
                    </div>
                    <div class="row info">
                      <i class="bi bi-calendar"></i>
                      <span class="card-text">Date</span>
                    </div>
                    <div class="row info">
                      <i class="bi bi-geo-fill position-icon"></i>
                      <span class="card-text">Localisation</span>
                    </div><br><br>
                    <a href="#" class=" reserver-btn" style="margin-left: inherit;">Réserver</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
            </div>
          </div>
          
          
        <!-- <div class="container">
            <div class="row ">
                <div class="card">
            <div class="col-md-3">
              <img src="../assets/img/douz.JPEG" alt="Votre Image" class="rounded-image">
            </div>
            <div class="col-md-3 block" style="margin-left: 20px !important;">
              <div class="row agence " >
                <img src="../assets/img/h0.png" alt="Image Agence" class="circular-image">
                <h4 class="" style="font-weight: 600;font-size: x-large;">Camp Life</h4>
              
              </div>
              <div class="col sec_info ">
              <div class="row info " >
                <h5>Douz Sahara</h5>
              </div>
              <div class="row info">
                <i class="bi bi-calendar"></i>
                <span>Date</span>
              </div>
              <div class="row info">
                <i class="bi bi-geo-fill position-icon"></i>
                <span>Localisation</span>
              </div>
              <br><br>
              <a href="" class=" reserver-btn"  >Réserver</a> 
            </div>
        </div></div>
        <br> <div class="card">
        <div class="col-md-3">
            <img src="../assets/img/hewourya.png" alt="Votre Image" class="rounded-image">
          </div>
          <div class="col-md-3 block">
            <div class="row agence " >
              <img src="../assets/img/h0.png" alt="Image Agence" class="circular-image">
              <h4 class="" style="font-weight: 600;font-size: x-large;">Camp Life</h4>
            
            </div>
            <div class="col sec_info ">
            <div class="row info " >
              <h5>Douz Sahara</h5>
            </div>
            <div class="row info">
              <i class="bi bi-calendar"></i>
              <span>Date</span>
            </div>
            <div class="row info">
              <i class="bi bi-geo-fill position-icon"></i>
              <span>Localisation</span>
            </div>
            <br><br>
            <a href="" class=" reserver-btn"  >Réserver</a> 
          </div>
      </div>
          </div></div>
          </div> -->
        
</section>
    <br>
    <section class="client_section layout_padding"style="background-color: #B1D5E2;  padding: 50px 0;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="about_content">
                        <h1>À propos</h1>
                        <br>
                        <p>
                            Découvrez El Mundo! <br>Votre portail pour des aventures de randonnée uniques. Notre plateforme permet aux agences de proposer des randonnées détaillées avec une variété de matériel et d'activités. Réservez votre prochaine aventure dès aujourd'hui !
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="about_images container ">
                        <div class="image">
                            <img src="../assets/img/articl.jpg" alt="">
                       
                            <img src="../assets/img/4.jpg" alt="" >
                        </div>
                        <div class="image">
                            <img src="../assets/img/3.jpeg" alt="">
                        </div>
                    </div>
                </div>
            </div>
           
        </div>

    </section>
    
    <section class="client_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-4 column">
                    <img src="../assets/img/st.png" alt="Image 1" style="width: 100px; margin-top: 3px;">
                    <div class="column-content">
                        <h4 class="" style="font-weight: 600;">Expérience  Exceptionnelle</h4>
                        <p class="" style="font-size: 18px;">Une expérience utilisateur<br> exceptionnelle est notre priorité.</p>
                    </div>
                </div>
                <div class="col-md-4 column">
                    <img src="../assets/img/re.png" alt="Image 2" style="width: 100px; ">
                    <div class="column-content">
                        <h4 class="" style="font-weight: 600;">Exploration Sans Limite</h4>
                        <p class="" style="font-size: 18px;">Découvrez des sentiers uniques <br>et des destinations fascinantes.</p>
                    </div>
                </div>
                <div class="col-md-4 column">
                    <img src="../assets/img/lo.png" alt="Image 3" style="width: 100px; margin-top: 11px;">
                    <div class="column-content">
                        <h4 class="" style="font-weight: 600;">Communauté Engagée</h4>
                        <p class="" style="font-size: 18px;">Rejoignez une communauté <br>passionnée de randonneurs.</p>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
    <!-- <div class="container"><hr class="trait"></div> -->
    
  
                <section class="client_section layout_padding">
                    <div class="container" >
                    <div class="heading_container">
                        
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h2 class="temoinage">Materiél</h2>
                                </div></div></div></div></section>
   <section class="client_section layout_padding">
   <div class="container">
      <div class="row">
                <div class="col-md-1"> </div>
                <div class="col-md-4 ">
                    <div class="mat_images ">
                        <div class="image_mat" >
                            <img src="../assets/img/BAG.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mat_content">
                        <h3>Les indisponsables pour les randonnées et les campings</h3>
                        <br>
                        <p class="" style="font-size: 20px; margin-bottom:70px;">
                            Équipez-vous pour l'aventure !
                            <br> Découvrez notre sélection de matériel de randonnée de qualité et réservez dès maintenant pour une expérience inoubliable.
                        </p>
                       <div class=" voir-plus">
                            <a href="" class="materiel-btn"  style="width: 50px;">Voir tous</a> 
                      
                        </div>
                    </div>
                </div>
                <div class="col-md-1"> </div>
            </div>
        </div>
    </section>
    
    <section class="client_section layout_padding">
        <div class="container" >
        <div class="heading_container">
            
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="temoinage">Activités</h2>
                    <p class="" style="font-size: 20px;">Découvrez nos activités variées pour enrichir votre expérience en plein air.</p>
                </div>
            </div>
            <br>
            <div class="row justify-content-between">
                <div class=" col-sm-6 col-md-3">
                    <div class="activity_box text-center">
                        <img src="../assets/img/vélo.jpg" alt="Activité 1" class="activity_image">
                        <a href="page_activite" class="activity_button">Vélo</a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="activity_box text-center">
                        <img src="../assets/img/escalade.jpg" alt="Activité 2" class="activity_image">
                        <a href="page_activite" class="activity_button">Escalade</a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="activity_box text-center">
                        <img src="../assets/img/yogo.jpg" alt="Activité 3" class="activity_image">
                        <a href="page_activite" class="activity_button">Yoga</a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 ">
                    <div class="activity_box text-center">
                        <img src="../assets/img/kayak.jpg" alt="Activité 4" class="activity_image">
                        <a href="page_activite" class="activity_button">Kayak</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

   
   
    <section class="client_section layout_padding">
        <div class="container">
            <div class="heading_container">
                <h2 class="temoinage">Les voix de nos explorateurs</h2>
                <p class=""  style="font-size: 20px;">Votre témoignage compte ! <br>Ensemble, améliorons nos services pour des aventures toujours plus enrichissantes.</p>
            </div>
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="box row">
                            <div class="img-box col-md-4">
                                <img src="../assets/img/client.png" alt="">
                            </div>
                           
                            <div class="detail-box col-md-8">
                               
                                    <img  src="../assets/img/tém.png" alt="" class="icone">
                              
                                <p class="cmnt">
                                    El Mundo a rendu la randonnée accessible  et passionnante pour moi, un débutant. Des descriptions claires, des options adaptées, et une aventure mémorable à chaque étape.
                                 </p>
                                <h4>Sadok Mtir</h4>
                                <p class="city">Nabeul</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="box row">
                            <div class="img-box col-md-4">
                                <img src="../assets/img/client.png" alt="">
                            </div>
                            <div class="detail-box col-md-8">
                               
                                    <img src="../assets/img/tém.png" alt="" class="icone">
                             
                                <p class="cmnt">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.
                                </p>
                                <h4>Minim Veniam</h4>
                                <p class="city">London, UK</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel_btn-box">
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <i class="bi bi-arrow-left" aria-hidden="true"></i>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
   
    </section>
    <section id="contact" class="contact" >
        <div class="container">
  
          <div class="heading_container">
            
            <h2 class="temoinage">Contact </h2>
           
          </div>
  
          <div class="row" style="  border-radius:15px;">
  
         
  
            <div class="col-lg-12" style="  border-radius: 15px;">
              <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                <div class="row">
                  <div class="col-md-6 form-group mt-3 mt-md-0">
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
                <div class="text-center" style="text-align: right;"><button type="submit">Envoyer</button></div>
              </form>
            </div>
  
          </div>
  
        </div>
      </section>
      <div class="py-5">
       
            <div class="row align-items-center" id="brand-slider">
                <div class="col-md-3 col-sm-6 my-3">
                    <a href="#!"><img class="img-fluid img-brand d-block mx-auto" src="../assets/img/tutto.png" alt="..."  style="width:200px" /></a>
                </div>
                <div class="col-md-3 col-sm-6 my-3">
                    <a href="#!"><img class="img-fluid img-brand d-block mx-auto" src="../assets/img/Decathlon-Logo.png" alt="..."  style="width:150px"/></a>
                </div>
                <div class="col-md-3 col-sm-6 my-3">
                    <a href="#!"><img class="img-fluid img-brand d-block mx-auto" src="../assets/img/citysport.png" alt="..."  style="width:150px"/></a>
                </div>
                <div class="col-md-3 col-sm-6 my-3">
                    <a href="#!"><img class="img-fluid img-brand d-block mx-auto" src="../assets/img/lesportif.png" alt="..."  style="width:150px"/></a>
                </div>
                
            </div>
        
    </div>
    
    <section class="newsletter_section layout_padding" style="background-color: #B1D5E2; ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="newsletter_content text-center">
                        <img src="../assets/img/newsletter-01.png" alt="Newsletter Image" class="newsletter_image">
                        <h3 class="newsletter_title">Inscrivez-vous à notre newsletter</h3>
                        <p class="newsletter_description">Inscrivez-vous à notre newsletter pour ne rien manquer des dernières aventures, offres spéciales et conseils de randonnée exclusifs !</p>
                        <input type="email" class="newsletter_input" placeholder="Entrer votre e-mail" style="color: white; border-bottom: 1px solid white; background-color: transparent;">
                    </div>
                </div>
            </div>
        </div>
    </section>
 
   

</body>
<?php include('../layout/le-footer.php')?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>


  