<?php

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Contact Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="contactus.css">
  
	<!--Iconscout CDN-->
		<link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
		<link rel="stylesheet" href="./assets/css/contact.css">
		<link rel="stylesheet" href="./assets/css/style.css">

</head>
<body>
    <header>
    <nav>
            <div class="logo">
                <img src="deli.png" alt="Company Logo">
            </div>

            <form method="get" action="track.php" class="package-tracking-form">
            <label for="tracking-id"></label>
            <input type="text" name="tracking-id" id="tracking-id" placeholder="Enter your tracking ID" required>
            <button type="submit">Track</button>
            </form>

            <ul class="nav-links">
				<li><a href="landing.html">Home</a></li>
                <li><a href="login.php">Login</a></li>
				
            </ul>
        </nav>
    </header>
	<section class="contact">
		<div class="container contact__container">
			<aside class="contact__aside">
				<div class="aside__image">
					<img src="">
				</div>
				<h2>Contact Us</h2>
				<p>
					Experiencing issues? Feel free to contact us!
				</p>
				<ul class="contact__details">
					<li>
						<i class="uil uil-phone-times"></i>
						<h5>+254752052001</h5>
					</li>
					<li>
						<i class="uil uil-envelope"></i>
						<h5>Deli@gmail.com</h5>
					</li>
					<li>
						<i class="uil uil-location-point"></i>
						<h5>Nairobi, Kenya</h5>
					</li>
				</ul>
				<ul class="contact__socials">
					<li><a href="#"><i class="uil uil-facebook-f"></i></a></li>
					<li><a href="#"><i class="uil uil-instagram"></i></a></li>
					<li><a href="#"><i class="uil uil-twitter"></i></a></li>
					<li><a href="#"><i class="uil uil-linkedin"></i></a></li>
				</ul>
			</aside>

			<form action="https://formspree.io/f/mknydope" method="POST" class="contact__form">
				<div class="form__name">
					<input type="text" name="First Name" placeholder="First Name" required>
					<input type="text" name="Last Name" placeholder="Last Name" required>
				</div>
				<input type="email" name="email address" placeholder="Your Email Address" required>
				<textarea name="Message" rows="7" placeholder="Your Message Here" required></textarea>
				<button type="submit" class="btn btn-primary">Send Message</button>
			</form>

		</div>
	</section> 

    <footer>
            
            <p>&copy; 2023 Logistics & Courier</p>
        </footer>
</body>