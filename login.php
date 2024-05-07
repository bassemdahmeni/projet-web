<?php
session_start();  // Start the session at the very top

$host = 'localhost';
$db_name="clientsbuy";
$dbUser = 'root';
$dbPass = '';

// Establish database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Prepared statement to prevent SQL Injection
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($password, $user['PASSWORD'])) {
        // Store user data in session variables
        $_SESSION['username'] = $user['username'];
        // Redirect to web.php
        header("Location: web.php");
        exit();
    } else {
        echo '<script>alert("Invalid username or password.");</script>';
    }
}
?>
<!-- HTML code for login form -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="login.css" rel="stylesheet">
</head>
<body>
    <div class="wrapp">
        <form method="post">
            <h1>Login</h1>
            <div class="input">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="you">
                <input type="checkbox" name="remember" value="1"> Remember me for a month
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="register">
                <p>Don't have an account? <a href="http://localhost/projetweb/sign_up.php">Sign up</a></p>
            </div>
        </form>
    </div>
</body>
</html>
