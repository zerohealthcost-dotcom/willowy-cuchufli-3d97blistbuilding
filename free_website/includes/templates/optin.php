<?php
$filename = __DIR__ . "/../../admin/settings/privacy_terms_settings.txt";

if($handle = @fopen($filename, 'r'))
{
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	$privacy_terms_arr=explode("#_1_#",$contents);
}

$filename = __DIR__ . "/../../admin/settings/seo/content_pages/main-optin.php.txt";
if($handle = @fopen($filename, 'r'))
{
$contents = fread($handle, filesize($filename));
fclose($handle);
$seo_arr=explode("#_1_#",$contents);
}

if ( !isset( $seo_arr[7] ) or $seo_arr['7'] != 1 ) {
    header( "Cache-Control: no-cache, max-age=0, must-revalidate" );
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
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
    
<meta name="copyright" content="Free Monthly Websites">
 <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
 <link rel="icon" href="images/favicon.png" type="image/png">

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
/*ADDITIONAL FORM STYLING */
.formdiv {
    width: 55%;
	float: right;
	margin: auto;
}
.imagediv {
    width: 45%;
    float: left;
    text-align: center;
}
.optin-form-main-input {
	display: block;
	height: 40px;
	width: 100%;
	padding: 10px 0px;
	margin: 15px 0px 10px;
	line-height: 50px;
	font-family: Arial;
	font-size: 18px;
	font-weight: 100;
	font-style: italic;
	text-align: center;
	color: #777;
	border: 1px solid #CACACA;
	box-shadow: 0px 2px 2px rgba(0, 1, 1, 0.02) inset;
	background: #FFF linear-gradient(to bottom, rgba(0, 1, 1, 0.03) 0px, rgba(255, 255, 255, 0.03) 100%) repeat scroll 0% 0%;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px
}
#optin-form-main-button {
	width: 100%;
	padding: 15px 5px;
	border-width: 0px;
	border-radius: 5px;
	background: #00c080;
	box-shadow: none;
	line-height: 1.5;
	text-align: center;
	text-decoration: none;
	display: block;
	border-style: solid;
	font-family: Arial;
    font-size: 20px;
	font-weight: bold;
	color: #FFF;
	cursor: pointer;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}
#optin-form-main-button:hover {
	background-color:#009664;
}
/*ADDITIONAL FORM STYLING */
/*ADDITIONAL FORM STYLING MOBILE */
@media only screen and (max-width:480px) {
.formdiv {
    width: 100%;
	float: none;
}
.imagediv {
    width: 100%;
	float: none;
}
#optin-form-main-button {
    font-size: 7vw;
	line-height:1 !Important;
  }
input[type=email], input[type=text]{
    font-family: Arial;
	font-size: 5vw;
	line-height:1;
    color: #999;
}
}
/*ADDITIONAL FORM STYLING MOBILE */
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
	echo $filename;
echo  '<img src=\'./admin/images/custom_images/'.$filename.'\' />';
	  }
?>
</div>
<?php
}
?>
<!--Main Content -->

<div class="container">
    <div class="content">	
<?php echo $optin_arr['0']; ?>
<?php
//GETRESPONSE
if($optin_arr[9]=='gr')
{
?>
<!--getresponse image left -->    
<div class="imagediv"><?php echo $optin_arr['14']; ?></div>
<div class="formdiv">
<?php echo $optin_arr['15']; ?>
<form action="https://app.getresponse.com/add_subscriber.html" accept-charset="utf-8" method="post" target="_blank">       
<input name="first_name" type="text" class="optin-form-main-input" placeholder="<?php echo $optin_arr['10']; ?>" autocomplete="name" />
<input name="email" type="email" class="optin-form-main-input" placeholder="<?php echo $optin_arr['11']; ?>" autocomplete="email" />
<input name="campaign_token" value="<?php echo $optin_arr['7']; ?>" type="hidden">
<input name="custom_trackingcode" type="hidden" value="<?php echo $optin_arr['8']; ?>" />
<input type="hidden" name="thankyou_url" value="<?php echo $optin_arr['3']; ?>"/>
<input name="start_day" value="0" type="hidden">
<button type="submit" id="optin-form-main-button"><span><?php echo $optin_arr['12']; ?></span></button> 
</form>
<?php echo $optin_arr['16']; ?>
</div>
<!--getresponse image left -->   
<?php
}
//GETRESPONSE
?> 


<?php
//AWEBER
if($optin_arr[9]=='aweber')
{
?>
<!--aweber image left -->    
<div class="imagediv"><?php echo $optin_arr['14']; ?></div>
<div class="formdiv">
<?php echo $optin_arr['15']; ?>
<form action="https://www.aweber.com/scripts/addlead.pl" method="post" name="myform" target="_blank" id="myform" accept-charset="UTF-8">
<input type="hidden" name="listname" value="<?php echo $optin_arr['2']; ?>" />
<input type="hidden" name="redirect" value="<?php echo $optin_arr['3']; ?>" />
<input type="hidden" name="meta_adtracking" value="<?php echo $optin_arr['1']; ?>" />
<input type="hidden" name="meta_message" value="1" />
<input type="hidden" name="meta_required" value="name,email" />
<input type="hidden" name="meta_forward_vars" value="0" />
<input name="name" type="text" class="optin-form-main-input" placeholder="<?php echo $optin_arr['10']; ?>" autocomplete="name" />
<input name="email" type="email" class="optin-form-main-input" placeholder="<?php echo $optin_arr['11']; ?>" autocomplete="email" />
<button type="submit" id="optin-form-main-button"><span><?php echo $optin_arr['12']; ?></span></button> 
</form>
<?php echo $optin_arr['16']; ?>
</div>
<!--aweber image left -->   
<?php
}
//AWEBER
?> 

<?php
//OTHER
if($optin_arr[9]=='ot')
{
?>
<!--other image left -->    
<div class="imagediv"><?php echo $optin_arr['14']; ?></div>
<div class="formdiv">
<?php echo $optin_arr['15']; ?>
<?php echo $optin_arr['5']; ?>
<?php echo $optin_arr['16']; ?>
</div>
<!--other image left --> 
<?php
}
//OTHER
?>
    
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
</body>
</html>