<?php
//database con
@include 'config.php';

session_start();

$session_email = $_SESSION['email'];

$select_user_details = " SELECT * FROM user_details WHERE email = '$session_email' ";
$result_user_details = mysqli_query($conn, $select_user_details);

if(mysqli_num_rows($result_user_details) > 0){

   $row = mysqli_fetch_array($result_user_details);
   $firstname = $row['first_name'];
   $lastname = $row['last_name'];
   $dob = $row['dob'];
   $address = $row['address'];
   $gender = $row['gender'];
   $contact= $row['contact'];
   $email = $row['email'];
  
}

$select_membership_details = " SELECT * FROM user_membership_details WHERE email = '$session_email' ";
$result_membership_details = mysqli_query($conn, $select_membership_details);

if(mysqli_num_rows($result_membership_details) > 0){

    $row = mysqli_fetch_array($result_membership_details);
    $membership_id = $row['m_id'];
    $membership_startdate = $row['m_start_date'];
    $membership_enddate = $row['m_end_date'];
    $membership_plan = $row['m_plan'];
   
 }

 $customer_name = "user"; // Replace with session info or dynamic value
$appointments = $conn->query("SELECT * FROM appointments WHERE customer_email = '$session_email'");

// Fetch customer queries and responses
$queries = $conn->query("SELECT * FROM queries WHERE customer_email = '$session_email' ORDER BY id DESC");

// Handle query submission
if (isset($_POST['submit_query'])) {
    $query_text = $_POST['query_text'];
    $conn->query("INSERT INTO queries (customer_email, query_text, status) VALUES ('$session_email', '$query_text', 'Pending')");
    header("Location: customer_page.php");
    exit();
}

?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitZone | Dashboard</title>
    <link
      rel="icon"
      type="image/x-icon"
      href="image/home/FitZone Logo Icon PNG.png"
    />
    <link rel="stylesheet" type="text/css" href="customer_page_style.css">
</head>
<body>

<script>
    function profileShow() {
        document.getElementById("profileSection").style.display = 'flex';
        document.getElementById("passwordSection").style.display = 'none';
        document.getElementById("messageSection").style.display = 'none';
    }
    function passwordShow() {
        document.getElementById("profileSection").style.display = 'none';
        document.getElementById("passwordSection").style.display = 'block';
        document.getElementById("messageSection").style.display = 'none';
    }

    function messageShow() {
        document.getElementById("profileSection").style.display = 'none';
        document.getElementById("passwordSection").style.display = 'none';
        document.getElementById("messageSection").style.display = 'block';
    }
    </script>
    
    <div class="container">

        <!-- Sidebar Menu -->
        <aside class="sidebar">
            <div class="profile-section">
                <img src="image/profileimg.png" alt="Profile" class="profile-pic">
                <h2 class="username"><?php echo $firstname; ?> <?php echo $lastname;?> </h2>
            </div>
            <nav>
                <ul>
                    <li><a href="#" onclick="profileShow()">Profile Details</a></li>
                    <!-- <li><a href="#" onclick="passwordShow()">Change Password</a></li> -->
                    <li><a href="#" onclick="messageShow()">Message</a></li>
                    <li><a href="home2.php">Back</a></li>
                    <li><img src="image/home/FitZone Logo PNG.png"></img></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <section class="main-content" id="profileSection">
            <!-- Profile Section -->
            <div class="profile-form">
                <h3>Personal Info</h3>
                <div class="form-group">
                    <label for="nickname">First Name</label>
                    <input type="text" id="fname" value="<?php echo $firstname; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Last Name</label>
                    <input type="text" id="lname" value="<?php echo $lastname; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Date Of Birth</label>
                    <input type="date" id="dob" value="<?php echo $dob; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Address</label>
                    <input type="text" id="address" value="<?php echo $address; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Gender</label>
                    <input type="text" id="sex" value="<?php echo $gender; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Contact Number</label>
                    <input type="text" id="cnumber" value="<?php echo $contact; ?>">
                </div>

                <button class="save-btn">Update Details</button>
            </div>

            <!-- Profile Section -->
            <div class="profile-form">
                <h3>Membership Details</h3>
                <div class="form-group">
                    <label for="nickname">Membership Id</label>
                    <input type="text" id="memberid" value="<?php echo $membership_id; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Membership Start Date</label>
                    <input type="date" id="memberstartdate" value="<?php echo $membership_startdate; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Membership End Date</label>
                    <input type="date" id="memberenddate" value="<?php echo $membership_enddate; ?>">
                </div>
                <div class="form-group">
                    <label for="select">Plan Details</label>
                    <select> 
                        <option><?php echo $membership_plan; ?></option>  
                        
                        </select>         
                </div>

                <button class="save-btn">Update Details</button>
            </div>

        </section>

        <section class="main-content" id="passwordSection" style="display: none">
        </section>

        <section class="main-content" id="messageSection" style="display: none">
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
                </section>
            </div>
        </body>
</html>
