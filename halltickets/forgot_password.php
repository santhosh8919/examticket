<?php
session_start();

//$servername = "localhost:3306//";
//$username = "santhosh";
//$password = "santhosh123";
//$dbname = "exam_system";

$servername = "localhost:3306";
$username = "santhosh";
$password = "santhosh123";
$dbname = "exam_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset'])) {
    $email = $_POST['email'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        $sql = "UPDATE users SET reset_token='$token' WHERE email='$email'";
        $conn->query($sql);

        // Send reset link to the user's email
        $resetLink = "http://yourwebsite.com/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $body = "Click on the following link to reset your password: $resetLink";
        $headers = "From: noreply@yourwebsite.com";

        if (mail($email, $subject, $body, $headers)) {
            $message = "Password reset link has been sent to your email.";
        } else {
            $message = "Failed to send the email. Please try again.";
        }
    } else {
        $message = "No user found with that email address.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 400px;
            margin: 50px auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            margin-top: 20px;
            text-align: center;
        }
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        p {
            text-align: center;
            margin-top: 10px;
            color: #333;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form method="post" action="">
            <input type="email" name="email" placeholder="Enter your email" required><br>
            <input type="submit" name="reset" value="Reset Password">
        </form>
        <p><?php echo $message; ?></p>
        <a href="login.php">Back to Login</a>
    </div>
</body>
</html>

