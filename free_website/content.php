<?php
error_reporting(E_ERROR);
ini_set('display_errors',1);

function sectionText($text, $section_id, $start, $wordCount = 99999, $showRemaining = false) {
	$words = explode(' ', $text);
	$wordSubset = array_slice($words, $start, $wordCount);

	$substr = implode(' ', $wordSubset);
	$remaining = implode(' ', array_slice($words, $start + $wordCount));

	if ($showRemaining) {
		$onclick  = "document.getElementById('read_more_remaining').style.display = 'none';";
		$onclick .= "document.getElementById('section_remaining').style.display = 'inline';return false;";
		return "<span id='section_" . $section_id . "'>" . $substr .
			   '... <a class="read_more" href="#" id="read_more_remaining" onclick="' . $onclick . '">Read More</a>' .
			   "<span class='hidden' id='section_remaining'>$remaining</span></span>";
	}

	if ($remaining) {
		$substr .= '... <a class="read_more" href="#section_' . ($section_id + 1) . '">Read More</a>';
	} else {
		$substr .= $remaining;
	}

	return "<div id='section_" . $section_id . "'>" . $substr . '</div>';
}

$filename="admin/settings/privacy_terms_settings.txt";
if($handle = @fopen($filename, 'r'))
{
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	$privacy_terms_arr=explode("#_1_#",$contents);
}

$filename="admin/settings/home_settings.txt";
if($handle = @fopen($filename, 'r'))
{
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	$home_arr=explode("#_1_#",$contents);
	$display_ads_home_page = isset($home_arr[9]) ? trim((string)$home_arr[9]) : '2';
	$custom_home_ads = isset($home_arr[12]) ? $home_arr[12] : '';
}

if (!in_array($display_ads_home_page, array('0', '1', '2', 'custom'), true)) {
	$display_ads_home_page = '2';
}

function renderHomeAdditionalAds($display_ads_home_page, $custom_home_ads) {
	if ($display_ads_home_page === '0') {
		return;
	}

	if ($display_ads_home_page === 'custom') {
		if (trim($custom_home_ads) !== '') {
			echo $custom_home_ads;
		}
		return;
	}

	include 'includes/ads_main.php';
}
$filename="admin/settings/design_settings.txt";
if($handle = @fopen($filename, 'r'))
{
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	$design_arr=explode("#_1_#",$contents);
}

$file = basename($_GET['id'], ".html");

$filename="admin/settings/seo/content_pages/$file.txt";				
if($handle = @fopen($filename, 'r'))
{
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	$seo_arr=explode("#_1_#",$contents);
}

if(empty($seo_arr)){
$filename="admin/settings/seo_settings.txt";
if($handle = @fopen($filename, 'r'))
{
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	$seo_arr=explode("#_1_#",$contents);
}

}
if(!empty($_REQUEST['id'])) 
  {
            $filename="content_pages/$_REQUEST[id]";

        if(!$handle = fopen($filename, 'r')) 
          {
             echo "Cannot open file ($filename)";
             exit;
          }
        $contents = @fread($handle, filesize($filename));

        @fclose($handle);
        $argument_arr=explode("#_1_#",$contents);        
        if ( !empty( $argument_arr['1'] ) ){
            $arr_title=explode(":::",$argument_arr['1']);
        }
  }
if(empty($seo_arr['0']) || $seo_arr['0']=='Your Title Here')
$seo_arr['0']=$arr_title['1'];

$filename="admin/settings/seo_settings.txt";
if($handle = @fopen($filename, 'r'))
{
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	$track_arr=explode("#_1_#",$contents);
}

$filename="admin/settings/sidebar_settings.txt";
if($handle = @fopen($filename, 'r'))
{
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	$sidebar_arr=explode("#_1_#",$contents);
}
 $file = basename($_GET['id'], ".html");

$filename="admin/settings/optin_settings.txt";
if($handle = @fopen($filename, 'r'))
{
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	$optin_arr=explode("#_1_#",$contents);
}

// License
require_once __DIR__ . '/admin/includes/verificator-class.php';
global $reauth;

$verify = new Verificator(
	'easybuildr.com',
	'per_domain'
);

$verify_connection = $verify->canConnect();
if ( $verify_connection !== true ) {
	$verify->process($verify_connection);
}

$verify_result = $verify->check( $reauth );
if ( $verify_result !== true ) {
	header("location:https://easybuildr.com/members/no-license/");
	exit;
}
// License

