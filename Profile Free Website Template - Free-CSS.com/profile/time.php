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
$doctor_id = $_SESSION['user_password'];

// Retrieve doctor's slots based on doctor's ID
$query = "SELECT * FROM `app` WHERE `d_id` = '$doctor_id'";
$result = $conn->query($query);

$doctorSlots = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $date = $row['date'];
        foreach ($row as $key => $value) {
            if ($key !== 'd_id' && $key !== 'date' && $value === 'yes') {
                $time = $key;
                $doctorSlots[$date][] = $time;
            }
        }
    }
}

// Function to generate time slots with a 10-minute interval from 9 AM to 5 PM
function generateTimeSlots() {
    $timeSlots = array();
    $start = strtotime('09:00');
    $end = strtotime('17:00');
    $interval = 10 * 60; // 10 minutes

    for ($i = $start; $i <= $end; $i += $interval) {
        $timeSlots[] = date('H:i', $i);
    }

    return $timeSlots;
}

// Insert booking data into the database when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $date = $_POST["date"];
    $time = $_POST["time"];

    // Insert the form data into the patient_booking table
    $sql = "INSERT INTO patient_booking (patient_id, d_id, date, time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("iiss", $patient_id, $doctor_id, $date, $time);

    // Set patient_id (assuming it's available in the session, you may need to adjust)
    $patient_id = 445;

    // Execute the statement
    if ($stmt->execute()) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement
    $stmt->close();
}

// Display available slots
if (!empty($doctorSlots)) {
    echo "<h2>Book Appointment</h2>";
    echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>"; // Submit form to the same page
    echo "<label for='date'>Select Date:</label>";
    echo "<input type='date' id='date' name='date' required>";
    echo "<label for='time'>Select Time Slot:</label>";
    echo "<select id='time' name='time' required>";
    $timeSlots = generateTimeSlots();
    foreach ($timeSlots as $time) {
        echo "<option value='$time'>$time</option>";
    }
    echo "</select>";
    echo "<button type='submit' name='submit'>Book Slot</button>";
    echo "</form>";
} else {
    echo "No slots available.";
}

// Close connection
$conn->close();
?>
