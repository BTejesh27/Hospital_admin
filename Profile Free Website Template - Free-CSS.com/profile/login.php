
<?php
session_start(); // Start the session

// Database connection credentials
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'hospital_praj';

$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if (isset($_POST['upload'])) {
    // Get user input
    $D_id = $_POST["D_id"];
    $password = $_POST["password"];

    // You should perform proper validation and sanitation here before querying the database

    // Check if the provided credentials are valid
    $sql = "SELECT * FROM doctors WHERE D_id = '$D_id' AND D_password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Valid credentials, store the password in a session variable
        $_SESSION['user_id'] = $D_id;

        // Successful login, redirect to a protected page
        header("Location: index.php");
        exit;
    } else {
        // Invalid login, display an error message
        $errorMessage = "Invalid credentials. Please try again.";
    }
}

// Check if the registration form is submitted
if (isset($_POST['register'])) {
    // Get user input
    $D_id = $_POST["D_id"];
    $password = $_POST["password"];

    // You should perform proper validation and sanitation here before inserting into the database

    // Insert user information into the database
    $sql = "INSERT INTO doctors (D_id, D_password) VALUES ('$D_id', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Registration successful, you can redirect or display a success message
        $successMessage = "Registration successful. You can now login.";
    } else {
        // Registration failed, display an error message
        $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>login</title>
</head>

<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form action="" method="post">
            <!-- You can display an error message here if set -->
            <?php if (isset($errorMessage)) { ?>
                <p style="color: red;"><?php echo $errorMessage; ?></p>
            <?php } ?>

            <!-- You can display a success message here if set -->
            <?php if (isset($successMessage)) { ?>
                <p style="color: green;"><?php echo $successMessage; ?></p>
            <?php } ?>

            <label for="D_id">ID:</label>
            <input type="text" id="D_id" name="D_id" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="upload">Login</button>
        </form>
        
        <!-- Registration link -->
        <p class="register-link">Don't have an account? <a href="#" onclick="toggleRegistrationForm()">Register</a></p>
    </div>

        <!-- Registration form (initially hidden) -->
        
        <div class="registrationForm" style="display: none;">
            <form action="" method="post">
                <h2>Register</h2>
                <label for="D_id">ID:</label>
                <input type="text" id="D_id" name="D_id" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <label for="mobile_no">Mobile Number:</label>
                <input type="text" id="phoneNumber" name="phoneNumber" maxlength="10" required>
                <button onclick="sendSMS()">Get OTP</button><br>
                
                <div class='show' style="display:none">
                    <label for="OTP">Enter OTP:</label>
                    <input type="text" id="OTP" name="OTP" maxlength="6" required>
                    <button type="button" onclick="validateOtp()" >Submit OTP</button>
                    <p id="msg"></p>
                </div>
                
                <button class="reg_btn" type="submit" name="register" style='display:none'>Register</button>
                <p class="register-link">Do you have an account? <a href="#" onclick="toggleRegistrationForm()">login</a></p>
            </form>
        </div>

        <!-- JavaScript to toggle form visibility -->
        <script src="js/login.js"></script>
</body>

</html>
