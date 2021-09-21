<?php 
session_start();
define('FOXXEY', true);
define('FOXXEYadm', true);
require ('engine/inc/functions.class.php');

//$cssFiles = functions::filesInDirArray(ADMIN_DIR.'assets/css','.css');
//$JsFiles = functions::filesInDirArray(ADMIN_DIR.'assets/js','.js');

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
		//admFunctions::incFiles('assets/css/', '.css', 'css');
		admFunctions::incFiles('assets/js/', '.js', 'js');
	?>

	<link rel="stylesheet" href="assets/css/pace.min.css"      />
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/css/icons.css" 		   />
	<link rel="stylesheet" href="assets/css/app.css" 		   />
	<link rel="stylesheet" href="assets/css/animate.min.css"   />

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

		<!-- wrapper -->
			<div id="content" class="wrapper">

			</div>
		<!-- end wrapper -->
	</body>

</html>