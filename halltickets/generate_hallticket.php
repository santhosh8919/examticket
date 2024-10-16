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

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_GET['student_id'];
$sql = "SELECT * FROM students WHERE student_id = '$student_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    echo "No student found.";
    exit();
}

$sql = "SELECT * FROM subjects WHERE branch = '{$student['branch']}'";
$subjects = $conn->query($sql);

if ($subjects->num_rows > 0) {
    $subject_details = $subjects->fetch_all(MYSQLI_ASSOC);
} else {
    echo "No subjects found for this branch.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Exam Hall Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            background-image: url('uploads/iiit.jpeg'); /* Background image path */
            background-size: cover;
            background-position: center;
        }
        .logo img {
            width: 80px;
            height: 80px;
            position: absolute;
            top: 80px;
            left: 500px;
            z-index: 10; /* Ensure the logo is above other content */
        }
        .ticket {
            width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1; /* Ensure the ticket content is behind the logo */
        }
        .ticket h1 {
            margin: 0;
            color: #333;
            text-align: center;
        }
        .ticket p {
            margin: 10px 0;
        }
        .ticket img {
            width: 100px;
            height: 100px;
            border: 2px solid #ccc;
            position: absolute;
            top: 60px;
            right: 20px;
        }
        .ticket table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .ticket table th,
        .ticket table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
        }
        .ticket table th {
            background-color: #f2f2f2;
        }
        .ticket button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }
        .ticket button:hover {
            background-color: #45a049;
        }
        .ticket form {
            text-align: center;
        }
        .exam p{
            position:absolute;
            margin-right: 500px;
        }
    </style>
    <script>
        function printTicket() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="logo">
        <img src="rgukt_logo.jpeg" alt="Rajiv Gandhi University of Knowledge Technologies Logo">
    </div>
    <div class="ticket">
        <h1>Rajiv Gandhi University of Knowledge Technologies <br> Basar, Telangana</h1>
        <h2><center>Exam Hall Ticket</center></h2>
        <p><strong>Student ID:</strong> <?php echo $student['student_id']; ?></p>
        <p><strong>Name:</strong> <?php echo $student['name']; ?></p>
        <p><strong>Branch:</strong> <?php echo $student['branch']; ?></p>
        <p><img src="<?php echo htmlspecialchars($student['photo']); ?>" alt="Student Photo"></p>
        <h2>Exam Details</h2>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Subject</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
            <?php foreach ($subject_details as $subject) { ?>
                <tr>
                    <td><?php echo $subject['subject_name']; ?></td>
                    <td><?php echo $subject['exam_date']; ?></td>
                    <td><?php echo $subject['exam_time']; ?></td>
                </tr>
            <?php } ?>
        </table>
        <div class="exam">
               <p>Examination</p>
        </div>
        <form method="post" action="login.php">
            <input type="submit" name="logout" value="Logout">
        </form>
        <h3><center><b>Instructions</b></center></h3><hr>
        <p>
        1. All students shall produce valid institute ID Cards as and when instructed by the invigilator
or members of the vigilance squad or other officials of the Institute.<br>
2. Students are not permitted to bring any loose or written or blank sheets other than those
permitted by the course faculty to the examination hall. Any code books / data handbooks
/ other handouts carried by the students shall be duly attested / endorsed by the
course faculty. Any additional scribing in such materials with pen or pencil will be treated
as attempts for exam malpractice.<br>
3. Mobile phones/ Smart watches / Bluetooth devices/ Similar electronic gadgets are
strictly banned in examination halls. Carrying such devices to the exam hall will be
treated as attempts for exam malpractice. In case by oversight any student happens to bring
any such devices, the same shall be kept outside the examination hall at their own risk.<br>
4. Bio-break shall be availed only if necessary. The time of exit and entry for biobreak
during examination shall be recorded in the form available with the invigilator. Any misuse of
bio-break will be treated as an attempt for examination malpractice.<br>
5. Immediately after the Main Answer Booklets are issued to the students, they should fill in the
relevant fields on the front sheet. ID card shall be made available to the Invigilator for
verifying the filled data.<br>
6. Students shall ensure that the invigilator signs the main answer book after the verification.
Also all additional sheets are to be signed by the invigilator. Any answer books submitted
without the signatures of the invigilator will be treated as invalid.<br>
7. Students should mark their attendance in the relevant form provided by the invigilator. Entry
to the hall will not be permitted 15 minutes after the start of examination.<br>
8. Immediately after the question papers are issued to the students, the students should write
their name and Roll No. on the question paper. It is also instructed that no other pen/
pencil markings are to be made by the student in the question paper. Any such actions
will be treated as an attempt for malpractice.<br>

        </p>
        <button onclick="printTicket()">Print Hall Ticket</button>
    </div>
</body>
</html>
