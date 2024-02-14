<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_praj";

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Your SQL query to fetch the table structure
$query = "DESCRIBE app";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Error getting table structure: " . mysqli_error($connection));
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Set Appointment Time</title>
</head>
<body>
    <h2>Set Appointment Time</h2>
    <form method="POST" action="">
        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" required><br><br>
        
        <label for="time_slots">Select Time Slot(s):</label><br>
        <select id="time_slots" name="time_slots[]" multiple required>
            <?php
            // Loop through each column in the table starting from the third column (index 2)
            for ($i = 2; $i < 50; $i++) {
                // Get the time slot value from the table header
                $time_slot = explode("-", mysqli_fetch_field_direct($result, $i)->name)[0];
                echo "<option value='$time_slot'>$time_slot</option>";
            }
            ?>
        </select><br><br>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>

<?php
// Close the database connection
mysqli_close($connection);
?>
