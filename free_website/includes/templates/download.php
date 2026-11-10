<?php
$filename = __DIR__ . "/../../admin/settings/design_settings.txt";
if($handle = @fopen($filename, 'r'))
{
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	$design_arr=explode("#_1_#",$contents);
}

$filename = __DIR__ . "/../../admin/settings/privacy_terms_settings.txt";

if($handle = @fopen($filename, 'r'))
{
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	$privacy_terms_arr=explode("#_1_#",$contents);
}

$filename = __DIR__ . "/../../admin/settings/seo/content_pages/main-download.php.txt";
if($handle = @fopen($filename, 'r'))
{
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	$seo_arr=explode("#_1_#",$contents);
}

if ( !isset( $seo_arr[7] ) or $seo_arr['7'] != 1 ) {
    header( "Cache-Control: no-cache, max-age=0, must-revalidate" );
}
?><!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<meta name="copyright" content="Free Monthly Websites">
 <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
 <link rel="icon" href="images/favicon.png" type="image/png">
	<?php
	if ( $seo_arr[4] !== '1' ): ?>
        <meta name="description" content="<?php echo $seo_arr['1']; ?>">
        <meta name="keywords" content="<?php echo $seo_arr['2']; ?>">
        <meta name="robots" content="INDEX, FOLLOW">
	<?php else: ?>
        <meta name="robots" content="noindex, nofollow">
	<?php endif;
	?>
    <title><?php echo $seo_arr['0']; ?></title>
    
<style type="text/css">
a:link {
color: #f16d6e;
}
a:visited {
color: #f16d6e;
}
a:hover {
color: #f16d6e;
}
a:active {
color: #f16d6e;
}
.a {
color: #f16d6e;
}
.container {
    border:solid; 
    border-width:<?php echo $design_arr['5'],"px"; ?>; 
	border-color:<?php echo "#",$design_arr['4']; ?>; 
    float:none;
    width:100%;
	background-color:<?php echo "#",$design_arr['7']; ?>; 
	display: flex;
	overflow:hidden;
    text-align: left;
}
.content {
	float:right;
	width:100%;
	overflow:hidden;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
	padding-left:<?php echo $design_arr['10'],"px"; ?>;
	padding-right:<?php echo $design_arr['10'],"px"; ?>;
	vertical-align:top;  
    text-align: left;
}
.download-hero-ad {
  max-width: 900px;
  margin: 0 auto;
}
.footer-container {
    padding:10px; 
	background-color:<?php echo "#",$design_arr['3']; ?>;
}
.footer p {
    margin: 0px;
    padding: 0px;
}
.footer {
    margin: auto;
    text-align: center;
	}
.header-image {
    font-size: 0px;
	background-color: <?php echo "#",$design_arr['9']; ?>;
}
html, body {
	margin: 0;
	padding: 0;
	font-family: Arial, sans-serif;
	font-size: <?php echo $design_arr['6'],"px"; ?>;
	background-color: <?php echo "#",$design_arr['3']; ?>;
}
img {
    max-width: 100% !important;
	height: auto !important;
}
.main {
	background-color:#FFFFFF; 
	padding:0px; 
	margin:auto; 
	max-width:<?php echo $design_arr['2'],$design_arr['8']; ?>;
}
.powered,
.powered a:link,
.powered a:visited,
.powered a:active {
color:#EEEEEE;
font-size: 12px;
padding-top: 6px;
    margin: auto;
    text-align: center;
}
.powered a:hover {
    color:#f16d6e;
}
.privacy-terms,
.privacy-terms a:link,
.privacy-terms a:visited,
.privacy-terms a:active {
color:#EEEEEE;
font-size: 14px;
padding-top: 10px;
    margin: auto;
    text-align: center;
}
.privacy-terms a:hover {
color:#f16d6e;
}

/* For mobile phones: */
@media only screen and (max-width:480px) {
html, body {
    font-size: 5vw;
}
.container { 
    display:table;
    width:100%;
	vertical-align:top;
	overflow:hidden;
	margin:0px;
	padding-left:10px;
	padding-right:10px;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
   }
.content { 
    display:table-header-group;
    float:none;
    clear:both;
    width:100%; 
	vertical-align:top; 
	overflow:auto;
	margin:0;
	padding-left:10px;
	padding-right:10px;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
   }
table {
  width:100% !Important;
}
}
<?php echo str_replace(array('<style>','</style>','< /style>'),'',$seo_arr['6']); ?>
</style>
<?php echo $seo_arr['5']; ?>
</head>

<body>
<center>
<!--Main -->
<div class="main">
<!--Main -->
<?php
if($design_arr['1']==1)
{
?>
<div class="header-image">
<?php
if(!empty($design_arr['0'])){
	$filename=$design_arr['0'];
echo  '<img src=\'./admin/images/custom_images/'.$filename.'\' />';
	  }
?>
</div>
<?php
}
?>
<!--Main Content -->
<div class="container">
    <div class="content"><?php echo $download_arr['0']; ?>
<!--Download Ad -->
<?php
if($download_arr[2] == 'yes')
{
?>
<!--Custom CB Ads Local Hero -->
<div class="hero-ad-separator"></div>
<div class="download-hero-ad">
  <?php include __DIR__ . '/../ads_hero.php'; ?>
</div>
<br>
<!--Custom CB Ads Local Hero -->
<?php
}
?>
<!--Download Ad -->   
    </div>  
</div>
<!--Main Content -->
<!--Footer -->
<div class="footer-container">
    <div class="footer"><?php echo $design_arr['11']; ?></div>   
<?php if($privacy_terms_arr['2']==1) { ?><div class="privacy-terms">↗️ <a href="./terms.php" target="_blank">Terms & Conditions</a> | ↗️ <a href="./privacy.php" target="_blank">Privacy Policy</a></div><?php } ?>
<?php if($design_arr['13']=='1'){ ?><div class="powered"><a href="https://hop.clickbank.net/?affiliate=<?php echo $design_arr['12']; ?>&vendor=fmwebs" target="_blank">Powered by: Free Monthly Websites</a></div><?php } ?>
</div> 
<!--Footer -->
<!--Main -->
</div>
<!--Main -->
</center>
<!--Tracking -->
<?php echo $seo_arr['3']; ?>
<!--Tracking -->
<script>
var cbId = "<?php echo $design_arr['12']; ?>";

document.querySelectorAll("a").forEach(link => {
    link.href = link.href.replace(/CB-ID/g, encodeURIComponent(cbId));
});

document.body.innerHTML = document.body.innerHTML.replace(/CB-ID/g, cbId);
</script>
</body>
</html>