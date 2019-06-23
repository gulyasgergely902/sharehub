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
	
	//$userHubId = $_GET["id"];
	$userHubId = $_SESSION['userID'];
	
	$email = "null";
	$sqlForUserEmail = "SELECT id, email FROM users WHERE id = '" . $userHubId . "'";
	$resultForUserEmail= $conn->query($sqlForUserEmail);
	if ($resultForUserEmail->num_rows > 0) {
		while($row = $resultForUserEmail->fetch_assoc()) {
			$email = $row["email"];
		}
	}
	
	$sql = "SELECT shareFrom, shareTo, hubID FROM shares WHERE shareTo='" . $email . "'";
	$result = $conn->query($sql);
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
		<link href="css/signinstyle.css" rel="stylesheet">
		<link href="css/1-col-portfolio.css" rel="stylesheet">
		<link href="css/sharedHubs.css" rel="stylesheet">
		<link href="vendor/font-awesome/css/all.css" rel="stylesheet">
		
	</head>
	<body>
		<div class="container">
		<?php
			echo '<h3><a href="profile.php" class="backbtn"><i class="fas fa-angle-left"></i>BACK </a>&nbspHUBs shared with you:</h3>';
			echo '<hr>';
			
			$shareFromMail = "null";
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$shareFromMail = $row["shareFrom"];
					$uid = $row["hubID"];
					$fname = "null";
					$lname = "null";
					$sqlForUserFullName = "SELECT email, fname, lname FROM users WHERE email = '" . $shareFromMail . "'";
					$resultForUserFullName= $conn->query($sqlForUserFullName);
					if ($resultForUserFullName->num_rows > 0) {
						while($row = $resultForUserFullName->fetch_assoc()) {
							$fname = $row["fname"];
							$lname = $row["lname"];
						}
					}
					echo '<div class="box">';
					//echo '<form id="removeForm" action="removeSharedHub.php" method="POST">';
					//echo '<input type="hidden" value="' . $shareFromMail . '" name="shareFromMail">';
					echo '<h4>' . $lname . ' ' . $fname . '\'s HUB</h4>';
					//echo '<h4 class="right"> <a href="hub.php?id=' . $uid . '" class="buttonWithBg"><i class="fas fa-arrow-alt-circle-right  "></i> GO TO HUB</a><button type="submit" class="linkButton buttonWithBg"><i class="fas fa-trash-alt  "></i> REMOVE</button></h4>';
					echo '<h4 class="right"> <form class="inlineButton" action="hub.php?id=' . $uid . '" method="POST"><input type="hidden" name="innerOpen" value="1"><button type="submit" class="linkButton buttonWithBg inlineButton"><i class="fas fa-eye  "></i> VISIT HUB</button></form><form class="inlineButton" id="removeForm" action="removeSharedHub.php" method="POST"><input type="hidden" value="' . $shareFromMail . '" name="shareFromMail"><button type="submit" class="linkButton buttonWithBg inlineButton"><i class="fas fa-trash-alt  "></i> REMOVE</button></form></h4>';
					//echo '</form>';
					echo '</div>';
				}
			} else {
				echo '<h3> No shares, yet!</h3>';
			}
		?>
		</div>
		<script src="vendor/font-awesome/js/all.js"></script>
	</body>
</html>