<?php
	function randomString(){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randstring = '';
		for ($i = 0; $i < 10; $i++) {
			$randstring .= $characters[rand(0, strlen($characters))];
		}
		return $randstring;
	}
	
	require('config.php');
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$email = $_POST["inputEmail"];
	$password = $_POST["inputPassword"];
	$firstname = $_POST["inputFname"];
	$lastname = $_POST["inputLname"];
	$apikey = randomString();

	$sqlForEmail = "SELECT id FROM users WHERE email = ?;";
	$stmtForEmail = $conn->prepare($sqlForEmail);
	//$stmt->bind_param("ss", $email, $password);
	$stmtForEmail->bind_param("s", $email);
	$stmtForEmail->execute();

	$result = $stmtForEmail->get_result();

	if ($result->num_rows > 0) {
		$error = "The entered email already exists!";
		echo "<div class='alert alert-danger' role='alert'>" . $error . "</div>";
		//echo "The entered email already exists!";
	} else {
		echo $email . "<br>";
		echo $password . "<br>";
		echo $firstname . "<br>";
		echo $lastname . "<br>";

		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

		$stmt = $conn->prepare("INSERT INTO users (email, password, fname, lname, apikey) VALUES (?, ?, ?, ?, ?)");

		$stmt->bind_param("sssss", $email, $hashed_password, $firstname, $lastname, $apikey);
		$stmt->execute();

		echo "<h1>You registered successfully!</h1>";

		$stmt->close();
		$conn->close();

		header("Location: index.php");
		exit;
	}
?>

<html>
<head>
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

</body>
</html>


