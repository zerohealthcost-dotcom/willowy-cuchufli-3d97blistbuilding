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

$settings_file = "settings/design_settings.txt";
$success = false;
$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $display_powered = 1; //upgrade
    $upload_dir = './images/custom_images/';
    @mkdir($upload_dir);

    $allowed_image = ['image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/png'];
    $mypic = $_FILES['picture']['name'] ?? '';

    $design_arr = file_exists($settings_file) ? explode("#_1_#", file_get_contents($settings_file)) : array_fill(0, 16, "");

    if (empty($mypic)) {
        $mypic = $design_arr[0];
    }

    if (in_array($_FILES['picture']['type'], $allowed_image)) {
        move_uploaded_file($_FILES['picture']['tmp_name'], $upload_dir . $mypic);
    }

    $fields = [
        $mypic,
        $_POST['display_header'] ?? '',
        $_POST['page_width'] ?? '',
        $_POST['bg_color'] ?? '',
        $_POST['border_color'] ?? '',
        $_POST['border_width'] ?? '',
        $_POST['font_size'] ?? '',
        $_POST['page_color'] ?? '',
        $_POST['px_percent'] ?? '',
        $_POST['header_bg_color'] ?? '',
        $_POST['page_padding'] ?? '',
        $_POST['footer'] ?? '',
        $_POST['cbid'] ?? '',
        $_POST['display_powered'] ?? '',
        $_POST['shadow'] ?? '',
        $_POST['custom_css'] ?? '',
		$_POST['ts-title'] ?? '',
		$_POST['title_bg_color'] ?? '',
		$_POST['title_font_color'] ?? ''
    ];

    $content = implode("#_1_#", $fields);

    if (file_put_contents($settings_file, $content) !== false) {
        @unlink("./temp_preview/$mypic");
        header("Location: design_settings.php?flag=1");
        exit;
    } else {
        $error = true;
    }
}

$design_arr = file_exists($settings_file) ? explode("#_1_#", file_get_contents($settings_file)) : array_fill(0, 18, "");
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
#help_header { display:none; }
#help_display_header { display:none; }
#help_page_width { display:none; }
#help_bg_color { display:none; }
#help_border_color { display:none; }
#help_border_width { display:none; }
#help_display_nav { display:none; }
#help_nav_button { display:none; }
#help_nav_button_hov { display:none; }
#help_nav_button_font_color { display:none; }
#help_nav_button_font_size { display:none; }
#help_padding { display:none; }
#help_nav_button_round { display:none; }
#help_nav_background_color { display:none; }
#help_nav_padding { display:none; }
#help_content_padding { display:none; }
#help_page_color { display:none; }
#help_page_padding { display:none; }
#help_header_bg_color { display:none; }
#help_footer { display:none; }
#help_cbid { display:none; }
#help_display_powered { display:none; }
#help_ts-title { display:none; }
#help_title_bg_color { display:none; }
#help_title_font_color { display:none; }
#premier-upgrade-message {
    display:none;
    border:1px solid #e0c36c;
    background:#fff8e1;
    color:#5f4b00;
    line-height:1.6;
}
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
</script>
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a['i'])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a['i'].indexOf("#")!=0){ d.MM_p['j']=new Image; d.MM_p['j++'].src=a['i'];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames['n.substring(p+1)'].document; n=n.substring(0,p);}
  if(!(x=d['n'])&&d.all) x=d.all['n']; for (i=0;!x&&i<d.forms.length;i++) x=d.forms['i']['n'];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers['i'].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a['i']))!=null){document.MM_sr['j++']=x; if(!x.oSrc) x.oSrc=x.src; x.src=a['i+2'];}
}
//-->
</script>
<script src="js/jscolor.min.js"></script>
<script>
function ajaxFileUpload(upload_field)
{
// Checking file type
var re_text = /\.jpg|\.gif|\.png|\.jpeg/i;
var filename = upload_field.value;
if (filename.search(re_text) == -1) {
alert("File should be either jpg, gif, png or jpeg");
upload_field.form.reset();
return false;
}
document.getElementById('picture_preview').innerHTML = '<div><img src="images/ajax-loader.gif" border="0" /></div>';
upload_field.form.action = 'upload-picture.php';
upload_field.form.target = 'upload_iframe';
upload_field.form.submit();
upload_field.form.action = '';
upload_field.form.target = '';
return true;
}
</script>
</head>

