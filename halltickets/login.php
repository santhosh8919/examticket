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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $username;
                header("Location: student_registration.php");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with that username.";
        }
    } elseif (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            background-image:url("uploads/iiit.jpeg");
            background-size:cover;
            background-repeat:no-repeat;
            height: 620px;
           
        }
        .container {
            width:280px;
            height:320px;
            margin:30px auto;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="text"], input[type="password"] {
            width: calc(100% - 20px);
            height:10px;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid red;
            border-radius: 3px;
            font-size: 14px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background-color:lightblue;
            color: black;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
            border:1px solid blue;
        }
        input[type="submit"]:hover {
            background-color:blue;
            border:2px solid red;
        }
        p {
            text-align: center;
            margin-top: 5px;
            padding-top:-10px;
        }
        a {
            color:blue;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student Login</h2>
        <?php if (!isset($_SESSION['username'])): ?>
            <form method="post" action="">
                Student_Id: <input type="text" name="username" placeholder="Enter your ID" required><br>
                Password: <input type="password" name="password" placeholder="Enter your Password" required><br>
                <input type="submit" name="login" value="Login">
            </form>
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            <p>Forgot your password? <a href="forgot_password.php">Click here</a></p>
        <?php else: ?>
            <p>You are logged in as <?php echo $_SESSION['username']; ?></p>
            <form method="post" action="">
                <input type="submit" name="logout" value="Logout">
            </form>
            <p><a href="student_registration.php">Go to Student Registration</a></p>
        <?php endif; ?>
    </div>
</body>
</html>

