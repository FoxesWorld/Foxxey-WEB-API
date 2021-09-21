<?php
if(!defined('FOXXEYadm')){
	die('{"message": "Not In Admin Thread!"}');
}

	class admFunctions {
		
		public static function incFiles($path, $mask, $fileType) {
			if ($handle = opendir($path)) {
					while (false !== ($file = readdir($handle)))   {
					$filesToInclude = strpos($file, $mask);
					if ($file != "." && $file != ".." && $filesToInclude && !strpos($file, 'off') && !strpos($file, '.map')){
						if($fileType == 'css') {
							echo '<link rel="stylesheet" href="'.$path.$file.'">';
						} elseif($fileType == 'js') {
							echo '<script src="'.$path.$file.'"></script>'; 
						} else {
							die('{"message": "Unknown fileType!"}');
						}
					}
				}
			closedir($handle);
			}	
		}
	}
?>