<body>
<iframe name="upload_iframe" id="upload_iframe" style="display:none;"></iframe>
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

    <td width="706" align="left" valign="top" style="padding-left:10px; padding-right:10px; padding-top:20px; padding-bottom:20px"><div class="members_title"><strong>Design/Basic Settings </strong></div>
      <!--Main -->
      <table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
<form method="post" enctype="multipart/form-data">            
<?php if (isset($_GET['flag']) && $_GET['flag'] == 1): ?>
            <tr>
              <td height="50" colspan="2" align="center" valign="middle" class="saved">Data saved successfully <img src="images/check-green2.png" width="20" height="20" align="absmiddle" /></td>
            </tr>
<?php endif; ?>
            
            <tr>
              <td height="20" colspan="2" align="center" valign="middle">&nbsp;</td>
          </tr>
            <tr>
              <td height="50" align="right" valign="middle">Choose a Custom Header:&nbsp;&nbsp;</td>
              <td height="50" align="left" valign="middle"><div>
              <label for="picture" class="file-button">Custom Upload</label>                
                <a href="#" onClick="mm_showHide('help_header'); return false;"><input type="file" name="picture" id="picture" style="display:none"/></a>
    <a href="#" onClick="mm_showHide('help_header');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top"></a></div></td>
            </tr>
         <tr>
              <td colspan="2" align="center" valign="middle"><div class="upgrade_cell" id="help_header"> 
                <p><strong>Sorry, this function is reserved for <a href="https://freemonthlywebsites.com/premier" target="_blank">Premier Members Only</a>! </strong></p>
                <p>Premier Members have the ability to upload custom header images. <br>
If you are interested in upgrading to Premier Membership, you can see all the benefits that it offers, and also upgrade from <a href="https://freemonthlywebsites.com/premier" target="_blank">HERE</a>.</p>
              </div></td>
         </tr>
            <tr>
              <td height="50" colspan="2" align="center" valign="middle">
     <br />
<span id="picture_error"></span>
<div id="picture_preview">
<?php
if(!empty($design_arr['0'])){
	$filename=$design_arr['0'];
echo  '<img width=\'600px\' src=\'./images/custom_images/'.$filename.'\' id=\'preview_picture_tag\' name=\'preview_picture_tag\' /> <br>';
	  }
