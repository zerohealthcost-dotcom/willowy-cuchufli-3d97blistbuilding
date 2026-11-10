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

$content = $seopage_select = '';
		function checkIfDirExists(){

		if(!file_exists('./settings/seo'))
		mkdir("./settings/seo", 0777);

		if(!file_exists('./settings/seo/content_pages'))
		mkdir("./settings/seo/content_pages", 0777);

		}



       if($_SESSION['logged_in']!=true)
	     {
			header("location:index.php?flag=2");
			exit;
	     }

		$filename="settings/seo_settings.txt";

		// Lock this page: do not allow any SEO/CSS/script settings to be saved.
		$settings_locked = true;
		if ($settings_locked && isset($_POST["Submit"])) {
			unset($_POST["Submit"]);
		}



		if(isset($_POST['page'])){



				$temp_var=explode("|",$_POST['page']);

				$seopage_select=trim($_POST['page']);

				$seopage=$temp_var['1'];
				$filename=$temp_var['1'];

				if($temp_var['0']=='c'){
					$file = basename($filename, ".html");
					$filename="./settings/seo/content_pages/$file.txt";
					}
				else if($temp_var['0']=='o'){

				if($seopage=='index.php'){
					$filename="settings/seo_settings.txt";
				}
				else{
					$filename="settings/seo/$temp_var[1]";
					$file = basename($filename, ".php");
					$filename="./settings/seo/$file.txt";
				}
				}

		}
		else{
			$seopage='index.php';
		}




		if(isset($_POST['Submit'])){

		$temp_var=explode("|",$_POST['seo_page']);
		$seopage=$temp_var['1'];

		$seopage_select=trim($_POST['seo_page']);

		if($temp_var['0']=='c'){
			checkIfDirExists();
			$filename=$temp_var['1'];
			$file = basename($filename, ".html");
			$filename="./settings/seo/content_pages/$file.txt";
			if(!$handle = fopen($filename, 'w'))
			{
			 echo "Cannot open file ($filename)";
			 exit;
			}
			$content .=stripslashes($_REQUEST['website_page_title']);
			$content .=stripslashes("#_1_#".$_REQUEST['website_description']);
			$content .=stripslashes("#_1_#".$_REQUEST['website_keywords']);
			$content .="#_1_#";
			$content .=stripslashes($_REQUEST['track']) ;
			$content .="#_1_#";
			$content .=stripslashes($_REQUEST['hide_seo']) ;
			$content .="#_1_#";
			$content .=stripslashes($_REQUEST['track2']) ;
			$content .="#_1_#";
			$content .=stripslashes($_REQUEST['custom_css']) ;
            $content .="#_1_#";
            $content .=!$_REQUEST['nocache']?1:0;
			if(fwrite($handle, $content) === FALSE)
			{
			echo "Cannot write to file ($filename)";
			exit;
			}
			fclose($handle);
			$_REQUEST['flag']=1;

		}
		else if($temp_var['0']=='o'){

		if($seopage=='index.php'){

			$filename="settings/seo_settings.txt";

			$content .=stripslashes($_REQUEST['website_page_title']) ;
			$content .="#_1_#";
			$content .=stripslashes($_REQUEST['website_description']) ;
			$content .="#_1_#";
			$content .=stripslashes($_REQUEST['website_keywords']) ;
			$content .="#_1_#";
			$content .=stripslashes($_REQUEST['track']) ;
			$content .="#_1_#";
			$content .=stripslashes($_REQUEST['hide_seo']) ;
			$content .="#_1_#";
			$content .=stripslashes($_REQUEST['track2']) ;
			$content .="#_1_#";
			$content .=stripslashes($_REQUEST['custom_css']) ;
            $content .="#_1_#";
            $content .=!$_REQUEST['nocache']?1:0;
            if(!$handle = fopen($filename, 'w'))
			{
				echo "Cannot open file ($filename)";
				exit;
			}


			if(fwrite($handle, $content) === FALSE)
			{
				echo "Cannot write to file ($filename)";
				exit;
			}
			fclose($handle);

			$_REQUEST['flag']=1;
		}
		else{

			$filename="settings/seo/$temp_var[1]";
			$file = basename($filename, ".php");
			$filename="./settings/seo/$file.txt";
			checkIfDirExists();

			if(!$handle = fopen($filename, 'w'))
			{
			 echo "Cannot open file ($filename)";
			 exit;
			}
			$content .=stripslashes($_REQUEST['website_page_title']);
			$content .=stripslashes("#_1_#".$_REQUEST['website_description']);
			$content .=stripslashes("#_1_#".$_REQUEST['website_keywords']);
			$content .="#_1_#";
			$content .=stripslashes($_REQUEST['track']) ;
			$content .="#_1_#";
			$content .=stripslashes($_REQUEST['hide_seo']) ;
			$content .="#_1_#";
			$content .=stripslashes($_REQUEST['track2']) ;
			$content .="#_1_#";
			$content .=stripslashes($_REQUEST['custom_css']) ;
            $content .="#_1_#";
            $content .=!$_REQUEST['nocache']?1:0;
            if(fwrite($handle, $content) === FALSE)
			{
			echo "Cannot write to file ($filename)";
			exit;
			}
			fclose($handle);
			$_REQUEST['flag']=1;
		}

		}

		}



		if($handle = @fopen($filename, 'r'))
		  {
			 $contents = fread($handle, filesize($filename));
             fclose($handle);
		     $argument_arr=explode("#_1_#",$contents);
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
#help_page_title { display:none; }
#help_hide_seo { display:none; }
#help_desc { display:none; }
#help_key { display:none; }
#help_track { display:none; }
#help_track2 { display:none; }
#help_track3 { display:none; }
#help_select { display:none; }
-->
</style>
<script src="ckeditor/ckeditor.js"></script>
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

function loadSEOSettings(page){
	document.frmhid.page.value=page;
	document.frmhid.submit();
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

    <td width="706" align="left" valign="top" style="padding-left:10px; padding-right:10px; padding-top:20px; padding-bottom:20px"><div class="members_title"><strong>S.E.O/CSS/Script Settings</strong></div>
<!--Main -->
<script language="javascript">

 function submit_form()
 {
	 if(document.frm.edit.value=="")
	   {
		 alert("Please Select a Page To Edit");
         document.frm.edit.focus();
		 return false;
	   }
	 document.frm.flag.value=1;
	 document.frm.submit();
 }

function submitform()
 {
	 document.frm.flag.value=2;
 }
</script>
          <script language="JavaScript">

	function chk()
	{
		if(document.frm.edit.value=="-1")
		{
			alert("Please Select a Page To Edit");
			document.frm.edit.focus();
			return false;
		}
	}

        </script>
<table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
		          <form name="frmhid" action="seo_settings.php" method="post" >
<input type='hidden' name='page' value=''>
</form>
        <form name="frm" action="seo_settings.php" method="post" >
            <input type="hidden" name="do_type" value="seo_settings_write">
            <tr>
              <td colspan="2" align="center" valign="middle" class="main2"><div class="upgrade_cell" style="margin-bottom:10px;">
                  <p><strong>Sorry, S.E.O/CSS/Script Settings is reserved for <a href="https://freemonthlywebsites.com/premier" target="_blank">Premier Members Only!</a></strong></p>
                <p>Premier Members can change all S.E.O settings for ALL pages.</p>
                <p>If you are interested in upgrading to Premier Membership, you can see all the benefits that it offers, and also upgrade from <a href="https://freemonthlywebsites.com/premier" target="_blank">HERE</a>.</p>
              </div></td>
            </tr>
            <tr>
              <td height="100" colspan="2" align="center" valign="middle" class="main2"><br>
                  Select Which Page to Optimize:<br />
                  <select name="seo_page"    class="remove"  onchange="loadSEOSettings(this.options[this.selectedIndex].value)">
                     <?php
					//loading php pages

					$pages=file('./settings/files.txt');
					foreach($pages as $key=>$value){
						$value=trim($value);
						?>
                          <option value="o|<?=$value?>"  <?php if($seopage_select=="o|".$value) { echo 'selected'; }
					?>> <?=str_replace(array('.html','.php'),'',$value);?></option>
<?php
}
{
?>
    <option value="c|main-download.php"  <?php if($seopage_select=="c|main-download.php") { echo 'selected'; }
	?>>Download</option>
    <option value="c|main-optin.php"  <?php if($seopage_select=="c|main-optin.php") { echo 'selected'; }
	?>>Optin</option>

 					<?php

					}
					//loading content pages

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

								//echo "<option value='c|".$files[$j]."' $issel>".$files[$j]."</option>";
?>
								 <option value="c|<?=$files[$j]?>" <?php if($seopage_select=="c|".$files[$j]) { echo 'selected'; }?>> <?=str_replace(array('.html','.php'),'',$files[$j]);?></option>

<?php
							}
						}
					?>
                  </select>
                  <a href="#" onClick="mm_showHide('help_select');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a><br></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_select">
                Select which page you would like to optimize, then enter details for that page below.
                </div></td>
            </tr>
            <tr>
              <td height="50" colspan="2" align="center" valign="bottom" style="padding-bottom:10px;">Your Website Page Title (for S.E.O purposes):<a href="#" onClick="mm_showHide('help_page_title');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
            <tr>
              <td colspan="2" align="center" valign="middle" class="main2"><input name="website_page_title" type="text" id="website_page_title" value="<?php echo $argument_arr['0']; ?>" style="width:300px;"></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_page_title">
                Enter a page title for your website, this will only be visible in your web browser title bar.<br />
                This is generally quite similar to your  website header title, however, you should try to add additional key words about your website into this title as it is used by search engines in the indexing of your website.</div></td>
            </tr>
            <tr>
                <td width="340" height="50" align="center" valign="middle" class="main2">Hide This Page From Search Engines<br />                    </td>
          <td width="365" height="50" align="left" valign="middle" class="main2">
        <input name="hide_seo" type="checkbox" id="hide_seo" value="1" <?=($argument_arr['4'] === '1'? 'checked':'');?>/>
                    <a href="#" onClick="mm_showHide('help_hide_seo');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
            <tr>
                <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_hide_seo">
                        Check this to hide your chosen page from search engine results.<br>
                        *It is highly recommended that you hide 'thanks' or download pages.</div></td>
            </tr>
            <tr class="seo_row">
              <td height="50" colspan="2" align="center" valign="bottom" style="padding-bottom:10px;">Your Website Description (for S.E.O purposes):<a href="#" onClick="mm_showHide('help_desc');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
            <tr class="seo_row">
              <td colspan="2" align="center" valign="middle" class="main2"><textarea name="website_description" rows="4" style="width:705px; max-width:705px;"><?php echo $argument_arr['1']; ?></textarea></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_desc">
                Enter a description for your website, this is purely for Search Engine Optimization purposes.<br />
                Your description has no limit in length, however, we suggest you use a maximum of 250 characters  and try to make it as unique as possible.<br />
                You should also try to include some important key words in your description.
                </div></td>
            </tr>
            <tr class="seo_row">
              <td height="50" colspan="2" align="center" valign="bottom" style="padding-bottom:10px;">Your Website Key Words (for S.E.O purposes):<a href="#" onClick="mm_showHide('help_key');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
            <tr class="seo_row">
              <td colspan="2" align="center" valign="middle" class="main2"><textarea name="website_keywords" rows="4" style="width:705px; max-width:705px;"><?php echo $argument_arr['2']; ?></textarea></td>
            </tr>
            <tr class="seo_row">
              <td colspan="2" align="center" valign="middle" class="main2">
              If you require a little help with your key words then <a href="https://freemonthlywebsites.com/special/seo/" target="_blank"><u>check out this tool</u></a>.<br>
              <div class="userhelp_cell" id="help_key">
                Enter some key words for your website, this is purely for Search Engine Optimization purposes.
                Key words are simply words or short phrases that you would associate with your website.
                Your key words, again, have no limit in length, however, we suggest you use a maximum of 1000 characters, but this time they do not have to be in a coherent phrase as they were in the title and description, they simply need to be listed with a comma and a space after each word.
                  Place your important keywords at the beginning, and make sure that all the keywords used in the title and the description are listed again.<br />
              <strong>example keywords</strong>: your, key, words, here</div></td>
            </tr>

            <tr>
              <td height="50" colspan="2" align="center" valign="bottom" style="padding-bottom:10px;">Page Additional Custom CSS:<a href="#" onClick="mm_showHide('help_track3');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
          </tr>
            <tr>
              <td colspan="2" align="center" valign="middle" class="main2"><textarea name="custom_css" rows="10" id="custom_css" style="width:705px; max-width:705px;"><?php echo $argument_arr['6']; ?></textarea></td>
            </tr>
            <tr>
                <td colspan="2" align="center" valign="middle" class="main2_pad"><div class="userhelp_cell" id="help_track3">
                        Enter any additional CSS that you would like for your chosen page.<br>
              This is purely optional, if you are not sure then leave this empty.</div></td>
            </tr>

            <tr>
              <td height="50" colspan="2" align="center" valign="bottom" style="padding-bottom:10px;">Additional Scripts/Code For Page '&lt;head&gt;':<a href="#" onClick="mm_showHide('help_track2');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
