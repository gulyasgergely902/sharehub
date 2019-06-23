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
		<link href="css/hubStyle.css" rel="stylesheet">

	</head>
	<body>
	
	<?php
		include_once('config.php');
		
		$conn = new mysqli($servername, $username, $password, $dbname);
			
		if ($conn->connect_error) {
			die("Connection failed to the database: " . $conn->connect_error);
		}
		
		$sql = "SELECT snippetID, snippetRandomString FROM snippetshares WHERE snippetRandomString = ?;";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $_GET['s']);
		$stmt->execute();
		
		$results = $stmt->get_result();
		
		if($results->num_rows > 0){
			while($row = $results->fetch_assoc()){
				$snippetID = $row['snippetID'];
			}
		}
		
		$stmtSnippet = $conn->prepare("SELECT id, snippetName, snippetDescription, snippetDate, snippetContent, ownerEmail, ownerID, snippetType, fileUrl, fileExt, fileSize FROM snippets WHERE id=?");
		$stmtSnippet->bind_param("s", $snippetID);
		$stmtSnippet->execute();
		
		$resultSnippet = $stmtSnippet->get_result();
		
		if ($resultSnippet->num_rows > 0) {
			while ($rowSnippet = $resultSnippet->fetch_assoc()) {
					$urlIntoLink = "null";

						//Find the first link in the text
						$pattern = '~[a-z]+://\S+~';

						$text = $row["snippetContent"];
						if(preg_match_all($pattern, $text, $url)){
							$urlIntoLink = $url[0];
						}
				echo '<div class="row">';
						echo '<div class="col-md-7">';
						if ($rowSnippet["snippetType"] == "file") {
							if (($rowSnippet["fileExt"] == "png") or $rowSnippet["fileExt"] == "jpg" or ($rowSnippet["fileExt"] == "jpeg") or ($rowSnippet["fileExt"] == "gif") or ($rowSnippet["fileExt"] == "bmp")) {
								echo '<img class="img-fluid rounded mb-3 mb-md-0" src="img/ph_image.jpg" alt="">';
								echo '<hr>';
								if ($showImages == 2) echo '<img class="img-fluid rounded mb-3 mb-md-0" src="' . $rowSnippet["fileUrl"] . '" alt="">';
							} else {
								echo '<img class="img-fluid rounded mb-3 mb-md-0" src="img/ph_file.jpg" alt="">';
							}
						} else {
							if ($urlIntoLink != "null") {
								echo '<img class="img-fluid rounded mb-3 mb-md-0" src="img/ph_link.jpg" alt="">';
							} else {
								echo '<img class="img-fluid rounded mb-3 mb-md-0" src="img/ph_text.jpg" alt="">';
							}
						}
						echo '</div>';
						echo '<div class="col-md-5">';
						echo '<h3>' . htmlspecialchars($rowSnippet["snippetName"]) . '</h3>';
						echo '<p class="italic">' . htmlspecialchars($rowSnippet["snippetDescription"]) . '</p>';
						if ($urlIntoLink != "null") {
							echo '<p class="linksCaption">Links:</p>';
							foreach($url[0] as $item){
								echo '<p class="underline"><a href="' . $item . '">' . $item . '</a></p>';
							}
							//if ($showLinks == 2) echo '<p class="underline"><a href="' . $urlIntoLink . '">Open Link</a></p>';
						}
						if ($rowSnippet["snippetType"] == "file") {
							echo '<p class="underline"><a href="' . htmlspecialchars($rowSnippet["fileUrl"]) . '" target="_blank">Download file</a></p>';
						}
						//echo '<p class="snippetContentStyle">' .  htmlspecialchars($row["snippetContent"]) . '</p>';
						
						//$snippetContentPlain = htmlspecialchars($row["snippetContent"]);
						$snippetContentPlain = $rowSnippet["snippetContent"];
						$snippetContentParsed = $parsedown->text($snippetContentPlain);
						echo '<p class="snippetContentStyle">' . $snippetContentParsed . '</p>';
							
						echo '</div>';
						echo '</div>';
						if($currentEntryNum < $numberOfEntries) {
							echo '<hr>';
						} else {
							echo '<hr class="endOfPageMarker">';
						}
			}					
		}
	?>
	
	<!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/font-awesome/js/all.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/grayscale.min.js"></script>
	</body>
</html>