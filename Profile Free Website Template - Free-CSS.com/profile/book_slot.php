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

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $patient_id = 33; // Default patient ID
    $d_id = $_SESSION['user_id'];

    // Insert into patient_booking table
    $stmt = $conn->prepare("INSERT INTO patient_booking (patient_id, d_id, date, time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $patient_id, $d_id, $date, $time);
    if ($stmt->execute() === TRUE) {
        echo "Slot booked successfully!";
    } else {
        echo "Error booking slot: " . $conn->error;
    }
    $stmt->close();
    exit; // Stop further execution
}

$conn->close();
?>
