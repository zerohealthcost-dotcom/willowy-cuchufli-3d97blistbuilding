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

$settings_file = "settings/optin_settings.txt";
$success = false;
$error = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = [
        'text', 'meta_web', 'unit', 'redirect', 'to_display_form', 'form', 'to_display_alternate',
        'grlist', 'grref', 'autoresponder', 'name-place', 'email-place', 'button-text',
        'o-location', 'optimage', 'formtop', 'formbot'
    ];

    $content = '';
    foreach ($fields as $index => $field) {
        $value = isset($_POST[$field]) ? stripslashes($_POST[$field]) : '';
        if ($field === 'o-location') {
            $value = preg_replace("/[^a-z0-9]/", "", strtolower(strip_tags(trim($value))));
        }
        $content .= $value . "#_1_#";
    }
    $content = rtrim($content, "#_1_#");

    if (file_put_contents($settings_file, $content) !== false) {
        $success = true;
    } else {
        $error = true;
    }
}

// Load existing settings
$optin_arr = file_exists($settings_file) ? explode("#_1_#", file_get_contents($settings_file)) : array_fill(0, 17, "");
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
#help_location { display:none; }
#help_text { display:none; }
#help_meta { display:none; }
#help_unit { display:none; }
#help_redirect { display:none; }
#help_disp_aweber { display:none; }
#help_disp_alternate { display:none; }
#help_grlist { display:none; }
#help_grref { display:none; }
#help_name-place { display:none; }
#help_email-place { display:none; }
#help_button-text { display:none; }
#help_image { display:none; }
#help_formtop { display:none; }
#help_formbot { display:none; }

