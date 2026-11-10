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
// License
require_once "./includes/init.php";


error_reporting(E_ERROR);
ini_set('display_errors', 1);

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php?flag=2");
    exit;
}

$settings_file = "settings/admin_settings.txt";
$success = false;
$error = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['user_name']);
    $password = trim($_POST['password']);
    $f_name = trim($_POST['f_name']);
    $email = trim($_POST['email']);

    $content = $username . "#_1_#" . $password . "#_1_#" . $f_name . "#_1_#" . $email;

    if (file_put_contents($settings_file, $content) !== false) {
        $success = true;
    } else {
        $error = true;
    }
}

// Load current settings
$admin_arr = file_exists($settings_file) ? explode("#_1_#", file_get_contents($settings_file)) : ["", "", "", ""];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>Free Monthly Websites Admin Area</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="icon" href="images/favicon.png" type="image/png">
<style type="text/css">
<!--
#help_user { display:none; }
#help_pass { display:none; }
#help_name { display:none; }
#help_email { display:none; }
-->
</style>
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

    <td width="706" align="left" valign="top" style="padding-left:10px; padding-right:10px; padding-top:20px; padding-bottom:20px"><div class="members_title"><strong>Admin Settings</strong></div>
      <!--Main -->
      <table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
<script language="JavaScript">
	function chk()
	{
		if(document.frm.user_name.value=="")
		{
			alert("Please enter a unique username.");
			document.frm.user_name.focus();
			return false;
		}
		if(document.frm.password.value=="")
		{
			alert("Please enter a unique password.");
			document.frm.password.focus();
			return false;
		}
	}
          </script>

<form method="post">
            
<?php if ($success): ?>
            <tr>
              <td height="50" colspan="2" align="center" valign="middle" class="saved">Data saved successfully <img src="images/check-green2.png" width="20" height="20" align="absmiddle" /></td>
            </tr>
<?php endif; ?>
            <tr>
              <td height="100" colspan="2" align="center" valign="middle"><p>Please enter a unique  Username and Password, this will secure your settings.<br />
                Please choose a memorable  password and never give out your password to anyone.</p>
              <p>Your Name and Email are needed to confirm your 'lost password', should you need to use it.</p></td>
            </tr>
            <tr>
              <td width="300" height="50" align="center" valign="middle">Your Admin Username: </td>
              <td width="405" height="50" align="left" valign="middle"><input name="user_name" type="text" style="width:300px" value="<?php echo htmlspecialchars($admin_arr[0]); ?>">
                <a href="#" onClick="mm_showHide('help_user');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top"></a> </td>
          </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_user">
                Enter a username for login access to your admin control panel.<br />
                This will override any existing username so make sure you make a note of it before saving.
              </div></td>
            </tr>
            <tr>
              <td height="50" align="center" valign="middle">Your Admin Password: </td>
              <td height="50" align="left" valign="middle"><input name="password" type="text" style="width:300px" value="<?php echo htmlspecialchars($admin_arr[1]); ?>">
                <a href="#" onClick="mm_showHide('help_pass');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top"></a> </td>
            </tr>
            <tr>
              <td height="50" colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_pass">
                Enter a password for login access to your admin control panel.<br />
                  This will override any existing password so make sure you make a note of it before saving.
              </div></td>
            </tr>
            <tr>
              <td height="50" align="center" valign="middle">Your Full Name: </td>
              <td height="50" align="left" valign="middle"><input name="f_name" type="text" style="width:300px" value="<?php echo htmlspecialchars($admin_arr[2]); ?>" autocomplete="name" />
                <a href="#" onClick="mm_showHide('help_name');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a> </td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_name"> Enter your full name here, this is used when emailing you your lost password. </div></td>
            </tr>
            <tr>
              <td height="50" align="center" valign="middle">Your Contact Email Address: </td>
              <td height="50" align="left" valign="middle"><input name="email" type="email" style="width:300px" value="<?php echo htmlspecialchars($admin_arr[3]); ?>" autocomplete="email" />
                <a href="#" onClick="mm_showHide('help_email');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a> </td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_email"> Enter your contact email address here, this is  needed to confirm your lost password, should you need to use it.
                Be sure to enter a valid email address here.<br>
Please note - Your emails might get rejected if your domain doesn’t allow unauthenticated email from that server.<br>
You should test this and if you don't receive an email then try using an email address from your actual domain that you have this site located on.</div></td>
            </tr>
            <tr>
              <td height="20" colspan="2" align="center" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td height="50" colspan="2" align="center" valign="middle"><p>
                <input type="submit" name="Submit" value="Save Admin Settings" id="submit">
              </p></td>
            </tr>
            <tr>
              <td height="50" colspan="2" align="center" valign="middle">
<!-- You are not permitted to edit any code in this website -->
<br><br><br>
<div align="center">
<div class="image-rotator-ad"></div>
  <script async src="https://freemonthlywebsites.com/feeds/fmw3/?embed=1"></script>
  <a href="#" onClick="mm_showHide('help_ads');return false;" style="text-decoration:none"><span class="small_txt"><u>Remove this advert</u></span></a></div>
<table width="705" border="0" align="center" cellspacing="0" cellpadding="0">
         <tr>
              <td align="center" valign="middle"><div class="upgrade_cell" id="help_ads" style="display:none;"> 
                <p><strong>Sorry, this function is reserved for <a href="https://freemonthlywebsites.com/premier" target="_blank">Premier Members Only</a>! </strong></p>
                <p>Premier Members admin area will not show banner adverts.<br>
If you are interested in upgrading to Premier Membership, you can see all the benefits that it offers, and also upgrade from <a href="https://freemonthlywebsites.com/premier" target="_blank">HERE</a>.</p>
              </div></td>
         </tr>
</table>
<!-- You are not permitted to edit any code in this website -->              </td>
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