if ( !isset( $seo_arr[7] ) or $seo_arr['7'] != 1 ) {
    header( "Cache-Control: no-cache, max-age=0, must-revalidate" );
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="revisit-after" content="30 days">

    <?php
    if ( $seo_arr[4] !== '1' ): ?>
<meta name="description" content="<?php echo $seo_arr['1']; ?>">
<meta name="keywords" content="<?php echo $seo_arr['2']; ?>">
<meta name="robots" content="INDEX, FOLLOW">
    <?php else: ?>
<meta name="robots" content="noindex, nofollow">
    <?php endif;
    ?>
<meta name="distribution" content="Global">
<meta name="rating" content="General">
<meta name="copyright" content="Free Monthly Websites">
<link rel="icon" href="images/favicon.png" type="image/png">
<title><?php echo $seo_arr['0']; ?></title>

<style type="text/css">
* {
	box-sizing: border-box;
}
html {
	-webkit-text-size-adjust: 100%;
}
html, body {
	margin: 0;
	padding: 0;
	font-family: Arial, sans-serif;
	font-size: <?php echo $design_arr['6'],"px"; ?>;
	background-color: <?php echo "#",$design_arr['3']; ?>;
}
body {
	overflow-x: hidden;
}
img, video, embed, object {
	max-width: 100% !important;
	height: auto !important;
}
iframe {
	max-width: 100% !important;
}

@media only screen and (max-width: 768px) {
	iframe {
		width: 100% !important;
		height: auto !important;
	}
}
table {
	max-width: 100%;
}
a, button, input, textarea, select {
	touch-action: manipulation;
}
.hidden {
	display: none;
}
.read_more {
	display: inline-block;
	margin-top: 6px;
}
.main {
	background-color:#FFFFFF;
	padding:0;
	margin:0 auto;
	width:100%;
	max-width:<?php echo $design_arr['2'],$design_arr['8']; ?>;
}
.container {
    border:solid;
    border-width:<?php echo $design_arr['5'],"px"; ?>;
	border-color:<?php echo "#",$design_arr['4']; ?>;
	width:100%;
	background-color:<?php echo "#",$design_arr['7']; ?>;
	display:flex;
	align-items:flex-start;
	gap:20px;
	text-align:left;
	padding:15px;
	overflow:hidden;
}
.content {
	flex: 1 1 auto;
	min-width: 0;
	width: 100%;
	padding:<?php echo $design_arr['10'],"px"; ?>;
	text-align:left;
	background-color:#FFFFFF;
	margin:0;
	border:solid;
	border-color:#D6D6D6;
	border-width:2px;
}
.easybuildr-home-menu a{
    margin: 4px 3px !important;
    padding: 8px 8px !important;
}
.easybuildr-home-menu .menu-icon-wrap{
    height: 60px !important;
    width: 100% !important;
    margin-top: 4px !important;
}
.easybuildr-home-menu p {
    height: 60px !important;
    width: 100% !important;
    margin-top: 4px !important;
}
.easybuildr-home-menu .menu-icon-wrap img{
    width: 100% !important;
    height: 60px !important;
    max-width: 100% !important;
    max-height: 60px !important;
    object-fit: contain !important;
}
.footer-container {
    padding:10px;
	background-color:<?php echo "#",$design_arr['3']; ?>;
}
.footer p {
    margin: 0;
    padding: 0;
}
.footer {
    margin: auto;
    text-align: center;
}
.form-container-main {
    max-width:60%;
	width:100%;
	margin:auto;
	clear:both;
	margin-bottom:20px;
}
.form-container-side {
    width:100%;
	margin:auto;
	margin-bottom:20px;
}
.header-image {
    font-size: 0;
	background-color: <?php echo "#",$design_arr['9']; ?>;
}
.header-image img,
.header img {
    display: block;
    width: 100% !important;
}
#page-button {
    font-size:18px
	}
