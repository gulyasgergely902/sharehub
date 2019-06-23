<?php
	require('config.php');
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$from = $_POST['shareFromWho'];
	$to = $_POST['shareToWho'];
	$sharedHubID = $_POST['sharedHubID'];
	
	$stmt = $conn->prepare("INSERT INTO shares (shareFrom, shareTo, hubID) VALUES (?, ?, ?)");
	
	$stmt->bind_param("sss", $from, $to, $sharedHubID);
	$stmt->execute();
	
	header("Location: profile.php");
	exit;
?>