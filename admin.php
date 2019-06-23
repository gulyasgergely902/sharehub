<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="Blawg">
		
		<title>ShareHUB Admin</title>
		
		<link href="css/adminStyle.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	</head>
	<body>
		<div class="sideMenu">
			<h3 class="menuTitle">Menu</h3>
			<ul class="menuButtonHolder">
				<li class="menuButton" id="overview">Overview</li>
				<li class="menuButton" id="users">Users</li>
				<li class="menuButton" id="newspanel">News panel</li>
			</ul> 
		</div>
		<div class="content" id="content">
			
		</div>
		<script>
			$( document ).ready(function() {
				$('#content').load("admin/usersAdmin.php");
			});
			$('#overview').click(function() {
				$('#content').load("admin/overviewAdmin.php");
			});
			$('#users').click(function() {
				$('#content').load("admin/usersAdmin.php");
			});
			$('#newspanel').click(function() {
				$('#content').load("admin/newspanelAdmin.php");
			});
		</script> 
	</body>
</html>