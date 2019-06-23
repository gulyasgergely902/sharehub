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
    <link href="css/signinStyle.css" rel="stylesheet">

	</head>
	<body>
		<?php
			error_reporting(E_ALL);
			require('config.php');
			
			$conn = new mysqli($servername, $username, $password, $dbname);
			
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			
			session_start();
			
			if($_SERVER["REQUEST_METHOD"] == 'POST'){
				$email = mysqli_real_escape_string($conn, $_POST["email"]);
				//$password = mysqli_real_escape_string($conn, $_POST["password"]);
				
				//$sql = "SELECT id FROM users WHERE email = ? and password = ?;";
				$sql = "SELECT id, email, password, masterAdmin FROM users WHERE email = ?;";
				
				$stmt = $conn->prepare($sql);
				//$stmt->bind_param("ss", $email, $password);
				$stmt->bind_param("s", $email);
				$stmt->execute();
				
				$result = $stmt->get_result();
				//$row = $result->fetch_assoc();
				$row = $result->fetch_array(MYSQLI_ASSOC);
				
				$enteredPassword = $_POST["password"];
				
				if (password_verify($enteredPassword, $row['password'])) {
					$_SESSION['user'] = $email;
					$_SESSION['userID'] = $row['id'];
					$_SESSION['masterAdmin'] = $row['masterAdmin'];
					header("location: profile.php");
				} else {
					$error = "Wrong email and/or password!";
					echo "<div class='alert alert-danger' role='alert'>" . $error . "</div>";
				}
				
				/*$active = $row['active'];
				
				$count = mysqli_num_rows($result);
				
				if($count == 1){
					$_SESSION['user'] = $email;
					header("location: profile.php");
				} else{
					$error = "Wrong email and/or password!";
					echo "<div class='alert alert-danger' role='alert'>" . $error . "</div>";
				}*/
			}
		?>
		<div class="wrapper">
			<div class="signin">
				<h1>Sign-in</h1>
				<form action="" method="post">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Email">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Password">
					</div>
					<button type="submit" class="btn btn-primary longButton">Sign-in</button>
				</form>
				<h6 class="typefont">If you haven't signed up already, you can do it <b><a href="http://blawg.hu/demo/sharehub/#signup">here</a></b></h6>
			</div>
		</div>
	</body>
</html>