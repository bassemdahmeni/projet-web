<?php
session_start();

include("database.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$cryptos = [
    'Bitcoin' => 70744.33,
    'Ethereum' => 3744.33,
    'Big G' => 0.69,
    'BNB' => 0.69,
    'Solana' => 0.69,
    'Dogcoin' => 0.69,
    'Cardano' => 0.55,
    'Ripple' => 77,
    'Polkadot' => 800,
    'Chainlink' => 4,
    'Binance' => 550,
    'Litecoin' => 0.77,
    'Stellar' => 0.2,
    'Cosmos' => 0.55,
    'Monero' => 77,
    'Zcash' => 330,
    'Ave' => 0.5,
    // more cryptocurrencies can be added here
];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $username = $_SESSION['username'];
    $password = $_POST['code'] ?? '';
    $coin = $_POST['Coin'] ?? '';
    $value = (float) ($_POST['Value'] ?? '0');

    if (!array_key_exists($coin, $cryptos)) {
        echo "<script>alert('Invalid coin specified.'); window.location.href='buy.php';</script>";
        exit;
    }

    $neededMoney = $cryptos[$coin] * $value;

    try {
        
        $stmt = $pdo->prepare("SELECT PASSWORD, Money FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['PASSWORD'])) {
            throw new Exception("Invalid password.");
        }

        if ($user['Money'] < $neededMoney) {
            throw new Exception("Not enough money to complete the transaction.");
        }

        $pdo->beginTransaction();
        $stmtUpdateMoney = $pdo->prepare("UPDATE users SET Money = Money - ? WHERE username = ?");
        $stmtUpdateMoney->execute([$neededMoney, $username]);

        $stmtUpdateCoins = $pdo->prepare("UPDATE users SET `$coin` = `$coin` + ? WHERE username = ?");
        $stmtUpdateCoins->execute([$value, $username]);

        $pdo->commit();
        echo "<script>alert('Transaction completed successfully.'); window.location.href='buy.php';</script>";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<script>alert('Transaction failed: " . addslashes($e->getMessage()) . "'); window.location.href='buy.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Cryptocurrency</title>
    <link rel="stylesheet" href="buy.css">
</head>
<body>
    <div class="wrapp">
        <form method="POST" onsubmit="return validateForm()">
            <h1>BUY</h1>
            
           <div class="input">
               <input type="text" placeholder="Coin" name="Coin" id="coinInput" required>
           </div>
           <div class="input">
               <input type="text" placeholder="Value" name="Quantity" id="valueInput" required>
           </div>
           <div class="input">
            <input type="password" placeholder="Your account password" name="code" id="passwordInput" required>
           </div>
            <button type="submit" class="btn" name="submit">BUY</button>
        </form>
    </div>
    <script>
      function validateForm() {
         let coin = document.getElementById('coinInput').value.trim();
         let quantity = document.getElementById('valueInput').value.trim();
         let password = document.getElementById('passwordInput').value.trim();
     
         let valid = true;
         let validationMessage = "";
     
         let test = ["Bitcoin", "Ethereum", "BigG", "BNB", "Solana", "Dogcoin", "Cardano", "Ripple", "Polkadot", "Chainlink", "Binance", "Litecoin", "Stellar", "Cosmos", "Monero", "Zcash", "Ave"];
     
         // Validate Coin
         if (coin === "") {
             validationMessage = "Please enter a coin.";
             valid = false;
         } else if (!test.includes(coin)) {
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

</body>
</html>
