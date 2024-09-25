<?php
require 'vendor/autoload.php'; // Υποθέτοντας ότι χρησιμοποιείτε Composer για MongoDB

// Ξεκινήστε τη συνεδρία
session_start();

// Συνδέσου στη βάση δεδομένων MongoDB
$databaseConnection = new MongoDB\Client('mongodb://localhost:27017');
$myDatabase = $databaseConnection->myDB;
$ordersCollection = $myDatabase->selectCollection('orders');

// Έλεγχος αν η session user_id υπάρχει και είναι ορισμένη
if (isset($_SESSION['user_id'])) {
    // Αν υπάρχει, αποθήκευσε την τιμή της σε μια μεταβλητή
    $user_id = $_SESSION['user_id'];
} else {
    // Αν δεν υπάρχει, επιστρέψτε μήνυμα σφάλματος και τερματίστε την εκτέλεση
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Βρες την τελευταία παραγγελία του χρήστη
$lastOrder = $ordersCollection->findOne(
    ['user_id' => $user_id],
    ['sort' => ['order_date' => -1]]
);

// Έλεγχος αν βρέθηκε παραγγελία και αν υπάρχει τουλάχιστον ένα προϊόν
if ($lastOrder && isset($lastOrder['Products']) && count($lastOrder['Products']) > 0) {
    // Ανάκτησε τον πίνακα Products από την τελευταία παραγγελία
    $products = $lastOrder['Products'];
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Canacare</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="icon" href="/ergasia/favicon.ico" type="image/x-icon">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>

    <link rel="stylesheet" type="text/css" href="styleboot.css">
</head>
<body id="myPage">
    <header>
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

            </header>
            <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="message-box _success">
                     <i class="fa fa-check-circle" aria-hidden="true"></i>
                    <h2> Your payment was successful </h2>
                   <p> Thank you for your payment. we will <br>
be in contact with more details shortly </p>      
            </div>
        </div> 
    </div> 
    <hr></div>
    <div class="text-center">
    <h1>Rate the Products from Your Last Order</h1>
    </div>
        <form method="post" action="actions/submit_rating.php">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <h2><?php echo htmlspecialchars($product['title']); ?></h2>
                    <input type="hidden" name="products[<?php echo htmlspecialchars($product['id']); ?>][product_id]" value="<?php echo htmlspecialchars($product['id']); ?>">
                    <input type="hidden" name="products[<?php echo htmlspecialchars($product['id']); ?>][title]" value="<?php echo htmlspecialchars($product['title']); ?>">
                    <label for="rating_<?php echo htmlspecialchars($product['id']); ?>">Rate this product:</label>
                    <select name="products[<?php echo htmlspecialchars($product['id']); ?>][rating]" id="rating_<?php echo htmlspecialchars($product['id']); ?>">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <label for="comment_<?php echo htmlspecialchars($product['id']); ?>">Comment:</label>
                    <textarea name="products[<?php echo htmlspecialchars($product['id']); ?>][comment]" id="comment_<?php echo htmlspecialchars($product['id']); ?>"></textarea>
                </div>
            <?php endforeach; ?>
            <input type="submit" value="Submit">
        </form>
    </body>
    </html>
    <?php
} else {
    echo "<p>No orders found or no products in last order.</p>";
}
?>
         <!--cart-->
         <div class="cart-overlay transparentBcg">
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
                            <h3>SUM: $ <span class="cart-total" id="cartTotal">0</span></h3>
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
                    <script type="module" src="search.js"></script>
                        </body>
                </html>