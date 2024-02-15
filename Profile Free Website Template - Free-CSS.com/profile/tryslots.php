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

// Process form submission if POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $patient_id = 33; // Default patient ID

    // Check if the time slot is available
    $availability_query = "SELECT * FROM `patient_booking` WHERE `d_id` = '$d_id' AND `date` = '$date' AND `time` = '$time'";
    $availability_result = $conn->query($availability_query);
    if ($availability_result->num_rows > 0) {
        echo "This slot is already booked.";
        exit;
    }

    // Insert into patient_booking table
    $stmt = $conn->prepare("INSERT INTO patient_booking (patient_id, d_id, date, time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $patient_id, $d_id, $date, $time);
    if ($stmt->execute() === TRUE) {
        echo "Slot booked successfully!";
    } else {
        echo "Error booking slot: " . $conn->error;
    }
    $stmt->close();
}

// Fetch available slots for the selected date
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['date'])) {
    $date = $_GET['date'];
    $query = "SELECT * FROM `app` WHERE `d_id` = '$d_id' AND `date` = '$date'";
    $result = $conn->query($query);
    $timeSlots = [];
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        foreach ($row as $key => $value) {
            if ($key !== 'id' && $key !== 'date') {
                // Check if the slot is already booked
                $availability_query = "SELECT * FROM `patient_booking` WHERE `d_id` = '$d_id' AND `date` = '$date' AND `time` = '$key'";
                $availability_result = $conn->query($availability_query);
                if ($availability_result->num_rows == 0 && $value === 'yes') {
                    $timeSlots[] = ['time' => $key, 'status' => 'yes'];
                }
            }
        }
    }

    // Return time slots as JSON
    header('Content-Type: application/json');
    echo json_encode($timeSlots);
    exit; // Stop further execution
}

// Close database connection
$conn->close();
?>


<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Book Slot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.0/main.min.css" integrity="sha512-Y9hw2QpVj8TgvWLj96U1WVfF3XOwXmCqgF3Oh0UgJyRPm7z5osjIFG8W8KuP3+9R6+voAGlSXd6RTMDdKggyKQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .available {
            background-color: lightgreen;
        }
    </style>
</head>
<body>
    <h1>huuu</h1>
    <div id='calendar'></div>
    
    <form id="bookingForm" method="post">
        <input id="datePicker" type="date" name="date" required>
        <button type="button" id="fetchSlotsButton">Fetch Time Slots</button>
    </form>

    <div id="timeSlotsTableContainer"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('fetchSlotsButton').addEventListener('click', fetchTimeSlots);

            function fetchTimeSlots() {
                var selectedDate = document.getElementById('datePicker').value;
                var url = window.location.href + '?date=' + selectedDate;
                
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        displayTimeSlots(data);
                    })
                    .catch(error => {
                        console.error('Error fetching time slots:', error);
                    });
            }

            function displayTimeSlots(slotsData) {
                var container = document.getElementById('timeSlotsTableContainer');
                container.innerHTML = ''; // Clear previous content

                if (slotsData.length === 0) {
                    container.textContent = 'No available time slots for selected date.';
                    return;
                }

                var table = document.createElement('table');
                var headerRow = table.insertRow();
                headerRow.innerHTML = '<th>Time Slot</th><th>Action</th>';

                slotsData.forEach(slot => {
                    var row = table.insertRow();
                    var timeSlotCell = row.insertCell();
                    timeSlotCell.textContent = slot.time;
                    var actionCell = row.insertCell();
                    if (slot.status === 'yes') {
                        var bookButton = document.createElement('button');
                        bookButton.textContent = 'Book';
                        bookButton.addEventListener('click', function() {
                            bookSlot(slot.time);
                        });
                        actionCell.appendChild(bookButton);
                    } else {
                        actionCell.textContent = 'Not available';
                    }
                });

                container.appendChild(table);
            }

            function bookSlot(time) {
                var date = document.getElementById('datePicker').value;
                var formData = new FormData();
                formData.append('date', date);
                formData.append('time', time);

                fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // Handle response, e.g., show success message
                    fetchTimeSlots(); // Refresh time slots after booking
                })
                .catch(error => {
                    console.error('Error booking slot:', error);
                });
            }
        });
    </script>
</body>
</html>
