<?php
session_start(); // Ξεκινήστε τη συνεδρία
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Arkdadika Mas</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
        <link rel="icon" href="/ergasia/favicon.jpg" type="image/x-icon">

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
        <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" ></script>
        <link rel="stylesheet" type="text/css" href="styleboot.css">

   </head>
   
    <body id="myPage">
    <nav class="navbar navbar-expand-lg navbar-dark ">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="page.php">
                <img src="arkadikamas.jpg" id="logo" alt="Logo">
            </a>
        </div>
        <a class="navbar-brand" href="page.php">ArkadikaMas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="products.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="font-family=sans-serif;" href="aboutus.php">About us</a>
                </li>

                <?php
                if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                    // Εάν ο χρήστης είναι διαχειριστής, εμφανίστε το μενού "Edit"
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Edit
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="editusers.php">Edit Users</a></li>
                            <li><a class="dropdown-item" href="editorders.php">Edit Orders</a></li>
                            <li><a class="dropdown-item" href="editproducts.php">Edit Products</a></li>
                        </ul>
                    </li>
                    <?php
                }
                ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Profile
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                        if (isset($_SESSION['email'])) {
                            // Εάν ο χρήστης είναι συνδεδεμένος, εμφανίστε την επιλογή "Logout"
                            ?>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            <li><a class="dropdown-item" href="orders.php">Order History</a></li>

                            <li><a class="dropdown-item" href="profile.php">Edit Profile</a></li>
                            <?php
                        } else {
                            // Εάν ο χρήστης δεν είναι συνδεδεμένος, εμφανίστε τις επιλογές "Login" και "Sign up"
                            ?>
                            <li><a class="dropdown-item" href="index.php">Login User</a></li>
                            <li><a class="dropdown-item" href="signup.php">Sign up User</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
            </ul>
            <i class="fas fa-search" aria-hidden="true"></i>
            <div id="htmlContainer">
                <input type="text" id="search-item" placeholder="Search..">
            </div>
            <div class="cart-btn">
                <span class="nav-icon">
                    <i class="fas fa-cart-plus"></i>
                </span>
                <div class="cart-items">0</div>
            </div>
            <div class="heart-btn">
                <a class="nav1-icon" href="favorites.php">
                    <i class="fas fa-heart"></i>
                </a>
                <div class="heart-items">0</div>
            </div>
        </div>
    </div>
</nav>

<div class="more-information-section" id="moreInfo" style="background-color: rgba(255, 255, 255, 1); padding: 15px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                <!-- Όνομα Εταιρίας -->
                <h1 style="font-family: 'Playfair Display', serif; color: #333333;">
                    Εργαστήριο Ζυμαρικών
                </h1>
                
                <!-- Σλόγκαν -->
                <h2 style="font-family: 'Playfair Display', serif; color: #000000;">
                    ''Αρκαδικά μας''
                </h2>
                
                <!-- Περιγραφή -->
                <h3 style="font-family: 'Open Sans', sans-serif; color: #333333;">
                    Μεγαλόπολη Αρκαδίας
                </h3>
                
                <!-- Πρόσθετη Πληροφορία -->
                <h4 style="font-family: 'Open Sans', sans-serif; color: #ff6600;">
                    Παραδοσιακά ζυμαρικά από αγνά και φρέσκα υλικά!
                </h4>
            </div>
        </div>
    </div>
</div>
<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="m1.jpg" class="d-block w-100" alt="...">
            <div class="overlay">
                <a href="products.php" class="cta-button">Δείτε τα προϊόντα μας</a>
            </div>
        </div>
           <!-- Carousel item για τις επιχειρήσεις -->
           <div class="carousel-item">
            <img src="b2b.png" class="d-block w-100" alt="Business Solutions">
            <div class="carousel-caption d-none d-md-block">
                <h2>Εξυπηρετούμε και Επιχειρήσεις!</h2>
                <p>Προσφέρουμε εξειδικευμένες λύσεις για την επιχείρησή σας. Επικοινωνήστε μαζί μας για να μάθετε πώς μπορούμε να σας βοηθήσουμε να αναπτύξετε την επιχείρησή σας!</p>
                <a href="aboutus.php#business-services" class="cta-button">Εξυπηρετούμε και Επιχειρήσεις</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="genika.jpg" class="d-block w-100" alt="...">
      
            <div class="overlay">
                <a href="products.php" class="cta-button">Δείτε τα προϊόντα μας</a>
            </div>
        </div>
      
     
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>


    
           
        <div class="more-information-section" id="moreInfo" style="background-color: rgba(255,255,255,1);">
                <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 15px;">
                    <h1 style="text-align: center; font-family:Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">&Mu;&epsilon; &pi;&omicron;&lambda;&lambda;ή &alpha;&gamma;ά&pi;&eta; &Pi;&alpha;&rho;&alpha;&sigma;&kappa;&epsilon;&upsilon;ά&zeta;&omicron;&upsilon;&mu;&epsilon;:</h1>                </div>
            </div>
        </div>
    </div>


<div class="home-service-section cl_blk 1-7-12 columnblock_43855" id="column_43855" style="background-color: rgba(255,255,255,1);">
            <div class="container">
        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 verticalitems">
                    <div class="imgbtm"><div class="vercontentblock textcolspan_vertical_box"><table style="width: 100%;" cellpadding="5">
<tbody>
<tr>
<td style="width: 33%; text-align: center; vertical-align: middle;"><img src="https://www.ourglobalidea.com/rep/app/webroot/files/smewebsites/79909/_chi__upsilon__lambda__omicron__pi____tau__epsilon__sigmaf_2-60percent_pinta.jpg" alt="" width="100%" height="NaN" /></td>
<td style="vertical-align: top;">
<div class="text-start">
<h2><strong><span style="color: #000000;">&Chi;&upsilon;&lambda;&omicron;&pi;ί&tau;&epsilon;&sigmaf;</span></strong></h2>
<p style="text-align: justify;"><br />&Tau;&omicron; &pi;&alpha;&rho;&alpha;&delta;&omicron;&sigma;&iota;&alpha;&kappa;ό &epsilon;&lambda;&lambda;&eta;&nu;&iota;&kappa;ό &mu;&alpha;&sigmaf; &zeta;&upsilon;&mu;&alpha;&rho;&iota;&kappa;ό &pi;&alpha;&rho;&alpha;&sigma;&kappa;&epsilon;&upsilon;ά&zeta;&epsilon;&tau;&alpha;&iota; &alpha;&pi;ό &alpha;&lambda;&epsilon;ύ&rho;&iota;, &alpha;&upsilon;&gamma;ά, &gamma;ά&lambda;&alpha; &kappa;&alpha;&iota; &alpha;&lambda;ά&tau;&iota;. &Tau;&epsilon;&mu;&alpha;&chi;ί&zeta;&omicron;&nu;&tau;&alpha;&iota; &sigma;&epsilon; &mu;&iota;&kappa;&rho;ά &tau;&epsilon;&tau;&rho;ά&gamma;&omega;&nu;&alpha; &kappa;&alpha;&iota; &mu;&epsilon;&tau;ά &tau;&eta;&nu; &alpha;&pi;&omicron;&xi;ή&rho;&alpha;&nu;&sigma;&eta; &epsilon;ί&nu;&alpha;&iota; έ&tau;&omicron;&iota;&mu;&alpha; &nu;&alpha; &mu;&pi;&omicron;&upsilon;&nu; &sigma;&tau;&omicron; &tau;&rho;&alpha;&pi;έ&zeta;&iota; &sigma;&alpha;&sigmaf; </p>
                    </div></td>
</tr>
</tbody>
</table></div><div class='content-block commoncls'></div></div>                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 verticalitems">
                    <div class="imgbtm"><div class="vercontentblock textcolspan_vertical_box"><table style="width: 100%;" cellpadding="5">
<tbody>
<tr>
<td style="width: 33%; text-align: center; vertical-align: middle;"><img src="https://www.ourglobalidea.com/rep/app/webroot/files/smewebsites/79909/mouf_lazania1-500x500-60percent.jpg" alt="" width="100%" height="NaN" /></td>
<td style="vertical-align: top;">
<div class="text-start">
<h2><strong><span style="color: #000000;">&Lambda;&alpha;&zeta;ά&nu;&iota;&alpha;</span></strong></h2>
<p style="text-align: justify;"><br />&Tau;&alpha; &lambda;&alpha;&zeta;ά&nu;&iota;&alpha; &pi;&alpha;&rho;&alpha;&sigma;&kappa;&epsilon;&upsilon;ά&zeta;&omicron;&nu;&tau;&alpha;&iota; ό&pi;&omega;&sigmaf; &kappa;&alpha;&iota; &alpha;&kappa;&rho;&iota;&beta;ώ&sigmaf; &kappa;&alpha;&iota; &omicron;&iota; &chi;&upsilon;&lambda;&omicron;&pi;ί&tau;&epsilon;&sigmaf;, &mu;ό&nu;&omicron; &pi;&omicron;&upsilon; &kappa;ό&beta;&omicron;&nu;&tau;&alpha;&iota; &sigma;&epsilon; &sigma;&tau;&epsilon;&nu;ό&mu;&alpha;&kappa;&rho;&epsilon;&sigmaf; &lambda;&omega;&rho;ί&delta;&epsilon;&sigmaf;.</p>
                    </div></td>
</tr>
</tbody>
</table></div><div class='content-block commoncls'></div></div>                </div>
                        </div>
    </div>
</div>
<style type="text/css">
        .vercontentblock h1,h2,h3,h4,h5,h6 {
            margin-top: 0px !important;
        }
    </style><style type="text/css">
  .videoblk{
    z-index: 1;
    position: relative;
  }
</style>

<div class="home-service-section cl_blk 1-8-12 columnblock_43856" id="column_43856" style="background-color: rgba(255,255,255,1);">
            <div class="container">
        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 verticalitems">
                    <div class="imgbtm"><div class="vercontentblock textcolspan_vertical_box"><table style="width: 100%;" cellpadding="5">
<tbody>
<tr>
<td style="width: 33%; text-align: center; vertical-align: middle;"><img src="https://www.ourglobalidea.com/rep/app/webroot/files/smewebsites/79909/_kappa__rho__iota__theta__alpha__rho____kappa__iota_-pinta-_alpha__sigma__pi__rho__omicron___phi____nu__tau__omicron_-60_c-_500x500.jpg" alt="" width="100%" height="NaN" /></td>
<td style="vertical-align: top;">
<div class="text-start">
<h2><strong><span style="color: #000000;">&Kappa;&rho;&iota;&theta;&alpha;&rho;ά&kappa;&iota;</span></strong></h2>
<p style="margin-bottom: 0cm; line-height: 100%; text-align: justify;"><br />&Tau;&omicron; &kappa;&rho;&iota;&theta;&alpha;&rho;ά&kappa;&iota; ή &mu;&alpha;&nu;έ&sigma;&tau;&rho;&alpha; &epsilon;ί&nu;&alpha;&iota; &zeta;&upsilon;&mu;&alpha;&rho;&iota;&kappa;ό &tau;&eta;&sigmaf; &epsilon;&lambda;&lambda;&eta;&nu;&iota;&kappa;ή&sigmaf; &kappa;&alpha;&iota; &iota;&tau;&alpha;&lambda;&iota;&kappa;ή&sigmaf; &kappa;&omicron;&upsilon;&zeta;ί&nu;&alpha;&sigmaf;. H &omicron;&nu;&omicron;&mu;&alpha;&sigma;ί&alpha; &tau;&omicron;&upsilon; &pi;&rho;&omicron;έ&rho;&chi;&epsilon;&tau;&alpha;&iota; &alpha;&pi;ό &tau;&omicron; &delta;&eta;&mu;&eta;&tau;&rho;&iota;&alpha;&kappa;ό &kappa;&rho;&iota;&theta;ά&rho;&iota;. </p>
</div></td>
</tr>
</tbody>
</table></div><div class='content-block commoncls'></div></div>                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 verticalitems">
                    <div class="imgbtm"><div class="vercontentblock textcolspan_vertical_box"><table style="width: 100%;" cellpadding="5">
<tbody>
<tr>
<td style="width: 33%; text-align: center; vertical-align: middle;"><img src="https://www.ourglobalidea.com/rep/app/webroot/files/smewebsites/79909/_mu__alpha__kappa__alpha__rho__omicron__nu____kappa__iota_-60_percent-pinta-500x500jpg.jpg" alt="" width="100%" height="NaN" /></td>
<td style="vertical-align: top;"> 
    <div class="text-start">
<h2><strong><span style="color: #000000;">&Mu;&alpha;&kappa;&alpha;&rho;&omicron;&nu;ά&kappa;&iota;</span></strong></h2>
<p style="text-align: justify;"><br />&Iota;&delta;&alpha;&nu;&iota;&kappa;ό &phi;&alpha;&gamma;&eta;&tau;ό &gamma;&iota;&alpha; &phi;&omicron;&iota;&tau;&eta;&tau;έ&sigmaf;, &epsilon;&rho;&gamma;έ&nu;&eta;&delta;&epsilon;&sigmaf; &kappa;&alpha;&iota; &alpha;&theta;&lambda;&eta;&tau;έ&sigmaf;. &Epsilon;ί&nu;&alpha;&iota; έ&nu;&alpha; &alpha;&gamma;&nu;ό &kappa;&alpha;&iota; &phi;&upsilon;&sigma;&iota;&kappa;ό &pi;&rho;&omicron;ϊό&nu;, &epsilon;&nu;ώ &theta;&epsilon;&omega;&rho;&epsilon;ί&tau;&alpha;&iota; &beta;&alpha;&sigma;&iota;&kappa;ό &kappa;&omicron;&mu;&mu;ά&tau;&iota; &tau;&eta;&sigmaf; &Mu;&epsilon;&sigma;&omicron;&gamma;&epsilon;&iota;&alpha;&kappa;ή&sigmaf; &Delta;&iota;&alpha;&tau;&rho;&omicron;&phi;ή&sigmaf;. </p>

</div></td>
</tr>
</tbody>
</table></div><div class='content-block commoncls'></div></div>                </div>
                        </div>
    </div>
</div>
<style type="text/css">
  .videoblk{
    z-index: 1;
    position: relative;
  }
</style>

<div class="home-service-section cl_blk 1-9-12 columnblock_44264" id="column_44264" style="background-color: rgba(255,255,255,1);">
            <div class="container">
        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 verticalitems">
                    <div class="imgbtm"><div class='content-block commoncls'></div><div class="vercontentblock textcolspan_vertical_box"><table style="width: 100%;" cellpadding="5">
<tbody>
<tr>
<td style="width: 33%; text-align: center; vertical-align: middle;"><img src="https://www.ourglobalidea.com/rep/app/webroot/files/smewebsites/79909/_beta__iota__delta__epsilon__sigma__sigma_-60.jpg" alt="" width="100%" height="NaN" /></td>
<td style="vertical-align: top;">
<div class="text-start">
<h2><strong><span style="color: #000000;">&Beta;ί&delta;&epsilon;&sigmaf;</span></strong></h2>
<p style="text-align: justify;"><br />&Iota;&delta;&alpha;&nu;&iota;&kappa;ά &gamma;&iota;&alpha; &kappa;&rho;ύ&epsilon;&sigmaf; &sigma;&alpha;&lambda;ά&tau;&epsilon;&sigmaf; &zeta;&upsilon;&mu;&alpha;&rho;&iota;&kappa;ώ&nu; &alpha;&lambda;&lambda;ά &kappa;&alpha;&iota; &kappa;ά&theta;&epsilon; &mu;&alpha;&kappa;&alpha;&rho;&omicron;&nu;ά&delta;&alpha;. &Omicron;&iota; &sigma;&tau;&rho;&omicron;&phi;έ&sigmaf; &tau;&eta;&sigmaf; &ldquo;&beta;ί&delta;&alpha;&sigmaf;&rdquo; &sigma;&upsilon;&gamma;&kappa;&rho;&alpha;&tau;&omicron;ύ&nu; &tau;&eta;&nu; &sigma;ά&lambda;&tau;&sigma;&alpha; &alpha;&phi;ή&nu;&omicron;&nu;&tau;&alpha;&sigmaf; &mu;&iota;&alpha; &epsilon;&xi;&alpha;&iota;&rho;&epsilon;&tau;&iota;&kappa;ή &gamma;&epsilon;ύ&sigma;&eta; &kappa;&alpha;&iota; &sigma;&tau;&omicron;&upsilon;&sigmaf; &pi;&iota;&omicron; &alpha;&pi;&alpha;&iota;&tau;&eta;&tau;&iota;&kappa;&omicron;ύ&sigmaf;.</p>
</div>
</td>
</tr>
</tbody>
</table></div></div>                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 verticalitems">
                    <div class="imgbtm"><div class='content-block commoncls'></div><div class="vercontentblock textcolspan_vertical_box"><table style="width: 100%;" cellpadding="5">
<tbody>
<tr>
<td style="width: 33%; text-align: center; vertical-align: middle;"><img src="https://www.ourglobalidea.com/rep/app/webroot/files/smewebsites/79909/_kappa__omicron__chi__upsilon__lambda__alpha__kappa__iota_3-60percent-pinta.jpg" alt="" width="100%" height="NaN" /></td>
<td style="vertical-align: top;">
<div class="text-start">
<h2><strong><span style="color: #000000;">&Kappa;&omicron;&chi;&upsilon;&lambda;ά&kappa;&iota;</span></strong></h2>
<p style="margin-bottom: 0cm; line-height: 100%; text-align: justify;"><br />&Tau;&alpha; &kappa;&omicron;&chi;&upsilon;&lambda;ά&kappa;&iota;&alpha; &lambda;ό&gamma;&omega; &tau;&omicron;&upsilon; &iota;&delta;&iota;&alpha;ί&tau;&epsilon;&rho;&omicron;&upsilon; &sigma;&chi;ή&mu;&alpha;&tau;&omicron;&sigmaf; &epsilon;&nu;&tau;&upsilon;&pi;&omega;&sigma;&iota;ά&zeta;&omicron;&upsilon;&nu; &iota;&delta;&iota;&alpha;ί&tau;&epsilon;&rho;&alpha; &tau;&alpha; &mu;&iota;&kappa;&rho;ά &pi;&alpha;&iota;&delta;&iota;ά! &Sigma;&upsilon;&gamma;&kappa;&rho;&alpha;&tau;ώ&nu;&tau;&alpha;&sigmaf; &tau;&omicron;&nu; &kappa;&iota;&mu;ά ή &tau;&eta; &sigma;ά&lambda;&tau;&sigma;&alpha; &delta;ί&nu;&omicron;&upsilon;&nu; έ&nu;&alpha; &xi;&epsilon;&chi;&omega;&rho;&iota;&sigma;&tau;ό &sigma;&tau;&upsilon;&lambda; &sigma;&tau;&omicron; &tau;&rho;&alpha;&pi;έ&zeta;&iota;!</p>
</div>
</td>
</tr>
</tbody>
</table></div></div>                </div>
                        </div>
    </div>
</div>
<style type="text/css">
  .videoblk{
    z-index: 1;
    position: relative;
  }
</style>

<div class="home-service-section cl_blk 1-10-12 columnblock_44614" id="column_44614" style="background-color: rgba(255,255,255,1);">
            <div class="container">
        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 verticalitems">
                    <div class="imgbtm"><div class='content-block commoncls'></div><div class="vercontentblock textcolspan_vertical_box"><table style="width: 100%;" cellpadding="5">
<tbody>
<tr>
<td style="width: 33%; text-align: center; vertical-align: middle;"><img src="https://www.ourglobalidea.com/rep/app/webroot/files/smewebsites/79909/_tau__rho__alpha__chi__alpha__nu____sigmaf__500_chi_500_60percent_pinta.jpg" alt="" width="100%" height="NaN" /></td>
<td style="vertical-align: top;">
    <div class="text-start">
<h2><strong><span style="color: #000000;text-align: center;">&Tau;&rho;&alpha;&chi;&alpha;&nu;ά&sigmaf; &xi;&iota;&nu;ό&sigmaf;<br /></span></strong></h2>
<p style="margin-bottom: 0cm; line-height: 100%; text-align: justify;"><br />Έ&nu;&alpha; &pi;&iota;ά&tau;&omicron; &xi;&iota;&nu;ό&sigmaf; &tau;&rho;&alpha;&chi;&alpha;&nu;ά&sigmaf; &epsilon;ί&nu;&alpha;&iota; &tau;&omicron; &kappa;&alpha;&lambda;ύ&tau;&epsilon;&rho;&omicron; &mu;&alpha;&lambda;&alpha;&kappa;&tau;&iota;&kappa;ό &gamma;&iota;&alpha; &tau;&omicron; &sigma;&tau;&omicron;&mu;ά&chi;&iota; &kappa;&alpha;&iota; έ&nu;&alpha; &pi;&lambda;ή&rho;&epsilon;&sigmaf; &pi;&rho;&omega;&iota;&nu;ό &gamma;&iota;&alpha; &nu;&alpha; &alpha;&nu;&tau;έ&xi;&omicron;&upsilon;&mu;&epsilon; &mu;&iota;&alpha; &delta;ύ&sigma;&kappa;&omicron;&lambda;&eta; &mu;έ&rho;&alpha;. &Iota;&delta;&alpha;&nu;&iota;&kappa;ό &gamma;&iota;&alpha; &mu;&omega;&rho;ά &kappa;&alpha;&iota; &gamma;&iota;&alpha; &mu;&epsilon;&gamma;ά&lambda;&omicron;&upsilon;&sigmaf;. &Mu;&epsilon; &pi;&omicron;&lambda;ύ &lambda;ί&gamma;&alpha; &alpha;&gamma;&nu;ά &upsilon;&lambda;&iota;&kappa;ά έ&chi;&omicron;&upsilon;&mu;&epsilon; &tau;&omicron; &pi;&alpha;&rho;&alpha;&delta;&omicron;&sigma;&iota;&alpha;&kappa;ό&tau;&epsilon;&rho;&omicron; &phi;&alpha;&gamma;&eta;&tau;ό.</p>
</div>
</td>
</tr>
</tbody>
</table></div></div>                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 verticalitems">
                    <div class="imgbtm"><div class='content-block commoncls'></div><div class="vercontentblock textcolspan_vertical_box"><table style="width: 100%;" cellpadding="5">
<tbody>
<tr>
<td style="width: 33%; text-align: center; vertical-align: middle;"><img src="https://www.ourglobalidea.com/rep/app/webroot/files/smewebsites/79909/_pi__omicron__iota__kappa__iota__lambda__iota__alpha_2-60.jpg" alt="" width="100%" height="NaN" /></td>
<td style="vertical-align: top;"> 
    <div class="text-start">
<h2><strong><span style="color: #000000;text-align: center;">&Pi;&omicron;&iota;&kappa;&iota;&lambda;ί&alpha;</span></strong></h2>
<p><br />&Tau;&alpha; &pi;&alpha;&rho;&alpha;&delta;&omicron;&sigma;&iota;&alpha;&kappa;ά &mu;&alpha;&sigmaf; &zeta;&upsilon;&mu;&alpha;&rho;&iota;&kappa;ά &pi;&alpha;&rho;&alpha;&sigma;&kappa;&epsilon;&upsilon;ά&zeta;&omicron;&nu;&tau;&alpha;&iota;: &alpha;) &Kappa;&alpha;&nu;&omicron;&nu;&iota;&kappa;ά, &beta;) &Omicron;&lambda;&iota;&kappa;ή&sigmaf; ά&lambda;&epsilon;&sigma;&eta;&sigmaf;, &gamma;) &Nu;&eta;&sigma;&tau;ί&sigma;&iota;&mu;&alpha;, &delta;)&nbsp; &Delta;ί&kappa;&kappa;&omicron;&kappa;&omicron; &Sigma;&iota;&tau;ά&rho;&iota;&nbsp; &kappa;&alpha;&iota; &epsilon;) &Mu;&epsilon; &mu;&epsilon;&lambda;ά&nu;&iota; &sigma;&omicron;&upsilon;&pi;&iota;ά&sigmaf;!</p>
</div>
</td>
</tr>
</tbody>
</table></div></div>                </div>
                        </div>
    </div>
