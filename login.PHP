<?php
// Start the session to track the user login
session_start();
include('config.php');

// If the user is already logged in, redirect to the dashboard
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Handle form submission for login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL query to fetch the user from the database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); // Bind the username parameter
    $stmt->execute();

    // Get the result of the query
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if the user exists and password matches
    if ($user && $password == $user['password']) {
        // Valid credentials, store session data
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role']; // Store user role in session

        // Redirect to the dashboard
        header("Location: index.php");
        exit;
    } else {
        // Invalid credentials, show an error message
        $error_message = "Invalid username or password. Please try again.";
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}

// If the user has clicked the logout link, it will destroy the session
if (isset($_GET['logout'])) {
    session_destroy(); // Destroy the session to log out
    header("Location: login.php"); // Redirect back to login page
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASTAAN TV SUBSCRIPTION SYSTEM - Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        h1 {
            background-color: #EE5B2A;
            color: white;
            text-align: center;
            padding: 15px;
            margin: 0;
            font-size: 2rem;  /* Reduced font size for header */
            letter-spacing: 1px;
        }

        .logo {
            display: block;
            margin: 20px auto;  /* Adjust spacing around the logo */
            width: 120px;  /* Smaller logo size */
        }

        .login-container {
            max-width: 350px;  /* Reduced width for the login container */
            margin: 30px auto;
            padding: 20px;  /* Reduced padding for a compact form */
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            text-align: center;
            color: #EE5B2A;
        }

        .login-container label {
            font-size: 1rem;  /* Reduced font size for labels */
            margin-bottom: 8px;
            display: block;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;  /* Reduced padding for inputs */
            margin: 8px 0;  /* Adjusted margins for a smaller form */
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        .login-container input[type="submit"] {
            background-color: #EE5B2A;
            color: white;
            font-size: 1rem;  /* Reduced font size for the submit button */
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .login-container input[type="submit"]:hover {
            background-color: #d05a27;  /* Slightly darker color for hover effect */
        }

        .error-message {
            background-color: #ffcdd2;
            color: #d32f2f;
            padding: 8px;
            text-align: center;
            font-size: 1rem;
            margin-top: 15px;
            border-radius: 5px;
        }

        footer {
            text-align: center;
            padding: 10px;  /* Reduced footer padding */
            background-color: #EE5B2A;
            color: white;
            position: absolute;
            width: 98.2%;
            bottom: 0;
        }
    </style>
</head>
<body>

    <h1>ASTAAN TV SUBSCRIPTION SYSTEM</h1>

    <!-- Logo Image under header -->
    <img src="images/logo.png" alt="ASTAAN TV Logo" class="logo"> <!-- Make sure to adjust the logo path -->

    <div class="login-container">
        <h2>Login</h2>

        <!-- Display error message if login fails -->
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <input type="submit" value="Login">
        </form>
    </div>

    <footer>
        <p>&copy; 2025 ASTAAN TV SUBSCRIPTION SYSTEM. All Rights Reserved (Sacad).</p>
    </footer>
</body>
</html>
