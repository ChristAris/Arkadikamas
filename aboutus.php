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

<div id="maindiv" class="container text-center">
    
  
<div class="well well-sm">
        
       
<h3><strong>Παραδοσιακά, οικογενειακά</strong><small> και Αρκαδικά!</small></h3>
        
        

   
<div class="home-service-section blk_44343" id="line_44343">
            
           

 
<div class="container">
                
         
<div class="flex-container">
                    
                    

          
<!-- Κείμενο και Χάρτης -->
                    
                  

     
<div class="text-container">
                        
             

   
<div class="content-container">
                            
                    
<p>Το<strong> 1971</strong> ο Θάνος και η Γλυκερία Καντέλη άνοιξαν το πρώτο παραδοσιακό εργαστήριο παρασκευής ζυμαρικών στην Μεγαλόπολη Αρκαδίας.
 Εξυπηρετούσαν εκτός από τη πόλη της Μεγαλόπολης και τα χωριά της γύρω περιοχής.
 Με τα δικά σας αγνά και φρέσκα υλικά παρήγαγαν ζυμαρικά για 35 συνεχή έτη!
<p>
Το <strong> 2017</strong>, εμείς η επόμενη γενιά, ξανανοίγουμε το "ΧΥΛΟΠΙΤΑΔΙΚΟ ΚΑΝΤΕΛΗ".
Με αγνά και φρέσκα υλικά,  χωρίς συντηρητικά και με τη συνταγή της γιαγίας και του παππού ξαναφτιάχνουμε ζυμαρικά.

Ζυμαρικά με παραδιακές γεύσεις που θα θυμηθούν οι παλιοί και θα γνωρίσουν οι νέοι, ζυμαρικά με νέες γεύσεις που θα ενθουσιάσουν μικρούς και μεγάλους.</p>
                        

                    
                    

            

       
                    </div>
 
</div>

                    

                  
<!-- Φωτογραφία -->
                    
                    

      
<div class="image-container">
                        
   
<img src="arkadikamas.jpg" alt="Φωτογραφία" />
                    
              

   
</div>

                
                

       
</div>
            
         
</div>
        </div>
    </div>

</div>
<section id="business-services">
    <h2>Εξυπηρετούμε και Επιχειρήσεις!</h2>
    <p>Είμαστε εδώ για να καλύψουμε τις ανάγκες της επιχείρησής σας! Αν είστε επαγγελματίας ή ιδιοκτήτης επιχείρησης, προσφέρουμε εξειδικευμένες λύσεις για να σας βοηθήσουμε να αναπτύξετε και να βελτιώσετε τις υπηρεσίες σας. Από πληρωμές έως προσαρμοσμένες υπηρεσίες, έχουμε τις λύσεις που χρειάζεστε.</p>
    
    <ul>
        <li>Διαχείριση Πληρωμών για Επιχειρήσεις</li>
        <li>Συμβουλευτική Επιχειρήσεων</li>
        <li>Προσαρμοσμένες Λύσεις</li>
        <li>Υποστήριξη 24/7</li>
    </ul>
    
    <p>Επικοινωνήστε μαζί μας σήμερα για να μάθετε πώς μπορούμε να σας βοηθήσουμε να αναπτύξετε την επιχείρησή σας!</p>
    
    <!-- Φόρμα επικοινωνίας -->
    <form action="actions/b2b.php" method="post">
        <label for="name">Όνομα Εταιρείας:</label>
        <input type="text" id="name" name="company_name" required>

        <label for="email">Email Επικοινωνίας:</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Μήνυμα:</label>
        <textarea id="message" name="message" rows="4" required></textarea>

        <button type="submit">Υποβολή Αίτησης</button>
    </form>
</section>
         
<div class="map-container">
    <h3>Η τοποθεσία μας</h3> <!-- Προσθήκη τίτλου -->
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1332.6283391951188!2d22.135453605842336!3d37.400657325162776!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x136045f320a6d3c9%3A0xccc5cab2d538fba8!2zzpHOoc6azpHOlM6ZzprOkc6czpHOoyDOoM6RzqHOkc6Uzp_Oo86ZzpHOms6RIM6WzqXOnM6RzqHOmc6azpE!5e0!3m2!1sel!2sgr!4v1727102162181!5m2!1sel!2sgr"
    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>





    
                    
       


                        
<div id="suggest" class="bg-1">
            <div class="container">
            <h3 class="text-center">Προτεινόμενα προϊόντα</h3>

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
                    <a href="https://www.instagram.com/arkadika_mas_zymarika?igsh=MTB3NTd5MGZjczRjcg==" target="_blank"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <hr>
        <p class="copyright">
            &copy; 2024 ArkadikaMas. Με επιφύλαξη παντός δικαιώματος.
        </p>
    </div>
</footer>

        <script type="module" src="productDisplay.js"></script>
                    <script type="module" src="search.js"></script>

    
    </body>
</html>