<?php
// Include database connection setup with PDO
include("database.php");
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Array of cryptocurrencies with their current prices
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

if (isset($_POST['submit'])) {
    $username = $_POST['UserName'];
    $coin = $_POST['Coin'];
    $value = (float) $_POST['Value'];  // Ensure the value is a float

    // Check if the selected coin is valid
    if (!array_key_exists($coin, $cryptos)) {
        echo "<script>alert('Invalid coin specified.'); window.location.href='buy.php';</script>";
        exit();
    }

    $price = $cryptos[$coin];
    $neededMoney = $price * $value;

    try {
        $pdo->beginTransaction();

        // Check if user has enough money
        $stmtCheckMoney = $pdo->prepare("SELECT Money FROM users WHERE username = ?");
        $stmtCheckMoney->execute([$username]);
        $userMoney = $stmtCheckMoney->fetchColumn();

        if ($userMoney < $neededMoney) {
            throw new Exception('Not enough money to complete the transaction.');
        }

        // Deduct the money from the user's account
        $stmtUpdateMoney = $pdo->prepare("UPDATE users SET Money = Money - ? WHERE username = ? AND Money >= ?");
        $stmtUpdateMoney->execute([$neededMoney, $username, $neededMoney]);

        // Safely updating the user's coin balance
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
    <title>Document</title>
    <link rel="stylesheet" href="buy.css">
</head>
<body>
    <div class="wrapp">
        <form method="POST" onsubmit="return validateForm()">
            <h1>BUY</h1>
            <div class="input">
                <input type="text" placeholder="Username" name="UserName" required>
            </div>
            <div class="input">
                <input type="text" placeholder="Coin" name="Coin" id="coinInput" required>
                <div id="coinValidationMessage"></div>
            </div>
            <div class="input">
                <input type="text" placeholder="Value" name="Value" required>
            </div>
           
           
            <button type="submit" class="btn" name="submit">BUY</button>
        </form>
    </div>

    
       
</body>
</html>
