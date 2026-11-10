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
ini_set('display_errors',1);

$remove_status = '';
$remove_message = '';
//upgrade
$upgrade_lock_pages = true;
//upgrade

       if($_SESSION['logged_in']!=true)
	     {
			header("location:index.php?flag=2");
			exit;
	     }
		//upgrade
		if(!$upgrade_lock_pages && !empty($_REQUEST['flag']) and $_REQUEST['flag']==4) 
		  {
					$display = 0;
					if(!empty($_REQUEST['display_pages']) and $_REQUEST['display_pages']==1)
				    $display = 1;
					$thefile = 'settings/display_content.txt';
					$openedfile = fopen($thefile, "w");
					fwrite($openedfile, $display);	
					fclose($openedfile);  
		  }
		//upgrade
		if(!$upgrade_lock_pages && !empty($_REQUEST['flag']) and $_REQUEST['flag']==1) 
		  {

             $page_name = preg_replace(
                 "/[^a-zA-Z0-9\-_]/",
                 '',
                 $_REQUEST['page_name']
             );
			 $filename=$page_name.".html";
			 $file_handle = fopen("settings/order_content.txt", "rb");
			  while (!feof($file_handle) ) {
			 $line_of_text = fgets($file_handle);
			 $files = explode(';', $line_of_text);
				}
				fclose($file_handle);
				$pos = strpos($line_of_text, $filename);
				if($pos==0)
				{
					if(empty($files['0']))
					{
						$content = $filename;
					}
					else
						$content = ';'.$filename;
					 if(!file_exists("../content_pages/$filename"))
					  {
						 copy("includes/templates/blank.txt","../content_pages/$filename");
						 chmod("../content_pages/$filename", 0777);
		 	          }
					$thefile = 'settings/order_content.txt';
					$openedfile = fopen($thefile, "a");
					fwrite($openedfile, $content);	
					fclose($openedfile);
					
				}
		  }
// PROTECT 404
//upgrade
if (!$upgrade_lock_pages && !empty($_REQUEST['flag']) && $_REQUEST['flag'] == 2) 
{
    $delete_404_confirm = isset($_REQUEST['delete_404_confirm'])
        ? trim($_REQUEST['delete_404_confirm'])
        : '';

    $deleted_any = false;
    $blocked_404 = false;

    foreach ($_REQUEST['page_remove'] as $val)
    {
        $val = str_replace("..", "", $val);

        if ($val === '404.html' && $delete_404_confirm !== 'DELETE') {
            $blocked_404 = true;
            continue;
        }

        unlink("../content_pages/$val");

        $file_handle = fopen("settings/order_content.txt", "rb");
        while (!feof($file_handle)) {
            $line_of_text = fgets($file_handle);
            $content = $line_of_text;
        }
        fclose($file_handle);

        $content = str_replace(';' . $val, '', $content);
        $content = str_replace($val . ';', '', $content);
        $content = str_replace($val, '', $content);

        $thefile = 'settings/order_content.txt';
        $openedfile = fopen($thefile, "w");
        fwrite($openedfile, $content);    
        fclose($openedfile);

        $deleted_any = true;
    }

    if ($blocked_404) {
        $remove_status = 'warning';
        $remove_message = '404 Page Not Deleted Because Confirmation Was Incorrect/Missing';
    } elseif ($deleted_any) {
        $remove_status = 'success';
        $remove_message = 'Page Removed Successfully';
    }
}
// PROTECT 404
		//upgrade
		if(!$upgrade_lock_pages && !empty($_REQUEST['flag']) and $_REQUEST['flag']==3)
		{
			$numpage = $_REQUEST['numpage'];
			$page_s = array();
			$order_s = array();
			for($i=0;$i<$numpage;$i++)
			{
				$page_s[] = $_REQUEST['pages'.$i];
				$order_s[] = $_REQUEST['orders'.$i];
			}
			for($i=0;$i< $numpage-1;$i++)
			{
				for($j=$i+1;$j< $numpage;$j++)
				{
					if($order_s[$j]<$order_s[$i])
					{
						$temp = $order_s[$i];
						$order_s[$i] = $order_s[$j];
						$order_s[$j] = $temp;
						$temp = $page_s[$i];
						$page_s[$i] = $page_s[$j];
						$page_s[$j] = $temp;
					}
				}
			}
			$contents = array();
			foreach($page_s as $page)
				$contents[] = $page;
			$content = implode(";",$contents);
			$thefile = 'settings/order_content.txt';
			$openedfile = fopen($thefile, "w");
			fwrite($openedfile, $content);	
			fclose($openedfile);
		}
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
#help_add_page {display:none; }
#help_rem_page {display:none; }
#help_sort {display:none; }
#help_display {display:none; }
//upgrade
#help_pages_upgrade {display:block; }
//upgrade
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

    <td width="706" align="left" valign="top" style="padding-left:10px; padding-right:10px; padding-top:20px; padding-bottom:20px"><div class="members_title"><strong>Add/Remove New Pages</strong></div>
