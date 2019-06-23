<?php
	include_once('config.php');
			
	$conn = new mysqli($servername, $username, $password, $dbname);
		
	if ($conn->connect_error) {
		die("Connection failed to the database: " . $conn->connect_error);
	}
	
	session_start();
	
	if(!isset($_SESSION['user'])){
		header("location: signin.php");
	}
	
	$uid = "null";
	$set = "";
	$fname = "";
	$lname = "";
	$maxSpace = 50000000;
	$apikey = "";
	$sqlForUserId = "SELECT id, email, fname, lname, settings, usedSpace, apikey FROM users WHERE email = '" . $_SESSION['user'] . "'";
	$resultForUserId= $conn->query($sqlForUserId);
	if ($resultForUserId->num_rows > 0) {
		while($row = $resultForUserId->fetch_assoc()) {
			$uid = $row["id"];
			$set = $row["settings"];
			$fname = $row["fname"];
			$lname = $row["lname"];
			$usedSpace = $row["usedSpace"];
			$apikey = $row["apikey"];
		}
	}
	
	$freeSpace = $maxSpace - $usedSpace;
	
	$freeSpacePerc = ($freeSpace / $maxSpace) * 100;
	$usedSpacePerc = ($usedSpace / $maxSpace) * 100;
?>

<html>
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
		<link href="css/userProfileStyle.css" rel="stylesheet">
		
		<link href="vendor/font-awesome/css/all.css" rel="stylesheet">
		
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="js/Chart.js"></script>
		
	</head>
	<body>
		<div class="userProfile">
			<h1><a href="profile.php" class="backbtn"><i class="fas fa-angle-left"></i>BACK </a>&nbspProfile</h1>
			<hr>
			<div class="wrapper">
				<div class="chartWrapper">
					<canvas id="myChart" width="200" height="200"></canvas>
				</div>
				<div class="userData">
					<h3>Name: <?php echo $lname . " " . $fname ?></h3>
					<h5>Email: <?php echo $_SESSION['user'] ?></h5>
					<h5>Used space: <?php echo round(($usedSpace / 1000000), 3, PHP_ROUND_HALF_UP) . " MB / 50 MB" ?> </h5>
					<hr>
					<h5 class="inline">API Key:</h5><h5 class="code inline"><?php echo $apikey ?></h5>
					<h6 class="alertText">Keep this code safe! Keep in mind: knowing this code grants you superpowers and the ability to post on your hub!</h6>
				</div>
			</div>
			<script>
			var fsp = <?php echo $freeSpacePerc; ?>;
			var usp = <?php echo $usedSpacePerc; ?>;
			var ctx = document.getElementById("myChart");
			var myChart = new Chart(ctx, {
				type: 'doughnut',
				data: {
					labels: ["Free Space", "Used Space"],
					datasets: [{
						label: 'Space',
						data: [fsp, usp],
						backgroundColor: [
							'rgba(54, 162, 235, 0.2)',
							'rgba(255, 99, 132, 0.2)'
						],
						borderColor: [
							'rgba(54, 162, 235, 1)',
							'rgba(255,99,132,1)'
						],
						borderWidth: 1
					}]
				},
				options: {
				}
			});
			</script>
		</div>
	</body>
</html>