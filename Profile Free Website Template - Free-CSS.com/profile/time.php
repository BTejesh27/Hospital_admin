<h2>Book Appointment</h2>
<form action="" method="post">
    <label for="date">Select Date:</label>
    <input type="date" id="date" name="date" required>
    <label for="time">Select Time Slot:</label>
    <select id="time" name="time" required>
        <!-- Time slots will be populated dynamically based on selected date -->
    </select>
    <button type="submit" name="submit">Book Slot</button>
</form>
<?php
// Start the session
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_praj";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve doctor's ID from session variable
$doctor_id = $_SESSION['user_password']; // Replace 'user_password' with your actual session variable

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Get the form data
    $date = $_POST["date"];
    $time = $_POST["time"];

    // Insert the form data into the patient_booking table
    $sql = "INSERT INTO patient_booking (patient_id, d_id, date, time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Assuming patient_id is available in session, replace with actual session variable
    $patient_id = 111; // Example patient ID, replace with your actual session variable

    // Bind parameters
    $stmt->bind_param("iiss", $patient_id, $doctor_id, $date, $time);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
