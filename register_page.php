<?php

@include 'config.php';

if(isset($_POST['add'])){

   $uf_fullname = mysqli_real_escape_string($conn, $_POST['name_fullname']);
   $uf_email = mysqli_real_escape_string($conn, $_POST['name_email']);
   $uf_password = md5($_POST['name_password']);
   $uf_usertype = $_POST['name_usertype'];

   $select = " SELECT * FROM user_form WHERE email = '$uf_email' && password = '$uf_password' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'user already exist!';

   }else{

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
         header('location:login_page.php');

   }

   

}


?>

<html>
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>FitZone | Register</title>
   <link
      rel="icon"
      type="image/x-icon"
      href="image/home/FitZone Logo Icon PNG.png"
    />

   <!-- custom css file link  -->
   <link rel="stylesheet" type="text/css" href="login_page_style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Register Now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
<div class="profile-form-3">
                <h4 style="text-align: left;font-size:24px">Account Info</h4>
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
                        </select>         
                </div>
</div>
<div class="profile-form-3">
<h4 style="text-align: left;font-size:24px">Personal Info</h4>
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
                
<h4 style="text-align: left;font-size:24px">Membership Details</h4>
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
                    <input type="date" id="amemberenddate" name="name_memenddate" placeholder="Enter End Date">
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
      <p>already have an account? <a href="login_page.php">login now</a></p>
   </form>

</div>

</body>
</html>