<!--Main -->
<table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
            <?php
		//upgrade
		if(!$upgrade_lock_pages && !empty($_REQUEST['flag']) and $_REQUEST['flag']==3)
		  {
?>
            <tr>
              <td height="50" colspan="2" align="center" valign="middle" class="saved">Pages Sorted Successfully <img src="images/check-green2.png" width="20" height="20" align="absmiddle" /></td>
            </tr>
        <?php
		}
?>
<!-- // PROTECT 404 -->
<?php if ($remove_status === 'success') { ?>
<tr>
  <td height="50" colspan="2" align="center" valign="middle" class="saved">
    <?php echo $remove_message; ?> <img src="images/check-green2.png" width="20" height="20" align="absmiddle" />
  </td>
</tr>
<?php } ?>

<?php if ($remove_status === 'warning') { ?>
<tr>
  <td height="50" colspan="2" align="center" valign="middle" class="saved" style="color:#cc0000;">
    <?php echo $remove_message; ?>
  </td>
</tr>
<?php } ?>
<!-- // PROTECT 404 -->
            <?php
		//upgrade
		if(!$upgrade_lock_pages && !empty($_REQUEST['flag']) and $_REQUEST['flag']==1)
		  {
?>
            <tr>
              <td height="50" colspan="2" align="center" valign="middle" class="saved">Page Added Successfully <img src="images/check-green2.png" width="20" height="20" align="absmiddle" /></td>
            </tr>
        <?php
		}
?>
          <tr>
            <td height="80" colspan="2" align="center" valign="middle"><p>New pages allow you to add any content you like. Simply enter the name for the page to be created, once created then you
            can edit that page from the '<a href="edit_content_pages.php"><u>Edit  Pages</u></a>' section.</p>              </td>
          </tr>
          <!-- //upgrade -->
          <tr>
            <td colspan="2" align="center" valign="middle"><div class="upgrade_cell" id="help_pages_upgrade">
              <p><strong>Sorry, the Add/Remove New Pages option is reserved for <a href="https://freemonthlywebsites.com/premier" target="_blank">Premier Members Only</a>!</strong></p>
              <p>Premier Members can add/remove new or existing pages as they see fit.<br>
              If you are interested in upgrading to Premier Membership, you can see all the benefits that it offers, and also upgrade from <a href="https://freemonthlywebsites.com/premier" target="_blank">HERE</a>.</p>
            </div></td>
          </tr>
          <!-- //upgrade -->
      <form name="frm" action="add_content_pages.php" method="post">
            <input type="hidden" name="flag" value="1">
            
            <tr>
              <td height="50" colspan="2" align="center" valign="middle">Enter a Name For Your New Page That You Wish To Add:<a href="#" onClick="mm_showHide('help_add_page');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a><a href="#" onClick="mm_showHide('help_add_page');return false;"></a><br>
              (no spaces and no irregular characters)</td>
          </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_add_page">
Enter a name for your new  page with <b>no spaces and no irregular characters</b>,<br /> 
only letters and numbers.<br>                
You may use underscore (_) and hyphen (-) to separate words. <br><br>
<strong>example page name: </strong>my-new-page1                  
<br />
Once you have added a new page you must then proceed to edit that page from the<br />
'<a href="edit_content_pages.php"><u>Edit Pages</u></a>' section.<br>
                                <br>
                    This will allow you to enter content for the page you have just created.
                  </div></td>
            </tr>
            <tr>
              <td height="60" colspan="2" align="center" valign="middle"><p>
                  <!-- //upgrade -->
                  <input name="page_name" type="text" id="page_name" value="your_new_page_name_here" size="40" disabled>
                  <!-- //upgrade -->
              </p></td>
          </tr>
            <tr>
              <td height="60" colspan="2" align="center" valign="middle"><!-- //upgrade -->
              <input name="Submit2" type="submit" value="Add New Page" id="submit-butt" disabled>
              <!-- //upgrade -->              </td>
            </tr>
        </form>
          <form name="frm" action="add_content_pages.php" method="post" onSubmit="return chk()">
            <input type="hidden" name="flag" value="2">
            <tr>
              <td height="50" colspan="2" align="center" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td height="70" colspan="2" align="center" valign="middle">Remove a Page:<a href="#" onClick="mm_showHide('help_rem_page');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a><a href="#" onClick="mm_showHide('help_rem_page');return false;"></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_rem_page">
                Simply select the page you wish to be removed and click on the 'Remove Page'<br>
                  button below to remove the page totally.<br />
                <span style="color:#CC0000">Warning!</span> <strong>This will delete the chosen page  forever, so be sure before you remove.</strong>
              </div></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><p>
                  <!-- //upgrade -->
                  <select name="page_remove[]" size="6"  multiple class="remove" style="min-width:300px" disabled>
                  <!-- //upgrade -->
                    <?php
						$file_handle = fopen("settings/order_content.txt", "rb");
						while (!feof($file_handle) ) {
							$line_of_text = fgets($file_handle);
							$files = explode(';', $line_of_text);
						}
						fclose($file_handle);

						for($j=0;$j<count($files);$j++)
						{
							if(!empty($files[$j]))
							{
								$order = $j+1;
								echo "<option value='".$files[$j]."'>".str_replace('.html','',$files[$j])."</option>";
							}
						}
					?>
                  </select>
              </p></td>
            </tr>
