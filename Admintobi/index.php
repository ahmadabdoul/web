<?php
session_start();

// Check if the admin is logged in, otherwise redirect to the login page
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Database configuration
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'porcode_db'; // Replace with your database name

// Create a database connection
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch the admin's username
$admin_username = '';
if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];

    $sql = "SELECT username FROM admin WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $admin_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $admin_username);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <!-- Include your CSS files here -->
    <link rel="stylesheet" href="styles/reset.min.css" />
    <link rel="stylesheet" href="styles/style.css" />
    <link rel="stylesheet" href="styles/admin-dashboard.css" />
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
</head>

<body>
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li class="active" onclick="showSection('user-management')">User Management</li>
            <li onclick="showSection('service-management')">Service Management</li>
            <li onclick="showSection('country-management')">Country Management</li>
            <li onclick="showSection('number-management')">Number Management</li>
            <li onclick="showSection('order-management')">View Orders</li>
            <li onclick="showSection('payment-management')">Payment Management</li>
            <li onclick="logout()">Logout</li>
        </ul>
    </div>
    <div class="main">
        <div class="admin-section">
            <h2>Welcome to the Admin Dashboard, <?php echo $admin_username; ?>!</h2>
            <div class="statistics">
                <div class="statistic">
                    <h3>Total Users</h3>
                    <p>1000</p>
                </div>
                <div class="statistic">
                    <h3>Active Users</h3>
                    <p>800</p>
                </div>
                <div class="statistic">
                    <h3>Inactive Users</h3>
                    <p>200</p>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="section user-management active">
                <!-- User Management section -->
                <h2>User Management</h2>
                <?php
                // Fetch user data from the database and populate the table
                $conn = mysqli_connect($hostname, $username, $password, $database);
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $sql = "SELECT id, username, email, role, status FROM users";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    echo '<table class="user-table">';
                    echo '<tr>';
                    echo '<th>ID</th>';
                    echo '<th>Name</th>';
                    echo '<th>Email</th>';
                    echo '<th>Role</th>';
                    echo '<th>Status</th>';
                    echo '<th>Actions</th>';
                    echo '</tr>';

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['username'] . '</td>';
                        echo '<td>' . $row['email'] . '</td>';
                        echo '<td>' . $row['role'] . '</td>';
                        echo '<td>' . $row['status'] . '</td>';
                        echo '<td>';
                        echo '<button>Edit</button>';
                        echo '<button>Delete</button>';
                        echo '</td>';
                        echo '</tr>';
                    }

                    echo '</table>';
                } else {
                    echo 'No users found.';
                }

                mysqli_close($conn);
                ?>
            </div>

            <!-- Add other sections here -->

        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>