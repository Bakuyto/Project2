<?php
session_start();

include '../connection/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve username from the form
    $myusername = mysqli_real_escape_string($conn, $_POST['username']);
    $mypassword = mysqli_real_escape_string($conn, $_POST['password']);

    // Assuming User_login stored procedure returns 'user_level_fk' column
    $sql = "CALL User_login ('$myusername','$mypassword')";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Check if 'user_level_fk' is present in the fetched row
        if (isset($row['user_level_fk'])) {
            // Check user type
            if ($row["user_level_fk"] == "2") {
                echo 'user';
            } elseif ($row["user_level_fk"] == "1") {
                // Store username in session
                $_SESSION['username'] = $myusername;
                // Redirect to admin panel
                header("Location: ../admin/main.php");
                exit; // Ensure script execution stops after redirection
            } else {
                echo 'Unknown user type';
            }
        } else {
            echo 'User data incomplete';
        }
    } else {
        echo 'Username or password incorrect!!!';
    }

    // Free result set
    mysqli_free_result($result);
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
    <form class="login container-fluid" action="login.php" method="POST" id="login-user">
        <div class="form">
            <div class="mb-3">
                <div class="form-header"><h1 class="text-center mb-3">Login Form</h1></div>
              <label class="form-label">Username</label>
              <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember">
              <label class="form-check-label" for="exampleCheck1">Remember me</label>
            </div>
            <div class="bottom-but w-100 d-flex align-content-center justify-content-center">
                <button class="btn btn-primary mt-2" type="submit" value="login">SIGN IN</button>
            </div>
        </div>
      </form>

</body>

</html>