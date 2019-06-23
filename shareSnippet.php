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

		function randomString(){
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randstring = '';
			for ($i = 0; $i < 10; $i++) {
				$randstring .= $characters[rand(0, strlen($characters))];
			}
			return $randstring;
		}

		$selectedSnippet = $_POST["snippetID"];
		$assignedRandomString = randomString();
		
		require('config.php');
		
		$conn = new mysqli($servername, $username, $password, $dbname);
		
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$sql = "SELECT snippetID, snippetRandomString FROM snippetshares WHERE snippetID = ?;";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("i", $selectedSnippet);
		$stmt->execute();
		
		$results = $stmt->get_result();
		
		if($results->num_rows > 0){
			while($row = $results->fetch_assoc()){
				echo "<h3 align='center'>This snippet is already exists!</h3>";
				$error = " URL for share: <a href='http://sharehub.blawg.hu/snippet.php?s=" . $row["snippetRandomString"] . "'>http://sharehub.blawg.hu/snippet.php?s=" . $row["snippetRandomString"] . "</a>" ;
				echo "<p align='center'>" . $error . "</p>";
			}
		} else {
			$sqlInsert = "INSERT INTO snippetshares (snippetID, snippetRandomString) VALUES (?, ?);";
			$stmtInsert = $conn->prepare($sqlInsert);
			$stmtInsert->bind_param("is", $selectedSnippet, $assignedRandomString);
			$stmtInsert->execute();
			
			$stmtInsert->close();
			
			echo "snippetshare created!";
			
			$yes = "YES";
			$sharedLink = "snippet.php?s=" . $assignedRandomString;
			
			$stmtUpdate = $conn->prepare("UPDATE snippets SET isShared=?, sharedLink=? WHERE id=?");
			$stmtUpdate->bind_param("ssi", $yes, $sharedLink, $selectedSnippet);
			$stmtUpdate->execute();
			
			//$updateResult = mysql_query("UPDATE snippets SET isShared=YES");
			
			echo "<h3 align='center'>You have successfully shared the snippet!</h3>";
			$msg = " URL for share: <a href='http://sharehub.blawg.hu/snippet.php?s=" . $assignedRandomString . "'>http://sharehub.blawg.hu/snippet.php?s=" . $assignedRandomString . "</a>" ;
			echo "<p align='center'>" . $msg . "</p>";
		}
	?>
	</body>
</html>