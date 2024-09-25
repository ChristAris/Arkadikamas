<?php
session_start();
if(!isset($_SESSION['email'])){
   header('Location: index.php');
   exit();
}

else{


    //this pulls the MongoDb driver from vendor folder
    require_once 'vendor/autoload.php';
    //connect to MongoDB database
    $databaseConnection = new MongoDB\Client;
    //connecting to specific database in MongoDB
    $myDatabase = $databaseConnection->myDB;
    //connecting to our mongoDB Collections
    $userCollection = $myDatabase->users;
    $userEmail = $_SESSION['email'];
    $data = array(
        "Email"=> $userEmail,
    );
    
    //insert into MongoDB Users Collection
    $fetch = $userCollection->findOne($data);
    
    
    
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Canacare</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link rel="icon" href="/ergasia/favicon.ico" type="image/x-icon">

        <script src="hhtps://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
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

       <form action="actions/editprof.php" method="POST">         
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold"></span><span class="text-black-50"></span><span> </span></div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6"><label class="labels">Name</label><input type="text" class="form-control" name="fname" value="<?php echo $fetch['Firstname'];?>"></div>
                            <div class="col-md-6"><label class="labels">Surname</label><input type="text" class="form-control" name="lname" value="<?php echo $fetch['LastName'];?>"></div>
                        </div>
                        <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Mobile Number</label><input type="text" class="form-control" name="phnumb" value="<?php echo $fetch['Phone Number'];?>"></div>
                            <div class="col-md-12"><label class="labels">Address Line</label><input type="text" class="form-control"  name="adress" value="<?php echo $fetch['Adress'];?>"></div>
                            <div class="col-md-12"><label class="labels">Postcode</label><input type="text" class="form-control" name="postcode" value="<?php echo $fetch['PostCode'];?>"></div>
                            <div class="col-md-12"><label class="labels">Postcode</label><input type="text" class="form-control" name="psw" value="<?php echo $fetch['Password'];?>"></div>
                            <div class="col-md-12"><label class="labels">Postcode</label><input type="text" class="form-control" name="pswrepeat" value="<?php echo $fetch['Password Repeat'];?>"></div>
                            <div class="col-md-12"><label class="labels">State</label><input type="text" class="form-control" name="state" value="<?php echo $fetch['State'];?>"></div>
                            <div class="col-md-12"><label class="labels">Area</label><input type="text" class="form-control" name="area" value="<?php echo $fetch['Area']; ?>"></div>
                            <div class="col-md-12"><label class="labels">Email ID</label><input type="text" class="form-control" name="email" value="<?php echo $fetch['Email'];?>"></div>
                            <div class="col-md-6"><label class="labels">Country</label><input type="text" class="form-control" name="country" value="<?php echo $fetch['Country'];?>"></div>
                            <div class="col-md-6"><label class="labels"></label><input type="hidden" class="form-control" name="hidden_id" id="hidden_id" value="<?php echo $fetch['_id'];?>"></div>

                        </div>
                       
                        <input type="submit" name="update" id="update" value="Update info"/><br/><br/>                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </form>
    <a href="profile.php">Profile page</a>
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


        <div id="maindiv" class="container text-center">
            <div class="well well-sm">
                <h3>Canacare<small>Probably the best CBD in the world</small></h3>
            </div>
            <p>Η Canacare λειτουργεί στο κτίριο της οδού Διστόμου 48.Στην Canacare παράγουμε οι ίδιοι το προϊόν φροντίζοντας έτσι για την καλύτερη δυνατή ποιότητα</p>
        </div>
        <div id="suggest" class="bg-1">
            <div class="container">
                <h3 class="text-center">Η Canacare προτείνει</h3>
                <div class="row">
                    <div class="col-sm-4">
                        <p class="text-center"><strong>CBD OIL</strong><span class="label label-success">ΝΕΟ</span></p>
                        <a href="#demo1" data-toggle="collapse"><img src="Cbdoil.jpg" class="food img-circle"></a>
                        <div id="demo1" class="collapse">
                            <p>AMVROSIA - FULL SPECTRUM CBD OIL 5% LIGHT</p>
                            <button class="btn btn-success" data-toggle="modal" data-target="#myModal">Αγορά</button>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <p class="text-center"><strong>CBD FLOWER</strong></p>
                        <a href="#demo2" data-toggle="collapse"><img src="gellato.jpg" class="food img-circle"></a>
                        <div id="demo2" class="collapse">
                            <p>HEMP FLOWERS POWER GELATO 27% CBD 2GR – SEEDBIS</p>
                            <button class="btn btn-success" data-toggle="modal" data-target="#myModal">Αγορά</button>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <p class="text-center"><strong>CBD COSMETIC</strong></p>
                        <a href="#demo3" data-toggle="collapse"><img src="gellato.jpg" class="food img-circle"></a>
                        <div id="demo3" class="collapse">
                            <p>ENECTA BODY LOTION 200mg CBD 200ml</p>
                            <button class="btn btn-success" data-toggle="modal" data-target="#myModal">Αγορά</button>
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
<?php }