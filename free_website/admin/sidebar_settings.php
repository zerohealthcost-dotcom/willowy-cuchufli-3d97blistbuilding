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

$settings_file = "settings/sidebar_settings.txt";
$success = false;
$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = [
        'sidebar', 'rightside_width', 'rightside_bg_color', 'rightside_border_color', 'rightside_border_width',
        'leftside_width', 'leftside_bg_color', 'leftside_border_color', 'leftside_border_width',
        'leftcontent', 'rightcontent', 'leftcontent2', 'rightcontent2', 'left_title', 'right_title',
        'text', 'optimage', 'formtop', 'formbot', 'to_display_form', 'title_bg_color', 'title_font_color', 'display_ads_sidebar'
    ];

    $values = [];
    foreach ($fields as $field) {
        $values[] = isset($_POST[$field]) ? stripslashes($_POST[$field]) : '';
    }
    $values[0] = 'rightside'; //upgrade
    $values[22] = '1'; //upgrade
    $content = implode("#_1_#", $values);

    if (file_put_contents($settings_file, $content) !== false) {
        $success = true;
    } else {
        $error = true;
    }
}

$sidebar_arr = file_exists($settings_file) ? explode("#_1_#", file_get_contents($settings_file)) : array_fill(0, 23, "");
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
#help_title { display:none; }
#help_display_title { display:none; }
#help_content { display:none; }
#none { display:none; }
#help_sidebar { display:none; }
#help_rightside_width { display:none; }
#help_rightside_bg_color { display:none; }
#help_rightside_border_color { display:none; }
#help_rightside_border_width { display:none; }
#help_leftside_width { display:none; }
#help_leftside_bg_color { display:none; }
#help_leftside_border_color { display:none; }
#help_leftside_border_width { display:none; }
#help_rightcontent { display:none; }
#help_text { display:none; }
#help_image { display:none; }
#help_formtop { display:none; }
#help_formbot { display:none; }
#help_disp_aweber { display:none; }
#help_title_bg_color { display:none; }
#help_title_font_color { display:none; }
#help_sidebar_ads { display:none; }
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
function mm_showHide1(id)
{
    a=document.getElementById(id);
    if(a.style.display != 'none' && a.style.display != 'block') a.style.display='none';
    if(a.style.display == 'block') {
        //a.style.display='none';
    }
    else {
        a.style.display='block';
        what_hide = 'rightside';
        $(what_hide+"1").style.display='none';
        $(what_hide+"2").style.display='none';
        $(what_hide+"3").style.display='none';
        $(what_hide+"4").style.display='none';
        $(what_hide+"5").style.display='none';
        $(what_hide+"6").style.display='none';
        $(what_hide+"7").style.display='none';
        $(what_hide+"8").style.display='none';
        what_hide = 'leftside';
        $(what_hide+"1").style.display='none';
        $(what_hide+"2").style.display='none';
        $(what_hide+"3").style.display='none';
        $(what_hide+"4").style.display='none';
        $(what_hide+"5").style.display='none';
        $(what_hide+"6").style.display='none';
        $(what_hide+"7").style.display='none';
        $(what_hide+"8").style.display='none';
        $('sidebarads1').style.display='none';
        $('help_sidebar_ads').style.display='none';
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

    <td width="706" align="left" valign="top" style="padding-left:10px; padding-right:10px; padding-top:20px; padding-bottom:20px"><div class="members_title"><strong>Sidebar Settings </strong></div>
      <!--Main -->
      <form method="post">
      <table width="705" border="0" align="center" cellpadding="0" cellspacing="0">

<?php if ($success): ?>
            <tr>
              <td height="50" colspan="2" align="center" valign="middle" class="saved">Data saved successfully <img src="images/check-green2.png" width="20" height="20" align="absmiddle" /></td>
            </tr>
<?php endif; ?>

            <tr>
              <td height="20" colspan="2" align="center" valign="middle">&nbsp;</td>
          </tr>

            <tr>
              <td width="300" height="50" align="right" valign="middle">Display a Sidebar?:&nbsp;&nbsp;</td>
              <td width="405" height="50" align="left" valign="middle"><select name="sidebar" id="sidebar" onChange="awgr_do_change(); lockSidebarOption();"> <!-- //upgrade -->
    <option value="rightside" <?php if ($sidebar_arr[0] == 'rightside') echo 'selected'; ?>>Display Right Sidebar</option> <!-- //upgrade -->
    <option value="leftside" <?php if ($sidebar_arr[0] == 'leftside') echo 'selected'; ?>>Display Left Sidebar</option> <!-- //upgrade -->
    <option value="none" <?php if ($sidebar_arr[0] == 'none') echo 'selected'; ?>>Do Not Display Sidebar</option> <!-- //upgrade -->
</select>

              <script>
                function awgr_do_change()
                {
                    q = document.getElementById('sidebar');
                    if(q.value=='rightside') //upgrade
                    {
                        awgr_show_hide('rightside', 'leftside');
                        $('none').style.display='none'; //upgrade
                    }
                    if(q.value=='leftside') //upgrade
                    {
                        awgr_show_hide('leftside', 'rightside');
                        $('none').style.display='none'; //upgrade
                    }
                    if(q.value=='none') //upgrade
                    {
                        mm_showHide1('none');
                    }
                }
                function awgr_show_hide(what_show, what_hide)
                {
                    $(what_show+"1").style.display='table-row';
                    $(what_show+"2").style.display='table-row';
                    $(what_show+"3").style.display='table-row';
                    $(what_show+"4").style.display='table-row';
                    $(what_show+"5").style.display='table-row';
                    $(what_show+"6").style.display='table-row';
                    $(what_show+"7").style.display='table-row';
                    $(what_show+"8").style.display='table-row';

                    $(what_hide+"1").style.display='none';
                    $(what_hide+"2").style.display='none';
                    $(what_hide+"3").style.display='none';
                    $(what_hide+"4").style.display='none';
                    $(what_hide+"5").style.display='none';
                    $(what_hide+"6").style.display='none';
                    $(what_hide+"7").style.display='none';
                    $(what_hide+"8").style.display='none';
                }
                function lockSidebarOption() //upgrade
                {
                    var q = document.getElementById('sidebar');
                    var help = document.getElementById('help_sidebar');

                    if (q.value === 'rightside') {
                        help.style.display = 'none';
                    } else {
                        help.style.display = 'block';
                    }
                }
                function $(id) { return document.getElementById(id); }
                f=window.onload;
                window.onload=function() {
                    if(f) f();
                    awgr_do_change();
                    lockSidebarOption(); //upgrade
                };
              </script><a href="#" onClick="mm_showHide('help_sidebar');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="upgrade_cell" id="help_sidebar"> <!-- //upgrade -->
                <p><strong>Sorry, this function is reserved for <a href="https://freemonthlywebsites.com/premier" target="_blank">Premier Members Only</a>!</strong></p> <!-- //upgrade -->
                <p>Premier Members have the ability to choose different sidebar layouts.<br> <!-- //upgrade -->
                If you are interested in upgrading to Premier Membership, you can see all the benefits that it offers, and also upgrade from <a href="https://freemonthlywebsites.com/premier" target="_blank">HERE</a>.</p> <!-- //upgrade -->
              </div></td>
            </tr>
            <tr id="rightside1">
              <td height="50" align="right" valign="middle">Right Sidebar Width (in %):&nbsp;&nbsp;</td>
            <td height="50" align="left" valign="middle"><input style="width:40px" name="rightside_width" value="<?php echo htmlspecialchars($sidebar_arr[1]); ?>" />
            %<a href="#" onClick="mm_showHide('help_rightside_width');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_rightside_width">Select the width of your right sidebar in %. </div></td>
            </tr>
            <tr id="rightside2">
              <td height="50" align="right" valign="middle">Right Sidebar Background Color:&nbsp;&nbsp;</td>
            <td height="50" align="left" valign="middle"><input name="rightside_bg_color" class="jscolor" value="<?php echo "#" . htmlspecialchars($sidebar_arr[2]); ?>" /><a href="#" onClick="mm_showHide('help_rightside_bg_color');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_rightside_bg_color">Select the color you wish to have for your right sidebar background.</div></td>
            </tr>
            <tr id="rightside3">
              <td height="50" align="right" valign="middle">Right Sidebar Border Color:&nbsp;&nbsp;</td>
            <td height="50" align="left" valign="middle"><input name="rightside_border_color" class="jscolor" value="<?php echo "#" . htmlspecialchars($sidebar_arr[3]); ?>" /><a href="#" onClick="mm_showHide('help_rightside_border_color');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_rightside_border_color">Select the color you wish to have for your right sidebar border. </div></td>
            </tr>
            <tr id="rightside4">
              <td height="50" align="right" valign="middle">Right Sidebar Border Width (in pixels):&nbsp;&nbsp;</td>
            <td height="50" align="left" valign="middle"><input style="width:40px" name="rightside_border_width" value="<?php echo htmlspecialchars($sidebar_arr[4]); ?>" />
              px<a href="#" onClick="mm_showHide('help_rightside_border_width');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_rightside_border_width">Select the width of your right sidebar border in pixels, use 0 for no border. </div></td>
            </tr>
            <tr id="leftside1">
              <td height="50" align="right" valign="middle">Left Sidebar Width (in %):&nbsp;&nbsp;</td>
            <td height="50" align="left" valign="middle"><input style="width:40px" name="leftside_width" value="<?php echo htmlspecialchars($sidebar_arr[5]); ?>" />
            %<a href="#" onClick="mm_showHide('help_leftside_width');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_leftside_width">Select the width of your left sidebar in %. </div></td>
            </tr>
            <tr id="leftside2">
              <td height="50" align="right" valign="middle">Left Sidebar Background Color:&nbsp;&nbsp;</td>
            <td height="50" align="left" valign="middle"><input name="leftside_bg_color" class="jscolor" value="<?php echo "#" . htmlspecialchars($sidebar_arr[6]); ?>" /><a href="#" onClick="mm_showHide('help_leftside_bg_color');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_leftside_bg_color">Select the color you wish to have for your left sidebar background.</div></td>
            </tr>
            <tr id="leftside3">
              <td height="50" align="right" valign="middle">Left Sidebar Border Color:&nbsp;&nbsp;</td>
            <td height="50" align="left" valign="middle"><input name="leftside_border_color" class="jscolor" value="<?php echo "#" . htmlspecialchars($sidebar_arr[7]); ?>" /><a href="#" onClick="mm_showHide('help_leftside_border_color');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_leftside_border_color">Select the color you wish to have for your left sidebar border. </div></td>
            </tr>
            <tr id="leftside4">
              <td height="50" align="right" valign="middle">Left Sidebar Border Width (in pixels):&nbsp;&nbsp;</td>
            <td height="50" align="left" valign="middle"><input style="width:40px" name="leftside_border_width" value="<?php echo htmlspecialchars($sidebar_arr[8]); ?>" />
              px<a href="#" onClick="mm_showHide('help_leftside_border_width');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr id="none">
              <td colspan="2" align="center" valign="middle"></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_leftside_border_width">Select the width of your left sidebar border in pixels, use 0 for no border. </div></td>
            </tr>
            <!-- //upgrade -->
            <tr id="sidebarads1">
              <td height="50" align="right" valign="middle">Display Ads in Sidebar?:&nbsp;&nbsp;</td>
              <td height="50" align="left" valign="middle"><select name="display_ads_sidebar" id="display_ads_sidebar" onChange="lockSidebarAdsOption();">
                  <option value="0" <?php if (!isset($sidebar_arr[22]) || $sidebar_arr[22] === '' || $sidebar_arr[22] == '0') echo 'selected'; ?>>0</option>
                  <option value="1" <?php if (isset($sidebar_arr[22]) && $sidebar_arr[22] == '1') echo 'selected'; ?>>1</option>
                  <option value="2" <?php if (isset($sidebar_arr[22]) && $sidebar_arr[22] == '2') echo 'selected'; ?>>2</option>
                  <option value="3" <?php if (isset($sidebar_arr[22]) && $sidebar_arr[22] == '3') echo 'selected'; ?>>3</option>
                </select><a href="#" onClick="mm_showHide('help_sidebar_ads');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="upgrade_cell" id="help_sidebar_ads">
                <p><strong>Sorry, this function is reserved for <a href="https://freemonthlywebsites.com/premier" target="_blank">Premier Members Only</a>! </strong></p>
                <p>Premier Members have the ability to choose how many ClickBank ads are displayed in the sidebar.<br>
If you are interested in upgrading to Premier Membership, you can see all the benefits that it offers, and also upgrade from <a href="https://freemonthlywebsites.com/premier" target="_blank">HERE</a>.</p>
              </div></td>
            </tr>
            <!-- //upgrade -->
<!--Title Colors -->
            <tr id="sidebartitle1">
              <td height="50" align="right" valign="middle">Sidebar Title Background Color:&nbsp;&nbsp;</td>
              <td height="50" align="left" valign="middle"><input name="title_bg_color" class="jscolor" value="<?php echo "#" . htmlspecialchars($sidebar_arr[20]); ?>" />
                <a href="#" onClick="mm_showHide('help_title_bg_color');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr id="sidebartitle2">
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_title_bg_color">Select the color you wish to have for your sidebar title background.</div></td>
            </tr>
            <tr id="sidebartitle3">
              <td height="50" align="right" valign="middle">Sidebar Title Font Color:&nbsp;&nbsp;</td>
              <td height="50" align="left" valign="middle"><input name="title_font_color" class="jscolor" value="<?php echo "#" . htmlspecialchars($sidebar_arr[21]); ?>" />
                <a href="#" onClick="mm_showHide('help_title_font_color');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr id="sidebartitle4">
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_title_font_color">Select the color you wish to have for your sidebar title font. </div></td>
            </tr>
<!--Title Colors -->

            <tr id="leftside7">
              <td height="50" colspan="2" align="center" valign="middle">Left Sidebar Title:</td>
            </tr>
            <tr id="leftside8">
              <td height="50" colspan="2" align="center" valign="middle"><input name="left_title" type="text" id="left_title" value="<?php echo htmlspecialchars($sidebar_arr[13]); ?>" style="width: 300px;" /></td>
            </tr>

            <tr id="leftside5">
              <td height="50" colspan="2" align="center" valign="middle">Left Sidebar  Content: <a href="#" onClick="mm_showHide('help_content');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_content">Enter your content for your left sidebar here using the WYSIWYG editor.
                  <br />
                There is no limit to the amount of information you place here but we suggest you add a little at a time and keep checking your page to make sure it looks OK.<br />
                If you would like to place adverts or any other code in this section then be sure to click on the <img src="images/source.png" width="59" height="22" align="absmiddle" /> button in the WYSIWYG editor and paste your code in 'source' view.<br />
                If you would like to promote InstantAzon in your sidebar via an image, you can find all the images you need, along with your affiliate link <a style="color:#0099FF" href="http://instant-azon.com/jv/" target="_blank">here</a>.<br />
                    <br />
                    We also recommend that if you are pasting a block of text in here, you paste your text in a basic notepad document first, then copy from there to here, so that it
                  removes all the hidden formatting and makes it simpler for you to edit.<br />
Use the WYSIWYG editor below to easily format your text.
              </div></td>
            </tr>
            <tr id="leftside6">
              <td height="50" colspan="2" align="center" valign="middle">
<textarea style="width:705px" name="leftcontent" rows="4" id="leftcontent" class="main_text"><?php echo htmlspecialchars($sidebar_arr[9]); ?></textarea>
<script>
CKEDITOR.replace('leftcontent');
</script></td>
            </tr>

            <tr id="rightside7">
              <td height="50" colspan="2" align="center" valign="middle">Right Sidebar Title:</td>
            </tr>
            <tr id="rightside8">
              <td height="50" colspan="2" align="center" valign="middle"><input name="right_title" type="text" id="right_title" value="<?php echo htmlspecialchars($sidebar_arr[14]); ?>" style="width: 300px;" /></td>
            </tr>
            <tr id="rightside5">
              <td height="50" colspan="2" align="center" valign="middle">Right Sidebar Content: <a href="#" onClick="mm_showHide('help_rightcontent');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_rightcontent">Enter your content for your right sidebar here using the WYSIWYG editor.
                  <br />
                There is no limit to the amount of information you place here but we suggest you add a little at a time and keep checking your page to make sure it looks OK.<br />
                If you would like to place adverts or any other code in this section then be sure to click on the <img src="images/source.png" width="59" height="22" align="absmiddle" /> button in the WYSIWYG editor and paste your code in 'source' view.<br />
                If you would like to promote InstantAzon in your sidebar via an image, you can find all the images you need, along with your affiliate link <a style="color:#0099FF" href="http://instant-azon.com/jv/" target="_blank">here</a>.<br />
                    <br />
                    We also recommend that if you are pasting a block of text in here, you paste your text in a basic notepad document first, then copy from there to here, so that it
                  removes all the hidden formatting and makes it simpler for you to edit.<br />
Use the WYSIWYG editor below to easily format your text.
              </div></td>
            </tr>
            <tr id="rightside6">
              <td height="50" colspan="2" align="center" valign="middle">
<textarea style="width:705px;" name="rightcontent" rows="4" id="rightcontent" class="main_text"><?php echo htmlspecialchars($sidebar_arr[10]); ?></textarea>
<script>
CKEDITOR.replace('rightcontent');
</script></td>
            </tr>

<!--Sidebar Optin -->
<tbody id="sidebarOptinContent">
          <tr>
<tr>
  <td height="20" colspan="2"></td>
</tr>
            <td height="50" colspan="2" align="center" valign="middle" class="main2">Sidebar Optin Header Content:
            <a href="#" onClick="mm_showHide('help_text');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a><br><br>
This uses the same optin autoresponder 'form' settings as your '<a href="optin_settings.php" target="_self">Optin Page Settings</a>' but you can choose different wording and styling for your sidebar optin form.<br>
You can also choose where and if you prefer to show this form on the sidebar below.<br>
<br></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_text">
              <p>This uses the same optin autoresponder 'form' settings as your '<a href="optin_settings.php" target="_self">Optin Page Settings</a>'.</p>
              <p>This is basically some text explaining to your potential subscriber exactly what they will get when they sign up with you.<br />
                  <br />
                  It is recommended that you give your visitors a gift or some kind of incentive for signing up.</p>
            </div></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2"><textarea style="width:705px" name="text" rows="3" id="text" class="main_text"><?php echo htmlspecialchars($sidebar_arr[15]); ?></textarea>
            <script>
                            CKEDITOR.replace("text",
                                {
                                  height: 300
                                });
                        </script></td>
          </tr>

          <tr>
            <td height="50" colspan="2" align="center" valign="middle" class="main2">Sidebar Optin  Image:
            <a href="#" onClick="mm_showHide('help_image');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_image">
              <p>This is where you can add your own image for the free item you are offering.</p>
            </div></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2"><textarea style="width:705px" name="optimage" rows="3" id="optimage" class="main_text"><?php echo htmlspecialchars($sidebar_arr[16]); ?></textarea>
            <script>
                            CKEDITOR.replace("optimage",
                                {
                                  height: 300
                                });
                        </script></td>
          </tr>

          <tr>
            <td height="50" colspan="2" align="center" valign="middle" class="main2">Sidebar Optin Text Above Form:
            <a href="#" onClick="mm_showHide('help_formtop');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_formtop">
              <p>This is where you can add your own text that will be displayed above the optin form.</p>
            </div></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2"><textarea style="width:705px" name="formtop" rows="3" id="formtop" class="main_text"><?php echo htmlspecialchars($sidebar_arr[17]); ?></textarea>
            <script>
                            CKEDITOR.replace("formtop",
                                {
                                  height: 200
                                });
                        </script></td>
          </tr>

          <tr>
            <td height="50" colspan="2" align="center" valign="middle" class="main2">Sidebar Optin  Text Below Form:
            <a href="#" onClick="mm_showHide('help_formbot');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_formbot">
              <p>This is where you can add your own text that will be displayed below the optin form.</p>
            </div></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2"><textarea style="width:705px" name="formbot" rows="3" id="formbot" class="main_text"><?php echo htmlspecialchars($sidebar_arr[18]); ?></textarea>
            <script>
                            CKEDITOR.replace("formbot",
                                {
                                  height: 200
                                });
                        </script></td>
          </tr>
          <tr>
            <td height="50" colspan="2" align="center" valign="middle" class="main2">Display Optin Form on Sidebar:
              <select name="to_display_form" id="to_display_form">
                <option value="topside" <?php if ($sidebar_arr[19] == 'topside') echo 'selected'; ?>>Display at The Top of The Sidebar</option>
                <option value="bottomside" <?php if ($sidebar_arr[19] == 'bottomside') echo 'selected'; ?>>Display at The Bottom of The Sidebar</option>
                <option value="none" <?php if ($sidebar_arr[19] == 'none') echo 'selected'; ?>>Do Not Display an Optin Form on The Sidebar</option>
                    </select>
              <a href="#" onClick="mm_showHide('help_disp_aweber');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_disp_aweber">
              <p>Select where you want to display the sidebar signup form on your website.<br>
              This uses the same optin 'form' settings as your '<a href="optin_settings.php" target="_self">Optin Page Settings</a>'.</p>
            </div></td>
          </tr>
</tbody>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const dropdown = document.getElementById('sidebar');
  const sidebarContent = document.getElementById('sidebarOptinContent');
  const sidebarAds = document.getElementById('sidebarads1');
  const sidebarAdsHelp = document.getElementById('help_sidebar_ads');
  const sidebarTitleRows = [
    document.getElementById('sidebartitle1'),
    document.getElementById('sidebartitle2'),
    document.getElementById('sidebartitle3'),
    document.getElementById('sidebartitle4')
  ];

  function toggleSidebarContent() {
    const showSidebarItems = (dropdown.value !== 'none');
    sidebarContent.style.display = showSidebarItems ? '' : 'none';

    sidebarTitleRows.forEach(function (row) {
      if (row) {
        row.style.display = showSidebarItems ? 'table-row' : 'none';
      }
    });

    if (sidebarAds) {
      sidebarAds.style.display = showSidebarItems ? 'table-row' : 'none';
    }
    if (sidebarAdsHelp && !showSidebarItems) {
      sidebarAdsHelp.style.display = 'none';
    }
    if (!showSidebarItems) {
      var titleBgHelp = document.getElementById('help_title_bg_color');
      var titleFontHelp = document.getElementById('help_title_font_color');
      if (titleBgHelp) titleBgHelp.style.display = 'none';
      if (titleFontHelp) titleFontHelp.style.display = 'none';
    }
  }


  //upgrade
  const sidebarAdsDropdown = document.getElementById('display_ads_sidebar');

  function lockSidebarAdsOption() {
    if (!sidebarAdsDropdown || !sidebarAdsHelp) return;

    if (sidebarAdsDropdown.value === '1') {
      sidebarAdsHelp.style.display = 'none';
    } else {
      sidebarAdsHelp.style.display = 'block';
    }
  }
  //upgrade

  toggleSidebarContent();
  lockSidebarAdsOption(); //upgrade
  dropdown.addEventListener('change', toggleSidebarContent);
  if (sidebarAdsDropdown) sidebarAdsDropdown.addEventListener('change', lockSidebarAdsOption); //upgrade
});
</script>
<!--Sidebar Optin -->

            <tr>
              <td height="20" colspan="2" align="center" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td height="50" colspan="2" align="center" valign="middle" class="save-button-wrapper">
                  <input type="submit" name="Submit" value="Save Sidebar Settings" id="submit">              </td>
            </tr>
            <tr>
              <td height="50" colspan="2" align="center" valign="middle" class="save-button-wrapper">
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
      </table>
      </form>
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
