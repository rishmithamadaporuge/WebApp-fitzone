<?php

//database con
@include 'config.php';

session_start();

$session_email = $_SESSION['email'];

//select table
$select_user_details = " SELECT * FROM user_details WHERE email = '$session_email' ";
$result_user_details = mysqli_query($conn, $select_user_details);

if(mysqli_num_rows($result_user_details) > 0){

   $row = mysqli_fetch_array($result_user_details);
   $m_firstname = $row['first_name'];
   $m_lastname = $row['last_name'];
  
}

//search member
if(isset($_POST['search'])){


    $emailAddr = $_POST['email'];

 //select table
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

 //display data
 echo '<style>#userHidForm{display: block !important;}</style>';
 echo '<style>#membershipHidForm{display: inline-block !important;}</style>';

 }


 //add member
 if(isset($_POST['add'])){

    $uf_fullname = mysqli_real_escape_string($conn, $_POST['name_fullname']);
    $uf_email = mysqli_real_escape_string($conn, $_POST['name_email']);
    $uf_password = md5($_POST['name_password']);
    $uf_usertype = $_POST['name_usertype'];

 //insert table
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

 //delete member
 if(isset($_POST['delete'])){

    $delete_email = mysqli_real_escape_string($conn, $_POST['delete_email']);
    
 //delete table data
    $deleteFromUserForm = "DELETE FROM user_form WHERE email='$delete_email'";
    mysqli_query($conn, $deleteFromUserForm);

    $deleteFromUserDetails = "DELETE FROM user_details WHERE email='$delete_email'";
    mysqli_query($conn, $deleteFromUserDetails);

    $deleteFromUserMemDetails = "DELETE FROM user_membership_details WHERE email='$delete_email'";
    mysqli_query($conn, $deleteFromUserMemDetails);
 
 }

?>



<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitZone | Admin Dashboard</title>
    <link
      rel="icon"
      type="image/x-icon"
      href="image/home/FitZone Logo Icon PNG.png"
    />
    <link rel="stylesheet" type="text/css" href="admin_page_style.css">
</head>
<body>
    
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
                    <li><a href="#" onclick="deleteShow()">Delete Members</a></li>
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
                
                <input type="submit" name="search" value="Search Member" class="save-btn">
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

        <section class="main-content" id="deleteSection" style="display: none">
            <!-- Profile Section -->
            <div class="profile-form">
            <form action="" method="post">
                <h3>Delete Member</h3>
                <div class="form-group">
                    <label for="nickname">Email</label>
                    <input type="text" id="email" name="delete_email" placeholder="Enter Email of Member" required>
                </div>
                
                <input type="submit" name="delete" value="Delete Member" class="save-btn">
            </form>
            </div>
</section>
    </div>
</body>

<script>
    function addShow() {
        document.getElementById("addSection").style.display = 'inline-block';
        document.getElementById("searchSection").style.display = 'none';
        document.getElementById("deleteSection").style.display = 'none';
    }
    function searchShow() {
        document.getElementById("addSection").style.display = 'none';
        document.getElementById("deleteSection").style.display = 'none';
        document.getElementById("searchSection").style.display = 'flex';
    }
    function deleteShow() {
        document.getElementById("addSection").style.display = 'none';
        document.getElementById("searchSection").style.display = 'none';
        document.getElementById("deleteSection").style.display = 'inline-block';
    }
</script>
</html>
