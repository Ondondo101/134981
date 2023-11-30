<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DELI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="landing.css">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
  />
  <!-- Google Font -->
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap"
    rel="stylesheet"
  />

</head>
<body>
    <header>
        <nav>
          <a href="landing.php">
            <div class="logo">
                <img src="deli.png" alt="Company Logo">
            </div>
        </a>
        
        


            <form method="get" action="track.php" class="package-tracking-form">
            <label for="tracking-id"></label>
            <input type="text" name="tracking-id" id="tracking-id" placeholder="Enter your tracking ID" required>
            <button type="submit">Track</button>
            </form>

            <ul class="nav-links">
                <li><a href="login.php">Login</a></li>
             
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>
    
    <section class="hero">
        <div class="container">
            <h1>Consolidate Deliveries.</h1>
            <h1>Save Money.</h1>
            <p>Deliver with Speed and Precision.</p>
            <p>More Opportunities for SME's operating physically and online to scale effortlessly and affordably.</p>
            <a href="Signup.php" class="cta-button">Get Started</a>
        </div>
    </section>
    <!-- Add this section after the existing content -->
<section class="services">
    <div class="container">
        <h2>Discover Our Services</h2>
        <div class="row">
            <!-- Card 1: Save on Delivery Cost -->
            <div class="column">
                <div class="card">
                    <div class="icon-wrapper">
                        <!-- Add an icon or image for the service -->
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h3>Save on Delivery Cost</h3>
                    <p>Give your customers more convenience with our network of 150+ safe parcel collection points.</p>
                </div>
            </div>

            <!-- Card 2: Doorstep Delivery -->
            <div class="column">
                <div class="card">
                    <div class="icon-wrapper">
                        <!-- Add an icon or image for the service -->
                        <i class="fas fa-truck"></i>
                    </div>
                    <h3>Doorstep Delivery</h3>
                    <p>Enjoy convenient door-to-door delivery at an affordable rate with our network of experienced riders.</p>
                </div>
            </div>

            <!-- Card 3: Rent a Shelf -->
            <div class="column">
                <div class="card">
                    <div class="icon-wrapper">
                        <!-- Add an icon or image for the service -->
                        <i class="fas fa-store"></i>
                    </div>
                    <h3>Track you package</h3>
                    <p>Relax and track your package in real Time at the comfort of your home.</p>
                </div>
            </div>

            <!-- Card 4: Errands Services -->
            <div class="column">
                <div class="card">
                    <div class="icon-wrapper">
                        <!-- Add an icon or image for the service -->
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Errands Services</h3>
                    <p>Save time with our errand services. We drop your parcels at your customer’s preferred SACCO or Courier Provider.</p>
                </div>
            </div>
        </div>
    </div>

    <br>
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
    
</body>
<footer>
    <?php include 'footer.html'; ?>
</footer>
</html>
