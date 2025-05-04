<?php
//databse con
@include 'config.php';

if(isset($_POST['submit'])){

$uf_name = mysqli_real_escape_string($conn, $_POST['full_name']);
$uf_email = mysqli_real_escape_string($conn, $_POST['email']);
$uf_message = mysqli_real_escape_string($conn, $_POST['cus_message']);

$insertToUserForm = "INSERT INTO contact_form(name, email, message) VALUES('$uf_name','$uf_email','$uf_message')";
   mysqli_query($conn, $insertToUserForm);
}
?>

<html>

<head>
<meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="cont.css">
    <title>FitZone | Contact</title>
   <link
      rel="icon"
      type="image/x-icon"
      href="image/home/FitZone Logo Icon PNG.png"
    />
</head>

<body>
<nav class="main-navbar">
          <div class="logo">
            <a href="http://localhost/fitzone/index.html">
              <img src="image/home/FitZone Logo PNG.png" />
            </a>
          </div>
          <ul class="nav-list">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#our_team">Trainers</a></li>
            <li><a href="#pricing">Prices</a></li>
            <li><a href="#blog">Blog</a></li>
          </ul>
          <a href="login_page.php" class="join-us-btn-wrapper">
            <button class="btn join-us-btn">Log In</button>
          </a>
          <a href="register_page.php" class="join-us-btn-wrapper">
            <button class="btn join-us-btn">Join Us</button>
          </a>
          <div class="hamburger-btn">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </nav>
    <section id="last">
        <!-- heading -->
        <div class="full">
            <h3>Drop a Message</h3>

            <div class="lt">
                <!-- form starting  -->
                <form class="form-horizontal" method="post" action="">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <!-- name  -->
                            <input type="text" class="form-control" id="name" placeholder="NAME" name="full_name" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <!-- email  -->
                            <input type="email" class="form-control" id="email" placeholder="EMAIL" name="email" required />
                        </div>
                    </div>

                    <!-- message  -->
                    <textarea class="form-control" rows="10" placeholder="MESSAGE" name="cus_message" required></textarea>

                    <button class="btn btn-primary send-button" id="submit" type="submit" name="submit">
                        <i class="fa fa-paper-plane"></i>
                        <span class="send-text">SEND</span>
                    </button>
                </form>
                <!-- end of form -->
            </div>

            <!-- Contact information -->
            <div class="rt">
                <ul class="contact-list">
                    <li class="list-item">
                        <i class="fa fa-map-marker fa-1x">
                            <span class="contact-text place">279, kandy Road, Kurunagala</span>
                        </i>
                    </li>

                    <li class="list-item">
                        <i class="fa fa-envelope fa-1x">
                            <span class="contact-text gmail">
                                <a href="mailto:yourmail@gmail.com" title="Send me an email">anjith@gmail.com</a>
                            </span>
                        </i>
                    </li>

                    <li class="list-item">
                        <i class="fa fa-phone fa-1x">
                            <span class="contact-text phone">(033) 2250944</span>
                        </i>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</body>
</html>
