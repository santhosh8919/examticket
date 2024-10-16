<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost:3306//";
$username = "santhosh";
$password = "santhosh123";
$dbname = "exam_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $branch = $_POST['branch'];
    $photo = "uploads/" . basename($_FILES["photo"]["name"]);
    move_uploaded_file($_FILES["photo"]["tmp_name"], $photo);

    $sql = "INSERT INTO students (student_id, name, branch, photo) VALUES ('$student_id', '$name', '$branch', '$photo')";

    if ($conn->query($sql) === TRUE) {
        header("Location: generate_hallticket.php?student_id=$student_id");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            background-image: url('uploads/iiit1.jpeg'); /* Background image path */
            background-size: cover;
            background-position: center;
        }
        .container {
            width: 600px;
            margin: 50px auto;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
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
        input[type="text"], input[type="file"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student Registration</h2>
        <form method="post" action="" enctype="multipart/form-data">
            Student ID: <input type="text" name="student_id" required><br>
            Name: <input type="text" name="name" required><br>
            Branch: <input type="text" name="branch" required><br>
            Photo: <input type="file" name="photo" required><br>
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>

