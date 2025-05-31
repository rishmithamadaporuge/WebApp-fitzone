<?php

@include 'config.php';

session_start();

$logoutMessage = '';
if (isset($_SESSION['logout_message'])) {
    $logoutMessage = $_SESSION['logout_message'];
    unset($_SESSION['logout_message']); // Show it only once
}

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);

   $select = "SELECT * FROM user_form WHERE email = '$email' AND password = '$pass'";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

      $_SESSION['user_name'] = $row['name'];
      $_SESSION['email'] = $row['email'];
      $_SESSION['login_success'] = "Welcome, " . $row['name'] . "!";

      if($row['user_type'] == 'manager'){
         header('location:manager_page.php');
      } elseif($row['user_type'] == 'user'){
         header('location:home2.php');
      } elseif($row['user_type'] == 'admin'){
         header('location:admin_page.php');
      }

   } else {
      $error[] = 'incorrect email or password!';
   }
}


?>
<html>
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>FitZone | Login</title>
   <link rel="icon" type="image/x-icon" href="image/home/FitZone Logo Icon PNG.png" />
   <link rel="stylesheet" type="text/css" href="login_page_style.css">
</head>
<body>

<div class="form-container">
   <form action="" method="post">
      <h3>login now</h3>
      <?php
      if(isset($error)){
         foreach($error as $errorMsg){
            echo '<span class="error-msg">'.$errorMsg.'</span>';
         }
      }
      ?>
      <input type="email" name="email" required placeholder="enter your email">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="submit" name="submit" value="login now" class="form-btn">
      <p>Don't have an account? <a href="register_page.php">register now</a></p>
   </form>
</div>

<?php if (!empty($logoutMessage)) : ?>
  <div id="logoutModal" style="
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9999;
  ">
    <div style="
        background: white;
        padding: 20px 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px #000;
        text-align: center;
    ">
      <h2><?php echo $logoutMessage; ?></h2>
      <button onclick="document.getElementById('logoutModal').style.display='none'">OK</button>
    </div>
  </div>
<?php endif; ?>


</body>
</html>
