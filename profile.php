<?php
session_start();

require_once 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

$databaseConnection = new MongoDB\Client;
$myDatabase = $databaseConnection->myDB;
$userCollection = $myDatabase->users;
$user_id = $_SESSION['user_id'];



// Κώδικας για να ανακτήσετε τα δεδομένα του χρήστη από τη βάση δεδομένων
$userData = $userCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($user_id)]);

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
<form action="actions/editprof.php" method="POST">
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                </div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    
                    <div class="col-md-12">
                    <input type="hidden" class="form-control" name="user_id" value="<?php echo $user_id; ?>">
                    <label class="labels">Name
                            <input type="text" class="form-control" name="name" value="<?php echo isset($userData->name) ? htmlspecialchars($userData->name) : ''; ?>">
                            <label class="labels">Email
                            <input type="email" class="form-control" name="email" value="<?php echo isset($userData->email) ? htmlspecialchars($userData->email) : ''; ?>">
                        </label>
                        <label class="labels">Password
                            <input type="password" class="form-control" name="password"value="<?php echo isset($userData->password ) ? htmlspecialchars($userData->password ) : ''; ?>">
                        </label>
                        <label class="labels">Repeat Password
                        <input type="password" class="form-control" name="password_repeat" value="<?php echo isset($userData->password_repeat) ? htmlspecialchars($userData->password_repeat) : ''; ?>">
                        </label>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="submit" name="edit" id="edit" class="btn btn-primary">Edit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<!--cart-->
<div class="cart-overlay">
    <div class="cart">
        <span class="close-cart">
            <i class="fas fa-window-close"></i>
        </span>
        <h2>Your Cart</h2>
        <div class="cart-content">
        </div>
        <div class="cart-footer">
            <h3>Your total: $ <span class="cart-total">0</span></h3>
            <button class="clear-cart banner-btn">Clear Cart</button>
        </div>
    </div>
</div>
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
