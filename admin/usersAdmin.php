<head>
		<link href="vendor/font-awesome/css/all.css" rel="stylesheet">
</head>
<style>
	.userDetails{
		background-color: #f1f1f1;
		border-radius: 5px;
		width: 80%;
		margin-left: auto;
		margin-right: auto;
		margin-bottom: 16px;
		margin-top: 16px;
		padding: 1px 16px;
		height: 200px;
		overflow: hidden;
	}
	
	.userDetails:hover{
		background-color: #cccccc;
	}
	
	hr{
		border: 0;
		border-top: 1px solid rgba(0,0,0,.1);
	}
	
	.idText{
		margin-bottom: 0;
		font-size: 32px;
	}
	
	.nameText{
		margin: 0;
		font-size: 24px;
	}
	
	.emailText{
		margin: 0;
		font-size: 16px;
	}
	
	p{
		margin: 0;
	}
	
	.mainInfos{
		width: 30%;
		height: 100%;
		overflow: hidden;
		float: left;
	}
	
	.details{
		width:70%;
		height: 100%;
		float: right;
	}
</style>
<?php
	include_once('../config.php');
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	if ($conn->connect_error) {
		die("Connection failed to the database: " . $conn->connect_error);
	}
	
	$sql = "SELECT id, email, fname, lname, settings, usedSpace, apikey, publicHub FROM users";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo '<div class="userDetails">';
				echo '<h2 class="idText"><i class="fas fa-hashtag"></i> ' . $row["id"] . '</h2>';
				echo '<hr>';
				echo '<div class="mainInfos">';
					echo '<h3 class="nameText"><i class="fas fa-user"></i> ' . $row["fname"] . ' ' . $row["lname"] . '</h3>';
					echo '<h4 class="emailText"><i class="fas fa-at"></i> ' . $row["email"] . '</h4>';
				echo '</div>';
				echo '<div class="details">';
					echo '<p>Details:</p>';
					echo '<p>Settings: ' . $row['settings'] . '</p>';
					echo '<p>Used Space: ' . $row['usedSpace'] . '</p>';
					echo '<p>API Key: ' . $row['apikey'] . '</p>';
					echo '<p>Public HUB: ' . $row['publicHub'] . '</p>';
				echo '</div>';
			echo '</div>';
		}
	}
?>