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
$query = "SELECT `date`, 
                 `9-9:10`, `9:10-9:20`, `9:20-9:30`, `9:30-9:40`, `9:40-9:50`, `9:50-10`, 
                 `10-10:10`, `10:10-10:20`, `10:20-10:30`, `10:30-10:40`, `10:40-10:50`, `10:50-11`, 
                 `11-11:10`, `11:10-11:20`, `11:20-11:30`, `11:30-11:40`, `11:40-11:50`, `11:50-12`, 
                 `12-12:10`, `12:10-12:20`, `12:20-12:30`, `12:30-12:40`, `12:40-12:50`, `12:50-1`, 
                 `1-1:10`, `1:10-1:20`, `1:20-1:30`, `1:30-1:40`, `1:40-1:50`, `1:50-2`, 
                 `2-2:10`, `2:10-2:20`, `2:20-2:30`, `2:30-2:40`, `2:40-2:50`, `2:50-3`, 
                 `3-3:10`, `3:10-3:20`, `3:20-3:30`, `3:30-3:40`, `3:40-3:50`, `3:50-4`, 
                 `4-4:10`, `4:10-4:20`, `4:20-4:30`, `4:30-4:40`, `4:40-4:50`, `4:50-5` 
          FROM `app` 
          WHERE `d_id` = '$d_id'";

$result = $conn->query($query);
if (!$result) {
    echo "Error: " . $conn->error;
} else {
    $slotsData = [];
    while ($row = $result->fetch_assoc()) {
        $slotsData[$row['date']] = $row;
    }
    echo json_encode($slotsData);
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-+9Btqc/xE36/dl7Z6XusvzB5pI0gDlfQPHQr6TyovH/uIrT4trwQ+5LWJo83C1uXtFZKZvzDlmJrO1CEMUH+fQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.0/main.min.js" integrity="sha512-0qvT7rfQa+zVdzuhE0+XyU5Lw/P2Pmg8eBnE3Pw/Rt/L81YhSmIw5nLbSjdpjIMQQL2ssLb3lXXB0kVYjFtrtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('fetchSlotsButton').addEventListener('click', fetchTimeSlots);

            function fetchTimeSlots() {
                var selectedDate = document.getElementById('datePicker').value;
                var url = 'fetch_timeslots.php?date=' + selectedDate;
                
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

                if (Object.keys(slotsData).length === 0) {
                    container.textContent = 'No available time slots for selected date.';
                    return;
                }

                var table = document.createElement('table');
                var headerRow = table.insertRow();
                headerRow.innerHTML = '<th>Date</th><th>Time Slots</th>';

                Object.keys(slotsData).forEach(date => {
                    var row = table.insertRow();
                    var dateCell = row.insertCell();
                    dateCell.textContent = date;
                    var timeSlotsCell = row.insertCell();
                    timeSlotsCell.textContent = Object.values(slotsData[date]).slice(1).join(', ');
                });

                container.appendChild(table);
            }
        });
    </script>
</body>
</html>
