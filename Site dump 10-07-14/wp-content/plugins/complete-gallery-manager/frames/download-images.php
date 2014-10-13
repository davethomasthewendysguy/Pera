<?php
Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
require_once('../../../../wp-load.php');


$fullPath = urldecode($_GET['download_file']);
$upload_dir = wp_upload_dir();

if(!empty($fullPath)){
	$tmp_content = explode('uploads',$fullPath);
	if(count($tmp_content) > 1){
		$fullPath = $upload_dir['basedir'].$tmp_content[1];
	} else {
		$tmp_content = explode('file',$fullPath);
		if(count($tmp_content) > 1){
			$fullPath = $upload_dir['basedir'].$tmp_content[1];
		} else {
			echo 'Error';
			die();
		}
	}

    	$fsize = filesize($fullPath);
    	$path_parts = pathinfo($fullPath);
   	$ext = strtolower($path_parts["extension"]);

    switch ($ext) {
        case "gif":
        header("Content-type: application/gif");
        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
        break;
        case "png":
        header("Content-type: application/png");
        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
        break;
        case "jpg":
        header("Content-type: application/jpg");
        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
        break;
        default;
        header("Content-type: application/octet-stream");
        header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
    }
    header("Content-length: $fsize");
	if ($fd = fopen ($fullPath, "r")) {
   		 while(!feof($fd)) {
        		$buffer = fread($fd, 2048);
        		echo $buffer;
		}
	}
	fclose ($fd);
	exit;
}


?>