<?php
session_start();

// Σύνδεση στη βάση δεδομένων
require_once 'vendor/autoload.php';
$databaseConnection = new MongoDB\Client("mongodb://localhost:27017");
$myDatabase = $databaseConnection->myDB;
$orderCollection = $myDatabase->orders;

// Κάνετε ερώτηση (query) για να ανακτήσετε όλες τις παραγγελίες
$ordersCursor = $orderCollection->find([]);
$orders = iterator_to_array($ordersCursor);
$totalOrders = count($orders);
?>



<!DOCTYPE html>
<html>
<head>
    <title>Canacare - Edit Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="icon" href="/ergasia/favicon.ico" type="image/x-icon">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
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
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
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
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Profile
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php if (isset($_SESSION['email'])): ?>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="profile.php">Edit Profile</a></li>
                                <li><a class="dropdown-item" href="orders.php">History Orders</a></li>

                            <?php else: ?>
                                <li><a class="dropdown-item" href="index.php">Login User</a></li>
                                <li><a class="dropdown-item" href="signup.php">Sign up User</a></li>
                            <?php endif; ?>
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

    <div class="container mt-5">
    <h1>Edit Orders</h1>

    <h3>(Total Orders: <?php echo $totalOrders; ?>)</h3>

        
        <?php foreach ($orders as $order): ?>
            <form action="actions/update_orders.php" method="POST">
                <input type="hidden" name="order_id" value="<?php echo $order['_id']; ?>">
                <div class="mb-3">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" value="<?php echo isset($order['name']) ? $order['name'] : ''; ?>">
                </div>
                <div class="mb-3">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" name="address" value="<?php echo isset($order['address']) ? $order['address'] : ''; ?>">
                </div>
                <div class="mb-3">
                    <label for="city">City:</label>
                    <input type="text" class="form-control" name="city" value="<?php echo isset($order['city']) ? $order['city'] : ''; ?>">
                </div>
                <div class="mb-3">
                    <label for="postal_code">Postal Code:</label>
                    <input type="text" class="form-control" name="postal_code" value="<?php echo isset($order['postal_code']) ? $order['postal_code'] : ''; ?>">
                </div>
                <div class="mb-3">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo isset($order['phone']) ? $order['phone'] : ''; ?>">
                </div>

                <ul class="products-list">
                    <?php foreach ($order['Products'] as $product): ?>
                        <li class="product-item">
                            <div class="product-info">
                                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>">
                                <h3><?php echo $product['title']; ?></h3>
                                <p>Price: <?php echo $product['price']; ?></p>
                                <label for="amount">Amount:</label>
                                <input type="text" name="product_<?php echo $product['id']; ?>_amount" value="<?php echo $product['amount']; ?>">
                                <input type="hidden" name="product_<?php echo $product['id']; ?>_title" value="<?php echo $product['title']; ?>">
                                <input type="hidden" name="product_<?php echo $product['id']; ?>_price" value="<?php echo $product['price']; ?>">
                                <input type="hidden" name="product_<?php echo $product['id']; ?>_image" value="<?php echo $product['image']; ?>">
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <input type="submit" class="btn btn-primary" name="update" value="Update Order">
                <input type="submit" class="btn btn-primary" name="delete" value="Delete Order">
            </form>
            <hr>
        <?php endforeach; ?>
    </div>

    <footer class="dark-footer text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h3>About us</h3>
                    <p>Canacare is a specialized online platform that offers a sophisticated collection of CBD products to care for your health and wellness.</p>
                </div>
                <div class="col-md-4">
                    <h3>Contact</h3>
                    <p>Address: 48 Distomou, City: Piraeus, P.O. 18532</p>
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
</body>
</html>
