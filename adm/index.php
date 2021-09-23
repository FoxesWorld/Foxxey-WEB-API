<?php 
/*
=====================================================
 This is my AdminCore! | AdminPanel main file
-----------------------------------------------------
 https://FoxesWorld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: index.php
-----------------------------------------------------
 Version: 0.1.3.0 Experimental
-----------------------------------------------------
 Usage: All the AdminActions are performed in here
=====================================================
*/
	session_start();
	define('FOXXEY', true);
	define('FOXXEYadm', true);
	require ('engine/inc/functions.class.php');
?>
<!DOCTYPE html>
		<html lang="en">

			<head>
				<!-- meta tags -->
				<meta charset="utf-8" />
				<meta name="format-detection" content="telephone=no">
				<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width, height=device-height"> 
				<meta name="apple-mobile-web-app-capable" content="yes">
				<meta name="apple-mobile-web-app-status-bar-style" content="default">
				<meta property="og:image" content="assets/images/login-images/login-frent-img.jpg">
				<title>Foxxey Admin</title>
				
				
				<!--favicon-->
				<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
				<script src="assets/js/jquery.min.js"></script>

				<?php 
					admFunctions::incFiles('assets/css/', '.css', 'css');
					admFunctions::incFiles('assets/js/', '.js', 'js');
				?>

				<script>
					setTimeout(function(){
					$.ajax({
					  url: "admin.php",
					  context: $("#content"),
					  success: function(data){
						$(this).html(data);
					  }
					});
					}, 100);
				</script>
			</head>

			<body class="bg-theme bg-theme1">

				<!-- ToLoad Content -->
					<div id="content" class="wrapper">

					</div>
				<!-- end wrapper -->
			</body>

		</html>