.content-pages-grid {
	display: flex;
	width: 100%;
	flex-wrap: wrap;
	margin-top: 10px;
}
.content-page-card {
	width: 50%;
	padding: 5px;
	box-sizing: border-box;
}
.content-page-card::after {
	content: '';
	display: table;
	clear: both;
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
.sidebar-right,
.sidebar-left {
	flex: 0 0 auto;
	min-width: 0;
	margin: 0;
	border: solid;
	padding-left:10px;
	padding-right:10px;
	padding-top:15px;
	padding-bottom:15px;
}
.sidebar-right {
    width:<?php echo $sidebar_arr['1'],"%"; ?>;
	background-color:<?php echo "#",$sidebar_arr['2']; ?>;
	border-color:<?php echo "#",$sidebar_arr['3']; ?>;
	border-width:<?php echo $sidebar_arr['4'],"px"; ?>;
}
.sidebar-left {
    width:<?php echo $sidebar_arr['5'],"%"; ?>;
	background-color:<?php echo "#",$sidebar_arr['6']; ?>;
	border-color:<?php echo "#",$sidebar_arr['7']; ?>;
	border-width:<?php echo $sidebar_arr['8'],"px"; ?>;
}

/* START OF INLINE OPTIN FORM */
.optin-form-side-input {
	display: block;
	height: 40px;
	width: 100%;
	padding: 10px 12px;
	margin: 15px 0 10px;
	line-height: 1;
	font-family: Arial;
	font-size: 16px;
	font-weight: 100;
	font-style: italic;
	text-align: center;
	color: #777;
	border: 1px solid #CACACA;
	box-shadow: 0px 2px 2px rgba(0, 1, 1, 0.02) inset;
	background: #FFF linear-gradient(to bottom, rgba(0, 1, 1, 0.03) 0px, rgba(255, 255, 255, 0.03) 100%) repeat scroll 0% 0%;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}
#optin-form-side-button {
	width: 100%;
	padding: 15px 5px;
	min-height: 44px;
	border-width: 0;
	border-radius: 5px;
	background: #00c080;
	box-shadow: none;
	line-height: 1;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	border-style: solid;
	font-family: Arial;
    font-size: 18px;
	font-weight: bold;
	color: #FFF;
	cursor: pointer;
}
#optin-form-side-button:hover {
	background-color:#009664;
}
.optin-form-main-input {
	display: block;
	height: 40px;
	width: 100%;
	padding: 10px 12px;
	margin: 15px 0 10px;
	line-height: 1;
	font-family: Arial;
	font-size: 18px;
	font-weight: 100;
	font-style: italic;
	text-align: center;
	color: #777;
	border: 1px solid #CACACA;
	box-shadow: 0px 2px 2px rgba(0, 1, 1, 0.02) inset;
	background: #FFF linear-gradient(to bottom, rgba(0, 1, 1, 0.03) 0px, rgba(255, 255, 255, 0.03) 100%) repeat scroll 0% 0%;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}
#optin-form-main-button {
	width: 100%;
	padding: 15px 5px;
	min-height: 44px;
	border-width: 0;
	border-radius: 5px;
	background: #00c080;
	box-shadow: none;
	line-height: 1.3;
	text-align: center;
	text-decoration: none;
	display: block;
	border-style: solid;
	font-family: Arial;
    font-size: 20px;
	font-weight: bold;
	color: #FFF;
	cursor: pointer;
}
#optin-form-main-button:hover {
	background-color:#009664;
}


.easybuildr-home-menu {
    margin-top: 10px !important;
	position: relative;
}
.easybuildr-menu-toggle {
	display: none;
	width: 100%;
	min-height: 44px;
	padding: 12px 14px;
	border: 1px solid #d6d6d6;
	background: #ffffff;
	font: inherit;
	font-weight: bold;
	text-align: left;
	cursor: pointer;
}
.easybuildr-menu-toggle-icon {
	display: inline-block;
	width: 18px;
	height: 12px;
	position: relative;
	margin-right: 10px;
	vertical-align: middle;
}
.easybuildr-menu-toggle-icon span {
	display: block;
	position: absolute;
	left: 0;
	width: 100%;
	height: 2px;
	background: #333333;
}
.easybuildr-menu-toggle-icon span:nth-child(1) { top: 0; }
.easybuildr-menu-toggle-icon span:nth-child(2) { top: 5px; }
.easybuildr-menu-toggle-icon span:nth-child(3) { top: 10px; }

@media only screen and (max-width: 768px) {
	html, body {
		font-size: 16px;
	}
	.main {
		max-width: 100%;
	}
	.container {
		flex-direction: column;
		gap: 15px;
		padding: 12px;
	}
	.content,
	.sidebar-left,
	.sidebar-right {
		width: 100% !important;
		max-width: 100% !important;
		display: block;
		margin: 0;
	}
	.sidebar-left,
	.sidebar-right {
		padding-left: 10px;
		padding-right: 10px;
	}
	.form-container-main {
		max-width: 100%;
	}
	table {
		width: 100% !important;
		display: block;
		overflow-x: auto;
	}
	.header-image img,
	.header img {
		height: auto !important;
	}
	.easybuildr-home-menu {
    margin-top: 10px !important;
		display: block !important;
	}
	.easybuildr-home-menu .menu-icon-wrap,
	.easybuildr-home-menu .menu-icon-wrap img {
		display: none !important;
	}
	.easybuildr-menu-toggle {
		display: block;
		margin: 0 0 10px;
	}
	.easybuildr-home-menu.is-collapsed a {
		display: none !important;
	}
	.easybuildr-home-menu.is-open a {
		display: block !important;
		width: 100% !important;
		margin: 0 0 8px !important;
		padding: 12px 14px !important;
		text-align: left !important;
	}
	.content-pages-grid {
		display: block;
	}
	.content-page-card {
		width: 100% !important;
		padding: 5px 0 !important;
	}
	.optin-form-side-input,
	.optin-form-main-input,
	input[type=email],
	input[type=text] {
		font-size: 16px;
	}
	#optin-form-side-button,
	#optin-form-main-button {
		font-size: 18px;
	}
}

