<?php
	require('config.php');
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	session_start();
	
	if(!isset($_SESSION['user'])){
		header("location: signin.php");
	}
	
	$uid = "null";
	$usedSpace = "";
	$sqlForUserId = "SELECT id, email, usedSpace FROM users WHERE email = '" . $_SESSION['user'] . "'";
	$resultForUserId= $conn->query($sqlForUserId);
	if ($resultForUserId->num_rows > 0) {
		while($row = $resultForUserId->fetch_assoc()) {
			$uid = $row["id"];
			$usedSpace = $row["usedSpace"];
		}
	}
	
	$snippetName = $_POST["snippetTitle"];
	$snippetDescription = $_POST["snippetDescription"];
	$snippetContent = $_POST["snippetContent"];
	$snippetDate = date("Y-m-d h:i:s");
	$ownerEmail = $_SESSION['user'];
	
	if($usedSpace + $_FILES['fileToUpload']['size'] >= 50000000){
		echo "No more space!";
		header ("location: profile.php");
	} else {
		//FILE UPLOAD STUFF
		$snippetType = "notFile";
		$fileUrl = "";
		if (!$_FILES['fileToUpload']['size'] == 0){
			$snippetType = "file";
			$target_dir = "uploads/" . $uid . "/";
			if(!file_exists($target_dir)){
				mkdir($target_dir);
			}
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$fileExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
			$fileUrl = $target_file;
			$fileSize = $_FILES["fileToUpload"]["size"];
			if(file_exists($target_file)){
				echo "<div class='alert alert-danger' role='alert'>File already exists!</div>";
				$uploadOk = 0;
			}
			
			if($_FILES["fileToUpload"]["size"] > 50000000){
				echo "<div class='alert alert-danger' role='alert'>The filesize can't exceed 50MB!</div>";
				$uploadOk = 0;
			}
			
			if($imageFileType == "exe" && $imageFileType == "bat" && $imageFileType == "APP") {
				echo "<div class='alert alert-danger' role='alert'>Executable files are not allowed!</div>";
				$uploadOk = 0;
			}
			
			if($uploadOk != 0){
				if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
					echo "<div class='alert alert-success' role='alert'>File uploaded successfully!</div>";
				}
			}
		}
		
		$sql = "INSERT INTO snippets (snippetName, snippetDescription, snippetDate, snippetContent, ownerEmail, ownerID, snippetType, fileUrl, fileExt, fileSize) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sssssisssi", $snippetName, $snippetDescription, $snippetDate, $snippetContent, $ownerEmail, $uid, $snippetType, $fileUrl, $fileExt, $fileSize);
		$stmt->execute();
		
		$usedSpace = $usedSpace + $fileSize;
		
		$sqlUsers = "UPDATE users SET usedSpace='" . $usedSpace . "' WHERE id = '" . $uid . "'";
		if($conn->query($sqlUsers) === TRUE){
			echo "Success";
		}
	}
	
	header("location: profile.php");
?>