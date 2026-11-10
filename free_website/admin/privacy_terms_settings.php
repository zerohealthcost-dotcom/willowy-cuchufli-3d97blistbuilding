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


error_reporting(E_ERROR);
ini_set('display_errors', 1);

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php?flag=2");
    exit;
}

$settings_file = "settings/privacy_terms_settings.txt";
$success = false;
$error = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $privacy = trim($_POST['privacy'] ?? '');
    $terms = trim($_POST['terms'] ?? '');
    $display = isset($_POST['display_privacy_terms']) ? '1' : '0';

    $content = $privacy . "#_1_#" . $terms . "#_1_#" . $display;

    if (file_put_contents($settings_file, $content) !== false) {
        $success = true;
    } else {
        $error = true;
    }
}

// Load existing settings
$privacy_terms_arr = file_exists($settings_file) ? explode("#_1_#", file_get_contents($settings_file)) : ["", "", "no"];
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
#help_privacy { display:none; }
#help_terms { display:none; }
#help_display_privacy_terms { display:none; }
-->
</style>
<script src="ckeditor/ckeditor.js"></script>
<script src="js/jscolor.min.js"></script>
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

    <td width="706" align="left" valign="top" style="padding-left:10px; padding-right:10px; padding-top:20px; padding-bottom:20px"><div class="members_title"><strong>Privacy/Terms Settings </strong></div>
      <!--Main -->
      <table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
<form method="post">
            
<?php if ($success): ?>
            <tr>
              <td height="50" colspan="2" align="center" valign="middle" class="saved">Data saved successfully <img src="images/check-green2.png" width="20" height="20" align="absmiddle" /></td>
            </tr>
<?php endif; ?>
            
            <tr>
              <td height="20" colspan="2" align="center" valign="middle">&nbsp;</td>
          </tr>
            <tr>
              <td height="50" colspan="2" align="center" valign="bottom" style="padding:10px">Privacy Policy: <a href="#" onClick="mm_showHide('help_privacy');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>If you need a great place to get your own Privacy Policy, Terms & Conditions and Cookie Consent all in one then we highly recommend you check out <a href="https://freemonthlywebsites.com/special/gdpr-my-site" target="_blank">GDPR My Site</a>.<br><br><a id='preview-butt' href="../privacy.php" target='_blank'>View Privacy Policy Page</a></td>
          </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_privacy">Enter any content for your Privacy Policy here using the WYSIWYG editor. <br />
                There is no limit to the amount of information you place here but we suggest you add a little at a time and keep checking your page to make sure it looks OK.<br />
                <br />
                We also recommend that if you are pasting a block of text in here, you paste your text in a basic notepad document first, then copy from there to here, so that it
                removes all the hidden formatting and makes it simpler for you to edit.<br />
                Use the WYSIWYG editor below to easily format your text. </div></td>
            </tr>
            <tr>
              <td height="50" colspan="2" align="center" valign="middle"><table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" valign="top"><textarea style="width:705px" name="privacy" rows="4" id="privacy" class="main_text"><?php echo htmlspecialchars($privacy_terms_arr[0]); ?></textarea>
                        <script>
                            CKEDITOR.replace("privacy",
                                {
                                  height: 400
                                });
                        </script>                        </td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="80" colspan="2" align="center" valign="bottom" style="padding:10px">Terms &amp; Conditions: <a href="#" onClick="mm_showHide('help_terms');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>If you need a great place to get your own Privacy Policy, Terms & Conditions and Cookie Consent all in one then we highly recommend you check out <a href="https://freemonthlywebsites.com/special/gdpr-my-site" target="_blank">GDPR My Site</a>.<br><br><a id='preview-butt' href="../terms.php" target='_blank'>View Terms & Conditions Page</a></td>
          </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_terms">Enter any content for your Terms &amp; Conditions here using the WYSIWYG editor. <br />
                There is no limit to the amount of information you place here but we suggest you add a little at a time and keep checking your page to make sure it looks OK.<br />
                <br />
                We also recommend that if you are pasting a block of text in here, you paste your text in a basic notepad document first, then copy from there to here, so that it
                removes all the hidden formatting and makes it simpler for you to edit.<br />
                Use the WYSIWYG editor below to easily format your text. </div></td>
            </tr>
            <tr>
              <td height="50" colspan="2" align="center" valign="middle"><table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" valign="top"><textarea style="width:705px" name="terms" rows="4" id="terms" class="main_text"><?php echo htmlspecialchars($privacy_terms_arr[1]); ?></textarea>
                        <script>
                            CKEDITOR.replace("terms",
                                {
                                  height: 400
                                });
                        </script>              </td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td width="300" height="50" align="right" valign="middle" style="padding-right:10px;">Display Privacy/Terms:</td>
              <td width="405" align="left" valign="middle">
              <input type="checkbox" name="display_privacy_terms" value="1" <?php if ($privacy_terms_arr[2] === '1') echo 'checked'; ?>>
              <a href="#" onClick="mm_showHide('help_display_privacy_terms');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top"></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle">
            <div class="userhelp_cell" id="help_display_privacy_terms">Check this to display your Privacy/Terms links in footer.<br />
            </div></td>
            </tr>
            
    <tr>
              <td height="20" colspan="2" align="center" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td height="50" colspan="2" align="center" valign="middle"><p>
                  <input type="submit" name="Submit" value="Save Privacy/Terms Settings" id="submit">
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
<!-- You are not permitted to edit any code in this website --> 
              </td>
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
