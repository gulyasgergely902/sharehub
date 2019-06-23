<!DOCTYPE html>
<html lang="en">
	<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ShareHUB</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <link href="css/grayscale.min.css" rel="stylesheet">
	<link href="css/indexStyle.css" rel="stylesheet">
  </head>

  <body id="page-top">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
		<div class="container">
			<a class="navbar-brand js-scroll-trigger" href="#page-top">ShareHUB</a>
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				Menu
				<i class="fas fa-bars"></i>
			</button>
			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link js-scroll-trigger" href="#about">About</a>
					</li>
					<li class="nav-item">
						<a class="nav-link js-scroll-trigger" href="#projects">Features</a>
					</li>
					<li class="nav-item">
						<a class="nav-link js-scroll-trigger" href="#signup">Get started</a>
					</li>
					<li>
						<a class="nav-link" href="apiDoc.html" target="_blank">API Documentation</a>
					</li>
					<li class="nav-item">
						<?php
							session_start();
							if(isset($_SESSION['user'])){
								echo '<a class="nav-link" id="user" href="profile.php">Profile</a>';
							} else {
								echo '<a class="nav-link" id="user" href="signin.php">Sign-in</a>';
							}
						?>
					</li>
				</ul>
			</div>
		</div>
    </nav>

    <!-- Header -->
    <header class="masthead">
      <div class="container d-flex h-100 align-items-center">
        <div class="mx-auto text-center">
          <h1 class="mx-auto my-0 text-uppercase">ShareHUB</h1>
            <h2 class="text-white-50 mx-auto mt-2 mb-5">A free and easy way to share anything with your team</font></h2>
          <a href="#signup" class="btn btn-primary js-scroll-trigger">Get Started</a>
        </div>
      </div>
    </header>

    <!-- About Section -->
    <section id="about" class="about-section text-center">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <h2 class="text-white mb-4">What is ShareHUB?</h2>
            <p class="text-white-50">ShareHUB is a free service to aggregate and share files, documents or links from the internet with your team. Register an account today and get started!</p>
          </div>
        </div>
        <img src="img/laptop.png" class="img-fluid" alt="">
      </div>
    </section>

    <!-- Features Section -->
    <section id="projects" class="projects-section bg-light">
      <div class="container">

        <!-- Featured Feature Row -->
        <div class="row align-items-center no-gutters mb-4 mb-lg-5">
          <div class="col-xl-8 col-lg-7">
            <img class="img-fluid mb-3 mb-lg-0" src="img/bg-masthead-n.jpg" alt="">
          </div>
          <div class="col-xl-4 col-lg-5">
            <div class="featured-text text-center text-lg-left">
              <h4>ShareHUB</h4>
              <p class="text-black-50 mb-0">Share anything, anytime. ShareHUB</p>
            </div>
          </div>
        </div>

        <!-- Feature One Row -->
        <div class="row justify-content-center no-gutters mb-5 mb-lg-0">
          <div class="col-lg-6">
            <img class="img-fluid" src="img/sc1.jpg" alt="">
          </div>
          <div class="col-lg-6">
            <div class="bg-black text-center h-100 project">
              <div class="d-flex h-100">
                <div class="project-text w-100 my-auto text-center text-lg-left">
                  <h4 class="text-white">Adding Snippets</h4>
                  <p class="mb-0 text-white-50">Snippets are the things you share. Just fill in the gaps and add them to your HUB. It's easy!</p>
                  <hr class="d-none d-lg-block mb-0 ml-0">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Feature Two Row -->
        <div class="row justify-content-center no-gutters">
          <div class="col-lg-6">
            <img class="img-fluid" src="img/sc2.jpg" alt="">
          </div>
          <div class="col-lg-6 order-lg-first">
            <div class="bg-black text-center h-100 project">
              <div class="d-flex h-100">
                <div class="project-text w-100 my-auto text-center text-lg-right">
                  <h4 class="text-white">Link highlighting</h4>
                  <p class="mb-0 text-white-50">Never miss a link again! ShareHUB grabs the link from the text for better visibility!</p>
                  <hr class="d-none d-lg-block mb-0 mr-0">
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- Signup Section -->
    <section id="signup" class="signup-section">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-lg-8 mx-auto text-center">

					<i class="far fa-paper-plane fa-2x mb-2 text-white"></i>
					<h2 class="text-white mb-5">Sign-up to get started!</h2>

					<form action="register.php" method="post">
						<input type="text" class="form-control mr-0 mr-sm-2 mb-3 mb-sm-2" id="inputFname" name="inputFname" placeholder="First name"></br>
						<input type="text" class="form-control mr-0 mr-sm-2 mb-3 mb-sm-2" id="inputLname" name="inputLname" placeholder="Last name"></br>
						<input type="email" class="form-control mr-0 mr-sm-2 mb-3 mb-sm-2" id="inputEmail" name="inputEmail" placeholder="Email"></br>
						<input type="password" class="form-control mr-0 mr-sm-2 mb-3 mb-sm-2" id="inputPassword" name="inputPassword" placeholder="Password"></br>
						<button type="submit" class="btn btn-primary">Sign-up</button>
					</form>

				</div>
				
			</div>
		</div>
    </section>

    <!-- Footer -->
    <footer class="bg-black small text-center text-white-50">
      <div class="container">
        Copyright &copy; ShareHUB 2018
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/font-awesome/js/all.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts -->
    <script src="js/grayscale.min.js"></script>

  </body>

</html>