@media only screen and (max-width: 480px) {
	.container {
		padding: 8px;
		gap: 10px;
	}
	.content,
	.sidebar-left,
	.sidebar-right {
		padding: 10px !important;
	}
	.easybuildr-home-menu.is-open a {
		padding: 10px 12px !important;
	}
}
<?php echo str_replace(array('<style>','
@media (max-width: 768px) {
  .header,
  .header-image,
  .header img {
    width: 100% !important;
    max-width: 100% !important;
  }

  .container {
    flex-direction: column !important;
  }

  .content,
  .sidebar-left,
  .sidebar-right {
    width: 100% !important;
    max-width: 100% !important;
  }
}

@media (max-width: 480px) {
  .content,
  .sidebar-left,
  .sidebar-right {
    padding: 10px !important;
  }
}


@media (max-width: 768px) {
  .sidebar-right {
    padding: 0 !important;
  }
}


@media (max-width: 768px) {
  .sidebar-right,
  .sidebar-left {
    padding: 0 !important;
  }
}

@media (max-width: 480px) {
}


.mobile-title-bar {
  background-color:#000000;
  height:30px;
}

@media (max-width:768px){
  .mobile-title-bar{
    display:block;
    width:100% !important;
    background-color:#f9f9f9 !important;
    padding:10px !important;
    height:auto !important;
    text-align:left;
  }
}








.responsive-title-bar {
	width: 100%;
	max-width: 100%;
	box-sizing: border-box;
	display: block;
	padding: 4px 10px;
	line-height: 22px;
	text-align: left;
	margin: 0 0 10px 0;
}
.responsive-title-bar span {
	color: inherit;
}

@media only screen and (max-width:768px) {
	.container {
		display: flex !important;
		flex-direction: column !important;
	}
	.container > .content {
		order: 1 !important;
	}
	.container > .sidebar-left,
	.container > .sidebar-right {
		order: 2 !important;
	}
	.responsive-title-bar {
		width: 100% !important;
		max-width: 100% !important;
		display: block !important;
		margin-left: 0 !important;
		margin-right: 0 !important;
	}
}

@media only screen and (max-width:480px) {
	.responsive-title-bar {
		height: auto !important;
		padding: 8px 10px;
		line-height: 1.3;
	}
}


/* FORCE vertical centering fix */
.responsive-title-bar {
  display: flex !important;
  align-items: center !important;
  height: 30px !important;
  padding: 0 10px !important;
  box-sizing: border-box !important;
}
.responsive-title-bar span {
  display: inline-block;
  line-height: normal !important;
}


/* Let title bars size naturally so text can center cleanly */
.responsive-title-bar {
  display: flex !important;
  align-items: center !important;
  min-height: 30px !important;
  height: auto !important;
  padding: 6px 10px !important;
  box-sizing: border-box !important;
  line-height: 1.2 !important;
}
.responsive-title-bar span {
  display: inline-block;
  line-height: 1.2 !important;
}
@media only screen and (max-width:480px) {
  .responsive-title-bar {
    padding: 8px 10px !important;
  }
}


.vid {
	display: block;
	width: 100%;
	clear: both;
	margin: 0 0 20px 0;
}
.vid p {
	width: auto !important;
	height: auto !important;
	margin: 0 0 15px 0 !important;
}
.vid iframe,
.vid video,
.vid embed,
.vid object {
	display: block;
	max-width: 100% !important;
	margin: 0;
}

@media only screen and (max-width: 768px) {
	.vid iframe,
	.vid video,
	.vid embed,
	.vid object {
		width: 100% !important;
		height: auto !important;
	}
}


/* Keep iframe embeds at their pasted size on desktop, only scale down on smaller screens */
iframe {
	max-width: 100% !important;
}

@media only screen and (min-width: 769px) {
	.vid iframe {
		width: auto !important;
		height: auto !important;
		max-width: 100% !important;
	}
}

@media only screen and (max-width: 768px) {
	.vid iframe {
		width: 100% !important;
		height: auto !important;
	}
}





/* Safe reset for paragraph-wrapped video embeds */
.vid p {
  margin: 0 !important;
  padding: 0 !important;
}

</style>','< /style>'),'',$seo_arr['6']); ?>
</style>
<?php echo $seo_arr['5']; ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
	var menus = document.querySelectorAll('.easybuildr-home-menu');
	if (!menus.length) return;

	function setMenuState(menu) {
		var toggle = menu.querySelector('.easybuildr-menu-toggle');
		if (!toggle) return;
		if (window.innerWidth <= 768) {
			if (!menu.classList.contains('is-open')) {
				menu.classList.add('is-collapsed');
			}
		} else {
			menu.classList.remove('is-collapsed');
			menu.classList.remove('is-open');
		}
		var expanded = menu.classList.contains('is-open') ? 'true' : 'false';
		toggle.setAttribute('aria-expanded', expanded);
	}

	menus.forEach(function (menu) {
		if (menu.querySelector('.easybuildr-menu-toggle')) {
			setMenuState(menu);
			return;
		}

		var toggle = document.createElement('button');
		toggle.type = 'button';
		toggle.className = 'easybuildr-menu-toggle';
		toggle.setAttribute('aria-expanded', 'false');
		toggle.innerHTML = '<span class="easybuildr-menu-toggle-icon" aria-hidden="true"><span></span><span></span><span></span></span>Menu';
		menu.insertBefore(toggle, menu.firstChild);
		menu.classList.add('is-collapsed');

		toggle.addEventListener('click', function () {
			var isOpen = menu.classList.toggle('is-open');
			menu.classList.toggle('is-collapsed', !isOpen);
			toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
		});

		setMenuState(menu);
	});

	window.addEventListener('resize', function () {
		menus.forEach(setMenuState);
	});
});
</script>
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
echo  '<img src="./admin/images/custom_images/'.$filename.'" />';
	  }
