<?php
session_start();

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'hospital_praj';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['upload'])) {
    $D_id = $_POST["D_id"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM doctors WHERE D_id = ? AND D_password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $D_id, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['user_id'] = $D_id;
        echo '<script type="text/javascript"> 
						window.onload = function () { 
							window.location.href = "index.php"; 
						}; 
			</script> 
		'; 
        exit;
    } else {
        $errorMessage = "Invalid credentials. Please try again.";
    }
}

if (isset($_POST['register'])) {
    $D_id = $_POST["D_id"];
    $password = $_POST["password"];
    $phoneNumber = $_POST["phoneNumber"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO doctors (D_id, D_password, D_number) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $D_id, $hashedPassword, $phoneNumber);

    if ($stmt->execute()) {
        $successMessage = "Registration successful. You can now login.";
        header("Location: login.php");
        exit;
    } else {
        $errorMessage = "Error: Registration failed. Please try again later.";
    }
}

$conn->close();
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