-->
</style>
<script src="ckeditor/ckeditor.js"></script>
<script src="js/jscolor.min.js"></script>
<script type="text/javascript">
//var cp = new ColorPicker('window');
</script>
<script type="text/javascript">
function mm_showHide(id) {
    var a = document.getElementById(id);
    if (!a) return false;

    if (a.style.display !== 'none' && a.style.display !== 'block') {
        a.style.display = 'none';
    }

    a.style.display = (a.style.display === 'block') ? 'none' : 'block';
    return false;
}
function mm_showHide1(id) {
    var a = document.getElementById(id);
    if (!a) return false;

    if (a.style.display !== 'none' && a.style.display !== 'block') {
        a.style.display = 'none';
    }

    if (a.style.display !== 'block') {
        a.style.display = 'block';
    }

    ['gr1', 'gr2', 'gr3', 'gr4', 'aweber1', 'aweber2', 'aweber3', 'aweber4'].forEach(function (rowId) {
        var row = document.getElementById(rowId);
        if (row) {
            row.style.display = 'none';
        }
    });

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

    <td width="706" align="left" valign="top" style="padding-left:10px; padding-right:10px; padding-top:20px; padding-bottom:20px"><div class="members_title"><strong>Optin Page Settings </strong></div>
      <!--Main -->
      <table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
<form method="post">
          
<?php if ($success): ?>
            <tr>
              <td height="50" colspan="2" align="center" valign="middle" class="saved">Data saved successfully <img src="images/check-green2.png" width="20" height="20" align="absmiddle" /></td>
            </tr>
<?php endif; ?>
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2"><p>Your  mailing list is a very important part of your website. <br>
              You can use an autoresponder service like <a href="https://freemonthlywebsites.com/special/aweber" target="_blank"><u>AWeber</u></a> or <a href="https://freemonthlywebsites.com/special/getresponse" target="_blank">GetResponse</a> to collect email addresses in a secure database, which will allow your visitors to opt-in to your subscriber list, this will allow you to send them broadcast and predefined email responses.<br />
              <br />
              <a href="https://freemonthlywebsites.com/special/aweber" target="_blank"><u>An autoresponder service</u></a> will allow you to securely and safely, send emails to your subscriber list without fear of spam complaints.
These emails can include any website updates, product offers, sales, news, tips  and so on. This is a highly recommended option.</p></td>
          </tr>
          <tr>
            <td height="20" colspan="2" align="center" valign="middle" class="main2">&nbsp;</td>
          </tr>
          <tr>
            <td width="343" height="50" align="right" valign="middle" class="main2">Your Optin Page Location:</td>
        <td width="362" height="50" align="left" valign="middle" class="main2" style="padding-left:20px">
              <input name="o-location" type="text" id="o-location" value="<?php echo htmlspecialchars($optin_arr[13]); ?>" style="width: 200px;" />
            <a href="#" onClick="mm_showHide('help_location');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a>            </td>
          </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_location">
                Enter a short location for your page, once added you will be given the full link to this page.<br>
                This can be any location you choose, as long as it's is not already used.<br>
                eg. If you enter 'free' as the location (without quotes), that path will be added to your website upload location and presented to you below.
              </div></td>
            </tr>
<?php
if (isset($optin_arr[13]) && $optin_arr[13]) {
    $url  = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'];
    $url .= htmlspecialchars($_SERVER['REQUEST_URI']);
    $url  = dirname(dirname($url)) . '/' . urlencode($optin_arr[13]);
    echo "<tr><td colspan='2' align='center'><a id='preview-butt' href='{$url}' target='_blank'>View Optin Page</a></td></tr>";
}
?>
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2">&nbsp;</td>
          </tr>
          
          <tr>
            <td height="50" colspan="2" align="center" valign="middle" class="main2">Optin Page Header Content:
            <a href="#" onClick="mm_showHide('help_text');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_text">
              <p>This is basically some text explaining to your potential subscriber exactly what they will get when they sign up with you.<br />
                  <br />It is recommended that you give your visitors a gift or some kind of incentive for signing up.</p>
            </div></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2"><textarea style="width:705px" name="text" rows="3" id="text" class="main_text"><?php echo htmlspecialchars($optin_arr[0]); ?></textarea>
            <script>
                            CKEDITOR.replace("text",
                                {
                                  height: 300
                                });
                        </script>                        </td>
          </tr>
          
          <tr>
            <td height="50" colspan="2" align="center" valign="middle" class="main2">Optin Page Image:
            <a href="#" onClick="mm_showHide('help_image');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_image">
              <p>This is where you can add your own image for the free item you are offering.</p>
            </div></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2"><textarea style="width:705px" name="optimage" rows="3" id="optimage" class="main_text"><?php echo htmlspecialchars($optin_arr[14]); ?></textarea>
            <script>
                            CKEDITOR.replace("optimage",
                                {
                                  height: 300
                                });
                        </script>                        </td>
          </tr>
          
          <tr>
            <td height="50" colspan="2" align="center" valign="middle" class="main2">Optin Page Text Above Form:
            <a href="#" onClick="mm_showHide('help_formtop');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_formtop">
              <p>This is where you can add your own text that will be displayed above the optin form.</p>
            </div></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2"><textarea style="width:705px" name="formtop" rows="3" id="formtop" class="main_text"><?php echo htmlspecialchars($optin_arr[15]); ?></textarea>
            <script>
                            CKEDITOR.replace("formtop",
                                {
                                  height: 200
                                });
                        </script>                        </td>
          </tr>
          
          <tr>
            <td height="50" colspan="2" align="center" valign="middle" class="main2">Optin Page Text Below Form:
            <a href="#" onClick="mm_showHide('help_formbot');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_formbot">
              <p>This is where you can add your own text that will be displayed below the optin form.</p>
            </div></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2"><textarea style="width:705px" name="formbot" rows="3" id="formbot" class="main_text"><?php echo htmlspecialchars($optin_arr[16]); ?></textarea>
            <script>
                            CKEDITOR.replace("formbot",
                                {
                                  height: 200
                                });
                        </script>                        </td>
          </tr>
<!--new -->
          <tr id="redirectRow">
            <td width="343" height="50" align="center" valign="middle" class="main2">Your Optin Thanks URL: <br>
              (optional)</td>
            <td width="362" height="50" align="left" valign="middle" class="main2"><input name="redirect" type="text" id="redirect" value="<?php echo htmlspecialchars($optin_arr[3]); ?>" style="width: 300px;" />
              <a href="#" onClick="mm_showHide('help_redirect');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
          <tr id="redirectHelpRow">
            <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_redirect">
              <p>This is simply a link to a 'Please confirm your email address' or a 'Thanks for subscribing' page. It can be any page you like, autoresponders usually have a 'default' confirmation page.</p>
              <p>If you are offering a gift in return for a subscription, then you may want to include a download for that gift on your thanks page too.<br>
                We have included a Download Page for you if needed, you can edit that from <a href="download_page_settings.php">here</a>.</p>
            </div></td>
          </tr>
          <tr>
            <td height="90" align="center" valign="middle" class="main2">Select Your Autoresponder</td>
            <td height="90" align="left" valign="middle" class="main2">
              <select name="autoresponder" id="autoresponder" onChange="awgr_do_change();">
            <option value="aweber" <?php if ($optin_arr[9] == 'aweber') echo 'selected'; ?>>AWeber</option>
            <option value="gr" <?php if ($optin_arr[9] == 'gr') echo 'selected'; ?>>GetResponse</option>
            <option value="ot" <?php if ($optin_arr[9] == 'ot') echo 'selected'; ?>>Other</option>
        </select>
                <script>
                (function () {
                    function byId(id) {
                        return document.getElementById(id);
                    }

                    function setDisplay(id, displayValue) {
                        var el = byId(id);
                        if (el) {
                            el.style.display = displayValue;
                        }
                    }

                    function setRows(ids, displayValue) {
                        for (var i = 0; i < ids.length; i++) {
                            setDisplay(ids[i], displayValue);
                        }
                    }

                    function showProviderRows(providerToShow, providerToHide) {
                        setRows([
                            providerToShow + "1",
                            providerToShow + "2",
                            providerToShow + "3",
                            providerToShow + "4"
                        ], "table-row");

                        setRows([
                            providerToHide + "1",
                            providerToHide + "2",
                            providerToHide + "3",
                            providerToHide + "4"
                        ], "none");
                    }

                    function showOtherFields() {
                        setRows([
                            "hidother",
                            "hidother2",
                            "hidother3",
                            "hidother4",
                            "hidother5",
                            "hidother6"
                        ], "table-row");
                    }

                    function hideOtherFields() {
                        setRows([
                            "hidother",
                            "hidother2",
                            "hidother3",
                            "hidother4",
                            "hidother5",
                            "hidother6"
                        ], "none");
                    }

                    function showAlternateForm() {
                        setDisplay("help_disp_alternate", "block");
                    }

                    function hideAlternateForm() {
                        setDisplay("help_disp_alternate", "none");
                    }

                    
    function showRedirect() {
        setDisplay("redirectRow", "table-row");
        setDisplay("redirectHelpRow", "table-row");
    }

    function hideRedirect() {
        setDisplay("redirectRow", "none");
        setDisplay("redirectHelpRow", "none");
    }

    window.awgr_do_change = function () {
                        var autoresponder = byId("autoresponder");
                        if (!autoresponder) {
                            return;
                        }

                        switch (autoresponder.selectedIndex) {
                            case 0: // AWeber
                                showProviderRows("aweber", "gr");
                                hideAlternateForm();
                                showOtherFields();
                                showRedirect();
                                break;

                            case 1: // GetResponse
                                showProviderRows("gr", "aweber");
                                hideAlternateForm();
                                showOtherFields();
                                showRedirect();
                                break;

                            case 2: // Other
                                setRows(["aweber1", "aweber2", "aweber3", "aweber4"], "none");
                                setRows(["gr1", "gr2", "gr3", "gr4"], "none");
                                showAlternateForm();
                                hideOtherFields();
                                hideRedirect();
                                break;
                        }
                    };

                    var previousOnload = window.onload;
                    window.onload = function () {
                        if (typeof previousOnload === "function") {
                            previousOnload();
                        }
                        window.awgr_do_change();
                    };
                })();
              </script>           </td>
          </tr>
          <tr id="aweber3">
            <td height="50" align="center" valign="middle" class="main2">Your Aweber Unique List ID:</td>
            <td height="50" align="left" valign="middle" class="main2"><input name="unit" type="text" id="unit" value="<?php echo htmlspecialchars($optin_arr[2]); ?>" style="width: 300px;" />
              <a href="#" onClick="mm_showHide('help_unit');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
          <tr id="aweber4">
            <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_unit">
              <p>This setting can be found if you login to <a href="https://freemonthlywebsites.com/special/aweber" target="_blank">Aweber</a> and in your chosen list go to<br>
                List Options &gt; List Settings &gt; Basic Settings</p>
              </div></td>
          </tr>
          <tr id="aweber1">
            <td height="50" align="center" valign="middle" class="main2">Your Aweber Tracking Code:<br>
              (optional)</td>
            <td height="50" align="left" valign="middle" class="main2"><input name="meta_web" type="text" value="<?php echo htmlspecialchars($optin_arr[1]); ?>" style="width: 300px;" />
              <a href="#" onClick="mm_showHide('help_meta');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
          <tr id="aweber2">
            <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_meta">
              <p>This can be any name you like, it is for tracking purposes.</p>
            </div></td>
          </tr>
          <tr id="gr1">
            <td height="50" align="center" valign="middle" class="main2">Your Getresponse Campaign Token ID:</td>
            <td height="50" align="left" valign="middle" class="main2"><input name="grlist" type="text" id="grlist" value="<?php echo htmlspecialchars($optin_arr[7]); ?>" style="width: 300px;" />
              <a href="#" onClick="mm_showHide('help_grlist');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
          <tr id="gr2">
            <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_grlist">
              <p>This setting can be found in your <a href="https://freemonthlywebsites.com/special/getresponse" target="_blank">Getresponse</a> control panel.<br>
              Click <a href="https://app.getresponse.com/campaign_list.html" target="_blank">here</a> once logged in to see all your campaign lists.</p>
              </div></td>
          </tr>
          <tr id="gr3">
            <td height="50" align="center" valign="middle" class="main2">Your Getresponse Tracking Code:<br>
              (optional)</td>
            <td height="50" align="left" valign="middle" class="main2"><input name="grref" type="text" id="grref" value="<?php echo htmlspecialchars($optin_arr[8]); ?>" style="width: 300px;" />
              <a href="#" onClick="mm_showHide('help_grref');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
          <tr id="gr4">
            <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_grref">
              <p>This can be any name you like, it is for tracking purposes.</p>
              </div></td>
          </tr>
          
          <tr>
            <td colspan="2" align="center" valign="middle" class="main2"><div align="center" id="help_disp_alternate">Your Alternate Autoresponder Web Form or Javascript:
              <textarea name="form" rows="12" id="form" style="width:705px; max-width:705px; font-family:Tahoma; font-size:12px"><?php echo htmlspecialchars($optin_arr[5]); ?></textarea>
                    <p>This is the HTML optin form or javascript code that you receive from your autoresponder.<br />
                      <br />
                      If you are unsure, then ask your autoresponder service provider where you can get your web form<br />
                      for your website. </p>
            </div></td>
          </tr>

          <tr id="hidother">
            <td height="50" align="center" valign="middle" class="main2">Name Input Field Placeholder:</td>
            <td height="50" align="left" valign="middle" class="main2"><input name="name-place" type="text" id="name-place" value="<?php echo htmlspecialchars($optin_arr[10]); ?>" style="width: 300px;" />
            <a href="#" onClick="mm_showHide('help_name-place');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
          <tr id="hidother2">
            <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_name-place">
              <p>This is the placeholder text for your name input field.</p>
              </div></td>
          </tr>
          <tr id="hidother3">
            <td height="50" align="center" valign="middle" class="main2">Email Input Field Placeholder:</td>
            <td height="50" align="left" valign="middle" class="main2"><input name="email-place" type="text" id="email-place" value="<?php echo htmlspecialchars($optin_arr[11]); ?>" style="width: 300px;" />
            <a href="#" onClick="mm_showHide('help_email-place');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
          <tr id="hidother4">
            <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_email-place">
              <p>This is the placeholder text for your email input field.</p>
              </div></td>
          </tr>
          <tr id="hidother5">
            <td height="50" align="center" valign="middle" class="main2">Submit Button Text:</td>
            <td height="50" align="left" valign="middle" class="main2"><input name="button-text" type="text" id="button-text" value="<?php echo htmlspecialchars($optin_arr[12]); ?>" style="width: 300px;" />
            <a href="#" onClick="mm_showHide('help_button-text');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
          <tr id="hidother6">
            <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_button-text">
              <p>This is the text to be shown on your submit button.</p>
              </div></td>
          </tr>

          <tr>
            <td height="50" colspan="2" align="center" valign="middle" class="main2">&nbsp;</td>
          </tr>
          <tr>
            <td height="50" colspan="2" align="center" valign="middle" class="main2"><p>
                <input type="submit" name="Submit" value="Save Optin Form Settings" id="submit" />
            </p></td>
          </tr>
          <tr>
            <td height="50" colspan="2" align="center" valign="middle" class="main2">
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