?>
</div>
<?php
}
?>

<!--Right Sidebar Start -->
<?php
if($sidebar_arr['0']=='rightside')
{
?>
<div class="container">
	<div class="content">
<div class="responsive-title-bar responsive-title-bar-main" style="background-color:#<?php echo $design_arr[17]; ?>; color:#<?php echo $design_arr[18]; ?>;">▼ <span style="font-size:18px"><?php echo $design_arr['16']; ?></span> ▼</div>

      <?php echo $home_arr['6']; ?>
      <?php
      if (!empty($argument_arr['3'])) {
          $arr = explode(":::", $argument_arr['3']);
          echo $arr['1'];
      }
      ?>
<!-- New Pages Start -->
<?php
$count = 0;
$files = [];

if ($handle = opendir('content_pages/')) {
    $file_handle = fopen("admin/settings/order_content.txt", "rb");
    while (!feof($file_handle)) {
        $line_of_text = trim(fgets($file_handle));
        if (!empty($line_of_text)) {
            $files = array_merge($files, explode(';', $line_of_text));
        }
    }
    fclose($file_handle);
    closedir($handle);
}

$row_open = false;

foreach ($files as $file) {
    $filename = "./content_pages/$file";

    if (empty($file) || !file_exists($filename)) {
        continue;
    }

    $contents = file_get_contents($filename);
    $page_argument_arr = explode("#_1_#", $contents);
    $title = isset($page_argument_arr[1]) ? explode(":::", $page_argument_arr[1])[1] : "No title available";
    $content = isset($page_argument_arr[2]) ? explode(":::", $page_argument_arr[2])[1] : "No content available";

    $isHidden = isset($page_argument_arr[3]) && explode(":::", trim($page_argument_arr[3]))[1] == "0";

    if ($isHidden) {
        continue;
    }

    preg_match('/<img[^>]+src=["\']?([^"\'>]+)["\']?/i', $content, $matches);
    $imageSrc = isset($matches[1]) ? trim($matches[1]) : '';

    if (!empty($imageSrc) && (strpos($imageSrc, 'http://') === 0 || strpos($imageSrc, 'https://') === 0)) {
        $finalImageSrc = $imageSrc;
    } elseif (!empty($imageSrc)) {
        $finalImageSrc = $imageSrc;
    } else {
        $finalImageSrc = 'images/content-example.png';
    }

    $content = strip_tags($content, '<img>');

    $wordLimit = 15;
    $words = explode(' ', strip_tags($content));
    $trimmedContent = implode(' ', array_slice($words, 0, $wordLimit));

    if ($count % 2 == 0) {
        if ($row_open) {
            echo '</div>';
        }
        echo '<div class="content-pages-grid">';
        $row_open = true;
    }
?>

    <div class="content-page-card">
        <a id="page-button" href="<?php echo htmlspecialchars(pathinfo($file, PATHINFO_FILENAME)); ?>">
            <?php echo htmlspecialchars(html_entity_decode($title, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>
        </a>

        <p style="margin-top:5px; margin-bottom:5px">
        <?php if (!empty($finalImageSrc)) : ?>
            <img src="<?php echo htmlspecialchars($finalImageSrc); ?>" alt="Preview Image" 
                 style="width: 75px; height: auto; float: left; margin-right: 10px; margin-bottom: 5px;">
        <?php endif; ?>
        <?php echo htmlspecialchars(html_entity_decode($trimmedContent, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>...
        </p>
    </div>

<?php 
    $count++;
}

if ($row_open) {
    echo '</div>';
}
?>
<!-- New Pages End -->
<br>
<!--Custom CB Ads Local Main -->
    <?php renderHomeAdditionalAds($display_ads_home_page, $custom_home_ads); ?>
<!--Custom CB Ads Local Main -->
</div>

    <div class="sidebar-right">
	<?php if($sidebar_arr[19]=='topside') { ?>
<div class="responsive-title-bar responsive-title-bar-sidebar" style="background-color:#<?php echo $sidebar_arr[20]; ?>; color:#<?php echo $sidebar_arr[21]; ?>; ">
	<span>▼ <span style="font-size:16px"><?php echo $sidebar_arr['14']; ?></span> ▼</span>
</div>
    <div class="form-container-side">
	<?php include 'includes/optin-inline.php'; ?>
    </div>
    <?php echo $sidebar_arr['10']; ?>
<!--Custom CB Ads Local Side -->
    <?php include 'includes/ads_side.php'; ?>
<!--Custom CB Ads Local Side -->
	<?php } ?>
	<?php if($sidebar_arr[19]=='bottomside') { ?>
<div class="responsive-title-bar responsive-title-bar-sidebar" style="background-color:#<?php echo $sidebar_arr[20]; ?>; color:#<?php echo $sidebar_arr[21]; ?>; ">
	<span>▼ <span style="font-size:16px"><?php echo $sidebar_arr['14']; ?></span> ▼</span>
</div>
	<?php echo $sidebar_arr['10']; ?>
<!--Custom CB Ads Local Side -->
    <?php include 'includes/ads_side.php'; ?>
<!--Custom CB Ads Local Side -->
    <div class="form-container-side">
	<?php include 'includes/optin-inline.php'; ?>
    </div>
	<?php } ?>
    
	<?php if($sidebar_arr[19]=='none') { ?>
<div class="responsive-title-bar responsive-title-bar-sidebar" style="background-color:#<?php echo $sidebar_arr[20]; ?>; color:#<?php echo $sidebar_arr[21]; ?>; ">
	<span>▼ <span style="font-size:16px"><?php echo $sidebar_arr['14']; ?></span> ▼</span>
</div>
	<?php echo $sidebar_arr['10']; ?>
<!--Custom CB Ads Local Side -->
    <?php include 'includes/ads_side.php'; ?>
<!--Custom CB Ads Local Side -->
	<?php } ?>
    
    </div> 
    
</div>

<?php
}
?>

<!--Right Sidebar End -->


<!--Left Sidebar Start -->
<?php
if($sidebar_arr['0']=='leftside')
{
?>
<div class="container">
    <div class="sidebar-left">
	  <?php if($sidebar_arr[19]=='topside') { ?>
<div class="responsive-title-bar responsive-title-bar-sidebar" style="background-color:#<?php echo $sidebar_arr[20]; ?>; color:#<?php echo $sidebar_arr[21]; ?>; ">
	<span>▼ <span style="font-size:16px"><?php echo $sidebar_arr['13']; ?></span> ▼</span>
</div>
    <div class="form-container-side">
	<?php include 'includes/optin-inline.php'; ?>
    </div>
    <?php echo $sidebar_arr['9']; ?>
<!--Custom CB Ads Local Side -->
    <?php include 'includes/ads_side.php'; ?>
<!--Custom CB Ads Local Side -->
	  <?php } ?>
	  <?php if($sidebar_arr[19]=='bottomside') { ?>
<div class="responsive-title-bar responsive-title-bar-sidebar" style="background-color:#<?php echo $sidebar_arr[20]; ?>; color:#<?php echo $sidebar_arr[21]; ?>; ">
	<span>▼ <span style="font-size:16px"><?php echo $sidebar_arr['13']; ?></span> ▼</span>
</div>
    <?php echo $sidebar_arr['9']; ?>
<!--Custom CB Ads Local Side -->
    <?php include 'includes/ads_side.php'; ?>
<!--Custom CB Ads Local Side -->
    <div class="form-container-side">
	<?php include 'includes/optin-inline.php'; ?>
    </div>
	  <?php } ?>
      
	  <?php if($sidebar_arr[19]=='none') { ?>
<div class="responsive-title-bar responsive-title-bar-sidebar" style="background-color:#<?php echo $sidebar_arr[20]; ?>; color:#<?php echo $sidebar_arr[21]; ?>; ">
	<span>▼ <span style="font-size:16px"><?php echo $sidebar_arr['13']; ?></span> ▼</span>
</div>
    <?php echo $sidebar_arr['9']; ?>
<!--Custom CB Ads Local Side -->
    <?php include 'includes/ads_side.php'; ?>
<!--Custom CB Ads Local Side -->
	  <?php } ?>
      
    </div>
    <div class="content">
<div class="responsive-title-bar responsive-title-bar-main" style="background-color:#<?php echo $design_arr[17]; ?>; color:#<?php echo $design_arr[18]; ?>; ">
	<span>▼ <span style="font-size:18px"><?php echo $design_arr['16']; ?></span> ▼</span>
</div>

      <?php echo $home_arr['6']; ?>
      <?php
      if (!empty($argument_arr['3'])) {
          $arr = explode(":::", $argument_arr['3']);
          echo $arr['1'];
      }
      ?>
<!-- New Pages Start -->
<?php
$count = 0;
$files = [];

if ($handle = opendir('content_pages/')) {
    $file_handle = fopen("admin/settings/order_content.txt", "rb");
    while (!feof($file_handle)) {
        $line_of_text = trim(fgets($file_handle));
        if (!empty($line_of_text)) {
            $files = array_merge($files, explode(';', $line_of_text));
        }
    }
    fclose($file_handle);
    closedir($handle);
}

$row_open = false;

foreach ($files as $file) {
    $filename = "./content_pages/$file";

    if (empty($file) || !file_exists($filename)) {
        continue;
    }

    $contents = file_get_contents($filename);
    $page_argument_arr = explode("#_1_#", $contents);
    $title = isset($page_argument_arr[1]) ? explode(":::", $page_argument_arr[1])[1] : "No title available";
    $content = isset($page_argument_arr[2]) ? explode(":::", $page_argument_arr[2])[1] : "No content available";

    $isHidden = isset($page_argument_arr[3]) && explode(":::", trim($page_argument_arr[3]))[1] == "0";

    if ($isHidden) {
        continue;
    }

    preg_match('/<img[^>]+src=["\']?([^"\'>]+)["\']?/i', $content, $matches);
    $imageSrc = isset($matches[1]) ? trim($matches[1]) : '';

    if (!empty($imageSrc) && (strpos($imageSrc, 'http://') === 0 || strpos($imageSrc, 'https://') === 0)) {
        $finalImageSrc = $imageSrc;
    } elseif (!empty($imageSrc)) {
        $finalImageSrc = $imageSrc;
    } else {
        $finalImageSrc = 'images/content-example.png';
    }

    $content = strip_tags($content, '<img>');

    $wordLimit = 15;
    $words = explode(' ', strip_tags($content));
    $trimmedContent = implode(' ', array_slice($words, 0, $wordLimit));

    if ($count % 2 == 0) {
        if ($row_open) {
            echo '</div>';
        }
        echo '<div class="content-pages-grid">';
        $row_open = true;
    }
?>

    <div class="content-page-card">
        <a id="page-button" href="<?php echo htmlspecialchars(pathinfo($file, PATHINFO_FILENAME)); ?>">
            <?php echo htmlspecialchars(html_entity_decode($title, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>
        </a>

        <p style="margin-top:5px; margin-bottom:5px">
        <?php if (!empty($finalImageSrc)) : ?>
            <img src="<?php echo htmlspecialchars($finalImageSrc); ?>" alt="Preview Image" 
                 style="width: 75px; height: auto; float: left; margin-right: 10px; margin-bottom: 5px;">
        <?php endif; ?>
        <?php echo htmlspecialchars(html_entity_decode($trimmedContent, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>...
        </p>
    </div>

<?php 
    $count++;
}

if ($row_open) {
    echo '</div>';
}
?>
<!-- New Pages End -->
<br>
<!--Custom CB Ads Local Main -->
    <?php renderHomeAdditionalAds($display_ads_home_page, $custom_home_ads); ?>
<!--Custom CB Ads Local Main -->
        
      </div>  
</div>
<?php
}
?>
<!--Left Sidebar End -->

<!--No Sidebar Start -->
<?php
if($sidebar_arr['0']=='none')
{
?>
<div class="container">
    <div class="content">
<div class="responsive-title-bar responsive-title-bar-main" style="background-color:#<?php echo $design_arr[17]; ?>; color:#<?php echo $design_arr[18]; ?>; ">
	<span>▼ <span style="font-size:18px"><?php echo $design_arr['16']; ?></span> ▼</span>
</div>

      <?php echo $home_arr['6']; ?>
      <?php
      if (!empty($argument_arr['3'])) {
          $arr = explode(":::", $argument_arr['3']);
          echo $arr['1'];
      }
      ?>
<!-- New Pages Start -->
<?php
$count = 0;
$files = [];

if ($handle = opendir('content_pages/')) {
    $file_handle = fopen("admin/settings/order_content.txt", "rb");
    while (!feof($file_handle)) {
        $line_of_text = trim(fgets($file_handle));
        if (!empty($line_of_text)) {
            $files = array_merge($files, explode(';', $line_of_text));
        }
    }
    fclose($file_handle);
    closedir($handle);
}

$row_open = false;

foreach ($files as $file) {
    $filename = "./content_pages/$file";

    if (empty($file) || !file_exists($filename)) {
        continue;
    }

    $contents = file_get_contents($filename);
    $page_argument_arr = explode("#_1_#", $contents);
    $title = isset($page_argument_arr[1]) ? explode(":::", $page_argument_arr[1])[1] : "No title available";
    $content = isset($page_argument_arr[2]) ? explode(":::", $page_argument_arr[2])[1] : "No content available";

    $isHidden = isset($page_argument_arr[3]) && explode(":::", trim($page_argument_arr[3]))[1] == "0";

    if ($isHidden) {
        continue;
    }

    preg_match('/<img[^>]+src=["\']?([^"\'>]+)["\']?/i', $content, $matches);
    $imageSrc = isset($matches[1]) ? trim($matches[1]) : '';

    if (!empty($imageSrc) && (strpos($imageSrc, 'http://') === 0 || strpos($imageSrc, 'https://') === 0)) {
        $finalImageSrc = $imageSrc;
    } elseif (!empty($imageSrc)) {
        $finalImageSrc = $imageSrc;
    } else {
        $finalImageSrc = 'images/content-example.png';
    }

    $content = strip_tags($content, '<img>');

    $wordLimit = 15;
    $words = explode(' ', strip_tags($content));
    $trimmedContent = implode(' ', array_slice($words, 0, $wordLimit));

    if ($count % 2 == 0) {
        if ($row_open) {
            echo '</div>';
        }
        echo '<div class="content-pages-grid">';
        $row_open = true;
    }
?>

    <div class="content-page-card">
        <a id="page-button" href="<?php echo htmlspecialchars(pathinfo($file, PATHINFO_FILENAME)); ?>">
            <?php echo htmlspecialchars(html_entity_decode($title, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>
        </a>

        <p style="margin-top:5px; margin-bottom:5px">
        <?php if (!empty($finalImageSrc)) : ?>
            <img src="<?php echo htmlspecialchars($finalImageSrc); ?>" alt="Preview Image" 
                 style="width: 75px; height: auto; float: left; margin-right: 10px; margin-bottom: 5px;">
        <?php endif; ?>
        <?php echo htmlspecialchars(html_entity_decode($trimmedContent, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>...
        </p>
    </div>

<?php 
    $count++;
}

if ($row_open) {
    echo '</div>';
}
?>
<!-- New Pages End -->
<br>
<!--Custom CB Ads Local Main -->
    <?php renderHomeAdditionalAds($display_ads_home_page, $custom_home_ads); ?>
<!--Custom CB Ads Local Main -->
        
      </div>  
</div>
<?php
}
?>
<!--No Sidebar End -->

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

<script>
(function () {
  function moveLeftSidebarForMobile() {
    var containers = document.querySelectorAll('.container');
    for (var i = 0; i < containers.length; i++) {
      var container = containers[i];
      var leftSidebar = container.querySelector(':scope > .sidebar-left');
      var content = container.querySelector(':scope > .content');
      if (!leftSidebar || !content) continue;

      if (window.innerWidth <= 768) {
        if (content.nextElementSibling !== leftSidebar) {
          container.appendChild(leftSidebar);
        }
      } else {
        if (container.firstElementChild !== leftSidebar) {
          container.insertBefore(leftSidebar, content);
        }
      }
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', moveLeftSidebarForMobile);
  } else {
    moveLeftSidebarForMobile();
  }

  window.addEventListener('resize', moveLeftSidebarForMobile);
})();
</script>



<script>
(function () {
  function updateHomeVideoWrap() {
    var videos = document.querySelectorAll('.vid');
    for (var i = 0; i < videos.length; i++) {
      var vid = videos[i];
      var p = vid.querySelector('p');
      var media = vid.querySelector('iframe, video, embed, object');

      if (window.innerWidth > 768) {
        vid.style.display = 'inline-block';
        vid.style.float = 'left';
        vid.style.width = 'auto';
        vid.style.maxWidth = '560px';
        vid.style.clear = 'none';
        vid.style.margin = '20px 20px 15px 0';

        if (p) {
          p.style.width = 'auto';
          p.style.height = 'auto';
          p.style.margin = '0';
          p.style.padding = '0';
        }

        if (media) {
          media.style.display = 'block';
          media.style.width = '';
          media.style.maxWidth = '100%';
          media.style.height = '';
          media.style.margin = '0';
        }
      } else {
        vid.style.display = 'block';
        vid.style.float = 'none';
        vid.style.width = '100%';
        vid.style.maxWidth = '100%';
        vid.style.clear = 'both';
        vid.style.margin = '0 0 20px 0';

        if (p) {
          p.style.width = 'auto';
          p.style.height = 'auto';
          p.style.margin = '0 0 15px 0';
          p.style.padding = '0';
        }

        if (media) {
          media.style.display = 'block';
          media.style.width = '100%';
          media.style.maxWidth = '100%';
          media.style.height = 'auto';
          media.style.margin = '0';
        }
      }
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', updateHomeVideoWrap);
  } else {
    updateHomeVideoWrap();
  }

  window.addEventListener('resize', updateHomeVideoWrap);
})();
</script>

</body>
</html>
