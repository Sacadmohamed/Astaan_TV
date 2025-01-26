<?php
// Start session
session_start();
include('config.php');

// Ensure the user is an admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Handle adding a new subscriber
if (isset($_POST['add_subscriber'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, 'user')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $hashed_password, $email);
    $stmt->execute();
    $stmt->close();
}

// Handle deleting a subscriber
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id = ? AND role = 'user'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_subscribers.php");
    exit();
}

// Fetch all subscribers
$sql = "SELECT * FROM users WHERE role = 'user'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Subscribers</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        /* Header Styling */
        h1 {
            text-align: center;
            background-color: #EE5B2A;
            color: white;
            padding: 20px;
            margin: 0;
        }

        /* Navigation Bar Styling */
        nav {
            background-color: #F97A50;
            padding: 10px 0;
            text-align: center;
        }

        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
        }

        nav a:hover {
            background-color: #c04b23;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #EE5B2A;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        .btn {
            background-color: #EE5B2A;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #c04b23;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 30px;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #EE5B2A;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #c04b23;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <h1>Manage Subscribers</h1>

    <!-- Navigation Bar Below Header -->
    <nav>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="manage_subscriptions.php">Manage Subscriptions</a>
        <a href="manage_subscribers.php">Manage Subscribers</a>
        <a href="channel_services.php">Channel Services</a>
    </nav>

    <!-- Subscriber Management Content Section -->
    <div class="container">
        <!-- Add Subscriber Form -->
        <div class="form-container">
            <h2>Add New Subscriber</h2>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="add_subscriber">Add Subscriber</button>
            </form>
        </div>

        <!-- Subscribers Table -->
        <h2>Subscribers List</h2>
        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><a href="manage_subscribers.php?delete=<?php echo $row['id']; ?>" class="btn">Delete</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>

<?php $conn->close(); ?>
