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

$settings_file = "settings/home_settings.txt";

function eb_get_home_ads_display_setting($home_arr)
{
    $value = isset($home_arr[9]) ? trim((string)$home_arr[9]) : '2';
    return in_array($value, array('0', '1', '2', 'custom'), true) ? $value : '2';
}

function eb_get_home_split_words_setting($home_arr)
{
    $value = isset($home_arr[11]) ? (int)$home_arr[11] : 100;
    return ($value > 0) ? $value : 100;
}

function eb_extract_menu_settings($content_above)
{
    $defaults = array(
        'font_color' => '333333',
        'font_size' => '14',
        'btn_color' => 'FFFFFF',
        'btn_hover' => 'EEEEEE',
        'btn_border' => 'CCCCCC',
        'btn_border_width' => '1',
        'btn_radius' => '4'
    );
    if (preg_match('/<!--\s*MENU_SETTINGS:(\{.*?\})\s*-->/s', $content_above, $m)) {
        $json = json_decode(html_entity_decode($m[1], ENT_QUOTES), true);
        if (is_array($json)) {
            return array_merge($defaults, $json);
        }
    }
    return $defaults;
}

function eb_extract_menu_items($content_above)
{
    $defaults = array(
        array('label' => 'Home', 'link' => '', 'image' => '', 'new_window' => 0),
        array('label' => 'Top Stories', 'link' => '', 'image' => '', 'new_window' => 0),
        array('label' => 'Recommended', 'link' => '', 'image' => '', 'new_window' => 0),
        array('label' => 'Browse', 'link' => '', 'image' => '', 'new_window' => 0),
        array('label' => 'Free Site', 'link' => '', 'image' => '', 'new_window' => 0)
    );

    if (trim($content_above) == '') {
        return $defaults;
    }

    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $loaded = $dom->loadHTML('<?xml encoding="utf-8" ?>' . $content_above);
    if (!$loaded) {
        return $defaults;
    }

    $anchors = $dom->getElementsByTagName('a');
    $items = array();
    foreach ($anchors as $a) {
        $label = trim(preg_replace('/\s+/', ' ', $a->textContent));
        $link = trim($a->getAttribute('href'));
        $target = trim($a->getAttribute('target'));
        $imgsrc = '';
        $imgs = $a->getElementsByTagName('img');
        if ($imgs->length > 0) {
            $imgsrc = trim($imgs->item(0)->getAttribute('src'));
        }
        if ($label == '' && $imgsrc == '' && $link == '') {
            continue;
        }
        $items[] = array(
            'label' => $label,
            'link' => $link,
            'image' => $imgsrc,
            'new_window' => ($target == '_blank' ? 1 : 0)
        );
        if (count($items) >= 5) {
            break;
        }
    }

    for ($i = 0; $i < 5; $i++) {
        if (!isset($items[$i])) {
            $items[$i] = $defaults[$i];
        } else {
            if ($items[$i]['label'] == '') {
                $items[$i]['label'] = $defaults[$i]['label'];
            }
        }
    }

    return $items;
}

