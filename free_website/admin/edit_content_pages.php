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

$content = '';

       if($_SESSION['logged_in']!=true)
	     {
			header("location:index.php?flag=2");
			exit;
	     }
		if(!empty($_REQUEST['flag']) and $_REQUEST['flag']==2) 
		  {
			if(!$handle = fopen("../content_pages/$_REQUEST[edit]", 'w')) 
			  {
				 echo "Cannot open file ($filename)";
				 exit;
			  } 
			  
			if(!empty($_REQUEST['display_me']) and $_REQUEST['display_me']=="on")
			{
			$display_me=1;
			}
			else
			{
			$display_me=0;
			}
			
    // Fix checkbox handling
    $display_me = isset($_REQUEST['display_me']) && $_REQUEST['display_me'] == "on" ? 1 : 0;
    //upgrade start
    $display_social_sharing = 0;
    //upgrade end
    $split_after_words = isset($_REQUEST['split_after_words']) ? (int)$_REQUEST['split_after_words'] : 250;
    if ($split_after_words < 1) {
        $split_after_words = 250;
    }

    $content .= "#_1_#title:::" . (empty($_REQUEST['title']) ? '' : $_REQUEST['title']);
    $content .= "#_1_#content_above:::" . (empty($_REQUEST['content_above']) ? '' : $_REQUEST['content_above']);
    $content .= "#_1_#display_me:::" . $display_me;
    $content .= "#_1_#split_after_words:::" . $split_after_words;
    $content .= "#_1_#display_social_sharing:::" . $display_social_sharing;

			if(fwrite($handle, $content) === FALSE) 
			  {
				echo "Cannot write to file ($filename)";
				exit;
			  }
			  $flag=3;
		  }

        if(!empty($_REQUEST['flag']) and ($_REQUEST['flag']==1 || $_REQUEST['flag']==2))
		  {
			$filename="../content_pages/$_REQUEST[edit]";
			if(!$handle = fopen($filename, 'r')) 
			  {
				 echo "Cannot open file ($filename)";
				 exit;
			  }
			$contents = @fread($handle, filesize($filename));
			@fclose($handle);
			$argument_arr=explode("#_1_#",$contents);
            $argument_arr_page=explode(":::",$argument_arr['0']);
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
#help_sel_page {display:none; }
#help_title {display:none; }
#help_code {display:none; }
#help_display_title {display:none; }
#help_content_above {display:none; }
#help_content_below {display:none; }
#help_nav_link {display:none; }
#help_words {display:none; }
#help_social_sharing {display:none; }
-->
</style>
<script src="ckeditor/ckeditor.js"></script>
<script type="text/javascript">
//upgrade start
function lockSocialSharing()
{
    var checkbox = document.getElementById('display_social_sharing');
    var help = document.getElementById('help_social_sharing');

    if (checkbox.checked) {
        checkbox.checked = false;
        help.style.display = 'block';
    }
}
//upgrade end
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
		what_hide = 'showrow';
		$(what_hide+"1").style.display='none';
		$(what_hide+"2").style.display='none';
		$(what_hide+"3").style.display='none';
		$(what_hide+"4").style.display='none';
		$(what_hide+"5").style.display='none';
		$(what_hide+"6").style.display='none';
		$(what_hide+"7").style.display='none';
		$(what_hide+"8").style.display='none';
		what_hide = 'hiderow';
		$(what_hide+"1").style.display='none';
		$(what_hide+"2").style.display='none';
		$(what_hide+"3").style.display='none';
		$(what_hide+"4").style.display='none';
		$(what_hide+"5").style.display='none';
		$(what_hide+"6").style.display='none';
		$(what_hide+"7").style.display='none';
		$(what_hide+"8").style.display='none';
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

    <td width="706" align="left" valign="top" style="padding-left:10px; padding-right:10px; padding-top:20px; padding-bottom:20px"><div class="members_title"><strong>Edit Website Pages </strong></div>
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

function preview_page()
 {
	 if(document.frm.edit.value=="")
	   {
		 alert("Please Select a Page To Edit");
         document.frm.edit.focus();
		 return false;
	   }
	 window.open('../show.php?id=' + encodeURIComponent(document.frm.edit.value), '_blank');
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
          <form name="frm" method="post" enctype="multipart/form-data" action="edit_content_pages.php" onSubmit="return submitform()">
            <input type="hidden" name="flag" >
            <?php

		if(!empty($_REQUEST['flag']) and $_REQUEST['flag']==2 )

		  {

?>
            <tr>
              <td width="705" height="50" colspan="2" align="center" valign="middle" class="saved">Data Saved Successfully <img src="images/check-green2.png" width="20" height="20" align="absmiddle" /></td>
            </tr>
            <?php

		}

?>
            <tr>
              <td height="80"align="center" valign="middle" class="main2"><p>New pages allow you to add any content you like. Simply select a page that you created in '<a href="add_content_pages.php"><u>Add/Remove  Pages</u></a>'
and enter the content for that page below.</p>                </td>
            </tr>
            <tr>
              <td height="50" align="center" valign="middle" class="main2">Please Select a Page To Edit:<a href="#" onClick="mm_showHide('help_sel_page');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a><a href="#" onClick="mm_showHide('help_sel_page');return false;"></a></td>
            </tr>
            <tr>
              <td align="center" valign="middle" class="main2"><div class="userhelp_cell" id="help_sel_page">
                Simply select a page from the drop down menu below that you wish to edit.</div></td>
            </tr>
            <tr>
              <td height="50" align="center" valign="middle" class="main2"><div align="center">
                  <select name="edit" id="edit" onChange="submit_form()">
                    <option value="" selected disabled>&nbsp;&nbsp;Please Select a Page To Edit&nbsp;&nbsp;</option>
                    <?php
if ($handle = opendir('../content_pages')) {
    while (false !== ($file = readdir($handle))) {
        if ($file == "." || $file == "..")
            continue;
        $selected = ($file == $_REQUEST['edit']) ? "selected" : "";
        // Remove the ".html" extension for display
        $pageName = str_replace('.html', '', $file);
        echo "<option value='$file' $selected>$pageName</option>";
    }
    closedir($handle);
}
?>
</select>

<?php if (isset($_REQUEST['edit'])): ?>
    <input type="button" value="View Page" id="preview-butt" onClick="preview_page()">
    <?php
    // Extract the page name from the selected file name
    $currentPageName = str_replace('.html', '', $_REQUEST['edit']);
    ?>
<?php endif; ?>

                  <script>
                function awgr_do_change()
                {
                	q = document.getElementById('edit');
                	if(q.selectedIndex==0) //page edit
                	{
						awgr_show_hide('showrow', 'hiderow');
		 			   // a.style.display='none';
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
              	function $(id) { return document.getElementById(id); }
              	f=window.onload;
              	window.onload=function() {
              		if(f) f();
              		awgr_do_change();              		
              	};
              	
              </script>
              </div></td>
            </tr>
            <tr>
              <td height="20" align="center" valign="middle" class="main2">&nbsp;</td>
            </tr>
            <tr id="showrow1">
              <td></td>
            </tr>
            <tr id="showrow2">
              <td></td>
            </tr>
            <tr id="showrow3">
              <td></td>
            </tr>
            <tr id="showrow4">
              <td></td>
            </tr>
            <tr id="showrow5">
              <td></td>
            </tr>
            <tr id="showrow6">
              <td></td>
            </tr>
            <tr id="showrow7">
              <td></td>
            </tr>
            <tr id="showrow8">
              <td></td>
            </tr>

            <tr id="hiderow1">
              <td height="60" align="center" valign="middle" class="main2">Enter Page Title:<a href="#" onClick="mm_showHide('help_title');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr>
              <td align="center" valign="top" class="main2"><div class="userhelp_cell" id="help_title">Enter a title for your page.
              </div></td>
            </tr>
            <tr>
              <td height="60" align="center" valign="middle" class="main2">
              <table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr id="hiderow2">
                  <td align="center" valign="top"> 
                  <input name="title" type="text" id="title" value="<?php $arr=explode(":::",$argument_arr['1']); echo $arr['1']; ?>" style="width: 300px;" />              </td>
    </tr>
</table>              </td>
            </tr>
            
            <tr id="hiderow3">
              <td height="60" align="center" valign="middle" class="main2">Enter Page Content:<a href="#" onClick="mm_showHide('help_content_above');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr>
              <td align="center" valign="top" class="main2"><div class="userhelp_cell" id="help_content_above">Enter any content for your page using the WYSIWYG editor.<br />
                There is no limit to the amount of information you place here but we suggest you add a little at a time and keep checking your page to make sure it looks OK.<br />
                    <br />
                    We also recommend that if you are pasting a block of text in here, you paste your text in a basic notepad document first, then copy from there to here, so that it
                  removes all the hidden formatting and makes it simpler for you to edit.<br />
Use the WYSIWYG editor below to easily format your text.
              </div></td>
            </tr>
            <tr>
              <td height="60" align="center" valign="middle" class="main2">
              <table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr id="hiderow4">
                  <td align="center" valign="top">        
<textarea style="width:705px" name="content_above" rows="4" id="content_above" class="main_text"><?php 
			if ( !empty( $argument_arr['2'] ) ){
				$arr=explode(":::",$argument_arr['2']);
				echo $arr['1']; 
			}
			  ?></textarea>
              <script>
                            CKEDITOR.replace("content_above",
                                {
                                  height: 400
                                });
              </script>                  </td>
    </tr>
</table>            </td>
            </tr>
            <tr>
              <td height="25" align="center" valign="middle"></td>
            </tr>
            <tr id="hiderow5">
              <td height="40" align="center" valign="middle"><label for="split_after_words">Split Text After</label>
<input name="split_after_words" type="text" id="split_after_words" value="<?php
    $split_after_words_value = 450;
    if (!empty($argument_arr[4])) {
        $split_after_words_arr = explode(":::", $argument_arr[4]);
        if (isset($split_after_words_arr[1]) && (int)$split_after_words_arr[1] > 0) {
            $split_after_words_value = (int)$split_after_words_arr[1];
        }
    }
    echo $split_after_words_value;
?>" style="width:60px;" /> Words<a href="#" onClick="mm_showHide('help_words');return false;"><img src="images/help.png" alt="" width="20" height="20" hspace="8" border="0" align="top" /></a><br>
<div class="userhelp_cell" id="help_words">We Recommend you should use between 350–550 words.<br />
              </div></td>
            </tr>
            <tr id="hiderow6">
              <td height="50" align="center" valign="middle"><input name="display_me" type="checkbox" id="display_me" 
    <?php 
    if (
        (empty($argument_arr[3])) || // If no value is set, check by default
        (!empty($argument_arr[3]) && explode(":::", $argument_arr[3])[1] == 1)
    ) {
        echo "checked";
    }
    ?>>


    <label for="display_me">Display in Top Stories</label>

    <br></td>
            </tr>
            <tr id="hiderow7">
              <td height="50" align="center" valign="middle"><!-- //upgrade start --><input name="display_social_sharing" type="checkbox" id="display_social_sharing" onClick="lockSocialSharing();"> <!-- //upgrade end -->


    <label for="display_social_sharing">Display Social Sharing Options</label><a href="#" onClick="mm_showHide('help_social_sharing');return false;"><img src="images/help.png" alt="" width="20" height="20" hspace="8" border="0" align="top" /></a>

    <br></td>
            </tr>
            <tr id="hiderow8">
<!-- //upgrade start -->
              <td align="center" valign="top" class="main2"><div class="upgrade_cell" id="help_social_sharing"><p><strong>Sorry, this function is reserved for <a href="https://freemonthlywebsites.com/premier" target="_blank">Premier Members Only</a>!</strong><br /><br />Premier Members can enable social sharing options on their pages.<br>
If you are interested in upgrading to Premier Membership, you can see all the benefits that it offers, and also upgrade from <a href="https://freemonthlywebsites.com/premier" target="_blank">HERE</a>.</p>
              </div></td>
<!-- //upgrade end -->
            </tr>
            <tr>
              <td height="50" align="center" valign="middle" class="main2">&nbsp;</td>
            </tr>
            
            <tr>
              <td height="50" align="center" valign="middle" class="main2"><p>
                  <input type="submit" name="Submit" value="Save Edited Page" id="submit-butt" onclick='form_submit_2()'>
              </p></td>
            </tr>
            <tr>
              <td height="50" align="center" valign="middle" class="main2">
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
<script type="text/javascript" language="JavaScript">
    function preview_page()
    {
        window.open('./../<?=str_replace('.html','',$_REQUEST['edit']);?>')
    }
</script>
</body>
</html>
