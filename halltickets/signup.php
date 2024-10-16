<?php
$servername = "localhost:3306//";
$username = "santhosh";
$password = "santhosh123";
$dbname = "exam_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $student_name = $_POST['student_name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password, student_name) VALUES ('$username', '$password', '$student_name')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup Here</title>
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
            width: 280px;
            height:300px;
            margin: 30px auto;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
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
            height:7px;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid red;
            border-radius: 3px;
            font-size: 14px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 6px;
            margin-top: 10px;
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Signup Here</h2>
        <form method="post" action="">
            <label for="username">Student_Id:</label>
            <input type="text" id="username" name="username" placeholder="Enter your ID" required><br>
            <label for="student_name">Email:</label>
            <input type="text" id="student_name" name="student_name" placeholder="Enter your Email" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter the password" required><br>
            <input type="submit" value="Signup">
        </form>
    </div>
</body>
</html>

