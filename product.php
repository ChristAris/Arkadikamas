<?php
// Ξεκινήστε τη συνεδρία
session_start();


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Canacare</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
        <link rel="icon" href="/ergasia/favicon.ico" type="image/x-icon">

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
</head>
<div class="product-ratings-wrapper">
    <!-- Αριστερά: Εικόνα, Τίτλος, Τιμή, Κουμπιά -->
    <div id="single-product-container">
                    </div>
<!-- Δεξιά: Συστατικά και Βαθμολογίες -->
<div class="product-details-container">
        <h3>Συστατικά</h3>
        <p id="product-ingredients"></p> <!-- Εδώ θα εμφανίζονται τα συστατικά -->
        <h3>Βαθμολογίες</h3>
        <div id="ratings-container" class="ratings-container">
            <div class="ratings">
                <div class="rating">
                    <span>⭐️⭐️⭐️⭐️⭐️</span> <span>(5)</span>
                </div>
                <div class="rating">
                    <span>⭐️⭐️⭐️⭐️</span> <span>(4)</span>
                </div>
                <div class="rating">
                    <span>⭐️⭐️⭐️</span> <span>(3)</span>
                </div>
            </div>
        </div>
        <h3>Ποσότητα</h3>

        <input type="number" min="1" value="1" class="quantity-input" />
        <button class="bag-btn" data-id="product-id">Προσθήκη στο καλάθι</button>
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

    </body>
  
   
</html>