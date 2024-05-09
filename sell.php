<?php
session_start();  // Start the session to access the session variables

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Prices for different types of coins
$price = [
    "Bitcoin" => 70744.33, "Ethereum" => 3744.33, "BigG" => 10.69, 
    "BNB" => 134.69, "Solana" => 434.69, "Dogcoin" => 13.69, 
    "Cardano" => 0.55, "Ripple" => 77, "Polkadot" => 800, 
    "Chainlink" => 4, "Binance" => 550, "Litecoin" => 0.77, 
    "Stellar" => 0.2, "Cosmos" => 0.55, "Monero" => 77, 
    "Zcash" => 330, "Ave" => 0.5
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    try {
        $host = 'localhost';  
        $db_name = "clientsbuy";
        $dbUsername = 'root';
        $dbPassword = '';
        $pdo = new PDO("mysql:host=$host;dbname=$db_name", $dbUsername, $dbPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $password = $_POST['code'] ?? ''; // User-submitted password
        $Value = floatval($_POST['Quantity'] ?? '0'); 
        $Coin = $_POST['Coin'] ?? ''; 
        $username = $_SESSION['username']; // Ensure this is handled safely, should not be hardcoded in production

        if (empty($username) || empty($Coin) || $Value <= 0 || empty($password)) {
            echo '<script>alert("Please fill out all fields and ensure Value is positive.");</script>';
        } elseif (!array_key_exists($Coin, $price)) {
            echo '<script>alert("Coin type not recognized.");</script>';
        } else {
            $stmt = $pdo->prepare("SELECT PASSWORD, $Coin FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if the user exists and the password is correct
            if (password_verify($password, $user['PASSWORD'])) {
                if ($user[$Coin] >= $Value) {
                    $Values = $Value * $price[$Coin];

                    $request = "UPDATE users SET Money = Money + ? WHERE username = ?";
                    $stmt = $pdo->prepare($request);
                    $stmt->execute([$Values, $username]);

                    $request = "UPDATE users SET $Coin = $Coin - ? WHERE username = ?";
                    $stmt = $pdo->prepare($request);
                    $stmt->execute([$Value, $username]);

                    echo '<script>alert("Transaction successful.");</script>';
                    header("Location: web.php");
                } else {
                    echo '<script>alert("Not enough coins.");</script>';
                }
            } else {
                echo '<script>alert("Invalid password.");</script>';
            }
        }
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
    <title>Document</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="wrapp">
        <form method="POST" onsubmit="return validateForm()">
            <h1>SELL</h1>
            <div class="input">
                <input type="text" placeholder="Coin" name="Coin" id="coinInput" required>
                <div id="coinValidationMessage"></div>
            </div>
            <div class="input">
                <input type="text" placeholder="Value" name="Quantity" required>
            </div>
            <div class="input">
                <input type="password" placeholder="Your account password" name="code" required>
            </div>
            <button type="submit" class="btn" name="submit">SELL</button>
        </form>
    </div>
    <script>
function validateForm() {
    let coin = document.getElementById('coinInput').value.trim();
    let quantity = document.querySelector('input[name="Quantity"]').value.trim();
    let password = document.querySelector('input[name="code"]').value.trim();

    let valid = true;
    let validationMessage = "";

    let test=["Bitcoin", "Ethereum", "BigG", "BNB", "Solana", "Dogcoin", "Cardano", "Ripple", "Polkadot", "Chainlink", "Binance", "Litecoin", "Stellar", "Cosmos", "Monero", "Zcash", "Ave"]


    // Validate Coin
    if (coin === "") {
        validationMessage = "Please enter a coin.";
        valid = false;
    } else if (!test.includes(coin)) {
        // Example: Only allow specific coin names (you can modify this list)
        validationMessage = "Coin not recognized. Please enter a valid coin.";
        valid = false;
    }

    // Validate Quantity
    if (quantity === "") {
        validationMessage += "\nPlease enter a quantity.";
        valid = false;
    } else if (isNaN(quantity) || parseFloat(quantity) <= 0) {
        validationMessage += "\nQuantity must be a positive number.";
        valid = false;
    }

    // Validate Password
    if (password === "") {
        validationMessage += "\nPlease enter your account password.";
        valid = false;
    }

    if (!valid) {
        alert(validationMessage);
    }

    return valid;
}
</script>

    
       
