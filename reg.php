<?php
// Check if the form is submitted
if (isset($_POST['submitBtn'])) {
    // Establish database connection
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'hospital_praj';

    $conn = new mysqli($host, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $p_id = $_POST["p_id"];
    $P_Name = $_POST["P_Name"];
    $age = $_POST["age"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $d_password = $_POST["d_password"];

    // Perform any necessary validation here

    // Construct SQL INSERT statement
    $sql = "INSERT INTO patient (p_id, P_Name, Age, email, gender, d_password) VALUES ('$p_id', '$P_Name', '$age', '$email', '$gender', '$d_password')";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        // Redirect to login page after successful insertion
        header("Location: login.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <style>
        .container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .divider-text {
            position: relative;
            text-align: center;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .divider-text span {
            padding: 7px;
            font-size: 12px;
            position: relative;
            z-index: 2;
        }

        .divider-text:after {
            content: "";
            position: absolute;
            width: 100%;
            border-bottom: 1px solid #ddd;
            top: 55%;
            left: 0;
            z-index: 1;
        }

        .input-group-prepend span {
            width: 45px;
            background-color: #007bff;
            color: white;
            border:0 !important;
        }

        input:focus {
            outline: none !important;
            box-shadow: 0 0 10px #719ECE;
        }

        .btn-primary {
            background-color: #007bff !important;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <br>

        <div class="card bg-light">
            <article class="card-body mx-auto" style="max-width: 400px;">
                <!-- Remove the extra form tag here -->
                <form action="" method="post">
                    <h4 class="card-title mt-3 text-center">Create Account</h4>
                    <!-- Remove Facebook and Twitter login buttons -->
                    
                    <!-- Remove the extra form tag here -->
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-id-card"></i> </span>
                        </div>
                        <input name="p_id" class="form-control" placeholder="Mobile Number" id="p_id"
                            type="text">
                    </div> <!-- form-group// -->
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <input name="P_Name" class="form-control" placeholder="Name" id="P_Name" type="text">
                    </div> <!-- form-group// -->
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                        </div>
                        <input name="age" class="form-control" placeholder="Age" id="age" type="number">
                    </div> <!-- form-group// -->
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <input name="email" class="form-control" placeholder="Email address" id="email" type="email">
                    </div> <!-- form-group// -->
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-venus-mars"></i> </span>
                        </div>
                        <select class="form-control" id="gender" name="gender">
                            <option selected=""> Select Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div> <!-- form-group end.// -->
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input class="form-control" placeholder="Create password" id="d_password" name="d_password"
                            type="password">
                    </div> <!-- form-group// -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block" name="submitBtn"> Create Account
                        </button>
                    </div> <!-- form-group// -->
                    <p class="text-center">Have an account? <a href="login.php">Log In</a> </p>
                </form>
            </article>
        </div> <!-- card.// -->
    </div>

    <!--container end.//-->
    <br><br>
</body>

</html>

