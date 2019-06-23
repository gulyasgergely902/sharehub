<?php
	$selectedSnippet = $_POST["snippetID"];
	
	include_once('config.php');
	
	$conn = new mysqli($servername, $username, $password, $dbname);
		
	if ($conn->connect_error) {
		die("Connection failed to the database: " . $conn->connect_error);
	}
	
	session_start();
	
	if(!isset($_SESSION['user'])){
		header("location: signin.php");
	}
	
	$sqlForSnippets = "SELECT id, snippetName, snippetDescription, snippetDate, snippetContent, ownerEmail, ownerID FROM snippets WHERE ownerEmail='" . $_SESSION['user'] . "' AND id='" . $selectedSnippet . "'"; 
	$result = $conn->query($sqlForSnippets);
	
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$snippetId = $row["id"];
			$snippetName = $row["snippetName"];
			$snippetDescription = $row["snippetDescription"];
			$snippetContent = $row["snippetContent"];
		}
	}
?>
<html>
	<head>
		<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="css/grayscale.min.css" rel="stylesheet">
		<link href="css/editSnippetStyle.css" rel="stylesheet">
		<link href="css/buttonStyle.css" rel="stylesheet">
		<link href="css/component.css" rel="stylesheet">
		<link href="css/1-col-portfolio.css" rel="stylesheet">
		<link href="vendor/font-awesome/css/all.css" rel="stylesheet">
		
		<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		
		<title>Edit Snippet</title>
	</head>
	<body>
		<div class="container">
			<div class="addPanel">
				<form method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="text">Snippet Title</label>
						<input type="text" class="form-control" id="snippetTitle" name="snippetTitle" value="<?php echo $snippetName; ?>" aria-describedby="snippetTitle">
					</div>
					<div class="form-group">
						<label for="text">Snippet Description</label>
						<input type="text" class="form-control" id="snippetDescription" name="snippetDescription" value="<?php echo $snippetDescription; ?>">
					</div>
					<div class="form-group">
						<label for="snippetContent">Snippet Content</label>
						<textarea class='form-control' rows='16' cols='120' id='snippetContent' name='snippetContent'><?php echo $snippetContent; ?></textarea>
					</div>
					<hr>
					<input type="hidden" name="snippetIdToEdit" value="<?php echo $snippetId; ?>">
					<button type="submit" class="btn btn-secondary" name="backButton"><i class="fas fa-arrow-left"></i> Cancel</button>
					<button type="submit" class="btn btn-primary btn-right" name="saveButton"><i class="fas fa-plus"></i> Save</button>
				</form>
			</div>
		</div>
	</body>
</html>

<?php
	if (isset($_POST['saveButton'])) {
		$stmt = $conn->prepare("UPDATE snippets SET snippetName=?, snippetDescription=?, snippetContent=? WHERE ownerEmail=? AND id=?");
		$stmt->bind_param("ssssi", $_POST["snippetTitle"], $_POST["snippetDescription"], $_POST["snippetContent"], $_SESSION['user'], $_POST["snippetIdToEdit"]);
		$stmt->execute();
		
		$stmt->close();
		$conn->close();
		
		header("Location: profile.php");
		exit;
	}
	if (isset($_POST['backButton'])){
		header("Location: profile.php");
		exit;
	}
?>