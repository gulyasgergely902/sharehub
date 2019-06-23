<html>
	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="Blawg">

		<title>ShareHUB</title>


		<!-- SCRIPTS -->

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<!--<script src="vendor/tail-writer/js/marked.js"></script>-->
		<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
		<script src="vendor/tail-writer/js/tail.writer.min.js"></script>
		<script>
			$(document).ready(function(){

				$( "#toggleSettingsPanel" ).click(function() {
					$( "#settingsPanel" ).slideToggle( "fast", function() {

					});
				});
				$( "#toggleSharePanel" ).click(function() {
					$( "#sharePanel" ).slideToggle( "fast", function() {

					});
				});
				$( "#toggleSharePanel" ).click(function() {
					$( "#snippetSharePanel" ).slideToggle( "fast", function() {

					});
				});
				$( "#toggleUserProfilePanel" ).click(function() {
					$( "#userProfilePanel" ).slideToggle( "fast", function() {

					});
				});
				$( "#toggleAddFilePanel" ).click(function() {
					$( "#addFilePanel" ).slideToggle( "fast", function() {

					});
				});

			});
		</script>
		<script src="js/custom-file-input.js"></script>
		<script src="js/jquery.custom-file-input.js"></script>
		<!--<script>
		$( function() {
			$("textarea").jqte({
				color: false,
				fsize: false,
				formats: [
					["p","Paragraph"],
					["h1","Title"],
					["h2","Subtitle"]
				],
				indent: false,
				outdent: false,
				ol: false,
				remove: false,
				rule: false,
				source: false,
				sub: false,
				strike: false,
				sup: false,
				unlink: false,
				link: false,
				left: false,
				center: false,
				right: false
			});
		});
		</script>-->

		<!-- STYLES -->
		
		<!-- Bootstrap core CSS -->
		<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

		<link href="css/grayscale.min.css" rel="stylesheet">
		<link href="css/profileStyle.css" rel="stylesheet">
		<link href="css/buttonStyle.css" rel="stylesheet">
		<link href="css/component.css" rel="stylesheet">
		<link href="css/1-col-portfolio.css" rel="stylesheet">
		<link href="vendor/font-awesome/css/all.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/jquery-te-1.4.0.css"/>

		<link rel="stylesheet" href="vendor/tail-writer/css/tail.writer.css">
		<link rel="stylesheet" href="vendor/tail-writer/css/tail.writer.github.css">

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	</head>
	<body>
		<?php
			include_once('config.php');
			
			$conn = new mysqli($servername, $username, $password, $dbname);
				
			if ($conn->connect_error) {
				die("Connection failed to the database: " . $conn->connect_error);
			}
			
			session_start();
			
			$user_check = $_SESSION['user'];
			$masterAdmin = $_SESSION['masterAdmin'];
			
			if(!isset($_SESSION['user'])){
				header("location: signin.php");
			}

			$maxSpace = 50000000;

			$publicHub = 0;
			$sqlForUserId = "SELECT id, email, fname, lname, settings, usedSpace, apikey, publicHub FROM users WHERE email = '" . $_SESSION['user'] . "'";
			$resultForUserId= $conn->query($sqlForUserId);
			if ($resultForUserId->num_rows > 0) {
				while($row = $resultForUserId->fetch_assoc()) {
					$uid = $row["id"];
					$set = $row["settings"];
					$fname = $row["fname"];
					$lname = $row["lname"];
					$publicHub = $row["publicHub"];
					$usedSpace = $row["usedSpace"];
					$apikey = $row["apikey"];
				}
			}

			$freeSpace = $maxSpace - $usedSpace;

			$freeSpacePerc = ($freeSpace / $maxSpace) * 100;
			$usedSpacePerc = ($usedSpace / $maxSpace) * 100;
			
			$settings = stringToArray($set);
			$showImages = $settings[0];
			$showLinks = $settings[1];
			
			$sqlForNewsText = "SELECT newsText FROM news WHERE id=1";
			$resultForNewsText = $conn->query($sqlForNewsText);
			if($resultForNewsText->num_rows > 0){
				while($row = $resultForNewsText->fetch_assoc()){
					$newsText = $row["newsText"];
				}
			}
		?>
		<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNavDark">
			<div class="container">
				<a class="navbar-brand js-scroll-trigger" href="index.php">ShareHUB</a>
				<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
					Menu
					<i class="fas fa-bars"></i>
				</button>
				<div class="collapse navbar-collapse" id="navbarResponsive">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item">
							<!--<a class="nav-link" href="userProfile.php"><i class="fas fa-user"></i> <?php echo $lname . " " . $fname; ?></a>-->
							<a class="nav-link" id="toggleUserProfilePanel" href="#"><i class="fas fa-user"></i> <?php echo $lname . " " . $fname; ?><i class="fas fa-caret-down"></i></a>
						</li>
						<li class="nav-item">
							<form style="display: inline;" name="viewOwnHub" method="POST" action="hub.php?id=<?php echo $uid ?>">
							<input type="hidden" name="innerOpen" value="1">
							<a class="nav-link" href="javascript:document.viewOwnHub.submit()"><i class="fas fa-eye "></i> View my HUB</a>
							</form>
						</li>
						<li class="nav-item">
							<a class="nav-link " href="sharedhubs.php"><i class="fas fa-users "></i> Shared HUBs</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " id="toggleSharePanel" href="#"><i class="fas fa-share "></i> Share<i class="fas fa-caret-down"></i></a>
						</li>
						<li class="nav-item">
							<a class="nav-link " id="toggleSettingsPanel" href="#"><i class="fas fa-sliders-h  "></i> Settings<i class="fas fa-caret-down"></i></a>
						</li>
						<?php 
							if($masterAdmin == "yes"){
								echo '<li class="nav-item">';
								echo '<a class="nav-link" href="admin.php"><i class="fas fa-wrench"></i> Admin</a>';
								echo '</li>';
							}
						?>
						<form class="form-inline my-2 my-lg-0" action="logout.php" method="post">
							<button type="submit" class="btn btn-inline btn-secondary">Sign-out <i class="fas fa-sign-out-alt "></i></button>
						</form>
					</ul>
				</div>
			</div>
		</nav>
		
		<div class="container">

			<div class="userProfilePanel" id="userProfilePanel">
				<div class="wrapper">
					<!--<div class="chartWrapper">
						<canvas id="myChart" width="200" height="200"></canvas>
					</div>-->
					<div class="userData">
						<h3>Name: <?php echo $lname . " " . $fname ?></h3>
						<h5>Email: <?php echo $_SESSION['user'] ?></h5>
						<h5>Used space: <?php echo round(($usedSpace / 1000000), 3, PHP_ROUND_HALF_UP) . " MB / 50 MB" ?> </h5>
						<hr>
						<h5 class="inline">API Key:</h5><h5 class="code inline"><?php echo $apikey ?></h5>
						<h6 class="alertText"><i class="alert">Keep this code safe!</i> Keep in mind: knowing this code grants you superpowers and the ability to post on your hub!</h6>
					</div>
				</div>
			</div>
		
			<div class="settingsPanel" id="settingsPanel">
				<h1 class="slidingPanelTitle"><i class="fas fa-sliders-h  "></i> SETTINGS</h1>
				<hr>
				<form action="modifySettings.php" method="post">
					<div class="inputGroup">
						<input type="checkbox" name="showImages" id="showImages" <?php if($showImages == 2) echo 'checked="true"' ?>>
						<label for="showImages">Show images for Snippets</label>
					</div>
					<hr>
					<div class="inputGroup">
						<input type="checkbox" name="showLinks" id="showLinks" <?php if($showLinks == 2) echo 'checked="true"' ?>>
						<label for="showLinks">Highlight links in Snippets</label>
					</div>
					<hr>
					<div class="inputGroup">
						<input type="checkbox" name="publicHub" id="publicHub" <?php if($publicHub == 'yes') echo 'checked="true"'?>>
						<label for="publicHub">Public HUB</label>
					</div>
					<hr>
					<input type="hidden" name="user" value="<?php echo $_SESSION['user'] ?>">
					<button type="submit" class="btn btn-primary btn-right"><i class="fas fa-save  "></i> Save</button>
				</form>
			</div>


			<!-- SHARE -->
			<div class="sharePanel" id="sharePanel">
				<h1 class="slidingPanelTitle"><i class="fas fa-share-square "></i> SHARE</h1>
				<hr>
				<form action="share.php" method="post">
					<input type="hidden" name="shareFromWho" value="<?php echo $_SESSION['user'] ?>">
					<input type="hidden" name="sharedHubID" value="<?php echo $uid ?>">
					<div class="form-group">
						<label for="shareToWho">Partner email</label>
						<input type="email" class="form-control" name="shareToWho" id="shareToWho">
					</div>
					<button type="submit" class="btn btn-primary inline btn-right"><i class="fas fa-share   "></i> Share</button>
				</form>
			</div>
			
			<div class="newsBar news-information">
				<h4 class="newsTitle">News</h4>
				<span class="newsContent"><?php /*include('newsText.html');*/ echo $newsText ?></span>
			</div>

			<div class="addPanel">
				<form class="addSnippetForm" action="addSnippet.php" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="text">Snippet Title</label>
						<input type="text" class="form-control" id="snippetTitle" name="snippetTitle" aria-describedby="snippetTitle" placeholder="Snippet Title">
					</div>
					<div class="form-group">
						<label for="text">Snippet Description</label>
						<input type="text" class="form-control" id="snippetDescription" name="snippetDescription" placeholder="Snippet Description">
					</div>
					<div class="form-group">
						<label for="snippetContent">Snippet Content<sup>1</sup></label>
						<!--<input type="text" class="form-control" rows='4' cols='120' id="snippetContent" name="snippetContent" placeholder="Snippet Content">-->
						<textarea class='form-control' rows='4' cols='120' id='snippetContent' name='snippetContent' placeholder='Snippet Content'></textarea>
						<small><sup>1</sup>You can format the text using <a href="https://www.markdownguide.org/cheat-sheet"> Markdown</a>.</small>
					</div>
					<button type="button" class="btn btn-primary longButton" id="toggleAddFilePanel"><i class="fas fa-file-upload"></i> Attach file...</button>
					<div class="addFilePanel" id="addFilePanel">
						<div class="wrapper">
							<label for="file">File: </label>
							<input type="file" name="fileToUpload" id="fileToUpload" class="inputfile">
						</div>
					</div>
					<hr>
					<button type="submit" class="btn btn-primary longButton"><i class="fas fa-plus"></i> Add</button>
				</form>
			</div>


		
			<h1 class="snippetTitle">Your Snippets</h1>
			<hr class="titleUnderline">
		
			<?php
				include('/vendor/parsedown-1.7.1/Parsedown.php');
				$sql = "SELECT id, snippetName, snippetDescription, snippetDate, snippetContent, ownerEmail, ownerID, snippetType, fileUrl, fileExt, fileSize, isShared, sharedLink FROM snippets WHERE ownerEmail='" . $_SESSION['user'] . "' ORDER BY snippetDate DESC"; 
				$result = $conn->query($sql);

				$parsedown = new Parsedown();
				$parsedown->setSafeMode(true);

				$numberOfEntries = $result->num_rows;
				$currentEntryNum = 0;

				if ($result->num_rows > 0) {

					while($row = $result->fetch_assoc()) {
						$currentEntryNum++;

						$urlIntoLink = "null";
						
						//Find the first link in the text
						//$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
						$pattern = '~[a-z]+://\S+~';

						$text = $row["snippetContent"];
						if(preg_match_all($pattern, $text, $url)){
							$urlIntoLink = $url[0];
						}

						echo '<div class="row" id="pid_' . $row["id"] . '">';
							echo '<div class="col-md-7">';
								if($row["snippetType"] == "file"){
									if(($row["fileExt"] == "png") or $row["fileExt"] == "jpg" or ($row["fileExt"] == "jpeg") or ($row["fileExt"] == "gif") or ($row["fileExt"] == "bmp")){
										echo '<img class="img-fluid rounded mb-3 mb-md-0" src="img/ph_image.jpg" alt="">';
										echo '<hr>';
										echo '<img class="img-fluid rounded mb-3 mb-md-0" src="' . $row["fileUrl"] .'" alt="">';
									} else {
										echo '<img class="img-fluid rounded mb-3 mb-md-0" src="img/ph_file.jpg" alt="">';
									}
								} else {
									//if($urlIntoLink != "null"){
										//echo '<img class="img-fluid rounded mb-3 mb-md-0" src="img/ph_link.jpg" alt="">';
									//} else {
										echo '<img class="img-fluid rounded mb-3 mb-md-0" src="img/ph_text.jpg" alt="">';	
									//}
								}
							echo '</div>';
							echo '<div class="col-md-5">';
								if($row["isShared"] == "YES"){
									echo '<h3>' . htmlspecialchars($row["snippetName"]) . '&nbsp<a href="' . $row["sharedLink"] . '"><i class="fas fa-link"></i></a>&nbsp<a><i class="fas fa-unlink"></i></a></h3>';
								} else {
									echo '<h3>' . htmlspecialchars($row["snippetName"]) . '</h3>'; 
								}
								echo '<p class="italic">' . htmlspecialchars($row["snippetDescription"]) . '</p>';
								if($urlIntoLink != "null"){
									echo '<p class="linksCaption">Links:</p>';
									foreach($url[0] as $item){
										echo '<p class="underline"><a href="' . $item . '">' . $item . '</a></p>';
									}
									//echo '<p class="underline"><a href="' . $urlIntoLink . '">Open Link</a></p>'; 
								}
								if($row["snippetType"] == "file"){
									echo '<p class="underline"><a href="' . htmlspecialchars($row["fileUrl"]) . '" target="_blank">Download file</a></p>';
								}
								echo '<hr class="hrSmall">';

								//MARKDOWN EDITOR HERE!
								//$snippetContentPlain = htmlspecialchars($row["snippetContent"]);
								$snippetContentPlain = $row["snippetContent"];
								$snippetContentParsed = $parsedown->text($snippetContentPlain);
								echo '<p class="snippetContentStyle">' . $snippetContentParsed . '</p>';

								echo '<form style="display: inline" action="editSnippet.php" method="POST">';
									echo '<input type="hidden" name="snippetID" value="' . $row["id"] . '">';
									echo '<button type="submit" class="btn btn-secondary" value="Edit" name="edit"><span><i class="fas fa-edit"></i> EDIT</span></button>';
								echo '</form>';
								echo '&nbsp&nbsp&nbsp';
								echo '<form style="display: inline" action="shareSnippet.php" method="POST">';
									echo '<input type="hidden" name="snippetID" value="' . $row["id"] . '">';
									echo '<button type="submit" class="btn btn-secondary" value="Share" name="edit"><span><i class="fas fa-share"></i> SHARE</span></button>';
								echo '</form>';
								echo '&nbsp&nbsp&nbsp';
								echo '<form style="display: inline" action="deleteSnippet.php" method="POST">';
									echo '<input type="hidden" name="snippetID" value="' . $row["id"] . '">';
									echo '<input type="hidden" name="fileToDelete" value="' . $row["fileUrl"] . '">';
									echo '<input type="hidden" name="fileToDeleteSize" value="' . $row["fileSize"] . '">';
									echo '<input type="hidden" name="uid" value="' . $row["ownerID"] . '">';
									echo '<button type="submit" class="btn btn-secondary red-hover" value="Delete" name="delete"><span><i class="fas fa-trash-alt"></i> DELETE</span></button>';
								echo '</form>';
							echo '</div>';
						echo '</div>';
						if($currentEntryNum < $numberOfEntries) {
							echo '<hr>';
						} else {
							echo '<hr class="endOfPageMarker">';
						}
					}
				}
			
			function stringToArray($s){
				$r = array();
				for($i = 0; $i < strlen($s); $i++){
					$r[$i] = $s[$i];
				}
				return $r;
			}

			$ses_sql->close();
			$conn->close()
			?>

		</div>
	
	<!-- Bootstrap core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/font-awesome/js/all.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts -->
    <script src="js/grayscale.min.js"></script>
	
	</body>
</html>