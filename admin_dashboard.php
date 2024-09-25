<?php
session_start(); // Ξεκινήστε τη συνεδρία


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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="page.php">
                <img src="Phto1.png" id="logo" alt="Logo">
            </a>
        </div>
        <a class="navbar-brand" href="page.php">Canacare</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="products.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="aboutus.php">About us</a>
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
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="profile.php">Edit Profile</a></li>
                            <li><a class="dropdown-item" href="orders.php">History Orders</a></li>

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


    

        <div class="container text-center ">
          <h1 class="text-success">CANACARE</h1>
          <h5> WHY YOU SHOULD JOIN US</h5>
          <div class="row">
              <div class="col">
                  <div class="card bg-light
                              border border-success border-1"
                       style="width: 300px; height: 200px;">
                       <h4>Free shippings</h4>
                       <h6>from 25$ and more</h6>
                       <div class="text-center">
                       <img src="apostoli.png" width="50"></div>
                  </div>
              </div>
              <div class="col">
                  <div class="card bg-light
                              border border-success border-2"
                       style="width: 300px; height: 200px;">
                       <h4>100% ORGANIC!</h4>
                       <div class="text-center">
                       <img src="organiko.png" width="50"></div>

                  </div>
              </div>
              <div class="col">
                  <div class="card bg-light
                              border border-success border-3"
                       style="width: 300px; height: 200px;">
                       <h4>GRADUATED BY GMP</h4>
                       <div class="text-center">
                        <img src="gmp.png" width="50"></div>
                  </div>
              </div>
          </div>
      </div>
      <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="cbdoil24.jpg" class="d-block w-50" alt="...">
          </div>
          <div class="carousel-item">
            <img src="kalamata.jpg" class="d-block w-50" alt="...">
          </div>
          <div class="carousel-item">
            <img src="gellato.jpg" class="d-block w-50" alt="...">
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
        <div id="suggest" class="bg-1">
            <div class="container">
                <h3 class="text-center">Canacare suggests</h3>
                <div class="row">
                    <div class="col">
                        <p class="text-center"><strong>CBD OIL</strong><span class="label label-success">NEW</span></p>
                        <a href="CbdOilss.html" data-toggle="collapse"><img src="Cbdoil.jpg" class="food img-circle"></a>
                        <div id="demo1" class="collapse-show">
                            <p>AMVROSIA - FULL SPECTRUM CBD OIL 5% LIGHT</p>
                            
                        </div>
                    </div>
                    <div class="col">
                        <p class="text-center"><strong>CBD FLOWER</strong></p>
                        <a href="CbdFlowerr.html" data-toggle="collapse"><img src="gellato.jpg" class="food img-circle"></a>
                        <div id="demo2" class="collapse-show">
                            <p>HEMP FLOWERS POWER GELATO 27% CBD 2GR – SEEDBIS</p>
                        </div>
                    </div>
                    <div class="col">
                        <p class="text-center"><strong>CBD COSMETIC</strong></p>
                        <a href="CbdCosmeticcs.html" data-toggle="collapse"><img src="Sampouan.jpg" class="food img-circle"></a>
                        <div id="demo3" class="collapse-show">
                            <p>ENECTA BODY LOTION 200mg CBD 200ml</p>
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
   
        
         
                      <footer class="dark-footer text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h3>Σχετικά με εμάς</h3>
                <p>Η Canacare είναι μια εξειδικευμένη ηλεκτρονική πλατφόρμα που προσφέρει μια εκλεπτυσμένη συλλογή προϊόντων CBD για τη φροντίδα της υγείας και του ευεξίας σας.</p>
            </div>
            <div class="col-md-4">
                <h3>Επικοινωνία</h3>
                <p>Διεύθυνση: Διστόμου 48, Πόλη:Πειραιάς, Τ.Κ. 18532</p>
                <p>Email: xristos.aridas@yahoo.gr</p>
                <p>Τηλέφωνο: 699999999</p>
            </div>
            <div class="col-md-4">
                <h3>Ακολουθήστε μας</h3>
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