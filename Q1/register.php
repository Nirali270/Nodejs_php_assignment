<?php
session_start();
require './Admin/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if ($_POST['captcha'] != $_SESSION['captcha']) {
        echo "CAPTCHA did not match!";
    } else {
        $stmt = $conn->prepare("INSERT INTO user (name, email,phone, password) VALUES (?, ?,?, ?)");
        $stmt->bind_param("ssss", $username, $email,$phone, $password);
        if ($stmt->execute()) {
            header("Location: login.php");
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}

$captcha_code = rand(1000, 9999);
$_SESSION['captcha'] = $captcha_code;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .register-container {
            width: 400px;
            padding: 30px;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h3 class="text-center mb-4">User Registration</h3>
        <form action="register.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="captcha" class="form-label">Enter CAPTCHA</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="captcha" name="captcha" required>
                    <span class="input-group-text">
                        <img src="generate_captcha.php" alt="CAPTCHA">
                    </span>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
            <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>
