<?php
/*
 * ?? COPYRIGHT NOTICE
 *
 * This script is the intellectual property of Free Monthly Websites.
 *
 * Unauthorized copying, distribution, resale, or transfer of this script
 * is strictly prohibited and violates copyright law and the purchase agreement.
 *
 * Terms & Conditions:
 * https://freemonthlywebsites.com/copyright-terms/
 *
 * Violations may result in legal action.
 */
session_save_path(__DIR__ . '/sessions');
session_start();
error_reporting(E_ERROR);
ini_set('display_errors',1);

$upload_dir = './temp_preview/'; // Directory for file storing
$preview_url = './temp_preview/';
$filename= '';
$result = 'ERROR';
$result_msg = '';
$allowed_image = array ('image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg','image/png');
define('PICTURE_SIZE_ALLOWED', 2242880); // bytes
@mkdir("./temp_preview");
if (isset($_FILES['picture']))  // file was send from browser
{
 if ($_FILES['picture']['error'] == UPLOAD_ERR_OK)  // no error
 {



 if (in_array($_FILES['picture']['type'], $allowed_image)) {
 if(filesize($_FILES['picture']['tmp_name']) <= PICTURE_SIZE_ALLOWED) // bytes
 {
 $filename = $_FILES['picture']['name'];



 move_uploaded_file($_FILES['picture']['tmp_name'], $upload_dir.$filename);

//phpclamav clamscan for scanning viruses
//passthru('clamscan -d /var/lib/clamav --no-summary '.$upload_dir.$filename, $virus_msg); //scan virus
$virus_msg = 'OK'; //assume clamav returing OK.
if ($virus_msg != 'OK') {
unlink($upload_dir.$filename);
$result_msg = $filename." : ".FILE_VIRUS_AFFECTED;
$result_msg = '<font color=red>'.$result_msg.'</font>';
$filename = '';
}else {
// main action -- move uploaded file to $upload_dir
$result = 'OK';
}
}else {
$filesize = filesize($_FILES['picture']['tmp_name']);// or $_FILES['picture']['size']
$filetype = $_FILES['picture']['type'];
$result_msg = PICTURE_SIZE;
}
}else {
$result_msg = SELECT_IMAGE;
}
}
elseif ($_FILES['picture']['error'] == UPLOAD_ERR_INI_SIZE)
$result_msg = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
else
$result_msg = 'Unknown error';
}

// This is a PHP code outputing Javascript code.
echo '<script language="JavaScript" type="text/javascript">'."\n";
echo 'var parDoc = window.parent.document;';
if ($result == 'OK') {
echo 'parDoc.getElementById("picture_error").innerHTML =  "";';
}
else {
echo "parDoc.getElementById('picture_error').innerHTML = '".$result_msg."';";
}

if($filename != '') {
echo "parDoc.getElementById('picture_preview').innerHTML = '<img width=\'600px\' src=\'$preview_url$filename\' id=\'preview_picture_tag\' name=\'preview_picture_tag\' />';";
}

echo "\n".'</script>';
exit(); // do not go futher

?>