?>
</div>     </td>
          </tr>
            <tr>
              <td height="50" align="right" valign="middle">Display Custom Header:&nbsp;&nbsp;</td>
              <td height="50" align="left" valign="middle"><input type="checkbox" name="display_header" value="1" <?php
		  if($design_arr['1']==1)
		  {
			  echo "checked";
		  }
		  ?>><a href="#" onClick="mm_showHide('help_display_header');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top"></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle">
            <div class="userhelp_cell" id="help_display_header">Check this to display your header image.<br />
            </div></td>
            </tr>
            <tr>
              <td height="50" align="right" valign="middle">Header Background Color:&nbsp;&nbsp;</td>
              <td height="50" align="left" valign="middle"><input name="header_bg_color" class="jscolor" value="<?php echo "#",$design_arr['9']; ?>">
                <a href="#" onClick="mm_showHide('help_header_bg_color');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top"></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_header_bg_color"> Select the color you wish to have as the header background color.<br>
                This is only needed if you are using a transparent header image or no image.<br />
              </div></td>
            </tr>
            <tr>
              <td height="50" align="right" valign="middle">Overall Page Width:&nbsp;&nbsp;</td>
              <td height="50" align="left" valign="middle"><input style="width:40px" name="page_width" value="<?php echo $design_arr['2']; ?>" />
              <select name="px_percent" value="<?php echo $design_arr['8']; ?>">
                  <option value="px"<?php if($design_arr['8']=='px') echo "selected"; ?>>px</option>
                  <option value="%"<?php if($design_arr['8']=='%') echo "selected"; ?>>%</option>
                </select>
                <a href="#" onClick="mm_showHide('help_page_width');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_page_width">Choose your overall page width in pixels or percentage.<br />
                *Note: Your custom header image width should match the page width, if you use an image that exceeds your page width it will extend your page width to the width of that image.<br />
              </div></td>
            </tr>
            <tr>
              <td height="50" align="right" valign="middle">Page Padding (in pixels):&nbsp;&nbsp;</td>
              <td height="50" align="left" valign="middle"><input style="width:40px" name="page_padding" value="<?php echo $design_arr['10']; ?>" />
                px<a href="#" onClick="mm_showHide('help_page_padding');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_page_padding">Select the amount of padding you require in pixels.<br>
                This is basically the spacing around your page content.<br />
              </div></td>
            </tr>
            <tr>
              <td width="300" height="50" align="right" valign="middle">Page Color:&nbsp;&nbsp;</td>
              <td width="405" height="50" align="left" valign="middle"><input name="page_color" class="jscolor" value="<?php echo "#",$design_arr['7']; ?>">
                <a href="#" onClick="mm_showHide('help_page_color');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top"></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_page_color">
                Select the color you wish to have as the page color.<br />
              </div></td>
            </tr>
            <tr>
              <td width="300" height="50" align="right" valign="middle">Background Color:&nbsp;&nbsp;</td>
              <td width="405" height="50" align="left" valign="middle"><input name="bg_color" class="jscolor" value="<?php echo "#",$design_arr['3']; ?>">
                <a href="#" onClick="mm_showHide('help_bg_color');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top"></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_bg_color">
                Select the color you wish to have as the main background color.<br />
              </div></td>
            </tr>
            
            <tr>
              <td height="50" align="right" valign="middle">Border Color:&nbsp;&nbsp;</td>
              <td height="50" align="left" valign="middle"><input name="border_color" class="jscolor" value="<?php echo "#",$design_arr['4']; ?>" />
                <a href="#" onClick="mm_showHide('help_border_color');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_border_color">Select the color you wish to have as the main border color.<br />
              </div></td>
            </tr>
            <tr>
              <td height="50" align="right" valign="middle">Main Border Width (in pixels):&nbsp;&nbsp;</td>
              <td height="50" align="left" valign="middle"><input style="width:40px" name="border_width" value="<?php echo $design_arr['5']; ?>" />
                px<a href="#" onClick="mm_showHide('help_border_width');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_border_width">Select the width of your main border in pixels, use 0 for no border.<br />
              </div></td>
            </tr>
            <tr>
              <td height="50" align="right" valign="middle">Default Font Size:&nbsp;&nbsp;</td>
              <td height="50" align="left" valign="middle">
                  <select name="font_size" value="<?php echo $design_arr['6']; ?>">
                  <option value="10"<?php if($design_arr['6']=='10') echo "selected"; ?>>10</option>
                  <option value="11"<?php if($design_arr['6']=='11') echo "selected"; ?>>11</option>
                  <option value="12"<?php if($design_arr['6']=='12') echo "selected"; ?>>12</option>
                  <option value="13"<?php if($design_arr['6']=='13') echo "selected"; ?>>13</option>
                  <option value="14"<?php if($design_arr['6']=='14') echo "selected"; ?>>14</option>
                  <option value="15"<?php if($design_arr['6']=='15') echo "selected"; ?>>15</option>
                  <option value="16"<?php if($design_arr['6']=='16') echo "selected"; ?>>16</option>
                  <option value="17"<?php if($design_arr['6']=='17') echo "selected"; ?>>17</option>
                  <option value="18"<?php if($design_arr['6']=='18') echo "selected"; ?>>18</option>
                  <option value="19"<?php if($design_arr['6']=='19') echo "selected"; ?>>19</option>
                  <option value="20"<?php if($design_arr['6']=='20') echo "selected"; ?>>20</option>
                  <option value="21"<?php if($design_arr['6']=='21') echo "selected"; ?>>21</option>
                  <option value="22"<?php if($design_arr['6']=='22') echo "selected"; ?>>22</option>
                  <option value="23"<?php if($design_arr['6']=='23') echo "selected"; ?>>23</option>
                  <option value="24"<?php if($design_arr['6']=='24') echo "selected"; ?>>24</option>
                  <option value="25"<?php if($design_arr['6']=='25') echo "selected"; ?>>25</option>
                  <option value="20"<?php if($design_arr['6']=='26') echo "selected"; ?>>26</option>
                  <option value="21"<?php if($design_arr['6']=='27') echo "selected"; ?>>27</option>
                  <option value="22"<?php if($design_arr['6']=='28') echo "selected"; ?>>28</option>
                  <option value="23"<?php if($design_arr['6']=='29') echo "selected"; ?>>29</option>
                  <option value="24"<?php if($design_arr['6']=='30') echo "selected"; ?>>30</option>
                  <option value="25"<?php if($design_arr['6']=='31') echo "selected"; ?>>31</option>
                  <option value="20"<?php if($design_arr['6']=='32') echo "selected"; ?>>32</option>
                  <option value="21"<?php if($design_arr['6']=='33') echo "selected"; ?>>33</option>
                  <option value="22"<?php if($design_arr['6']=='34') echo "selected"; ?>>34</option>
                  <option value="23"<?php if($design_arr['6']=='35') echo "selected"; ?>>35</option>
                  <option value="24"<?php if($design_arr['6']=='36') echo "selected"; ?>>36</option>
                  <option value="25"<?php if($design_arr['6']=='37') echo "selected"; ?>>37</option>
                  <option value="20"<?php if($design_arr['6']=='38') echo "selected"; ?>>38</option>
                  <option value="21"<?php if($design_arr['6']=='39') echo "selected"; ?>>39</option>
                  <option value="22"<?php if($design_arr['6']=='40') echo "selected"; ?>>40</option>
                  <option value="23"<?php if($design_arr['6']=='41') echo "selected"; ?>>41</option>
                  <option value="24"<?php if($design_arr['6']=='42') echo "selected"; ?>>42</option>
                  <option value="25"<?php if($design_arr['6']=='43') echo "selected"; ?>>43</option>
                  <option value="20"<?php if($design_arr['6']=='44') echo "selected"; ?>>44</option>
                  <option value="21"<?php if($design_arr['6']=='45') echo "selected"; ?>>45</option>
                  <option value="22"<?php if($design_arr['6']=='46') echo "selected"; ?>>46</option>
                  <option value="23"<?php if($design_arr['6']=='47') echo "selected"; ?>>47</option>
                  <option value="24"<?php if($design_arr['6']=='48') echo "selected"; ?>>48</option>
                  <option value="25"<?php if($design_arr['6']=='49') echo "selected"; ?>>49</option>
                  <option value="25"<?php if($design_arr['6']=='50') echo "selected"; ?>>50</option>
                </select>
              px              <a href="#" onClick="mm_showHide('help_nav_button_font_size');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_nav_button_font_size">Select the default font size for the entire page.<br />
              </div></td>
            </tr>    
