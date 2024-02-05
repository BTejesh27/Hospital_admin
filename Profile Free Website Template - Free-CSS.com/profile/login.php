
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
        $_SESSION['user_password'] = $D_id;

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
    <link rel="stylesheet" href="style.css">
    <title>Tennis Tournament Admin</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            margin-bottom: 8px;
            color: #555;
        }

        input {
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            padding: 12px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
        }

        button:hover {
            background-color: #2980b9;
        }

        .register-link {
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }

        .register-link a {
            color: #3498db;
            text-decoration: none;
        }
        .login-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .register-form {
            display: none; /* Initially hide the registration form */
        }

        .register-link {
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }

        .register-link a {
            color: #3498db;
            text-decoration: none;
        }
    
    </style>
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

        <!-- Registration form (initially hidden) -->
        <form action="" method="post" style="display: none;" id="registrationForm">
            <h2>Register</h2>
            <label for="D_id">ID:</label>
            <input type="text" id="D_id" name="D_id" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="register">Register</button>
        </form>

        <!-- JavaScript to toggle form visibility -->
        <script>
            function toggleRegistrationForm() {
                var registrationForm = document.getElementById('registrationForm');
                registrationForm.style.display = (registrationForm.style.display === 'none') ? 'block' : 'none';
            }
        </script>
    </div>
</body>

</html>
