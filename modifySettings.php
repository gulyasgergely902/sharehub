<?php
	require('config.php');
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$showImages = isset($_POST["showImages"]) + 1;
	$showLinks = isset($_POST["showLinks"]) + 1;
	$publicHub = isset($_POST["publicHub"]);
	$email = $_POST["user"];
	$publicHubStr = "";
	
	$set = (int)($showImages . $showLinks);
	
	//echo $showImages;
	//echo $showLinks;
	//echo $publicHub;
	if($publicHub){
		$publicHubStr = "yes";
	} else {
		$publicHubStr = "no";
	}
	echo $publicHubStr;
	
	$stmt = $conn->prepare("UPDATE users SET settings=?, publicHub=? WHERE email=?");
	
	$stmt->bind_param("sss", $set, $publicHubStr, $email);
	$stmt->execute();
	
	$stmt->close();
	$conn->close();
	
	header("Location: profile.php");
	exit;
?>