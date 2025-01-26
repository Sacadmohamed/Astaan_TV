<?php
// Start session
session_start();
include('config.php');

// Ensure the user is an admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch Total Subscribers
$sql_subscribers = "SELECT COUNT(*) AS total_subscribers FROM users WHERE role = 'user'";
$result_subscribers = $conn->query($sql_subscribers);
$total_subscribers = $result_subscribers->fetch_assoc()['total_subscribers'];

// Fetch Total Channel Services
$sql_services = "SELECT COUNT(*) AS total_services FROM channel_services";
$result_services = $conn->query($sql_services);
$total_services = $result_services->fetch_assoc()['total_services'];

// Fetch Total Subscriptions (Assuming there is a 'subscriptions' table)
$sql_subscriptions = "SELECT COUNT(*) AS total_subscriptions FROM subscriptions";
$result_subscriptions = $conn->query($sql_subscriptions);
$total_subscriptions = $result_subscriptions->fetch_assoc()['total_subscriptions'];

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            background-color: #EE5B2A;
            color: white;
            padding: 20px;
            margin: 0;
        }

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

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .chart-container {
            width: 100%;
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }

        canvas {
            width: 30% !important; /* Adjusted to fit in the page */
            height: 250px !important; /* Adjusted size */
        }
    </style>
</head>
<body>

    <!-- Header -->
    <h1>Admin Dashboard</h1>

    <!-- Navigation Bar -->
    <nav>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="manage_subscriptions.php">Manage Subscriptions</a>
        <a href="manage_subscribers.php">Manage Subscribers</a>
        <a href="channel_services.php">Channel Services</a>
    </nav>

    <!-- Dashboard Content -->
    <div class="container">
        <h2>Dashboard Overview</h2>

        <!-- Display data as cards or numbers -->
        <div style="display: flex; justify-content: space-around; margin-bottom: 20px;">
            <div style="text-align: center; padding: 10px; background-color: #f9f9f9; border-radius: 8px; width: 30%;">
                <h3>Total Subscribers</h3>
                <p><?php echo $total_subscribers; ?></p>
            </div>
            <div style="text-align: center; padding: 10px; background-color: #f9f9f9; border-radius: 8px; width: 30%;">
                <h3>Total Channel Services</h3>
                <p><?php echo $total_services; ?></p>
            </div>
            <div style="text-align: center; padding: 10px; background-color: #f9f9f9; border-radius: 8px; width: 30%;">
                <h3>Total Subscriptions</h3>
                <p><?php echo $total_subscriptions; ?></p>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="chart-container">
            <!-- Subscribers Chart (Bar Chart) -->
            <canvas id="subscribersChart"></canvas>

            <!-- Channel Services Bar Chart -->
            <canvas id="servicesChart"></canvas>

            <!-- Subscriptions Bar Chart -->
            <canvas id="subscriptionsChart"></canvas>
        </div>
    </div>

    <script>
        // Data for Subscribers Chart (Bar Chart)
        const subscribersData = {
            labels: ['Subscribers'],
            datasets: [{
                label: 'Total Subscribers',
                data: [<?php echo $total_subscribers; ?>],
                backgroundColor: ['rgba(234, 90, 42, 0.6)'],
                borderColor: ['rgba(234, 90, 42, 1)'],
                borderWidth: 1
            }]
        };

        // Data for Channel Services Bar Chart
        const servicesData = {
            labels: ['Channel Services'],
            datasets: [{
                label: 'Total Channel Services',
                data: [<?php echo $total_services; ?>],
                backgroundColor: ['rgba(249, 122, 80, 0.6)'],
                borderColor: ['rgba(249, 122, 80, 1)'],
                borderWidth: 1
            }]
        };

        // Data for Subscriptions Bar Chart
        const subscriptionsData = {
            labels: ['Subscriptions'],
            datasets: [{
                label: 'Total Subscriptions',
                data: [<?php echo $total_subscriptions; ?>],
                backgroundColor: ['rgba(123, 123, 255, 0.6)'],
                borderColor: ['rgba(123, 123, 255, 1)'],
                borderWidth: 1
            }]
        };

        // Create Subscribers Bar Chart
        const ctx1 = document.getElementById('subscribersChart').getContext('2d');
        const subscribersChart = new Chart(ctx1, {
            type: 'bar',
            data: subscribersData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Create Channel Services Bar Chart
        const ctx2 = document.getElementById('servicesChart').getContext('2d');
        const servicesChart = new Chart(ctx2, {
            type: 'bar',
            data: servicesData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Create Subscriptions Bar Chart
        const ctx3 = document.getElementById('subscriptionsChart').getContext('2d');
        const subscriptionsChart = new Chart(ctx3, {
            type: 'bar',
            data: subscriptionsData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>
</html>
