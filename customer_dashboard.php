<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

session_start();

$session_email = $_SESSION['email'];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch appointments for a specific customer
$customer_name = "user"; // Replace with session info or dynamic value
$appointments = $conn->query("SELECT * FROM appointments WHERE customer_email = '$session_email'");

// Fetch customer queries and responses
$queries = $conn->query("SELECT * FROM queries WHERE customer_email = '$session_email' ORDER BY id DESC");

// Handle query submission
if (isset($_POST['submit_query'])) {
    $query_text = $_POST['query_text'];
    $conn->query("INSERT INTO queries (customer_email, query_text, status) VALUES ('$session_email', '$query_text', 'Pending')");
    header("Location: customer_dashboard.php");
    exit();
}

$conn->close();
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="dashboad.css">
</head>
<body>
    <h1><a href="http://localhost/fitzone/customer_page.php"><img src="image/back.png" alt=""></a> Customer Dashboard</h1>

    <!-- Appointments Section -->
    <section>
        <h2>Your Appointments</h2>
        <table>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
            <?php while($row = $appointments->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['appointment_date'] ?></td>
                    <td><?= $row['appointment_time'] ?></td>
                    <td><?= $row['status'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <!-- Submit New Query Section -->
    <section>
        <h2>Submit a Query</h2>
        <form method="post">
            <textarea name="query_text" rows="4" placeholder="Type your query here..."></textarea>
            <button type="submit" name="submit_query">Submit Query</button>
        </form>
    </section>

    <!-- View Previous Queries and Responses Section -->
    <section>
        <h2>Your Queries and Responses</h2>
        <table>
            <tr>
                <th>Query</th>
                <th>Response</th>
                <th>Status</th>
            </tr>
            <?php while($row = $queries->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['query_text'] ?></td>
                    <td><?= $row['response'] ?: 'No response yet' ?></td>
                    <td><?= $row['status'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>
</body>
</html>
