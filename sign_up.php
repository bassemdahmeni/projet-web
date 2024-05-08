<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="sign.css" rel="stylesheet">
</head>
<body>
    <div class="wrapp">
        <div class="inner">
            <div class="image-hol">
                <img src="./imgg.jpg">
            </div>
            <form method="post">
                <h3>Registration Form</h3>
                <fieldset>
                    <legend>Your Name</legend>
                    <div class="form-g">
                        <input type="text" name="firstName" placeholder="First Name" class="form-c">
                        <input type="text" name="secondName" placeholder="Second Name" class="form-c">
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Your Gender</legend>
                    <div class="form-choix">
                        <input type ="radio" name ="sexe" id="Homme" value="Men"> Men
                        <input type ="radio" name ="sexe" id="Femme" value="Women"> Women
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Your City</legend>
                    <div class="ville">
                        <select name="ville">
                            <option value="Tunis"> Tunis</option>
                            <option value="Gabes"> Gabes</option>
                            <option value="Xfax"> Sfax</option>
                            <option value="Jandouba"> Jandouba</option>
                            <option value="Tozeur"> Tozeur</option>
                        </select>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Your Credentials</legend>
                    <div class="form-wrapp">
                        <input type="text" name="username" placeholder="Username" class="form-c">
                    </div>
                    <div class="form-wrapp">
                        <input type="text" name="email" placeholder="Email" class="form-c">
                    </div>
                    <div class="form-wrapp">
                        <input type="password" name="password" placeholder="Password" class="form-c">
                    </div>
                    <div class="form-wrapp">
                        <input type="password" name="confirm_password" placeholder="Confirm Password" class="form-c">
                    </div>
                </fieldset>
                <div style="display: flex; flex-direction:row; >
                   <button type="submit" name="register">Register</button>
                   <button type="reset" name="register">Reset</button>
                </div>
                
            </form>
        </div>
    </div>
    <script src="sign up.js"></script>
</body>
</html>
<?php
include("database.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    try {
        $host = 'localhost';  
        $db_name="clientsbuy";
        $db_user="root";
        $db_pass="";
        
        $pdo = new PDO("mysql:host=$host;dbname=$db_name", $db_user,  $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $firstName = $_POST['firstName'] ?? '';
        $secondName = $_POST['secondName'] ?? '';
        $gender = $_POST['sexe'] ?? ''; 
        $city = $_POST['ville'] ?? ''; 
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($firstName) || empty($secondName) || empty($gender) || empty($city) || empty($username) || empty($email) || empty($password)) {
            echo '<script>alert("Please fill out all fields.");</script>';
        } else {
            // Check if email or username already exists
            $checkUser = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
            $checkUser->execute([$username, $email]);
            if ($checkUser->rowCount() > 0) {
                $existingUser = $checkUser->fetch(PDO::FETCH_ASSOC);
                if ($existingUser['username'] === $username) {
                    echo '<script>alert("Username already exists. Please choose another.");</script>';
                    exit();
                }
                if ($existingUser['email'] === $email) {
                    echo '<script>alert("Email already exists. Please use another email.");</script>';
                    exit();
                }
            } else {
                if ($confirm_password !== $password) { // Corrected comparison operator
                    exit();
                } else {
                    // Proceed to insert new record
                    $stmt = $pdo->prepare("INSERT INTO users (firstName, secondName, gender, city, username, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$firstName, $secondName, $gender, $city, $username, $email, password_hash($password, PASSWORD_DEFAULT)]);
                    echo '<script>alert("Registered successfully!");</script>';
                    header("Location: login.php");
                    exit();
                }
            }
        }
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    } catch (Exception $e) {
        die("An error occurred: " . $e->getMessage());
    }
}
?>
