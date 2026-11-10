<?php

error_reporting(E_ERROR);
ini_set('display_errors',1);
session_save_path(__DIR__ . '/../../sessions');
session_start();

if(!isset($_SESSION['logged_in']) or !$_SESSION['logged_in']) {
	raiseerror("Invalid Login");
}

require_once(__DIR__ . '/lang/en.php');

$path = pathinfo("$_SERVER[REQUEST_URI]");
$dirname = explode( '/admin/ckeditor/', $path['dirname'] );
$browserfolder = $dirname[0];
$usersiteroot   = dirname( dirname( dirname( dirname( $_SERVER['SCRIPT_FILENAME'] ) ) ) ) ;

$useruploadfolder = "$browserfolder/uploads/";
$useruploadpath = "$usersiteroot/uploads/";

if ( !file_exists( $useruploadpath ) ){
	mkdir( $useruploadpath, 0755 );
}

$info = pathinfo($_FILES["upload"]["name"]);
$ext = $info['extension'];

$randomLetters = substr(md5(microtime()),rand(0,26),3);
$filename = "$randomLetters-" . $_FILES["upload"]["name"];

$target_file = $useruploadpath . $filename;
$ckfile = $useruploadfolder . $filename;
$uploadOk = 1;

$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
$check = getimagesize($_FILES["upload"]["tmp_name"]);
if($check !== false) {
    $uploadOk = 1;
} else {
   raiseerror( $uploadimgerrors1 );
    $uploadOk = 0;
}
// Check if file already exists
if (file_exists($target_file)) {
   raiseerror( $uploadimgerrors2 );
    $uploadOk = 0;
}
// Check file size
if ($_FILES["upload"]["size"] > 6024000) {
   raiseerror( $uploadimgerrors3 );
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "ico" ) {
   raiseerror( $uploadimgerrors4 );
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
   raiseerror( $uploadimgerrors5 );
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
         $CKEditorFuncNum = $_GET['CKEditorFuncNum'];
	    echo json_encode(
	    	array(
			    "uploaded" => 1,
			    "fileName" => $filename,
			    "url" => $ckfile
		    )
	    );
	    exit;
    } else {
       raiseerror( $uploadimgerrors6." ".$target_file." ".$uploadimgerrors7 );
    }
}

function raiseerror($error){
	echo json_encode(
		array(
			"uploaded" => 0,
			"error" => array(
				'message' => $error
			)
		)
	);
	exit;
}