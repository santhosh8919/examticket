<?php
session_start();

$servername = "localhost:3306//";
$username = "santhosh";
$password = "santhosh123";
$dbname = "exam_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_password'])) {
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

        $sql = "SELECT * FROM users WHERE reset_token = '$token'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $sql = "UPDATE users SET password='$new_password', reset_token=NULL WHERE reset_token='$token'";
            if ($conn->query($sql) === TRUE) {
                $message = "Your password has been reset successfully.";
            } else {
                $message = "Error updating record: " . $conn->error;
            }
        } else {
            $message = "Invalid or expired token.";
        }
    }
} else {
    $message = "Invalid or expired token.";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
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
        input[type="password"] {
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
        <h2>Reset Password</h2>
        <form method="post" action="">
            New Password: <input type="password" name="new_password" required><br>
            <input type="submit" name="reset_password" value="Reset Password">
        </form>
        <p><?php echo $message; ?></p>
        <p><a href="login.php">Back to Login</a></p>
    </div>
</body>
</html>
