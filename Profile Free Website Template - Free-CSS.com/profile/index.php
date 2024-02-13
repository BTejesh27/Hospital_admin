<!DOCTYPE HTML>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Doctors </title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Website Template by freehtml5.co" />
	<meta name="keywords" content="free website templates, free html5, free template, free bootstrap, free website template, html5, css3, mobile first, responsive" />
	<meta name="author" content="freehtml5.co" />

	<!-- 
	//////////////////////////////////////////////////////

	FREE HTML5 TEMPLATE 
	DESIGNED & DEVELOPED by FreeHTML5.co
		
	Website: 		http://freehtml5.co/
	Email: 			info@freehtml5.co
	Twitter: 		http://twitter.com/fh5co
	Facebook: 		https://www.facebook.com/fh5co

	//////////////////////////////////////////////////////
	 -->

	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content="" />
	<meta property="og:image" content="" />
	<meta property="og:url" content="" />
	<meta property="og:site_name" content="" />
	<meta property="og:description" content="" />
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<link href="https://fonts.googleapis.com/css?family=Space+Mono" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">

	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">

	<!-- Theme style  -->
	<link rel="stylesheet" href="css/style.css">

	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

</head>

<body>

	<div class="fh5co-loader"></div>

	<div id="page">

		<header id="fh5co-header" class="fh5co-cover js-fullheight" role="banner" style="background-image:url(images/cover_bg_3.jpg);" data-stellar-background-ratio="0.5">
			<div class="overlay"></div>
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2 text-center">
						<div class="display-t js-fullheight">
							<div class="display-tc js-fullheight animate-box" data-animate-effect="fadeIn">
								<div class="profile-thumb" style="background: url(images/user-3.jpg);"></div>

								<?php
								session_start();

								// Database connection credentials
								$host = 'localhost';
								$username = 'root';
								$password = '';
								$database = 'hospital_praj';

								$conn = new mysqli($host, $username, $password, $database);

								// Check connection
								if ($conn->connect_error) {
									die("Connection failed: " . $conn->connect_error);
								}

								if (!isset($_SESSION['user_password'])) {
									// User is not logged in, redirect to login page
									header("Location: login.php");
									exit;
								}

								$userPassword = $_SESSION['user_password']; // Corrected variable name

								$stmt = $conn->prepare("SELECT D_name, D_number FROM doctors WHERE D_id = ?");
								$stmt->bind_param("s", $userPassword);
								$stmt->execute();
								$result = $stmt->get_result();

								if (!$result) {
									die("Error in the query: " . $conn->error);
								}

								if ($result->num_rows > 0) {
									$row = $result->fetch_assoc();
									$name = $row['D_name'];
									$number = $row['D_number'];

									echo "<h1>Welcome, $name!</h1>";
									// echo "<p>Your contact number is: $number</p>";
								}

								$stmt->close();
								$conn->close();
								?>
