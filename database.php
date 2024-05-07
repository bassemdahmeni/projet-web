<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "clientsbuy";

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$db_server;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "you're big"; // Connection successful message
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage(); // Connection failed message
}
?>