</tr>
            <tr>
              <td colspan="2" align="center" valign="middle" class="main2"><textarea name="track2" rows="10" id="track2" style="width:705px; max-width:705px;"><?php echo $argument_arr['5']; ?></textarea></td>
            </tr>
            <tr>
                <td colspan="2" align="center" valign="middle" class="main2_pad"><div class="userhelp_cell"  id="help_track2">
                        Enter any scripts/code that should be placed before closing &lt;/head&gt; on your chosen page.<br>
              This is purely optional, if you are not sure then leave this empty.</div></td>
            </tr>

            <tr>
              <td height="50" colspan="2" align="center" valign="bottom" style="padding-bottom:10px;">Additional Scripts/Code For Page '&lt;body&gt;':<a href="#" onClick="mm_showHide('help_track');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle" class="main2"><textarea name="track" rows="10" id="track" style="width:705px; max-width:705px;"><?php echo $argument_arr['3']; ?></textarea></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle" class="main2_pad"><div class="userhelp_cell" id="help_track">
              Enter any scripts/code that should be placed before closing &lt;/body&gt; on your chosen page.<br>
              This is purely optional, if you are not sure then leave this empty.</div></td>
            </tr>

            <tr>
              <td height="30" colspan="2" align="center" valign="middle" class="main2">&nbsp;</td>
            </tr>

            <tr>
                <td width="340" height="50" align="center" valign="middle" class="main2">Bypass Website Cache<br />                    </td>
                <td width="365" height="50" align="left" valign="middle" class="main2">
                    <input name="nocache" type="checkbox" id="nocache" value="1" <?=((!isset($argument_arr['7']) or !trim($argument_arr['7']) )? 'checked':'');?> />
                    <a href="#" onClick="mm_showHide('help_nocache');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr>
                <td colspan="2" align="center" valign="middle" class="main2_pad">
                    <div style="display:none" class="userhelp_cell" id="help_nocache">
                        If your web host uses CloudFlare CDN to cache your website then this will prevent you from seeing instant changes when made, leave this checked to bypass the Cloudflare CDN when developing your website.<br>*Note that your site could take upto 4 hours for the cache settings to update after saving.                    </div>                </td>
            </tr>
            <tr>
                <td height="50" colspan="2" align="center" valign="middle" class="main2">&nbsp;</td>
            </tr>

          <tr>

              <td height="50" colspan="2" align="center" valign="middle" class="main2"><p>
                  <input type="submit" name="Submit" value="Save S.E.O/CSS/Script Settings" id="submit-butt" disabled="disabled" onClick="return false;" style="opacity:0.55; cursor:not-allowed;" title="This option is locked.">
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

<script>
function checkHideSEO() {
    var checkbox = document.getElementById('hide_seo');
    if (!checkbox) return;

    var rows = document.getElementsByClassName('seo_row');

    for (var el of rows) {
        el.style.display = checkbox.checked ? 'none' : 'table-row';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var checkbox = document.getElementById('hide_seo');
    if (!checkbox) return;

    checkHideSEO();
    checkbox.addEventListener('change', checkHideSEO);
});
</script>
</body>
</html>
