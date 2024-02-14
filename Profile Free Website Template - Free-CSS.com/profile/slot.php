<?php
// Start the session
session_start();

// Check if the doctor's ID is set in the session
if (!isset($_SESSION['user_id'])) {
    // Redirect to login or set the doctor's ID using another method
    header('Location: login.php');
    exit();
}

// Initialize $conn with your database connection
$conn = mysqli_connect("localhost", "root", "", "hospital_praj");

// Check if the connection was successful
if (!$conn) {
    // Handle the connection error
    die("Connection failed: " . mysqli_connect_error());
}

// Get the doctor's ID from the session
$doctor_id = $_SESSION['user_id'];

// Display the calendar to select the date
if (!isset($_POST['date'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Select Date</title>
    </head>
    <body>
        <h1>Select Date</h1>
        <form method="POST">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required><br><br>
            <button type="submit">Select</button>
        </form>
    </body>
    </html>
    <?php
} else {
    // Get the selected date
    $date = $_POST['date'];
    $date_escaped = mysqli_real_escape_string($conn, $date);

    // Retrieve all slots for the selected date and doctor ID
    $select_query = "SELECT * FROM app WHERE date = '$date_escaped' AND d_id = '$doctor_id'";
    $result = mysqli_query($conn, $select_query);

    // Fetch the record for the selected date and doctor ID
    $record = mysqli_fetch_assoc($result);

    // Render form to select slots
    renderSlotForm($date, $record);
}

// Function to render the form for selecting slots
function renderSlotForm($date, $record) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Schedule Appointment</title>
    </head>
    <body>
        <h1>Schedule Appointment</h1>
        <form method="POST">
            <input type="hidden" name="date" value="<?php echo htmlspecialchars($date); ?>">
            <?php
            // Loop through each slot and display it in the form
            foreach ([
                '9-10' => '9:00 AM - 10:00 AM',
                '10-11' => '10:00 AM - 11:00 AM',
                '11-12' => '11:00 AM - 12:00 PM',
                '12-1' => '12:00 PM - 1:00 PM',
                '1-2' => '1:00 PM - 2:00 PM',
                '2-3' => '2:00 PM - 3:00 PM',
                '3-4' => '3:00 PM - 4:00 PM',
                '4-5' => '4:00 PM - 5:00 PM'
            ] as $slot_key => $slot_label):
            ?>
                <input type="checkbox" id="<?php echo $slot_key; ?>" name="slots[]" value="<?php echo $slot_key; ?>" <?php echo isset($record[$slot_key]) && $record[$slot_key] === 'yes' ? 'checked' : ''; ?>>
                <label for="<?php echo $slot_key; ?>"><?php echo $slot_label; ?></label><br>
            <?php endforeach; ?>
            <button type="submit">Submit</button>
        </form>
    </body>
    </html>
    <?php
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected date
    $date = $_POST['date'];
    $date_escaped = mysqli_real_escape_string($conn, $date);

    // Check if a record already exists for the selected date and doctor ID
    $select_query = "SELECT * FROM app WHERE date = '$date_escaped' AND d_id = '$doctor_id'";
    $result = mysqli_query($conn, $select_query);

    if (mysqli_num_rows($result) > 0) {
        // If a record exists, update the slots
        $record = mysqli_fetch_assoc($result);

        // Loop through each selected slot and update the database
        foreach ($_POST['slots'] as $selected_slot) {
            // Escape the selected slot to prevent SQL injection
            $selected_slot_escaped = mysqli_real_escape_string($conn, $selected_slot);

            // Update the slot in the record
            $record[$selected_slot_escaped] = 'yes';
        }

        // Update the record in the database
        $update_query = "UPDATE app SET ";
        foreach ($record as $slot_key => $value) {
            $update_query .= "`$slot_key` = '$value', ";
        }
        $update_query = rtrim($update_query, ", ") . " WHERE date = '$date_escaped' AND d_id = '$doctor_id'";

        if (mysqli_query($conn, $update_query)) {
            echo "Slots updated successfully!";
        } else {
            echo "Error updating slots: " . mysqli_error($conn);
        }
    } else {
        // If no record exists, insert a new record with the selected slots
        $insert_query = "INSERT INTO app (d_id, date";
        $values_query = "'$doctor_id', '$date_escaped'";
        foreach ($_POST['slots'] as $selected_slot) {
            // Escape the selected slot to prevent SQL injection
            $selected_slot_escaped = mysqli_real_escape_string($conn, $selected_slot);

            // Add the slot to the insert query
            $insert_query .= ", `$selected_slot_escaped`";
            $values_query .= ", 'yes'";
        }
        $insert_query .= ") VALUES ($values_query)";

        if (mysqli_query($conn, $insert_query)) {
            echo "Appointment scheduled successfully!";
        } else {
            echo "Error inserting appointment: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>