function eb_build_menu_html($items, $settings)
{
    $safe_settings = array(
        'font_color' => preg_replace('/[^a-fA-F0-9]/', '', $settings['font_color']),
        'font_size' => preg_replace('/[^0-9]/', '', $settings['font_size']),
        'btn_color' => preg_replace('/[^a-fA-F0-9]/', '', $settings['btn_color']),
        'btn_hover' => preg_replace('/[^a-fA-F0-9]/', '', $settings['btn_hover']),
        'btn_border' => preg_replace('/[^a-fA-F0-9]/', '', $settings['btn_border']),
        'btn_border_width' => preg_replace('/[^0-9]/', '', $settings['btn_border_width']),
        'btn_radius' => preg_replace('/[^0-9]/', '', $settings['btn_radius'])
    );

    $settings_json = htmlspecialchars(json_encode($safe_settings), ENT_QUOTES);

    $html = "\n<!-- MENU_SETTINGS:" . $settings_json . " -->\n";
    $html .= "<style type=\"text/css\">\n";
    $html .= ".easybuildr-home-menu{display:flex; justify-content:space-between; align-items:stretch; width:100%; gap:12px; padding:0; margin:0 auto;}\n";
    $html .= ".easybuildr-home-menu a{display:flex; flex:1 1 0; min-width:0; flex-direction:column; justify-content:space-between; align-items:center; margin:0; padding:12px 10px; text-decoration:none; color:#" . $safe_settings['font_color'] . " !important; font-size:" . $safe_settings['font_size'] . "px; background:#" . $safe_settings['btn_color'] . "; border:" . $safe_settings['btn_border_width'] . "px solid #" . $safe_settings['btn_border'] . "; border-radius:" . $safe_settings['btn_radius'] . "px; box-sizing:border-box; text-align:center; overflow:hidden;}\n";
    $html .= ".easybuildr-home-menu a:hover{background:#" . $safe_settings['btn_hover'] . " !important; color:#" . $safe_settings['font_color'] . " !important;}\n";
    $html .= ".easybuildr-home-menu .menu-label{display:block; width:100%; line-height:1.2;}\n";
    $html .= ".easybuildr-home-menu .menu-icon-wrap{width:100%; height:72px; display:flex; align-items:center; justify-content:center; margin-top:10px; overflow:hidden;}\n";
    $html .= ".easybuildr-home-menu img{display:block !important; margin:0 auto !important; border:0 !important; width:100% !important; height:100% !important; max-width:100% !important; max-height:72px !important; object-fit:contain !important;}\n";
    $html .= "</style>\n";
    $html .= "<div class=\"easybuildr-home-menu\" data-shrink-one-row=\"0\" data-font-size=\"" . $safe_settings['font_size'] . "\" data-image-width=\"76\" data-image-height=\"55\" data-icon-wrap-height=\"55\" data-pad-y=\"8\" data-pad-x=\"12\" data-margin-x=\"5\">\n";

    foreach ($items as $item) {
        $label = htmlspecialchars($item['label'], ENT_QUOTES);
        $link = htmlspecialchars($item['link'], ENT_QUOTES);
        $target = !empty($item['new_window']) ? ' target="_blank"' : '';
        $style = 'color:#' . $safe_settings['font_color'] . ' !important; font-size:' . $safe_settings['font_size'] . 'px; background:#' . $safe_settings['btn_color'] . '; border:' . $safe_settings['btn_border_width'] . 'px solid #' . $safe_settings['btn_border'] . '; border-radius:' . $safe_settings['btn_radius'] . 'px;';
        $html .= "<a href=\"" . $link . "\"" . $target . " style=\"" . $style . "\"><span class=\"menu-label\">" . $label . "</span>";
        if (!empty($item['image'])) {
            $src = htmlspecialchars($item['image'], ENT_QUOTES);
            $html .= "<span class=\"menu-icon-wrap\"><img src=\"" . $src . "\" alt=\"\" /></span>";
        }
        $html .= "</a>\n";
    }

    $html .= "</div>\n";
    $html .= "<script type=\"text/javascript\">(function(){function fitMenu(menu){if(!menu){return;}var links=menu.getElementsByTagName('a');if(!links.length){return;}var enabled=menu.getAttribute('data-shrink-one-row')==='1';var baseFont=parseFloat(menu.getAttribute('data-font-size'))||14;var baseImgW=parseFloat(menu.getAttribute('data-image-width'))||76;var baseImgH=parseFloat(menu.getAttribute('data-image-height'))||30;var baseWrapH=parseFloat(menu.getAttribute('data-icon-wrap-height'))||32;var basePadY=parseFloat(menu.getAttribute('data-pad-y'))||8;var basePadX=parseFloat(menu.getAttribute('data-pad-x'))||12;var baseMarginX=parseFloat(menu.getAttribute('data-margin-x'))||5;function resetItems(){for(var i=0;i<links.length;i++){links[i].style.width='';links[i].style.fontSize=baseFont+'px';links[i].style.padding=basePadY+'px '+basePadX+'px';links[i].style.margin='4px '+baseMarginX+'px';var wraps=links[i].getElementsByClassName?links[i].getElementsByClassName('menu-icon-wrap'):[];if(wraps.length){wraps[0].style.height=baseWrapH+'px';wraps[0].style.marginTop='6px';}var img=links[i].getElementsByTagName('img');if(img.length){img[0].style.width='';img[0].style.maxWidth=baseImgW+'px';img[0].style.maxHeight=baseImgH+'px';img[0].style.height='auto';img[0].style.marginTop='0';}}}function applyScale(scale){for(var i=0;i<links.length;i++){links[i].style.fontSize=Math.max(10,Math.round(baseFont*scale))+'px';links[i].style.padding=Math.max(2,Math.round(basePadY*scale))+'px '+Math.max(4,Math.round(basePadX*scale))+'px';links[i].style.margin='4px '+Math.max(1,Math.round(baseMarginX*scale))+'px';var wraps=links[i].getElementsByClassName?links[i].getElementsByClassName('menu-icon-wrap'):[];if(wraps.length){wraps[0].style.height=Math.max(18,Math.round(baseWrapH*scale))+'px';wraps[0].style.marginTop=Math.max(2,Math.round(6*scale))+'px';}var img=links[i].getElementsByTagName('img');if(img.length){img[0].style.maxWidth=Math.max(20,Math.round(baseImgW*scale))+'px';img[0].style.maxHeight=Math.max(14,Math.round(baseImgH*scale))+'px';img[0].style.width='auto';img[0].style.height='auto';}}}function setTargetWidths(available){var count=links.length||5;var per=Math.floor(available/count)-2;if(per<72){per=72;}for(var i=0;i<links.length;i++){links[i].style.width=per+'px';}}resetItems();menu.style.whiteSpace='normal';if(!enabled){return;}var parent=menu.parentNode;if(!parent){return;}var available=parent.clientWidth-4;if(available<100){return;}menu.style.whiteSpace='nowrap';setTargetWidths(available);var total=menu.scrollWidth;if(total<=available){return;}var scale=Math.max(0.42,Math.min(1,available/total));applyScale(scale);setTargetWidths(available);var totalAfter=menu.scrollWidth;if(totalAfter>available){var scale2=Math.max(0.34,Math.min(scale,available/totalAfter));applyScale(scale2);setTargetWidths(available);}if(menu.scrollWidth>available){for(var j=0;j<links.length;j++){links[j].style.width=Math.max(64,Math.floor((available/(links.length||5))-2))+'px';links[j].style.fontSize='10px';links[j].style.padding='2px 4px';var wraps2=links[j].getElementsByClassName?links[j].getElementsByClassName('menu-icon-wrap'):[];if(wraps2.length){wraps2[0].style.height='18px';wraps2[0].style.marginTop='2px';}var imgs2=links[j].getElementsByTagName('img');if(imgs2.length){imgs2[0].style.maxWidth='20px';imgs2[0].style.maxHeight='14px';}}}if(menu.scrollWidth>available){menu.style.whiteSpace='normal';}}function run(){var menus=document.getElementsByClassName?document.getElementsByClassName('easybuildr-home-menu'):[];for(var i=0;i<menus.length;i++){fitMenu(menus[i]);}}if(window.addEventListener){window.addEventListener('load',function(){run();setTimeout(run,100);setTimeout(run,300);},false);window.addEventListener('resize',run,false);}else if(window.attachEvent){window.attachEvent('onload',function(){run();setTimeout(run,100);setTimeout(run,300);});window.attachEvent('onresize',run);}})();</script>";
    return $html;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menu_items = array();
    for ($i = 1; $i <= 5; $i++) {
        $image_value = trim($_POST['menu_image_' . $i] ?? '');
        if (!empty($_FILES['menu_upload_' . $i]['name'])) {
            $filename = preg_replace('/[^A-Za-z0-9\.\-\_]/', '', basename($_FILES['menu_upload_' . $i]['name']));
            if ($filename != '') {
                if (!is_dir('../uploads')) {
                    @mkdir('../uploads', 0777, true);
                }
                if (move_uploaded_file($_FILES['menu_upload_' . $i]['tmp_name'], '../uploads/' . $filename)) {
                    $image_value = 'uploads/' . $filename;
                }
            }
        }

        $menu_items[] = array(
            'label' => trim($_POST['menu_label_' . $i] ?? ''),
            'link' => trim($_POST['menu_link_' . $i] ?? ''),
            'image' => $image_value,
            'new_window' => !empty($_POST['menu_new_window_' . $i]) ? 1 : 0
        );
    }

    $menu_settings = array(
        'font_color' => ltrim(trim($_POST['menu_font_color'] ?? '333333'), '#'),
        'font_size' => trim($_POST['menu_font_size'] ?? '14'),
        'btn_color' => ltrim(trim($_POST['menu_btn_color'] ?? 'FFFFFF'), '#'),
        'btn_hover' => ltrim(trim($_POST['menu_btn_hover'] ?? 'EEEEEE'), '#'),
        'btn_border' => ltrim(trim($_POST['menu_btn_border'] ?? 'CCCCCC'), '#'),
        'btn_border_width' => trim($_POST['menu_btn_border_width'] ?? '1'),
        'btn_radius' => trim($_POST['menu_btn_radius'] ?? '4')
    );

    $_POST['content_above'] = eb_build_menu_html($menu_items, $menu_settings);

    // Process form submission
    $content = $_POST['code'] . "#_1_#" .
               $_POST['bg_color'] . "#_1_#" .
               $_POST['border_color'] . "#_1_#" .
               $_POST['border_width'] . "#_1_#" .
               $_POST['footer'] . "#_1_#" .
               $_POST['footer_bg_color'] . "#_1_#" .
               $_POST['content_above'] . "#_1_#" .
               $_POST['content_below'] . "#_1_#" .
               $_POST['title'] . "#_1_#" .
               '1' . "#_1_#" . //upgrade
               (!empty($_POST['display_hero_ads_home_page']) ? '1' : '0') . "#_1_#" .
               max(1, (int)($_POST['split_text_words'] ?? 100)) . "#_1_#" .
               ($_POST['custom_ads_content'] ?? '');

    if (file_put_contents($settings_file, $content) === false) {
        echo "Error saving settings.";
    } else {
        header("Location: home_page_settings.php?flag=1");
        exit;
    }
}

