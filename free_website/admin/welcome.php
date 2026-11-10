<?php
/*
 * ⚠️ COPYRIGHT NOTICE
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

// License
require_once "./includes/init.php";

if( $_SESSION['logged_in'] != true ){
    header("location:index.php?flag=2");
    exit;
}
		 
if ( isset( $_GET[ 'download_backup' ] ) ){
    require_once './upgrade/config.php';
	require_once './upgrade/upgrade.php';
	$upgrader = new Upgrader( $config );
	$backup_status = $upgrader->getBackupInfo();

	if ( !$backup_status['success'] ) {
		header('Content-Type: text/html; charset=utf-8');
		echo '<h2>Backup Error</h2>';
		echo '<p>' . htmlspecialchars($backup_status['message'], ENT_QUOTES, 'UTF-8') . '</p>';
		exit;
	}

	$file_name = dirname( __FILE__  ) . '/upgrade/backup/website-backup.zip';
	if ( !file_exists($file_name) ) {
		header('Content-Type: text/html; charset=utf-8');
		echo '<h2>Backup Error</h2>';
		echo '<p>Backup file could not be created.</p>';
		exit;
	}
	header( 'Content-type: application/zip' ); 
	header( 'Content-Disposition: attachment; filename=website-backup.zip' );
	header( 'Content-length: ' . filesize( $file_name ) );
	header( 'Pragma: no-cache' ); 
	header( 'Expires: 0' ); 
	readfile( $file_name );
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>Free Monthly Websites Admin Area</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="icon" href="images/favicon.png" type="image/png">
<script type="text/javascript">
function mm_showHide(id)
{
    a=document.getElementById(id);
    if(a.style.display != 'none' && a.style.display != 'block') a.style.display='none';
    if(a.style.display == 'block') {
        a.style.display='none';
    }
    else {
        a.style.display='block';
    }
    return false;
}
</script>
</head>

<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="table_border">
  <tr>
    <td colspan="2" align="left" valign="top"><div align="center" class="header_bg"><img src="images/logo.png" width="900" height="77" /></div></td>
  </tr>
  <tr>
    <td width="250" align="center" valign="top" style="padding-left:10px; padding-right:10px; padding-top:20px; padding-bottom:20px">
<!--Side Nav -->
        <table width="250" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="middle"></td>
          </tr>
          <tr>
            <td align="center" valign="middle"><div class="members_title"><strong>Navigation</strong></div></td>
          </tr>
          <tr>
            <td height="10" align="center" valign="middle"></td>
          </tr>
          <tr>
            <td height="30" align="center" valign="middle"><div id="link"><a href="../" target="_blank" id="link"><b>View Your Website</b></a></div></td>
          </tr>
          <tr>
            <td height="20" align="center" valign="middle"></td>
          </tr>
          <tr>
            <td height="30" align="center" valign="middle"><div id="link"><a id="link" href="welcome.php"><b>Home</b></a></div></td>
          </tr>
          <tr>
            <td height="30" align="center" valign="middle"><div id="link"><a id="link" href="admin_settings.php"><b>Admin Settings</b></a></div></td>
          </tr>
          <tr>
            <td height="30" align="center" valign="middle"><div id="link"><a id="link" href="design_settings.php"><b>Design/Basic Settings</b></a></div></td>
          </tr>
          <tr>
            <td height="30" align="center" valign="middle"><div id="link"><a id="link" href="home_page_settings.php"><b>Home Page Settings</b></a></div></td>
          </tr>
          <tr>
            <td height="30" align="center" valign="middle"><div id="link"><a id="link" href="sidebar_settings.php"><b>Sidebar Settings</b></a></div></td>
          </tr>
          <tr>
            <td height="30" align="center" valign="middle"><div id="link"><a id="link" href="optin_settings.php"><b>Optin Page Settings</b></a></div></td>
          </tr>
          <tr>
            <td height="30" align="center" valign="middle"><div id="link"><a id="link" href="download_page_settings.php"><b>Download Page Settings</b></a></div></td>
          </tr>
          <tr>
            <td height="10" align="center" valign="middle"></td>
          </tr>

          <tr>
            <td height="20" align="center" valign="middle"></td>
          </tr>
          <tr>
            <td height="30" align="center" valign="middle"><div id="link"><a id="link" href="add_content_pages.php"><b>Add/Remove Pages</b></a></div></td>
          </tr>
          <tr>
            <td height="30" align="center" valign="middle"><div id="link"><a id="link" href="edit_content_pages.php"><b>Edit Pages</b></a></div></td>
          </tr>
          <tr>
            <td height="20" align="center" valign="middle"></td>
          </tr>
          <tr>
            <td height="30" align="center" valign="middle"><div id="link"><a id="link" href="privacy_terms_settings.php"><b>Privacy/Terms Settings</b></a></div></td>
          </tr>
          <tr>
            <td height="20" align="center" valign="middle"></td>
          </tr>
          <tr>
            <td height="30" align="center" valign="middle"><div id="link"><a id="link" href="seo_settings.php"><b>S.E.O/CSS/Script Settings</b></a></div></td>
          </tr>
          <tr>
            <td height="10" align="center" valign="middle"></td>
          </tr>
          <tr>
            <td height="30" align="center" valign="middle"><div id="link"><a id="link" href="logout.php"><b>Log Out</b></a></div></td>
          </tr>
          <tr>
            <td align="center" valign="middle"></td>
          </tr>
        </table>
<!--Side Nav -->
    </td>

    <td width="706" align="left" valign="top" style="padding-left:10px; padding-right:10px; padding-top:20px; padding-bottom:20px"><div class="members_title"><strong>Welcome to Your Website Admin Area!</strong></div>

<?php require "./upgrader.php"; ?>	
      <p align="center">
<!--Main -->
<!-- Admin-Welcome -->
<div id="target"></div>
<div style="text-align:center;">
<?php

function fetch_remote_content_cached(
    string $url,
    string $cacheFile,
    int $cacheTtl = 300,
    int $connectTimeout = 5,
    int $totalTimeout = 10
): string {
    $cacheIsValid = file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTtl);

    if ($cacheIsValid) {
        $cached = file_get_contents($cacheFile);
        return $cached !== false ? $cached : '';
    }

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => $connectTimeout,
        CURLOPT_TIMEOUT        => $totalTimeout,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS      => 3,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_USERAGENT      => 'FMW3-Admin-Welcome/1.0',
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        error_log('cURL error fetching ' . $url . ': ' . curl_error($ch));
        curl_close($ch);

        if (file_exists($cacheFile)) {
            $stale = file_get_contents($cacheFile);
            return $stale !== false ? $stale : '';
        }

        return '';
    }

    $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        error_log('HTTP ' . $httpCode . ' returned for ' . $url);

        if (file_exists($cacheFile)) {
            $stale = file_get_contents($cacheFile);
            return $stale !== false ? $stale : '';
        }

        return '';
    }

    file_put_contents($cacheFile, $response, LOCK_EX);
    return $response;
}

$url = 'https://freemonthlywebsites.com/feeds/fmw3-free-admin-welcome/';
$cacheFile = __DIR__ . '/cache/admin-welcome.html';

$cacheDir = dirname($cacheFile);
if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0755, true);
}

echo fetch_remote_content_cached($url, $cacheFile, 300);

?>
</div>
<!-- /Admin-Welcome -->
 <p>We've made this as simple as possible for you to edit every aspect of your website, with the use of our very special admin area. Simply use the navigation to edit your individual settings.</p>
 <p>If you ever need to backup your entire website, you can do that any time from <a href="welcome.php?download_backup=1">here</a>.</p>
 <p>You'll find  tool tips included in the admin area, just click on the <span style="color: #FFFFFF"><b style="background-color:#000000">&nbsp;?&nbsp;</b></span> for help in each section. </p>
 <p align="left">If you'd like to be kept upto date with the latest updates, please enter your details below:</p>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td height="332" align="center" valign="top"><p class="optin-text">Enter your name and email below and we'll keep you updated when new versions are available and updates added!</p>
<!--Free Monthly Websites Updates -->
<form method="post" class="af-form-wrapper" accept-charset="UTF-8" action="https://www.aweber.com/scripts/addlead.pl"  >
<div style="display: none;">
<input type="hidden" name="meta_web_form_id" value="" />
<input type="hidden" name="meta_split_id" value="" />
<input type="hidden" name="listname" value="freemonthly2" />
<input type="hidden" name="redirect" value="https://freemonthlywebsites.com/confirmed/" />
<input type="hidden" name="meta_redirect_onlist" value="https://freemonthlywebsites.com/confirmed/">
<input type="hidden" name="meta_adtracking" value="" />
<input type="hidden" name="meta_message" value="1" />
<input type="hidden" name="meta_required" value="name,email" />
<input type="hidden" name="meta_tooltip" value="" />
</div>      
        <input name="name" type="text" class="optin-input" value="Enter your first name here..." onFocus=" if (this.value == 'Enter your first name here...') { this.value = ''; }" onBlur="if (this.value == '') { this.value='Enter your first name here...';} " autocomplete="name" />
        
        <input name="email" type="email" class="optin-input" value="Enter your best email here..." onFocus=" if (this.value == 'Enter your best email here...') { this.value = ''; }" onBlur="if (this.value == '') { this.value='Enter your best email here...';} " autocomplete="email" />
        <input name="Submit" type="submit" value="Keep me in The Loop!" id="optin-button" />
    </form>
<!--Free Monthly Websites Updates -->
    </td>
            </tr>
      </table>
<!-- You are not permitted to edit any code in this website -->
<div align="center">
<div class="image-rotator-ad"></div>
  <script async src="https://freemonthlywebsites.com/feeds/fmw3/?embed=1"></script>
  <a href="#" onClick="mm_showHide('help_ads');return false;" style="text-decoration:none"><span class="small_txt"><u>Remove this advert</u></span></a>
</div>
<table width="705" border="0" align="center" cellspacing="0" cellpadding="0">
         <tr>
              <td align="center" valign="middle"><div class="upgrade_cell" id="help_ads" style="display:none;"> 
                <p><strong>Sorry, this function is reserved for <a href="https://freemonthlywebsites.com/premier" target="_blank">Premier Members Only</a>! </strong></p>
                <p>Premier Members admin area will not show banner adverts.<br>
If you are interested in upgrading to Premier Membership, you can see all the benefits that it offers, and also upgrade from <a href="https://freemonthlywebsites.com/premier" target="_blank">HERE</a>.</p>
              </div></td>
         </tr>
</table>
<!-- You are not permitted to edit any code in this website -->
<!--Main --></td>
  </tr>

</table>
<div align="center">
    <span class="footer_policy">
        No part of this website may be reproduced or transmitted in any form or by any means without written permission<br />
        <strong>&copy; <?php echo date('Y'); ?> FreeMonthlyWebsites.com. All Rights Reserved.</strong>
    </span>
</div>
</body>
</html>