<!--top stories -->
            <tr>
                <tr>
                  <td height="50" align="right" valign="middle" style="padding-right:10px;"><span class="main2">Top Stories Page Title:</span></td>
                  <td height="50" align="left" valign="middle" style="padding-left:20px"><input name="ts-title" value="<?php echo $design_arr['16']; ?>" style="width: 200px;"><a href="#" onClick="mm_showHide('help_ts-title');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a>                  </td>
               </tr>
                <tr>
                  <td align="center" colspan="2" valign="top" class="main2"><div class="userhelp_cell" id="help_ts-title">Enter a title for your 'Top Stories' page. </div></td>
                </tr>
                <tr>
                  <td height="50" align="right" valign="middle">Page Title Background Color:&nbsp;&nbsp;</td>
                  <td height="50" align="left" valign="middle"><input name="title_bg_color" class="jscolor" value="<?php echo "#",$design_arr[17]; ?>">
                    <a href="#" onClick="mm_showHide('help_title_bg_color');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top"></a></td>
                </tr>
                <tr>
                  <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_title_bg_color"> Select the color you wish to have as the page title background color.<br />
                  </div></td>
                </tr>
                <tr>
                  <td height="50" align="right" valign="middle">Page Title Font Color:&nbsp;&nbsp;</td>
                  <td height="50" align="left" valign="middle"><input name="title_font_color" class="jscolor" value="<?php echo "#",$design_arr[18]; ?>">
                    <a href="#" onClick="mm_showHide('help_title_font_color');return false;"><img src="images/help.png" alt="" width="20" height="20" hspace="8" border="0" align="top"></a></td>
                </tr>
                <tr>
                  <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_title_font_color"> Select the color you wish to have as the page title font color.<br />
                  </div></td>
                </tr>