// Load existing settings
$home_arr = file_exists($settings_file) ? explode("#_1_#", file_get_contents($settings_file)) : [];
$menu_items = eb_extract_menu_items($home_arr['6'] ?? '');
$menu_settings = eb_extract_menu_settings($home_arr['6'] ?? '');
$display_ads_home_page = eb_get_home_ads_display_setting($home_arr);
$split_text_words = eb_get_home_split_words_setting($home_arr);
$custom_ads_content = $home_arr[12] ?? '';
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
#help_code { display:none; }
#help_footer { display:none; }
#help_bg_color { display:none; }
#help_border_color { display:none; }
#help_border_width { display:none; }
#help_footer_bg_color { display:none; }
#help_content_above { display:none; }
#help_content_below { display:none; }
#help_title { display:none; }
#help_main_ads{ display:none; }
#help_hero_ads{ display:none; }
#help_words{ display:none; }
#help_custom_ads{ display:none; }
#custom_ads_wrap{ display:none; }
#help_upload{ display:none; }
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

function toggleCustomAdsField()
{
    var select = document.getElementById('display_ads_home_page');
    var wrap = document.getElementById('custom_ads_wrap');
    if (!select || !wrap) return;
    wrap.style.display = (select.value === 'custom') ? 'table-row' : 'none';
}
</script>

