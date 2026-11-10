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
ini_set('display_errors', 1);

// Ensure session security
if (!isset($_SESSION['sec'])) {
    $_SESSION['sec'] = 0;
}

$htaccess_path = __DIR__ . '/.htaccess';
if (!file_exists($htaccess_path)) {
    file_put_contents(
        $htaccess_path,
            'RewriteEngine on
RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond $0#%{REQUEST_URI} ([^#]*)#(.*)\1$
RewriteRule ^(.*)$ %2showpage.php?view=$1 [QSA,L]'
    );
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['pass'])) {
    $settings_file = "settings/admin_settings.txt";
    
    if (file_exists($settings_file)) {
        $contents = file_get_contents($settings_file);
        $admin_arr = explode("#_1_#", $contents);
        
        if ($admin_arr[0] === $_POST['username'] && $admin_arr[1] === $_POST['pass']) {
            $_SESSION['logged_in'] = true;
            $_SESSION['sec'] = 1;
            header("Location: welcome.php");
            exit;
        }
    }
    header("Location: index.php?flag=1");
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
    <td align="center" valign="middle"><div class="red-div"><strong>Log Into Your Admin Panel With Your Username & Password!</strong></div></td>
  </tr>
  <tr>
    <td align="center" valign="middle"></td>
  </tr>
</table>
<!--Side Nav -->    </td>
    <td width="706" align="left" valign="top" style="padding-left:10px; padding-right:10px; padding-top:20px; padding-bottom:20px"><div class="members_title"><strong>Admin Login</strong></div>
      <!--Main -->
      <table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
    <form method="post">
            <tr>
              <td height="50" align="center" valign="middle" class="title1">&nbsp;</td>
            </tr>
<?php if (isset($_GET['flag']) && $_GET['flag'] == 1): ?>
            <tr>
              <td height="50" align="center" valign="middle" class="error">Wrong, username/password. Please try again <img src="images/x-red.png" width="20" height="20" align="absmiddle" /></td>
            </tr>
<?php endif; ?>
            <?php
		if(!empty($_REQUEST['flag']) and $_REQUEST['flag']==2)
		  {
?>
            <tr>
              <td height="50" align="center" valign="middle" class="error">You need to login in to access that page <img src="images/x-red.png" width="20" height="20" align="absmiddle" /></td>
            </tr>
            <?php
		}
?>
            <tr>
              <td height="50" align="center" valign="middle">Username: 
              <input name="username" type="text" style="width:300px"></td>
            </tr>
            <tr>
              <td height="50" align="center" valign="middle">Password: 
              <input name="pass" type="password" style="width:300px"></td>
            </tr>
            <tr>
              <td height="20" align="center" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td height="50" align="center" valign="middle"><p>
                  <input type="submit" name="Submit" value="Login" id="submit">
              </p></td>
            </tr>
            <tr>
              <td height="60" align="center" valign="middle">
              <br>
              <br>
                  <a href="forgot.php">Forgot Your Username/Password? Click Here.</a>
                  <br>
                  <br>              </td>
            </tr>
          </form>
      </table>
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
