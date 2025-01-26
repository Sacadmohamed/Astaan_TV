<?php
// Start session
session_start();
include('config.php');

// Ensure the user is an admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Handle adding a new channel service
if (isset($_POST['add_service'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $sql = "INSERT INTO channel_services (name, description, price) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $name, $description, $price);
    $stmt->execute();
    $stmt->close();
}

// Handle deleting a channel service
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM channel_services WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: channel_services.php");
    exit();
}

// Fetch all channel services
$sql = "SELECT * FROM channel_services";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Channel Services</title>
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

        input[type="text"], input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        textarea {
            height: 100px;
            resize: vertical;
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
    <h1>Manage Channel Services</h1>

    <!-- Navigation Bar Below Header -->
    <nav>
        <a href="index.php">Home</a>  <!-- Added Home Tab -->
        <a href="dashboard.php">Dashboard</a>
        <a href="manage_subscriptions.php">Manage Subscriptions</a>
        <a href="manage_subscribers.php">Manage Subscribers</a>
        <a href="channel_services.php">Channel Services</a>
    </nav>

    <!-- Channel Services Content Section -->
    <div class="container">
        <!-- Add Channel Service Form -->
        <div class="form-container">
            <h2>Add New Channel Service</h2>
            <form method="POST">
                <input type="text" name="name" placeholder="Service Name" required>
                <textarea name="description" placeholder="Description" required></textarea>
                <input type="number" step="0.01" name="price" placeholder="Price" required>
                <button type="submit" name="add_service">Add Service</button>
            </form>
        </div>

        <!-- Channel Services Table -->
        <h2>Channel Services List</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><a href="channel_services.php?delete=<?php echo $row['id']; ?>" class="btn">Delete</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>

<?php $conn->close(); ?>
