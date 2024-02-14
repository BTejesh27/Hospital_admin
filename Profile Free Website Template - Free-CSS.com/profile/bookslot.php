<?php
// Start the session to access session variables
session_start();

// Database connection
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

if(isset($_POST['submit_date'])) {
    $date = $_POST['selected_date'];
    $doctorId = $_SESSION['user_id']; // Assuming session variable for doctor ID is 'user_id'

    $query = "SELECT `9-10`, `10-11`, `11-12`, `12-1`, `1-2`, `2-3`, `3-4`, `4-5` FROM `app` WHERE `d_id` = $doctorId AND `date` = '$date'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $slots = [];
        foreach ($row as $key => $value) {
            if ($value == 'yes') {
                $slots[] = $key;
            }
        }
        echo '<h2>Select Slot:</h2>';
        echo '<form action="" method="post">';

        foreach ($slots as $slot) {
            echo '<input type="radio" name="selected_slot" value="' . $slot . '"> ' . $slot . '<br>';
        }
        echo '<input type="hidden" name="selected_date" value="' . $date . '">';
        echo '<input type="hidden" name="selected_patient" value="222">'; // Assuming patient ID is always 222
        echo '<input type="submit" name="submit_slot" value="Book Slot">';
        echo '</form>';
    } else {
        echo 'No slots available for this date.';
    }
}

// Close the connection
$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Appointment Booking</title>
</head>
<body>
    <h2>Select Date:</h2>
    <form action="" method="post">
        <input type="date" name="selected_date">
        <input type="submit" name="submit_date" value="Submit">
    </form>
</body>
</html>
<?php
// Start the session to access session variables


// Database connection
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

if(isset($_POST['submit_slot'])) {
    $date = $_POST['selected_date'];
    $slot = $_POST['selected_slot'];
    $doctorId = $_SESSION['user_id']; // Assuming session variable for doctor ID is 'user_id'
    $patientId = $_POST['selected_patient'];

    // Check if a booking already exists for the selected date and time
    $check_query = "SELECT * FROM patient_booking WHERE d_id = $doctorId AND date = '$date' AND time = '$slot'";
    $check_result = mysqli_query($connection, $check_query);

    if(mysqli_num_rows($check_result) > 0) {
        // Booking already exists, update the existing booking
        $update_query = "UPDATE patient_booking SET patient_id = $patientId WHERE d_id = $doctorId AND date = '$date' AND time = '$slot'";
        if(mysqli_query($connection, $update_query)) {
            echo "Booking updated successfully!";
        } else {
            echo "Error updating booking: " . mysqli_error($connection);
        }
    } else {
        // Booking does not exist, insert a new booking
        $insert_query = "INSERT INTO patient_booking (patient_id, d_id, date, time) VALUES ($patientId, $doctorId, '$date', '$slot')";
        if(mysqli_query($connection, $insert_query)) {
            echo "Booking successful!";
        } else {
            echo "Error inserting booking: " . mysqli_error($connection);
        }
    }
}

// Close the connection
$connection->close();
?>