<!-- // PROTECT 404 -->
<tr id="delete404ConfirmRow" style="display:none;">
  <td colspan="2" align="center" valign="middle">
    <div class="userhelp_cell" style="display:block;">
      This is an Important page - To delete the 404 page, type <strong>DELETE</strong> below.
      <br>
      <br>
      <!-- //upgrade -->
      <input type="text" name="delete_404_confirm" id="delete_404_confirm" value="" style="width:220px;" disabled />
      <!-- //upgrade -->
    </div>
  </td>
</tr>
<!-- // PROTECT 404 -->
            <tr>
              <td height="60" colspan="2" align="center" valign="middle"><!-- //upgrade -->
              <input type="submit" name="Submit" value="Remove Page" id="submit-butt" disabled>
              <!-- //upgrade --></td>
            </tr>
          </form><!--
          <form name="frm" action="add_content_pages.php" method="post" onSubmit="return chk()">
            <input type="hidden" name="flag" value="3">
            <tr>
              <td height="50" colspan="2" align="center" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td height="50" colspan="2" align="center" valign="middle">Sort Your Page Links:<a href="#" onClick="mm_showHide('help_sort');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a><a href="#" onClick="mm_showHide('help_sort');return false;"></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_sort">
                Choose the order in which you wish your page links to be displayed.<br />
                  Simply enter a number that corresponds with your preferred order of that particular link.<br />
                  Links are displayed  left to right.<br />
              </div></td>
            </tr>
            <tr>
              <td height="150" colspan="2" align="center" valign="middle"><table width="400" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="294" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Page Name</td>
                  <td width="106" align="center">Page Order</td>
                </tr>
              </table><br>
                    <?php
						$file_handle = fopen("settings/order_content.txt", "rb");
						while (!feof($file_handle) ) {
							$line_of_text = fgets($file_handle);
							
							$files = explode(';', $line_of_text);
						}
						fclose($file_handle);
					for($j=0;$j<count($files);$j++)
					{
						if(!empty($files[$j]))
						{
							$order = $j+1;	
				$hack = str_replace("/", "", $files[$j]);
				$hack = str_replace(".php", "", $hack);
					?>
                              <input name="pages<?=$j?>" type="text" value="<?=$hack?>" size="40" />
                              
                              <input name="orders<?=$j?>" type="text" value="<?=$order?>" size="2" /><br />
 					<?php
						}
					}
					?>
						<input name="numpage" type="hidden" value="<?=$j?>" size="4" />
              </p></td>
            </tr>
            <tr>
              <td height="60" colspan="2" align="center" valign="middle"><input type="submit" name="Submit" value="Sort Pages" id="submit-butt"></td>
            </tr>
            -->
          </form>
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
<!-- // PROTECT 404 -->
<script type="text/javascript">
(function () {
    var removeSelect = document.querySelector('select[name="page_remove[]"]');
    var confirmRow = document.getElementById('delete404ConfirmRow');

    function updateDelete404Prompt() {
        if (!removeSelect || !confirmRow) return;

        var requiresConfirm = false;

        for (var i = 0; i < removeSelect.options.length; i++) {
            var option = removeSelect.options[i];
            if (option.selected && option.value === '404.html') {
                requiresConfirm = true;
                break;
            }
        }

        confirmRow.style.display = requiresConfirm ? 'table-row' : 'none';
    }

    if (removeSelect) {
        removeSelect.addEventListener('change', updateDelete404Prompt);
        updateDelete404Prompt();
    }
})();
</script>
<!-- // PROTECT 404 -->
</body>
</html>
