<?php

@include 'config.php';

session_start();

$session_email = $_SESSION['email'];

$select_user_details = " SELECT * FROM user_details WHERE email = '$session_email' ";
$result_user_details = mysqli_query($conn, $select_user_details);

if(mysqli_num_rows($result_user_details) > 0){

   $row = mysqli_fetch_array($result_user_details);
   $m_firstname = $row['first_name'];
   $m_lastname = $row['last_name'];
  
}

if(isset($_POST['search'])){


    $emailAddr = $_POST['email'];
 
    $select_user_details = " SELECT * FROM user_details WHERE email = '$emailAddr' ";
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

    $select_membership_details = " SELECT * FROM user_membership_details WHERE email = '$emailAddr' ";
$result_membership_details = mysqli_query($conn, $select_membership_details);

if(mysqli_num_rows($result_membership_details) > 0){

    $row = mysqli_fetch_array($result_membership_details);
    $membership_id = $row['m_id'];
    $membership_startdate = $row['m_start_date'];
    $membership_enddate = $row['m_end_date'];
    $membership_plan = $row['m_plan'];
   
 }

 echo '<style>#userHidForm{display: block !important;}</style>';
 echo '<style>#membershipHidForm{display: inline-block !important;}</style>';

 }

 if(isset($_POST['add'])){

    $uf_fullname = mysqli_real_escape_string($conn, $_POST['name_fullname']);
    $uf_email = mysqli_real_escape_string($conn, $_POST['name_email']);
    $uf_password = md5($_POST['name_password']);
    $uf_usertype = $_POST['name_usertype'];
 
    $insertToUserForm = "INSERT INTO user_form(name, email, password, user_type) VALUES('$uf_fullname','$uf_email','$uf_password','$uf_usertype')";
    mysqli_query($conn, $insertToUserForm);

    $ud_firstname = $_POST['name_firstname'];
    $ud_lastname = $_POST['name_lastname'];
    $ud_dob = $_POST['name_dob'];
    $ud_address = $_POST['name_address'];
    $ud_sex = $_POST['name_sex'];
    $ud_contactnumber = $_POST['name_contactnumber'];

    $insertToUserDetails = "INSERT INTO user_details(first_name, last_name, dob, address, gender, contact, email) VALUES('$ud_firstname','$ud_lastname','$ud_dob','$ud_address','$ud_sex','$ud_contactnumber','$uf_email')";
    mysqli_query($conn, $insertToUserDetails);

    $umd_id = $_POST['name_memid'];
    $umd_startdate = $_POST['name_memstartdate'];
    $umd_enddate = $_POST['name_memenddate'];
    $umd_plan = $_POST['name_memplan'];

    $insertToUserMemDetails = "INSERT INTO user_membership_details(m_id, m_start_date, m_end_date, m_plan, email) VALUES('$umd_id','$umd_startdate','$umd_enddate','$umd_plan', '$uf_email')";
    mysqli_query($conn, $insertToUserMemDetails);
 
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
        header("Location: manager_page.php#");
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
        header("Location: manager_page.php#");
        exit();
    } else {
        echo "Error responding to query: " . $conn->error;
    }
}

