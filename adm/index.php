<?php 
session_start();
define('FOXXEY', true);
define('FOXXEYadm', true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width, height=device-height"> 
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="default">
	<meta property="og:image" content="assets/images/login-images/login-frent-img.jpg">
	<title>Foxxey Admin</title>
	
	
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />

	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>

	<!-- Bootstrap -->
	<script src="assets/js/jquery.min.js"></script>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<script src="assets/js/bootstrap.min.js"></script>

	<!-- Icons CSS -->
	<link rel="stylesheet" href="assets/css/icons.css" />
	
	<!-- App CSS -->
	<link rel="stylesheet" href="assets/css/app.css" />
	<link rel="stylesheet" href="assets/css/animate.min.css" />

	
	<script src="assets/js/notify.min.js"></script>
	<script src="assets/js/popper.min.js"></script>

	<!--plugins-->
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/js/notify.min.js"></script>
	<script src="assets/js/SetCookie.js"></script>
	<script src="assets/js/functions.foxxey.js"></script>
	
	<script>
		setTimeout(function(){
		$.ajax({
		  url: "admin.php",
		  context: $( "#content" ),
		  success: function(data){
			$(this).html(data);
		  }
		});
		}, 100);
	</script>
</head>

	<body class="bg-theme bg-theme1">
		<!-- wrapper -->
		<div id="content" class="wrapper">

		</div>
		<!-- end wrapper -->
	</body>

</html>