<!-- 
								<h1>YOUR SCHEDULE</h1>
								

									<style>
										/* Define the CSS for the booked class */
										.booked {
											background-color: green;
											color: white;
											/* Change text color for better contrast */
										}

										/* Basic table styling */
										table {
											width: 100%;
											border-collapse: collapse;
											margin-bottom: 20px;
											/* Add some space below the table */
										}

										th,
										td {
											padding: 8px;
											text-align: center;
										}

										th {
											background-color: #f2f2f2;
											/* Light gray background for table headers */
										}

										tr:nth-child(even) {
											background-color: #f2f2f2;
											/* Alternate row background color */
										}

										/* Center align the table */
										.table-container {
											text-align: center;
											margin: 0 auto;
											max-width: 800px;
											/* Adjust the maximum width as needed */
										}
									</style>
								<div class="table-container">
									<?php


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

									// Escape the session variable to prevent SQL injection
									$d_id = $_SESSION['user_password'];

									// Define time slots
									$timeSlots = ['9-10', '10-11', '11-12', '12-1', '1-2', '2-3', '3-4', '4-5'];

									// Construct the select query dynamically based on time slots
									$selectColumns = "`date`";
									foreach ($timeSlots as $slot) {
										$selectColumns .= ", `$slot`";
									}

									// Query to select booked slots from the "app" table based on d_id and ordered by date
									$query = "SELECT $selectColumns
            FROM `app`
            WHERE `d_id` = '$d_id'
            ORDER BY `date`";

									// Execute the query
									$result = $conn->query($query);

									// Check if there are any rows returned
									if ($result->num_rows > 0) {
										// Output the table header
										echo "<table border='1'>";
										echo "<tr><th>Date</th>";
										foreach ($timeSlots as $slot) {
											echo "<th>$slot</th>";
										}
										echo "</tr>";

										// Output data of each row
										while ($row = $result->fetch_assoc()) {
											echo "<tr>";
											echo "<td>" . $row['date'] . "</td>";
											foreach ($timeSlots as $slot) {
												echo "<td class='" . ($row[$slot] == 'yes' ? 'booked' : '') . "'></td>";
											}
											echo "</tr>";
										}
										echo "</table>";
									} else {
										// Output a message if no rows found
										echo "No slots Schedule.";
									}

									// Close connection
									$conn->close();
									?>
								</div> -->





								
							</div>
						</div>
					</div>
				</div>
			</div>
			<br>
		</header>

        <h1>YOUR SCHEDULE</h1>
								

                                <style>
                                    /* Define the CSS for the booked class */
                                    .booked {
                                        background-color: green;
                                        color: white;
                                        /* Change text color for better contrast */
                                    }

                                    /* Basic table styling */
                                    table {
                                        width: 100%;
                                        border-collapse: collapse;
                                        margin-bottom: 20px;
                                        /* Add some space below the table */
                                    }

                                    th,
                                    td {
                                        padding: 8px;
                                        text-align: center;
                                    }

                                    th {
                                        background-color: #f2f2f2;
                                        /* Light gray background for table headers */
                                    }

                                    tr:nth-child(even) {
                                        background-color: #f2f2f2;
                                        /* Alternate row background color */
                                    }

                                    /* Center align the table */
                                    .table-container {
                                        text-align: center;
                                        margin: 0 auto;
                                        max-width: 800px;
                                        /* Adjust the maximum width as needed */
                                    }
                                </style>
                            <div class="table-container">
                                <?php


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

                                // Escape the session variable to prevent SQL injection
                                $d_id = $_SESSION['user_password'];

                                // Define time slots
                                $timeSlots = ['9-10', '10-11', '11-12', '12-1', '1-2', '2-3', '3-4', '4-5'];

                                // Construct the select query dynamically based on time slots
                                $selectColumns = "`date`";
                                foreach ($timeSlots as $slot) {
                                    $selectColumns .= ", `$slot`";
                                }

                                // Query to select booked slots from the "app" table based on d_id and ordered by date
                                $query = "SELECT $selectColumns
        FROM `app`
        WHERE `d_id` = '$d_id'
        ORDER BY `date`";

                                // Execute the query
                                $result = $conn->query($query);

                                // Check if there are any rows returned
                                if ($result->num_rows > 0) {
                                    // Output the table header
                                    echo "<table border='1'>";
                                    echo "<tr><th>Date</th>";
                                    foreach ($timeSlots as $slot) {
                                        echo "<th>$slot</th>";
                                    }
                                    echo "</tr>";

                                    // Output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['date'] . "</td>";
                                        foreach ($timeSlots as $slot) {
                                            echo "<td class='" . ($row[$slot] == 'yes' ? 'booked' : '') . "'></td>";
                                        }
                                        echo "</tr>";
                                    }
                                    echo "</table>";
                                } else {
                                    // Output a message if no rows found
                                    echo "No slots Schedule.";
                                }

                                // Close connection
                                $conn->close();
                                ?>
                            </div>

		<div id="fh5co-resume" class="fh5co-bg-color">
			<div class="container">
			</div>
		</div>
		<style>
			h1 {
				text-align: center;

			}

			form {
				max-width: 600px;
				margin: 0 auto;
				background-color: #fff;
				padding: 20px;
				border-radius: 8px;
				box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
			}

			label {
				display: block;
				margin-bottom: 10px;
			}

			input[type="date"] {
				width: 100%;
				padding: 10px;
				margin-bottom: 20px;
				border-radius: 5px;
				border: 1px solid #ccc;
				box-sizing: border-box;
			}

			fieldset {
				border: none;
				margin: 0;
				padding: 0;
			}

			legend {
				font-size: 1.2em;
				font-weight: bold;
				margin-bottom: 10px;
			}

			button[type="submit"] {
				background-color: #007bff;
				color: #fff;
				padding: 10px 20px;
				border: none;
				border-radius: 5px;
				cursor: pointer;
				font-size: 16px;
			}

			button[type="submit"]:hover {
				background-color: #0056b3;
			}

			.success {
				color: #28a745;
				margin-top: 20px;
				text-align: center;
			}

			.error {
				color: #dc3545;
				margin-top: 20px;
				text-align: center;
			}
		</style>


		<div>
			<h1>Set Appointment Time</h1>

			<form action="" method="post">
				<label for="date">Date:</label>
				<input type="date" id="date" name="date" required>

				<fieldset>
					<legend>Select Time Slot(s):</legend>

					<?php
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

					// Define time slots
					$timeSlots = ['9-10', '10-11', '11-12', '12-1', '1-2', '2-3', '3-4', '4-5'];

					// Display checkboxes for each time slot
					foreach ($timeSlots as $slot) {
					?>
						<label>
							<input type="checkbox" name="time_slot[]" value="<?php echo $slot; ?>"><?php echo $slot; ?>
						</label>
					<?php
					}

					// Close connection
					$conn->close();
					?>

				</fieldset>

				<button type="submit">Submit</button>
			</form>

			<?php
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				// Start the session


				// Get d_id from session
				$d_id = $_SESSION['user_password'];

				// Get date and selected time slots from form
				$date = $_POST["date"];
				$selectedTimeSlots = isset($_POST["time_slot"]) ? $_POST["time_slot"] : [];

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

				// Escape user inputs to prevent SQL injection
				$date = mysqli_real_escape_string($conn, $date);

				// Session variable for table name
				$table_name = "app";

				// Check if appointment already exists for this date
				$existingAppointment = $conn->query("SELECT * FROM `$table_name` WHERE `date` = '$date' AND `d_id` = '$d_id'")->fetch_assoc();

				if ($existingAppointment) {
					// Update existing appointment
					$updateColumns = [];
					foreach ($selectedTimeSlots as $slot) {
						$updateColumns[] = "`$slot` = 'yes'";
					}

					$updateQuery = "UPDATE `$table_name` SET " . implode(",", $updateColumns) . " WHERE `date` = '$date' AND `d_id` = '$d_id'";

					if ($conn->query($updateQuery) === TRUE) {
						echo "<p class='success'>Appointment updated successfully!</p>";
					} else {
						echo "<p class='error'>Error updating appointment: " . $conn->error . "</p>";
					}
				} else {
					// Insert new appointment
					$sqlColumns = "`d_id`, `date`," . implode(",", array_map(function ($slot) {
						return "`$slot`";
					}, $selectedTimeSlots));

					$sqlValues = "'$d_id', '$date'," . implode(",", array_fill(0, count($selectedTimeSlots), "'yes'"));

					$insertQuery = "INSERT INTO `$table_name` ($sqlColumns) VALUES ($sqlValues)";

					if ($conn->query($insertQuery) === TRUE) {
						echo "<p class='success'>Appointment scheduled successfully!</p>";
					} else {
						echo "<p class='error'>Error scheduling appointment: " . $conn->error . "</p>";
					}
				}

				// Close connection
				$conn->close();
			}
			?>
		</div>


		<!-- jQuery -->
		<script src="js/jquery.min.js"></script>
		<!-- jQuery Easing -->
		<script src="js/jquery.easing.1.3.js"></script>
		<!-- Bootstrap -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Waypoints -->
		<script src="js/jquery.waypoints.min.js"></script>
		<!-- Stellar Parallax -->
		<script src="js/jquery.stellar.min.js"></script>
		<!-- Easy PieChart -->
		<script src="js/jquery.easypiechart.min.js"></script>
		<!-- Google Map -->
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCefOgb1ZWqYtj7raVSmN4PL2WkTrc-KyA&sensor=false"></script>
		<script src="js/google_map.js"></script>

		<!-- Main -->
		<script src="js/main.js"></script>

</body>

</html>