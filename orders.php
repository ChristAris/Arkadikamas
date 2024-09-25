<?php
session_start();
// Έλεγχος αν ο χρήστης είναι συνδεδεμένος
if (!isset($_SESSION['user_id'])) {
    echo "Παρακαλώ συνδεθείτε πρώτα.";
    exit;
}

// Σύνδεση στη βάση δεδομένων
require_once 'vendor/autoload.php'; // Εισάγετε το απαραίτητο αρχείο autoload
$databaseConnection = new MongoDB\Client("mongodb://localhost:27017");
$myDatabase = $databaseConnection->myDB; // Αντικαταστήστε myDB με το όνομα της βάσης δεδομένων σας
$orderCollection = $myDatabase->orders; // Αντικαταστήστε orders με το όνομα της συλλογής σας


// Αναζήτηση παραγγελιών για τον συνδεδεμένο χρήστη βάσει του user_id
$userOrdersCursor = $orderCollection->find(['user_id' => $_SESSION['user_id']]);

// Μετατροπή του αποτελέσματος σε πίνακα
$userOrders = iterator_to_array($userOrdersCursor);

if (!empty($userOrders)) {
    foreach ($userOrders as $order) {
        // Ο κώδικας που αντιστοιχεί στο κάθε $order εδώ
    }
} 
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
<div class="container mt-5">
    <h1>Your Orders</h1>
    <?php
// Ταξινόμηση του πίνακα με τις παραγγελίες σε φθίνουσα σειρά βάσει της ημερομηνίας
usort($userOrders, function($a, $b) {
    return $b['order_date'] <=> $a['order_date'];
});
// Εμφάνιση των ταξινομημένων παραγγελιών
foreach ($userOrders as $order):
    ?>
    
        <div class="card5">
            <!-- Κανονικές πληροφορίες παραγγελίας -->
            <h4>Name: <?php echo $order['name']; ?></h4>
            <h4>Address: <?php echo $order['address']; ?></h4>
            <h4>City: <?php echo $order['city']; ?></h4>
            <h4>Postal Code: <?php echo $order['postal_code']; ?></h4>
            <h4>Phone: <?php echo $order['phone']; ?></h4>
            <h4>Payment_method: <?php echo $order['payment_method']; ?></h4>
            <h4>Order Date: <?php echo $order['order_date']->toDateTime()->format('Y-m-d H:i:s'); ?></h4>

            <!-- Προϊόντα παραγγελίας -->
            <h5>Προϊόντα:</h5>
            <?php foreach ($order['Products'] as $product): ?>
                <p>Τίτλος: <?php echo $product['title']; ?>, Τιμή: <?php echo $product['price']; ?>€, Ποσότητα: <?php echo $product['amount']; ?></p>
            <?php endforeach; ?>

            <!-- Έλεγχος για ακύρωση παραγγελίας -->
            <?php
// Υπολογισμός της διαφοράς σε ώρες μεταξύ της τρέχουσας ημερομηνίας και της ημερομηνίας παραγγελίας
$orderDate = $order['order_date']->toDateTime(); // Μετατροπή σε αντικείμενο DateTime
$currentDate = new DateTime();
$interval = $currentDate->diff($orderDate); // Υπολογισμός της διαφοράς
$hoursDifference = $interval->h + ($interval->days * 24); // Μετατροπή της διαφοράς σε ώρες

// Έλεγχος για ακύρωση παραγγελίας
if ($hoursDifference <= 24) {
    echo '<form action="actions/history_order.php" method="POST">';
    echo '<input type="hidden" name="order_id" value="' . $order['_id'] . '">';
    echo '<button type="submit">Ακύρωση Παραγγελίας</button>';
    echo '</form>';
}

            ?>
            <hr>
        </div>
    <?php endforeach; ?>
    <div class="container mt-8">

    <?php
// Ελέγχουμε αν ο χρήστης έχει παραγγελίες ή όχι
if (!empty($userOrders)) {
    foreach ($userOrders as $order) {
        // Κώδικας που εμφανίζει τις λεπτομέρειες της κάθε παραγγελίας
    }
} else {
    // Εάν ο χρήστης δεν έχει παραγγείλει κάτι ακόμα, εμφανίζουμε το μήνυμα "No Orders Yet!"
    echo '<p style="font-size:2.5rem;">No Orders Yet!</p>';
}
?>
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
                      </body>
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


</html>
