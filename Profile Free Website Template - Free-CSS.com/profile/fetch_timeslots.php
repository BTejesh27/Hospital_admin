<?php
session_start();

// Check if doctor is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_praj";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch available slots for the doctor from the app table
$d_id = $_SESSION['user_id'];
$date = $_GET['date']; // Get the selected date from the AJAX request
$query = "SELECT * FROM `app` WHERE `d_id` = '$d_id' AND `date` = '$date'";
$result = $conn->query($query);
$timeSlots = [];
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    foreach ($row as $key => $value) {
        if ($key !== 'id' && $key !== 'date' && $value === 'yes') {
            $timeSlots[] = ['time' => $key, 'status' => 'yes'];
        }
    }
}

// Close database connection
$conn->close();

// Return time slots as JSON
header('Content-Type: application/json');
echo json_encode($timeSlots);
?>
