<?php

error_reporting(E_ERROR);
ini_set('display_errors',1);

$filename="./admin/settings/download_settings.txt";

if($handle = @fopen($filename, 'r'))
{
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	$download_arr=explode("#_1_#",$contents);
}

$filename="./admin/settings/design_settings.txt";

if($handle = @fopen($filename, 'r'))
{
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	$design_arr=explode("#_1_#",$contents);
}

$filename="./admin/settings/optin_settings.txt";

if($handle = @fopen($filename, 'r'))
{
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	$optin_arr=explode("#_1_#",$contents);
}

if ( $optin_arr[13] == str_replace( '/', '', trim( $_GET['view'] ) ) ){
	include __DIR__ . "/includes/templates/optin.php";
	exit;
} else if ( $download_arr[1] == str_replace( '/', '', trim( $_GET['view'] ) ) ){
	include __DIR__ . "/includes/templates/download.php";
	exit;
} else {

	$_REQUEST['id'] = str_replace('page/','',$_GET['view'] . '.html');

	include "./show.php";
	exit;
}