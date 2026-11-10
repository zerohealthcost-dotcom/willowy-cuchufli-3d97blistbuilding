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

$success = false;
$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);
    $settings_file = "settings/admin_settings.txt";

    if (file_exists($settings_file)) {
        $contents = file_get_contents($settings_file);
        $admin_arr = explode("#_1_#", $contents);

        if (isset($admin_arr[3]) && $email === $admin_arr[3]) {
            $to = "$admin_arr[2] <$admin_arr[3]>";
            $subject = "Your Username and Password";
            $from = "Website Admin <$admin_arr[3]>";
            $message = "Hi {$admin_arr[2]},\n\nHere are your login details:\n\nUsername: {$admin_arr[0]}\nPassword: {$admin_arr[1]}\n\nRegards,\nWebsite Admin.";
            
            mail($to, $subject, $message, "From: $from");
            $success = true;
			$sent_to_email = htmlspecialchars($email);
        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
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
    <td align="center" valign="middle"><div class="red-div"><strong>Enter your email address that you used in your website and your username and password will be sent to your email.</strong></div></td>
  </tr>
  <tr>
    <td align="center" valign="middle"></td>
  </tr>
</table>
<!--Side Nav -->    </td>
    <td width="706" align="left" valign="top" style="padding-left:10px; padding-right:10px; padding-top:20px; padding-bottom:20px"><div class="members_title"><strong>Forgot Your Username or Password?</strong></div>
<!--Main -->
      <table width="705" border="0" cellspacing="0" cellpadding="0">
<form method="post">
            <tr>
              <td height="100" align="center" valign="middle" class="title1"><p><span class="main1b">Enter your email address that you used in your website and your username and password<br>
                  will be sent to your email.</span></p>
                </td>
            </tr>
<?php if ($success): ?>
            <tr>
              <td height="50" align="center" valign="middle" class="saved">Your username and password have been sent to your email address:<br /><?php echo $sent_to_email; ?><br />Please check your inbox! <img src="images/check-green2.png" width="20" height="20" align="absmiddle" /></td>
            </tr>
<?php elseif ($error): ?>
            <tr>
            <td height="50" align="center" valign="middle" class="error">Invalid email address. Please try again <img src="images/x-red.png" width="20" height="20" align="absmiddle" />            </tr>
<?php endif; ?>
            <tr>
              <td height="100" align="center" valign="middle" class="title1"><p><span class="main1b">Return to the login page <a href="./">here</a>.</span></p>
              </td>
            </tr>

            <tr>
              <td height="50" align="center" valign="middle">Email Address: 
              <input name="email" type="text" style="width:300px"></td>
            </tr>
            <tr>
              <td height="20" align="center" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td height="50" align="center" valign="middle"><p>
                  <input type="submit" name="Submit" value="Send Username/Password" id="submit">
              </p></td>
            </tr>
            <tr>
              <td height="50" align="center" valign="middle">&nbsp;</td>
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
