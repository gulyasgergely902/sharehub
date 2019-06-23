<head>
		<link href="vendor/font-awesome/css/all.css" rel="stylesheet">
</head>
<style>
	.editNewsPanel{
		background-color: #f1f1f1;
		border-radius: 5px;
		width: 80%;
		margin-left: auto;
		margin-right: auto;
		margin-top: 32px;
		padding: 16px;
		overflow: hidden;
	}
</style>


<?php	
	include_once('../config.php');
	
	$conn = new mysqli($servername, $username, $password, $dbname);
		
	if ($conn->connect_error) {
		die("Connection failed to the database: " . $conn->connect_error);
	}
	
	session_start();
	
	if(!isset($_SESSION['user'])){
		header("location: signin.php");
	}
	
	$sqlForNewsText = "SELECT newsText FROM news WHERE id=1";
	$resultForNewsText = $conn->query($sqlForNewsText);
	if($resultForNewsText->num_rows > 0){
		while($row = $resultForNewsText->fetch_assoc()){
			$newsText = $row["newsText"];
		}
	}
?>

<body>
	<div class="editNewsPanel">
		<form method="post" enctype="multipart/form-data">
			<textarea class='form-control' rows='16' cols='120' id='newsText' name='newsText'><?php echo $newsText; ?></textarea>
			<hr>
			<button type="submit" class="btn btn-primary btn-right" name="saveButton"><i class="fas fa-plus"></i> Save</button>
		</form>
	</div>
</body>

<?php
	$nId = 1;
	if (isset($_POST['saveButton'])) {
		$stmt = $conn->prepare("UPDATE news SET newsText=? WHERE id=?");
		$stmt->bind_param("si", $_POST["newsText"], $nId);
		$stmt->execute();
		
		$stmt->close();
		$conn->close();
	}
?>