<style type="text/css">
.file-button { display:inline-block; background:#666; color:#fff; padding:4px 8px; cursor:pointer; border-radius:3px; font-size:12px; }
.menu-mini-input { width:170px; }
.menu-preview-wrap { width:100%; overflow:hidden; }
.menu-preview-wrap a { pointer-events:none !important; cursor:default !important; }
.menu-preview-wrap .easybuildr-home-menu a { color:inherit; }
.menu-preview-wrap .easybuildr-home-menu .menu-icon-wrap { display:flex; align-items:center; justify-content:center; }
.menu-item-table td { padding-top:6px; padding-bottom:6px; }
.upload-name { font-size:11px; color:#666; padding-left:8px; display:inline-block; max-width:180px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; vertical-align:middle; }
.style1 {font-size: 10px}
</style>
<script type="text/javascript">
function updateMenuUploadName(input, index)
{
    var el = document.getElementById('upload_name_' + index);
    if (el && input.files.length > 0) {
        el.innerHTML = input.files[0].name;
    }
    previewMenu();
}
function previewMenu()
{
    var wrap = document.getElementById('menu_preview');
    if (!wrap) return;

    var fontColor = (document.getElementById('menu_font_color').value || '333333').replace('#','');
    var fontSize = document.getElementById('menu_font_size').value || '14';
    var btnColor = (document.getElementById('menu_btn_color').value || 'FFFFFF').replace('#','');
    var btnHover = (document.getElementById('menu_btn_hover').value || 'EEEEEE').replace('#','');
    var btnBorder = (document.getElementById('menu_btn_border').value || 'CCCCCC').replace('#','');
    var btnBorderWidth = document.getElementById('menu_btn_border_width').value || '1';
    var btnRadius = document.getElementById('menu_btn_radius').value || '4';
    var shrinkOneRow = '1';

    var html = '<style type="text/css">';
    html += '.easybuildr-home-menu{display:flex; flex-wrap:nowrap; justify-content:center; align-items:flex-start; gap:6px; padding:0; margin:0 auto; width:100%; box-sizing:border-box;}';
    html += '.easybuildr-home-menu a{display:block; flex:1 1 0; min-width:0; max-width:calc(20% - 6px); vertical-align:top; margin:0; padding:8px 8px; text-decoration:none; color:#' + fontColor + ' !important; font-size:' + fontSize + 'px; background:#' + btnColor + '; border:' + btnBorderWidth + 'px solid #' + btnBorder + '; border-radius:' + btnRadius + 'px; box-sizing:border-box; text-align:center; overflow:hidden;}';
    html += '.easybuildr-home-menu a:hover{background:#' + btnHover + ' !important; color:#' + fontColor + ' !important;}';
    html += '.easybuildr-home-menu .menu-label{display:block; line-height:1.2; white-space:normal; word-break:break-word; overflow-wrap:anywhere;}';
    html += '.easybuildr-home-menu .menu-icon-wrap{height:55px; width:100%; display:flex; align-items:center; justify-content:center; margin-top:6px; overflow:hidden;}';
    html += '.easybuildr-home-menu img{display:block !important; margin:0 auto !important; border:0 !important; width:auto !important; height:auto !important; max-width:100% !important; max-height:55px !important; object-fit:contain !important;}';
    html += '</style><div class="easybuildr-home-menu" data-shrink-one-row="' + shrinkOneRow + '" data-font-size="' + fontSize + '" data-image-width="76" data-image-height="55" data-icon-wrap-height="55" data-pad-y="8" data-pad-x="8" data-margin-x="3" data-gap-x="6">';

    for (var i = 1; i <= 5; i++) {
        var label = document.getElementById('menu_label_' + i).value || '';
        var image = document.getElementById('menu_image_' + i).value || '';
        var fileInput = document.getElementById('menu_upload_' + i);
        var imageSrc = image;

        if (fileInput && fileInput.files && fileInput.files[0]) {
            imageSrc = URL.createObjectURL(fileInput.files[0]);
        } else if (imageSrc.indexOf('uploads/') === 0) {
            imageSrc = '../' + imageSrc;
        }

        html += '<a href="javascript:void(0);" onclick="return false;" style="color:#' + fontColor + ' !important; font-size:' + fontSize + 'px; background:#' + btnColor + '; border:' + btnBorderWidth + 'px solid #' + btnBorder + '; border-radius:' + btnRadius + 'px;"><span class="menu-label">' + label.replace(/</g,'&lt;').replace(/>/g,'&gt;') + '</span>';
        if (imageSrc !== '') {
            html += '<span class="menu-icon-wrap"><img src="' + imageSrc.replace(/"/g, '&quot;') + '" alt="" /></span>';
        }
        html += '</a>';
    }

    html += '</div>';
    wrap.innerHTML = html;

    var menu = wrap.getElementsByClassName ? wrap.getElementsByClassName('easybuildr-home-menu')[0] : null;
    if (menu) {
        fitPreviewMenu(menu);
        setTimeout(function(){ fitPreviewMenu(menu); }, 50);
        setTimeout(function(){ fitPreviewMenu(menu); }, 180);
    }
}

function fitPreviewMenu(menu)
{
    if (!menu) return;
    var links = menu.getElementsByTagName('a');
    if (!links.length) return;

    var baseFont = parseFloat(menu.getAttribute('data-font-size')) || 14;
    var minFont = Math.max(6, baseFont - 8);

    function labelOverflow(link) {
        var label = link.getElementsByClassName ? link.getElementsByClassName('menu-label')[0] : null;
        return label && label.scrollWidth > label.clientWidth + 1;
    }

    function setWrap(link, wrap) {
        var label = link.getElementsByClassName ? link.getElementsByClassName('menu-label')[0] : null;
        if (!label) return;
        label.style.whiteSpace = wrap ? 'normal' : 'nowrap';
    }

    function applyFont(size) {
        for (var i = 0; i < links.length; i++) {
            links[i].style.fontSize = size + 'px';
        }
    }

    applyFont(baseFont);

    var size = baseFont;
    while (size > minFont) {
        var overflow = false;
        for (var i = 0; i < links.length; i++) {
            if (labelOverflow(links[i])) {
                overflow = true;
                break;
            }
        }
        if (!overflow) break;
        size--;
        applyFont(size);
    }

    for (var i = 0; i < links.length; i++) {
        if (labelOverflow(links[i])) {
            setWrap(links[i], true);
        } else {
            setWrap(links[i], false);
        }
    }
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

    <td width="705" align="left" valign="top" style="padding-left:10px; padding-right:10px; padding-top:20px; padding-bottom:20px"><div class="members_title"><strong>Main/Home Page Settings </strong></div>
      <!--Main -->
      <table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
  <form method="post" enctype="multipart/form-data">
            
            <?php
		if(!empty( $_REQUEST['flag'] ) and $_REQUEST['flag']==1)
		  {
?>
            <tr>
              <td height="50" align="center" valign="middle" class="saved">Data saved successfully <img src="images/check-green2.png" width="20" height="20" align="absmiddle" /></td>
            </tr>
            <?php
		}
?>
            <tr>
              <td align="center" valign="bottom" style="padding:10px">Home Page Title: <a href="#" onClick="mm_showHide('help_title');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
          </tr>
            <tr>
              <td align="center" valign="middle"><div class="userhelp_cell" id="help_title">Enter your home page title. </div></td>
            </tr>
            <tr>
              <td height="50" align="center" valign="middle"><table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" valign="top">
                      <input name="title" type="text" id="title" value="<?php echo $home_arr['8']; ?>" style="width: 300px;" />
                    </td>
                  </tr>
              </table></td>
            </tr>
            
            <tr>
              <td align="center" valign="bottom" style="padding:10px">Main Navigation: <a href="#" onClick="mm_showHide('help_content_above');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
          </tr>
            <tr>
              <td align="center" valign="middle"><div class="userhelp_cell" id="help_content_above">Edit your main menu images, labels and links here. We recommend your button image sizes should be around 140x75 pixels in size. Try to keep your button labels as short as possible. The menu will auto adjust for variations, but keep checking after you make any changes.</div></td>
            </tr>
            <tr>
              <td align="center" valign="middle">
                <input type="hidden" name="content_above" id="content_above" value="<?php echo htmlspecialchars($home_arr['6'] ?? '', ENT_QUOTES); ?>" />
                <table width="705" border="0" align="center" cellpadding="0" cellspacing="0" class="menu-item-table">
                  <tr>
                    <td width="180" align="right" valign="middle">Font Color:&nbsp;&nbsp;</td>
                    <td width="160" align="left" valign="middle"><input style="width:80px" name="menu_font_color" class="jscolor" id="menu_font_color" onChange="previewMenu();" onKeyUp="previewMenu();" value="<?php echo '#', $menu_settings['font_color']; ?>" size="8" /></td>
                    <td width="180" align="right" valign="middle">Font Size:&nbsp;&nbsp;</td>
                    <td width="185" align="left" valign="middle">
                      <select name="menu_font_size" id="menu_font_size" onChange="previewMenu();">
                        <?php for($fs=10;$fs<=50;$fs++): ?>
                        <option value="<?php echo $fs; ?>"<?php if($menu_settings['font_size']==(string)$fs) echo " selected"; ?>><?php echo $fs; ?></option>
                        <?php endfor; ?>
                    </select> px                    </td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle">Button Colour:&nbsp;&nbsp;</td>
                    <td align="left" valign="middle"><input style="width:80px" name="menu_btn_color" id="menu_btn_color" class="jscolor" value="<?php echo '#', $menu_settings['btn_color']; ?>" onKeyUp="previewMenu();" onChange="previewMenu();" /></td>
                    <td align="right" valign="middle">Button Hover Colour:&nbsp;&nbsp;</td>
                    <td align="left" valign="middle"><input style="width:80px" name="menu_btn_hover" id="menu_btn_hover" class="jscolor" value="<?php echo '#', $menu_settings['btn_hover']; ?>" onKeyUp="previewMenu();" onChange="previewMenu();" /></td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle">Button Border Color:&nbsp;&nbsp;</td>
                    <td align="left" valign="middle"><input style="width:80px" name="menu_btn_border" id="menu_btn_border" class="jscolor" value="<?php echo '#', $menu_settings['btn_border']; ?>" onKeyUp="previewMenu();" onChange="previewMenu();" /></td>
                    <td align="right" valign="middle">Button Border Width:&nbsp;&nbsp;</td>
                    <td align="left" valign="middle"><input style="width:40px" name="menu_btn_border_width" id="menu_btn_border_width" value="<?php echo $menu_settings['btn_border_width']; ?>" onKeyUp="previewMenu();" onChange="previewMenu();" /> px</td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle">Rounded Corners:&nbsp;&nbsp;</td>
                    <td align="left" valign="middle"><input style="width:40px" name="menu_btn_radius" id="menu_btn_radius" value="<?php echo $menu_settings['btn_radius']; ?>" onKeyUp="previewMenu();" onChange="previewMenu();" /> px</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="4" align="center" valign="middle" style="padding-top:10px; padding-bottom:10px;">Preview:
                      <div id="menu_preview" class="menu-preview-wrap" style="padding-top:12px;"></div> 
                      <span style="font-size:10px;">Links disabled in Preview</span> </td>
                  </tr>
                  <tr>
                    <td  style="padding-top: 0px; padding-bottom: 0px;"colspan="4" align="center" valign="middle"><div class="upgrade_cell" id="help_upload"> 
                <p><strong>Sorry, this function is reserved for <a href="https://freemonthlywebsites.com/premier" target="_blank">Premier Members Only</a>! </strong></p>
                <p>Premier Members have the ability to upload custom button images.<br>
If you are interested in upgrading to Premier Membership, you can see all the benefits that it offers, and also upgrade from <a href="https://freemonthlywebsites.com/premier" target="_blank">HERE</a>.</p>
              </div></td>
                  </tr>
                  <?php for($menu_i=1;$menu_i<=5;$menu_i++): $menu_item = $menu_items[$menu_i-1]; ?>
                  <tr>
                    <td align="right" valign="middle">Button <?php echo $menu_i; ?> Label:&nbsp;&nbsp;</td>
                    <td colspan="3" align="left" valign="middle"><input class="menu-mini-input" name="menu_label_<?php echo $menu_i; ?>" id="menu_label_<?php echo $menu_i; ?>" value="<?php echo htmlspecialchars($menu_item['label'], ENT_QUOTES); ?>" onKeyUp="previewMenu();" onChange="previewMenu();" />                    </td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle">Button <?php echo $menu_i; ?> Image:&nbsp;&nbsp;</td>
                    <td colspan="3" align="left" valign="middle"><input style="width:300px" name="menu_image_<?php echo $menu_i; ?>" id="menu_image_<?php echo $menu_i; ?>" value="<?php echo htmlspecialchars($menu_item['image'], ENT_QUOTES); ?>" onKeyUp="previewMenu();" onChange="previewMenu();" />
                      <label for="menu_upload_<?php echo $menu_i; ?>" class="file-button">Custom Upload</label>
                      <a href="#" onClick="mm_showHide('help_upload'); return false;">
                      <input type="file" name="menu_upload_<?php echo $menu_i; ?>" id="menu_upload_<?php echo $menu_i; ?>" style="display:none" />
                      </a>
                    <span class="upload-name" id="upload_name_<?php echo $menu_i; ?>"></span></td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle">Button <?php echo $menu_i; ?> Link:&nbsp;&nbsp;</td>
                    <td colspan="3" align="left" valign="middle"><input style="width:300px" class="menu-mini-input" name="menu_link_<?php echo $menu_i; ?>" id="menu_link_<?php echo $menu_i; ?>" value="<?php echo htmlspecialchars($menu_item['link'], ENT_QUOTES); ?>" />
                      <input type="checkbox" name="menu_new_window_<?php echo $menu_i; ?>" value="1" <?php if(!empty($menu_item['new_window'])) echo 'checked'; ?> /> 
                    Open in a New Window</td>
                  </tr>
                  <tr>
                    <td colspan="4" height="10"></td>
                  </tr>
                  <?php endfor; ?>
                </table>
                <script type="text/javascript">previewMenu();</script>
              </td>
            </tr>

            <tr>
              <td height="40" align="center" valign="bottom" style="padding:10px">Home Page Video:<a href="#" onClick="mm_showHide('help_code');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;              </td>
          </tr>
            <tr>
              <td align="center" valign="middle"><div class="userhelp_cell" id="help_code">Enter your own video here if requirted.<br>
Click on 'Source' in the editor and paste your YouTube or any other video code.
              </div></td>
            </tr>
            <tr>
              <td height="50" align="center" valign="middle">
<table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top">
<textarea style="width:705px; max-width:705px; font-family:Tahoma; font-size:12px" name="code" id="code"><?php echo $home_arr['0']; ?></textarea>
                        <script>
                            CKEDITOR.replace("code",
                                {
                                  height: 400
                                });
                        </script>              </td>
  </tr>
</table></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="bottom" style="padding:10px">Home Page Text: <a href="#" onClick="mm_showHide('help_content_below');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
          </tr>
            <tr>
              <td align="center" valign="middle"><div class="userhelp_cell" id="help_content_below">Enter any text content for your page here using the WYSIWYG editor.<br /><br>
                Large amounts of text will automatically be split between your video and page adverts based on the word count you set below to make it look more natural.
                There is no limit to the amount of information you place here but we suggest you add a little at a time and keep checking your page to make sure it looks OK.<br />
                <br />
                We also recommend that if you are pasting a block of text in here, you paste your text in a basic notepad document first, then copy from there to here, so that it
                removes all the hidden formatting and makes it simpler for you to edit.<br />
                Use the WYSIWYG editor below to easily format your text. </div></td>
            </tr>
            <tr>
              <td height="50" align="center" valign="middle"><table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" valign="top"><textarea style="width:705px" name="content_below" id="content_below" class="main_text"><?php echo $home_arr['7']; ?></textarea>
                        <script>
                            CKEDITOR.replace("content_below",
                                {
                                  height: 400
                                });
                        </script>              </td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="20" align="center" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle">Split Text Every
                <a href="#" onClick="mm_showHide('help_words'); return false;">
    <input type="hidden" name="text_split_words" value="100">
    <input type="number" value="100" readonly style="width:70px; margin:0 5px; cursor:pointer;" /></a> Words
              <a href="#" onClick="mm_showHide('help_words');return false;"><img src="images/help.png" alt="" width="20" height="20" hspace="8" border="0" align="top" /></a></td>
            </tr>
         <tr>
              <td align="center" valign="middle"><div class="upgrade_cell" id="help_words"> 
                <p><strong>Sorry, this function is reserved for <a href="https://freemonthlywebsites.com/premier" target="_blank">Premier Members Only</a>! </strong></p>
                <p>Premier Members have the ability to split the text after a number of words.<br>
If you are interested in upgrading to Premier Membership, you can see all the benefits that it offers, and also upgrade from <a href="https://freemonthlywebsites.com/premier" target="_blank">HERE</a>.</p>
              </div></td>
         </tr>
            <tr>
              <td height="20" align="right" valign="middle">&nbsp;</td>
          </tr>
            <tr>
              <td height="40" align="center" valign="middle">Display Hero Ads in Home Page?
                <input type="checkbox" name="display_hero_ads_home_page" value="1" style="margin-left:10px;"<?php if (!empty($home_arr[10]) && $home_arr[10] == '1') echo ' checked'; ?> />
              <a href="#" onClick="mm_showHide('help_hero_ads');return false;"><img src="images/help.png" alt="" width="20" height="20" hspace="8" border="0" align="top" /></a>              </td>
            </tr>
             <tr>
              <td colspan="2" align="center" valign="middle"><div class="userhelp_cell" id="help_hero_ads">Select whether you would like 'Hero' Ads displayed on your home page.<br>
                This is one page width ad that is affiliated to you via your ClickBank ID in <a href="design_settings.php">Design Settings</a><br />
              </div></td>
            </tr>
            <tr>
              <td height="50" align="center" valign="middle">Display Additional Ads in Home Page?
<select name="display_ads_home_page" id="display_ads_home_page" style="margin-left:10px;" onChange="lockHomeAdsOption();">
  <option value="0"<?php if($display_ads_home_page==='0') echo ' selected'; ?>>None</option>
  <option value="1"<?php if($display_ads_home_page==='1') echo ' selected'; ?>>1 ClickBank Ad</option>
  <option value="2"<?php if($display_ads_home_page==='2') echo ' selected'; ?>>2 ClickBank Ads</option>
  <option value="custom"<?php if($display_ads_home_page==='custom') echo ' selected'; ?>>Custom Ads</option>
</select>
<a href="#" onClick="mm_showHide('help_main_ads');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a>
              </td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle">
            <div class="upgrade_cell" id="help_main_ads">
            <p><strong>Sorry, this function is reserved for <a href="https://freemonthlywebsites.com/premier" target="_blank">Premier Members Only</a>! </strong></p>
                <p>Premier Members have the ability to display None, 1 ClickBank Ad, 2 ClickBank Ads (side by side) or your own custom ads.<br>
                These ClickBank ads are affiliated to you via your ClickBank ID<br>
If you are interested in upgrading to Premier Membership, you can see all the benefits that it offers, and also upgrade from <a href="https://freemonthlywebsites.com/premier" target="_blank">HERE</a>.</p>
            </div></td>
            </tr>
            <tr id="custom_ads_wrap">
              <td align="center" valign="middle">
                <div style="padding-top:10px; padding-bottom:10px;">Your Own Custom Ads: <a href="#" onClick="mm_showHide('help_custom_ads');return false;"><img src="images/help.png" width="20" height="20" hspace="8" border="0" align="top" /></a></div>
                <div class="userhelp_cell" id="help_custom_ads">This can be anything you like, it will be displayed on your Home and Article pages.</div>
                <table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" valign="top"><textarea style="width:705px" name="custom_ads_content" id="custom_ads_content" class="main_text"><?php echo $custom_ads_content; ?></textarea>
                        <script>
                            CKEDITOR.replace("custom_ads_content",
                                {
                                  height: 300
                                });
                        </script>              </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr><td><script type="text/javascript">toggleCustomAdsField();</script></td></tr>
            <tr>
              <td height="50" align="center" valign="middle"><p>
                  <input type="submit" name="Submit" value="Save Main/Home Page Settings" id="submit">
              </p></td>
            </tr>
            <tr>
              <td height="50" align="center" valign="middle">
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
<!--//upgrade -->
<script>
function lockHomeAdsOption() {
    var select = document.getElementById('display_ads_home_page');
    var help = document.getElementById('help_main_ads');

    if (select.value === '1') {
        help.style.display = 'none';
    } else {
        help.style.display = 'block';
    }
}
</script>
<!--//upgrade -->
</body>
</html>