// Add a new appointment
if (isset($_POST['addblog'])) {
    $blogType = $_POST['name_blogtype'] ?? '';
    $date = $_POST['name_date'] ?? '';
    $title = $_POST['name_title'] ?? '';
    $description = $_POST['name_des'] ?? '';

    // File upload handling
    if (isset($_FILES['name_image']) && $_FILES['name_image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['name_image']['tmp_name'];
        $imageName = basename($_FILES['name_image']['name']);
        $uploadDir = 'uploads/'; // Ensure this folder exists and is writable
        $imagePath = $uploadDir . time() . '_' . $imageName;

        if (move_uploaded_file($imageTmpPath, $imagePath)) {
            // Insert into DB
            $stmt = $conn->prepare("INSERT INTO blog_posts (title, content, image, category, published_at) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $title, $description, $imagePath, $blogType, $date);

            if ($stmt->execute()) {
                echo "<script>alert('Blog added successfully!');</script>";
            } else {
                echo "Database error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "Image upload error.";
    }
}

?>



<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitZone | Manager Dashboard</title>
    <link
      rel="icon"
      type="image/x-icon"
      href="image/home/FitZone Logo Icon PNG.png"
    />
    <link rel="stylesheet" type="text/css" href="manager_page_style.css">
</head>
<body>
    <script>
    function addShow() {
        document.getElementById("addSection").style.display = 'block';
        document.getElementById("searchSection").style.display = 'none';
        document.getElementById("messageSection").style.display = 'none';
        document.getElementById("blogSection").style.display = 'none';
    }
    function searchShow() {
        document.getElementById("addSection").style.display = 'none';
        document.getElementById("searchSection").style.display = 'block';
        document.getElementById("messageSection").style.display = 'none';
        document.getElementById("blogSection").style.display = 'none';
    }

    function messageShow() {
        document.getElementById("addSection").style.display = 'none';
        document.getElementById("searchSection").style.display = 'none';
        document.getElementById("messageSection").style.display = 'block';
        document.getElementById("blogSection").style.display = 'none';
    }

    function blogShow() {
        document.getElementById("addSection").style.display = 'none';
        document.getElementById("searchSection").style.display = 'none';
        document.getElementById("messageSection").style.display = 'none';
        document.getElementById("blogSection").style.display = 'block';
    }
    </script>
    
    <div class="container">

        <!-- Sidebar Menu -->
        <aside class="sidebar">
            <div class="profile-section">
                <img src="image/profileimg.png" alt="Profile" class="profile-pic">
                <h2 class="username"><?php echo $m_firstname; ?> <?php echo $m_lastname;?> </h2>
            </div>
            <nav>
                <ul>
                    <li><a href="#" onclick="searchShow()">Search Members</a></li>
                    <li><a href="#" onclick="addShow()">Add Members</a></li>
                    <li><a href="#" onclick="messageShow()">Message</a></li>
                    <li><a href="#" onclick="blogShow()">Add Blogs</a></li>
                    <li><a href="logout_page.php">Log Out</a></li>
                    <li><img src="image/home/FitZone Logo PNG.png"></img></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <section class="main-content" id="searchSection">
            <!-- Profile Section -->
            <div class="profile-form">
            <form action="" method="post">
                <h3>Search Member</h3>
                <div class="form-group">
                    <label for="nickname">Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter Email of Member" required>
                </div>
                
                <input type="submit" name="search" value="Search" class="save-btn">
            </form>
            </div>

            <div class="profile-form-2" id="userHidForm" style="display: none">
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
                    <input type="text" id="dob" value="<?php echo $dob; ?>">
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
            <div class="profile-form-2" id="membershipHidForm" style="display: none">
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


        <!-- Main Content -->
        <section class="main-content" id="addSection" style="display: none">
            <!-- Profile Section -->

            <form action="" method="post">


            <div class="profile-form-3">
                <h3>Account Info</h3>
                <div class="form-group">
                    <label for="nickname">Full Name</label>
                    <input type="text" id="afullname" name="name_fullname" placeholder="Enter Full Name">
                </div>
                <div class="form-group">
                    <label for="nickname">Email</label>
                    <input type="text" id="aemail" name="name_email" placeholder="Enter Email">
                </div>
                <div class="form-group">
                    <label for="nickname">Password</label>
                    <input type="text" id="apassword" name="name_password" placeholder="Enter Password">
                </div>
                <div class="form-group">
                    <label for="select">User Type</label>
                    <select name="name_usertype"> 
                    <option value="user">user</option>
         <option value="admin">admin</option>
         <option value="manager">manager</option>
                        </select>         
                </div>
</div>
<div class="profile-form-3">
                <h3>Personal Info</h3>
                <div class="form-group">
                    <label for="nickname">First Name</label>
                    <input type="text" id="afname" name="name_firstname" placeholder="Enter First Name">
                </div>
                <div class="form-group">
                    <label for="email">Last Name</label>
                    <input type="text" id="alname" name="name_lastname" placeholder="Enter Last Name">
                </div>
                <div class="form-group">
                    <label for="email">Date Of Birth</label>
                    <input type="date" id="adob" name="name_dob" placeholder="Enter Date of Birth">
                </div>
                <div class="form-group">
                    <label for="email">Address</label>
                    <input type="text" id="aaddress" name="name_address" placeholder="Enter Address">
                </div>
                <div class="form-group">
                    <label for="select">Gender</label>
                    <select name="name_sex"> 
                    <option value="male">male</option>
         <option value="female">female</option>
                        </select>         
                </div>
                <div class="form-group">
                    <label for="email">Contact Number</label>
                    <input type="text" id="acnumber" name="name_contactnumber" placeholder="Enter Contact">
                </div>
</div>
<div class="profile-form-3">
                
                <h3>Membership Details</h3>
                <div class="form-group">
                    <label for="nickname">Membership Id</label>
                    <input type="text" id="amemberid" name="name_memid" placeholder="Enter Membership Id">
                </div>
                <div class="form-group">
                    <label for="email">Membership Start Date</label>
                    <input type="date" id="amemberstartdate" name="name_memstartdate" placeholder="Enter Start Date">
                </div>
                <div class="form-group">
                    <label for="email">Membership End Date</label>
                    <input type="date" id="amemberenddate" name="name_memenddate" placeholder="Enter Password">
                </div>
                <div class="form-group">
                    <label for="select">Plan Details</label>
                    <select name="name_memplan"> 
                        <option value="Beginner">Beginner</option>  
                        <option value="Average">Average</option>  
                        <option value="Expert">Expert</option>  
                        </select>         
                </div>


            </div>
            
            <input type="submit" name="add" value="Add Member" class="save-btn">
            </form>
            
        </section>
        
        <section class="main-content" id="messageSection" style="display: none">
            <!-- Add New Appointment Section -->
             <section class="addAp">
                <h2>Add New Appointment</h2>
                <form method="post">
                    <input type="text" name="customer_email" placeholder="Customer Email" required>
                    <input type="date" name="appointment_date" required>
                    <input type="time" name="appointment_time" required>
                    <button type="submit" name="add_appointment">Add Appointment</button>
                </form>
            </section>
            
            <!-- Appointments Section -->
             <section class="apTable">
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
             <section class="queries">
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
            </section>

            <!-- Add Blogs Section -->
            <section class="blog" id="blogSection" style="display: none">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="profile-form-3">
                        <h3>Add Blogs</h3>
                        <div class="form-group">
                            <label for="nickname">Image</label>
                            <input type="file" id="aimage" name="name_image" placeholder="Add Image">
                        </div>
                        <div class="form-group">
                            <label for="select">Blog Type</label>
                            <select name="name_blogtype"> 
                                <option value="workouts">Workouts</option>
                                <option value="nutrition">Nutrition</option>
                                <option value="holisticHealth">Holistic Health</option>
                            </select>         
                        </div>
                        <div class="form-group">
                            <label for="nickname">Date</label>
                            <input type="date" id="adate" name="name_date" placeholder="Add Date">
                        </div>
                        <div class="form-group">
                            <label for="nickname">Blog Title</label>
                            <input type="text" id="atitle" name="name_title" placeholder="Enter Blog Title">
                        </div>
                        <div class="form-group">
                            <label for="nickname">Description</label>
                            <input type="text" id="ades" name="name_des" placeholder="Enter Description">
                        </div>
                        <input type="submit" name="addblog" value="Add Blog" class="save-btn">
                    </div>
                </form>

            
            <div class="blog-contents">
            <?php

$sql = "SELECT * FROM blog_posts ORDER BY published_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Format the date as dd/mm/yyyy
        $formattedDate = date("d/m/Y", strtotime($row['published_at']));
        echo '
        <div class="article-card">
            <img src="' . $row['image'] . '" />
            <div class="category">
                <div class="subject"><h3>' . htmlspecialchars($row['category']) . '</h3></div>
                <span class="blog_date">' . $formattedDate . '</span>
            </div>
            <h2 class="article-title">' . htmlspecialchars($row['title']) . '</h2>
            <p class="article-desc">' . htmlspecialchars($row['content']) . '</p>
        </div>
        ';
    }
} else {
    echo "<p>No blog posts available.</p>";
}
?>
            </div>

            </section>

        </div>

    </body>
</html>
