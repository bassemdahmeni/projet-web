<?php
session_start();  // Start the session to access the session variables

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
} else {
    try {
        $host = 'localhost';
        $db_name = "clientsbuy";
        $username = 'root';
        $password = '';
        $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $username = $_SESSION['username'];  // Assuming this username is safely retrieved or sanitized appropriately
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    } catch (Exception $e) {
        die("An error occurred: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Wallet</title>

</head>

<body>
    <navbar class="nav">
        <div class="nav1">
        <div class="LOGO">
                LOGO

            </div>

            <div class="container1">
                <div class="elements">
                    <img src="home.png">
                    <a href="page.html">Home</a>
                </div>
                <div class="elements">
                    <img src="broadcast.png">
                    <a href="http://localhost/projetweb/web.php">Wallet</a>

                </div>
                <div class="elements">
                    <img src="contact.png">
                    <a href="aboutus.html">About Us</a>

                </div>
                <div class="elements">
                    <img src="about.png">
                    <a href="firstpage.html">Log Out</a>
                </div>

            </div>






        </div>
    </navbar>
    <fieldset>
        <legend>General</legend>
        <div class="divm">
            <h2>Your Total Money</h2>
            <p id="TotalMoney">$0</p>
        </div>
        <div class="divd">
            <div class="divm">
                <h2>Your Real Money</h2>
                <p id="RealMoney">$0</p>
            </div>
            <div class="divm">
                <h2>Your Crypto Money</h2>
                <p id="cryptoTotal">$0</p>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <img src="search.png" class="searchpic3">
        <input class="input333" placeholder="Search Cryptocurrency">
        <a href="http://localhost/projetweb/sell.php"><button class="bouton3">SELL</button></a>
        <legend>Details</legend>
        <table id="cryptoTable">
           
            <thead>
                <tr>
                    <th>#</th>
                    <th>Coins</th>
                    <th>Rate</th>
                    <th>Price</th>
                    <th>Number of Coins</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <!-- Table rows will be inserted here by JavaScript -->
            </tbody>
        </table>
    </fieldset>

    <footer>
        <div class="footer">
            <div class="row">
                <a href="#"><i class="fa fa-facebook"><img src="facebook.png"></i></a>
                <a href="#"><i class="fa fa-instagram"><img src="instagram.png"></i></a>
                <a href="#"><i class="fa fa-youtube"><img src="play.png"></i></a>
                <a href="#"><i class="fa fa-twitter"><img src="twitter.png"></i></a>
            </div>

            <div class="row">
                <ul>
                    <li><a href="#">Contact us</a></li>
                    <li><a href="#">Our Services</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Career</a></li>
                </ul>
            </div>

            <div class="row">
                NEVER TOO LATE TO BECOME THE REAL G
            </div>
        </div>
    </footer>

    <p id="myParagraph" style="display: none;"><?php
                                                $Data = "";
                                                foreach ($user as $key => $value) {

                                                    $Data = $Data . "," . $key . "#" . $value;
                                                }
                                                echo "{$Data}"   ?></p>


    <script src="scripts.js"></script>
</body>

</html>