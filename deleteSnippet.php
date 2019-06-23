<?php
	if($_SERVER["REQUEST_METHOD"] == 'POST'){
		include_once 'config.php';
		
		$conn = new Mysqli($servername, $username, $password, $dbname);
		
		if ($conn->connect_error){
			$error = $conn->connect_error;
		}
		
		$query = 'DELETE FROM snippets WHERE id = ?';
		
		$stmt = $conn->prepare($query); 
		$stmt->bind_param('i', $_POST['snippetID']);
		$stmt->execute();
		
		$queryShare = 'DELETE FROM snippetshares WHERE snippetID = ?';
		$shareStmt = $conn->prepare($queryShare);
		$shareStmt->bind_param('i', $_POST['snippetID']);
		$shareStmt->execute();
		
		$deletableFile = $_POST['fileToDelete'];
		if(unlink($deletableFile)){
			echo "success<br>";
		}
		
		$fileSize = $_POST["fileToDeleteSize"];
		$uid = $_POST["uid"];
		
		$sqlForUsedSpace = "SELECT id, usedSpace FROM users WHERE id = '" . $uid . "'";
		$resultForUsedSpace= $conn->query($sqlForUsedSpace);
		if ($resultForUsedSpace->num_rows > 0) {
			while($row = $resultForUsedSpace->fetch_assoc()) {
				$usedSpace = $row["usedSpace"];
			}
		}
		
		$usedSpace = $usedSpace - $fileSize;
		
		$sqlUsers = "UPDATE users SET usedSpace='" . $usedSpace . "' WHERE id = '" . $uid . "'";
		if($conn->query($sqlUsers) === TRUE){
			echo "Success";
		}
		
		//echo json_encode(array('error' => $error));
		
		header("location: profile.php");
	}
?>