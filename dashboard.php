<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all appointments
$appointments = $conn->query("SELECT * FROM appointments ORDER BY appointment_date, appointment_time");

// Fetch pending customer queries
$queries = $conn->query("SELECT * FROM queries WHERE status = 'Pending'");

// Update appointment status
if (isset($_POST['update_status'])) {
    $appointment_id = $_POST['appointment_id'];
    $status = $_POST['status'];
    if ($conn->query("UPDATE appointments SET status='$status' WHERE id=$appointment_id")) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error updating appointment: " . $conn->error;
    }
}

// Respond to a query
if (isset($_POST['respond'])) {
    $query_id = $_POST['query_id'];
    $response = $_POST['response'];
    if ($conn->query("UPDATE queries SET response='$response', status='Answered' WHERE id=$query_id")) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error responding to query: " . $conn->error;
    }
}

// Add a new appointment
if (isset($_POST['add_appointment'])) {
    $customer_email = $_POST['customer_email'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $status = "Pending"; // Default status

    if ($conn->query("INSERT INTO appointments (customer_email, appointment_date, appointment_time, status) VALUES ('$customer_email', '$appointment_date', '$appointment_time', '$status')")) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error adding appointment: " . $conn->error;
    }
}

// Delete an appointment
if (isset($_POST['delete_appointment'])) {
    $appointment_id = $_POST['appointment_id'];
    if ($conn->query("DELETE FROM appointments WHERE id=$appointment_id")) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error deleting appointment: " . $conn->error;
    }
}

$conn->close();
?>


<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Dashboard</title>
    <link rel="stylesheet" href="dashboad.css">

</head>
<body>
    <h1>Management Dashboard</h1>

    <!-- Add New Appointment Section -->
    <section>
        <h2>Add New Appointment</h2>
        <form method="post">
            <input type="text" name="customer_email" placeholder="Customer Email" required>
            <input type="date" name="appointment_date" required>
            <input type="time" name="appointment_time" required>
            <button type="submit" name="add_appointment">Add Appointment</button>
        </form>
    </section>

    <!-- Appointments Section -->
    <section>
        <h2>Appointments</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Update Status</th>
                <th>Delete</th>
            </tr>
            <?php while($row = $appointments->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['customer_email'] ?></td>
                    <td><?= $row['appointment_date'] ?></td>
                    <td><?= $row['appointment_time'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="appointment_id" value="<?= $row['id'] ?>">
                            <select name="status">
                                <option value="Pending">Pending</option>
                                <option value="Confirmed">Confirmed</option>
                                <option value="Canceled">Canceled</option>
                            </select>
                            <button type="submit" name="update_status">Update</button>
                        </form>
                    </td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="appointment_id" value="<?= $row['id'] ?>">
                            <button type="submit" name="delete_appointment" onclick="return confirm('Are you sure you want to delete this appointment?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <!-- Pending Queries Section -->
    <section>
        <h2>Pending Queries</h2>
        <table>
            <tr>
                <th>Customer</th>
                <th>Query</th>
                <th>Response</th>
                <th>Action</th>
            </tr>
            <?php while($row = $queries->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['customer_email'] ?></td>
                    <td><?= $row['query_text'] ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="query_id" value="<?= $row['id'] ?>">
                            <textarea name="response" rows="2" placeholder="Type your response here..."></textarea>
                            <button type="submit" name="respond">Send Response</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>
</body>
</html>
