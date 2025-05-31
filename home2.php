<?php

@include 'config.php';

session_start();

$session_email = $_SESSION['email'];

$select_user_details = " SELECT * FROM user_details WHERE email = '$session_email' ";
$result_user_details = mysqli_query($conn, $select_user_details);

$loginMessage = '';
if (isset($_SESSION['login_success'])) {
    $loginMessage = $_SESSION['login_success'];
    unset($_SESSION['login_success']); // show message only once
}

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
    header("Location: customer_dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
  <head>
    <!--  *****   Link To Custom CSS Style Sheet   *****  -->
    <link rel="stylesheet" type="text/css" href="style.css" />

    <!--  *****   Link To Font Awsome Icons   *****  -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    />

    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <title>FitZone</title>
    <link
      rel="icon"
      type="image/x-icon"
      href="image/home/FitZone Logo Icon PNG.png"
    />
  </head>
  <body>
    <!--   *** Website Wrapper Starts ***   -->
    <div class="website-wrapper">
      <!--   *** Home Section Starts ***   -->
      <section class="home" id="home">
        <div class="home-overlay"></div>
        <!--   === Main Navbar Starts ===   -->
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
          <a class="profile" href="customer_page.php" class="join-us-btn-wrapper">
            <img src="image/profileimg.png" alt="" style="width: 40px" />
            <?php echo $firstname; ?> <?php echo $lastname;?>
          </a>
          <a href="logout_page.php" class="join-us-btn-wrapper">
            <button class="btn join-us-btn">Logout</button>
          </a>
          <div class="hamburger-btn">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </nav>
        <!--   === Main Navbar Ends ===   -->
        <!--   === Banner Starts ===   -->
        <div class="banner">
          <div class="banner-contents">
            <h2>Start your training at FitZone Fitness Center</h2>
            <h1>Fit body needs more training</h1>
            <p>
              At our gym, we believe in the power of persistence and discipline.
              Every workout brings you closer to your goals. No excuses, just
              results. Push beyond your limits, embrace the grind, and transform
              your body and mind. Stronger every day, fueled by effort and a
              commitment to greatness
            </p>
            <!-- <button class="btn read-more-btn">Read More</button> -->
          </div>
        </div>
        <!--   === Banner Ends ===   -->
      </section>
      <!--   *** Home Section Ends ***   -->

      <!--   *** Facilities Section Starts ***   -->
      <section class="facilities">
        <div class="facilities-contents">
          <div class="facility-item">
            <div class="facility-icon">
              <i class="fa-solid fa-dumbbell"></i>
            </div>
            <div class="facility-desc">
              <h2>Quality Equipment</h2>
              <p>
                Train with precision and confidence using our premium,
                state-of-the-art equipment, designed to elevate your workouts
                and maximize results
              </p>
            </div>
          </div>

          <div class="facility-item">
            <div class="facility-icon">
              <i class="fa-solid fa-wifi"></i>
            </div>
            <div class="facility-desc">
              <h2>Free Wifi</h2>
              <p>
                Stay connected while you train! Enjoy free Wi-Fi throughout the
                gym, keeping you online and motivated during every workout
              </p>
            </div>
          </div>

          <div class="facility-item">
            <div class="facility-icon">
              <i class="fa-solid fa-person-swimming"></i>
            </div>
            <div class="facility-desc">
              <h2>Swimming Pool</h2>
              <p>
                Dive into fitness with our full-size swimming pool, perfect for
                laps, aquatic workouts, or a refreshing post-workout cool down
              </p>
            </div>
          </div>
        </div>
      </section>
      <!--   *** Facilities Section Ends ***   -->

      <!--   *** About Section Starts ***   -->
      <section class="about" id="about">
        <div class="about-contents">
          <div class="about-left-col">
            <img src="image/about/about.jpg" />
          </div>

          <div class="about-right-col">
            <h4>About Us</h4>
            <h1>Best Facilities and Experienced Trainers</h1>
            <p>
              Our gym offers top-notch facilities, from a fully-equipped fitness
              center to a swimming pool. With expert trainers guiding you,
              experience personalized coaching and achieve your fitness goals
              faster and more effectively.
            </p>
            <div class="about-states">
              <div class="about-state about-state-1">
                <i class="fa-solid fa-person"></i>
                <h2>Best Trainers</h2>
              </div>
              <div class="about-state about-state-2">
                <i class="fa-solid fa-medal"></i>
                <h2>Award Winning</h2>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--   *** About Section Ends ***   -->

      <!--   *** Services Section Starts ***   -->
      <section class="services" id="services">
        <!--   === Services Header Starts ===   -->
        <header class="section-header">
          <h3>Services</h3>
          <h1>Services Which We Offer</h1>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </header>
        <!--   === Services Header Ends ===   -->

        <!--   === Services Contents Starts ===   -->
        <div class="services-contents">
          <div class="service-box">
            <div class="service-icon-box">
              <i class="fa-solid fa-dumbbell"></i>
            </div>
            <div class="service-desc">
              <h2>Body Building</h2>
              <p>
                We offer comprehensive services including bodybuilding, fitness
                training, boxing, and Crossfit, designed to meet all your
                strength and conditioning needs.
              </p>
            </div>
          </div>

          <div class="service-box">
            <div class="service-icon-box">
              <i class="fa-solid fa-person-walking"></i>
            </div>
            <div class="service-desc">
              <h2>Fitness</h2>
              <p>
                Elevate your strength and physique with our bodybuilding
                program, focusing on personalized training, nutrition guidance,
                and progressive overload for optimal results.
              </p>
            </div>
          </div>

          <div class="service-box">
            <div class="service-icon-box">
              <i class="fa-solid fa-weight-hanging"></i>
            </div>
            <div class="service-desc">
              <h2>Boxing</h2>
              <p>
                Experience the intensity of boxing with our dynamic classes,
                focusing on technique, strength, and conditioning to enhance
                your skills and fitness.
              </p>
            </div>
          </div>

          <div class="service-box">
            <div class="service-icon-box">
              <i class="fa-solid fa-dumbbell"></i>
            </div>
            <div class="service-desc">
              <h2>Crossfit</h2>
              <p>
                Join our CrossFit program for high-intensity workouts that
                combine strength, cardio, and functional movements, designed to
                build endurance and overall fitness.
              </p>
            </div>
          </div>
        </div>
        <!--   === Services Contents Ends ===   -->
      </section>
      <!--   *** Services Section Ends ***   -->

      <!--   *** Offer Section Starts ***   -->
      <section class="offer">
        <div class="offer-overlay"></div>
        <div class="offer-contents">
          <h1>Start Your Training Today</h1>
        </div>
      </section>
      <!--   *** Offer Section Ends ***   -->

      <!--   *** Team Section Starts ***   -->
      <section class="our-team" id="our_team">
        <!--   === Team Header Starts ===   -->
        <header class="section-header">
          <h3>Our Trainers</h3>
          <h1>Meet Our Experienced Trainers</h1>
          <p>
            Meet our experienced trainers, dedicated to guiding you with
            personalized workouts, expert advice, and motivation to achieve your
            fitness goals.
          </p>
        </header>
        <!--   === Team Header Ends ===   -->
        <!--   === Team Contents Starts ===   -->
        <div class="team-contents">
          <div class="trainer-card">
            <div class="trainer-image">
              <img src="image/trainers/trainer2.png" />
            </div>
            <div class="trainer-desc">
              <h2>David Bekam</h2>
              <p>Muscles Trainer</p>
            </div>
            <div class="trainer-contact">
              <a href="https://web.facebook.com/"
                ><i class="fa-brands fa-facebook-f"></i
              ></a>
              <a href="https://x.com/"><i class="fa-brands fa-twitter"></i></a>
              <a href="https://www.instagram.com/"
                ><i class="fa-brands fa-instagram"></i
              ></a>
            </div>
          </div>

          <div class="trainer-card">
            <div class="trainer-image">
              <img src="image/trainers/trainer1.png" />
            </div>
            <div class="trainer-desc">
              <h2>Ema Watson</h2>
              <p>Boxing Trainer</p>
            </div>
            <div class="trainer-contact">
              <a href="https://web.facebook.com/"
                ><i class="fa-brands fa-facebook-f"></i
              ></a>
              <a href="https://x.com/"><i class="fa-brands fa-twitter"></i></a>
              <a href="https://www.instagram.com/"
                ><i class="fa-brands fa-instagram"></i
              ></a>
            </div>
          </div>

          <div class="trainer-card">
            <div class="trainer-image">
              <img src="image/trainers/trainer4.png" />
            </div>
            <div class="trainer-desc">
              <h2>Chanaka Roshen</h2>
              <p>Fitness Trainer</p>
            </div>
            <div class="trainer-contact">
              <a href="https://web.facebook.com/"
                ><i class="fa-brands fa-facebook-f"></i
              ></a>
              <a href="https://x.com/"><i class="fa-brands fa-twitter"></i></a>
              <a href="https://www.instagram.com/"
                ><i class="fa-brands fa-instagram"></i
              ></a>
            </div>
          </div>
        </div>
        <!--   === Team Contents Ends ===   -->
      </section>
      <!--   *** Team Section Ends ***   -->

      <!--   *** Blog Section Starts ***   -->
      <section class="blog" id="blog">
        <!--   === Blog Header Starts ===   -->
        <header class="section-header">
          <h3>Our Blog</h3>
          <h1>Latest From Our Blog</h1>
          <p>
            Stay informed and inspired with our blogs, covering fitness tips,
            nutrition advice, workout routines, and success stories to support
            your wellness journey.
          </p>
        </header>
        <!--   === Blog Header Ends ===   -->

        <!--   === Blog Contents Starts ===   -->
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
        <!--   === Blog Contents Ends ===   -->
        <div class="view-more-btn-container">
          <a href="food.html">
            <button class="btn articles-view-btn">View More</button>
          </a>
        </div>
      </section>
      <!--   *** Blog Section Ends ***   -->

      <!--   *** Footer Section Starts ***   -->
      <section class="page-footer">
        <!--   === Footer Contents Starts ===   -->
        <div class="footer-contents">
          <div class="footer-col footer-col-1">
            <div class="footer-col-title">
              <h3>About</h3>
            </div>
            <div class="footer-col-desc">
              <p>
                At FitZone Fitness Center, we empower individuals to achieve
                their fitness goals through expert guidance, diverse programs,
                and a supportive community dedicated to transforming bodies and
                enhancing overall well-being.
              </p>

              <span>279 Kandy Road, Kurunagala, Sri Lanka</span>
              <span>076 3240577</span>
              <span>udnsachi@gmail.com</span>
              <div class="footer-social-media">
                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
              </div>
            </div>
          </div>

          <div class="footer-col footer-col-2">
            <div class="footer-col-title">
              <h3>Quick Links</h3>
            </div>
            <div class="footer-col-desc">
              <a href="#">Home</a>
              <a href="#">About</a>
              <a href="#">Services</a>
              <a href="#">Trainers</a>
              <a href="#">Pricing</a>
              <a href="#">Blog</a>
            </div>
          </div>

          <div class="footer-col footer-col-3">
            <div class="footer-col-title">
              <h3>Newsletter</h3>
            </div>
            <div class="footer-col-desc">
              <p>
                Stay updated with the latest fitness tips, nutrition advice, and
                exclusive offers! Subscribe to our newsletter for weekly
                insights and inspiration to help you on your fitness journey.
              </p>
              <form class="newsletter">
                <input type="email" placeholder="Your Email" />
              </form>
              <a href="cont.php" class="join-us-btn-wrapper">
                <button class="btn join-us-btn">Contact Us</button>
              </a>
            </div>
          </div>
        </div>
        <!--   === Footer Contents Ends ===   -->
      </section>
      <!--   *** Footer Section Ends ***   -->

      <!--   *** Copy Rights Starts ***   -->
      <div class="copy-rights">
        <p>&copy; 2024 FitZone Fitness Center. All rights reserved.</p>
      </div>
      <!--   *** Copy Rights Ends ***   -->
    </div>
    <!--   *** Website Wrapper Ends ***   -->

    <!--   *** Link To Custom Script File ***   -->
    <script type="text/javascript" src="script.js"></script>

        <?php if (!empty($loginMessage)) : ?>
  <div id="loginModal" style="
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
      <h2><?php echo $loginMessage; ?></h2>
      <button class="popupBtn" onclick="document.getElementById('loginModal').style.display='none'">OK</button>
    </div>
  </div>
<?php endif; ?>
  </body>
</html>
