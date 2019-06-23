<?php
	require('config.php');
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$shareFromMail = $_POST['shareFromMail'];
	
	$stmt = $conn->prepare("DELETE FROM shares WHERE shareFrom=?");
			
	$stmt->bind_param("s", $shareFromMail);
	$stmt->execute();
	
	header("Location: sharedhubs.php");
	exit;
?>