</div>
<style type="text/css">
        .columnblock_44434 {
            padding-bottom : 0px !important;
        }
    </style><style type="text/css">
  .videoblk{
    z-index: 1;
    position: relative;
  }
</style>

     
        <div id="suggest" class="bg-1">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <p class="text-center"><strong>Lazania</strong><span class="label label-success">NEW</span></p>
                        <a href="product.php?id=4" data-toggle="collapse"><img src="lazania.jpg" class="food img-circle"></a>
                        <div id="demo1" class="collapse-show">
                            <p>Lazania 750gr</p>
                            
                        </div>
                    </div>
                    <div class="col">
                        <p class="text-center"><strong>Vides Olikis</strong></p>
                        <a href="product.php?id=24" data-toggle="collapse"><img src="bidesolikhs500.jpg" class="food img-circle"></a>
                        <div id="demo2" class="collapse-show">
                            <p>Vides Olikis 500gr</p>
                        </div>
                    </div>
                    <div class="col">
                        <p class="text-center"><strong>Vides</strong></p>
                        <a href="product.php?id=27" data-toggle="collapse"><img src="videssoupias.jpg" class="food img-circle"></a>
                        <div id="demo3" class="collapse-show">
                            <p>Vides Soupias</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        
         <!--cart-->
         <div class="cart-overlay">
                        <div class="cart">
                          <span class="close-cart">
                            <i class="fas fa-window-close"></i>
                          </span>
                          <h2>Your Cart</h2>
                          <div class="cart-content">
                            <!--cart item-->
                       <!---     <div class="cart-item">
                              
                            </div>
                            <!-end of cart item-->
                            </div>
                          <div class="cart-footer">
                            <h3>SUM: $ <span class="cart-total">0</span></h3>
                            <button class="clear-cart banner-btn">Delete Cart</button>
                            <a href="Checkout.php">
                              <button class="clear-cart banner-btn">Checkout</button>
                            </a> 
                          </div>
                        </div>
                      </div>
                      <!--end of cart-->
   
               
                      <footer class="footer text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h3>About us</h3>
                <p>ArkadikaMas produce pasta with pure products with varieties for your households and businesses.</p>
            </div>
            <div class="col-md-4">
                <h3>Contact</h3>
                <p>Address: Panagioti Kefala 6, City:Megalopoli,Arcadia, P.O. 22200
                </p>
                <p>Email: arkadikamas@yahoo.gr</p>
                <p>Phone: 699999999</p>
            </div>
            <div class="col-md-4">
                <h3>Follow us</h3>
                <div class="social-links">
                    <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
        <hr>
        <p class="copyright">
            &copy; 2024 Canacare. Με επιφύλαξη παντός δικαιώματος.
        </p>
    </div>
</footer>

        <script type="module" src="productDisplay.js"></script>
                    <script type="module" src="search.js"></script>
        
    </body>
  
   
</html>