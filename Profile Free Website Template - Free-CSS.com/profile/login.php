
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
        $errorMessage = "Invalid Login. Please try again.";
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
    <link rel="stylesheet" href="style.css"> <!-- Link to your external CSS file -->
    <title>Tennis Tournament Admin</title>
    <style>
        /* Inline CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
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

        .error-message {
            color: red;
            margin-bottom: 10px;
        }

        .register-message {
            margin-top: 20px;
            font-size: 14px;
        }

        .register-link {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form action="" method="post">
            <!-- Error message display -->
            <?php if (isset($errorMessage)) { ?>
                <p class="error-message"><?php echo $errorMessage; ?></p>
            <?php } ?>

            <label for="D_id">ID:</label>
            <input type="text" id="D_id" name="D_id" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="upload">Login</button>

            <!-- Registration message with link -->
            <p class="register-message">Don't have an account? <a href="register.php" class="register-link">Register here</a>.</p>
        </form>
    </div>
</body>

</html>