<!--top stories -->              
            
            <tr>
              <td height="50" colspan="2" align="center" valign="middle">Website Footer Content: <a href="#" onClick="mm_showHide('help_footer');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_footer">Enter your content for your website footer here using the WYSIWYG editor. <br />
                There is no limit to the amount of information you place here but we suggest you add a little at a time and keep checking your page to make sure it looks OK.<br />
                <br />
                We also recommend that if you are pasting a block of text in here, you paste your text in a basic notepad document first, then copy from there to here, so that it
                removes all the hidden formatting and makes it simpler for you to edit.<br />
                Use the WYSIWYG editor below to easily format your text. </div></td>
            </tr>
            <tr>
              <td height="50" colspan="2" align="center" valign="middle"><table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" valign="top"><textarea style="width:705px" name="footer" rows="4" id="footer" class="main_text"><?php echo $design_arr['11']; ?></textarea>
                        <script>
			CKEDITOR.replace( 'footer' );
		      </script></td>
                  </tr>
              </table></td>
            </tr>

            
            <tr>
              <td height="50" align="right" valign="middle" style="padding-right:10px;">Your ClickBank ID:</td>
              <td height="50" align="left" valign="middle" style="padding-left:20px"><input name="cbid" value="<?php echo $design_arr['12']; ?>" style="width: 200px;">
              <a href="#" onClick="mm_showHide('help_cbid');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top"></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle">
            <div class="userhelp_cell" id="help_cbid">Enter your ClickBank ID to get paid for sales from your 'Powered by Free Monthly Websites' link in your footer and also multiple adverts shown throughout the site.<br>
              You can get a ClickBank account for FREE <a href="https://www.clickbank.com/" target="_blank">here</a>.<br />
            </div></td>
            </tr>
            <tr>
              <td height="50" align="right" valign="middle" style="padding-right:10px;">Earn by Displaying Your Powered by Free Monthly Websites Link:&nbsp;&nbsp;</td>
              <td height="50" align="left" valign="middle">
              <a href="#" onClick="mm_showHide('help_display_powered');return false;"><input type="checkbox" name="display_powered" value="1" checked></a><a href="#" onClick="mm_showHide('help_display_powered');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top"></a></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle">
            <div class="upgrade_cell" id="help_display_powered">
            <p><strong>Sorry, this function is reserved for <a href="https://freemonthlywebsites.com/premier" target="_blank">Premier Members Only</a>! </strong></p>
                <p>Premier Members have the ability to turn this option on/off. <br>
If you are interested in upgrading to Premier Membership, you can see all the benefits that it offers, and also upgrade from <a href="https://freemonthlywebsites.com/premier" target="_blank">HERE</a>.</p>
            </div></td>
            </tr>

            <tr>
              <td height="50" colspan="2" align="right" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td height="50" colspan="2" align="center" valign="middle"><p>
                  <input type="submit" name="Submit" value="Save Design/Basic Settings" id="submit-butt">
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
