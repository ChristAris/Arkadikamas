<?php
session_start();

// Σύνδεση στη βάση δεδομένων
require_once 'vendor/autoload.php';
$databaseConnection = new MongoDB\Client;
$myDatabase = $databaseConnection->selectDatabase('myDB');
$proiontaCollection = $myDatabase->products;

// Κάνετε ερώτηση (query) για να ανακτήσετε όλα τα προϊόντα
$proiontaCursor = $proiontaCollection->find([]);

// Μετατρέπετε τα αποτελέσματα σε έναν πίνακα
$products = iterator_to_array($proiontaCursor);

// Μετατροπή του $products σε πίνακα με τη χρήση json_decode και json_encode
$productsArray = json_decode(json_encode($products), true);
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
<div class="container">
    <?php
    foreach ($productsArray as $productDocument) {
        // Ανάλογα με τη δομή, προσαρμόζουμε τα πεδία
        $title = $productDocument['items'][0]['fields']['title'] ?? 'No Title'; // Έλεγχος για το πεδίο
        $price = $productDocument['items'][0]['fields']['price'] ?? 'No Price';
        $syst = $productDocument['items'][0]['fields']['syst'] ?? 'No Price';

        $image = $productDocument['items'][0]['fields']['image']['fields']['file']['url'] ?? 'No Image';
        ?>
        
        <form action="actions/update_prod.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $productDocument['_id']['$oid']; ?>">
            <label for="title">Title:</label>
            <input type="text" name="title" value="<?php echo $title; ?>">
            <label for="price">Price:</label>
            <input type="text" name="price" value="<?php echo $price; ?>">
            <label for="price">Systatika:</label>
            <input type="text" name="syst" value="<?php echo $syst; ?>">
            <label for="image">Image:</label>
            <input type="text" name="image" value="<?php echo $image; ?>">
            <input type="submit" name="edit" value="Edit">
            <input type="submit" name="delete" value="Delete">
            <a class="btn btn-primary" href="add.product.php">Add New Product</a>
        </form>

        <?php
    }
    ?>
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
                      <!-- Favorite Cart -->

        
                     
        <footer class="dark-footer text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h3>About us</h3>
                <p>Canacare is a specialized online platform that offers a sophisticated collection of CBD products to care for your health and wellness.</p>
            </div>
            <div class="col-md-4">
                <h3>Contact</h3>
                <p>Address: 48 Distomou, City: Piraeus, P.O. 18532
                </p>
                <p>Email: xristos.aridas@yahoo.gr</p>
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
          