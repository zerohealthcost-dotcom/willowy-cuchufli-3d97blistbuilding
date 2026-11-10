<?php
error_reporting(E_ERROR);
ini_set('display_errors',1);

$filename = "admin/settings/privacy_terms_settings.txt";
if ($handle = @fopen($filename, 'r')) {
    $contents = fread($handle, filesize($filename));
    fclose($handle);
    $privacy_terms_arr = explode("#_1_#", $contents);
}

$filename = "admin/settings/design_settings.txt";
if ($handle = @fopen($filename, 'r')) {
    $contents = fread($handle, filesize($filename));
    fclose($handle);
    $design_arr = explode("#_1_#", $contents);
}

$filename = "admin/settings/seo/Privacy.txt";
if ($handle = @fopen($filename, 'r')) {
    $contents = fread($handle, filesize($filename));
    fclose($handle);
    $seo_arr = explode("#_1_#", $contents);
}

if (!isset($seo_arr[7]) || $seo_arr['7'] != 1) {
    header("Cache-Control: no-cache, max-age=0, must-revalidate");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="revisit-after" content="30 days">
<?php if ($seo_arr[4] !== '1'): ?>
<meta name="description" content="<?php echo $seo_arr['1']; ?>">
<meta name="keywords" content="<?php echo $seo_arr['2']; ?>">
<meta name="robots" content="INDEX, FOLLOW">
<?php else: ?>
<meta name="robots" content="noindex, nofollow">
<?php endif; ?>
<meta name="distribution" content="Global">
<meta name="rating" content="General">
<meta name="copyright" content="Free Monthly Websites">
<link rel="icon" href="images/favicon.png" type="image/png">
<title><?php echo $seo_arr['0']; ?></title>

<style type="text/css">
* { box-sizing: border-box; }
html { -webkit-text-size-adjust: 100%; }
html, body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    font-size: <?php echo $design_arr['6'], "px"; ?>;
    background-color: <?php echo "#", $design_arr['3']; ?>;
}
body { overflow-x: hidden; }
img, video, embed, object { max-width: 100% !important; height: auto !important; }
iframe { max-width: 100% !important; }
table { max-width: 100%; }
a, button, input, textarea, select { touch-action: manipulation; }
a:link, a:visited, a:hover, a:active, .a { color: #f16d6e; }
.main {
    background-color: #FFFFFF;
    padding: 0;
    margin: 0 auto;
    width: 100%;
    max-width: <?php echo $design_arr['2'], $design_arr['8']; ?>;
}
.container {
    border: solid;
    border-width: <?php echo $design_arr['5'], "px"; ?>;
    border-color: <?php echo "#", $design_arr['4']; ?>;
    width: 100%;
    background-color: <?php echo "#", $design_arr['7']; ?>;
    display: flex;
    align-items: flex-start;
    gap: 20px;
    text-align: left;
    padding: 15px;
    overflow: hidden;
}
.content {
    flex: 1 1 auto;
    min-width: 0;
    width: 100%;
    padding: <?php echo $design_arr['10'], "px"; ?>;
    text-align: left;
    background-color: #FFFFFF;
    margin: 0;
    border: solid;
    border-color: #D6D6D6;
    border-width: 2px;
}
.header-image {
    font-size: 0;
    background-color: <?php echo "#", $design_arr['9']; ?>;
}
.header-image img,
.header img {
    display: block;
    width: 100% !important;
}
.footer-container {
    padding: 10px;
    background-color: <?php echo "#", $design_arr['3']; ?>;
}
.footer p {
    margin: 0;
    padding: 0;
}
.footer {
    margin: auto;
    text-align: center;
}
.powered,
.powered a:link,
.powered a:visited,
.powered a:active {
    color: #EEEEEE;
    font-size: 12px;
    padding-top: 6px;
    margin: auto;
    text-align: center;
}
.powered a:hover { color: #f16d6e; }
.privacy-terms,
.privacy-terms a:link,
.privacy-terms a:visited,
.privacy-terms a:active {
    color: #EEEEEE;
    font-size: 14px;
    padding-top: 10px;
    margin: auto;
    text-align: center;
}
.privacy-terms a:hover { color: #f16d6e; }
.responsive-title-bar {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    min-height: 30px;
    height: auto;
    padding: 6px 10px;
    line-height: 1.2;
    text-align: left;
    margin: 0 0 10px 0;
}
.responsive-title-bar span {
    display: inline-block;
    line-height: 1.2;
}
@media only screen and (max-width: 768px) {
    iframe { width: 100% !important; height: auto !important; }
    .main { max-width: 100%; }
    .container {
        flex-direction: column;
        gap: 15px;
        padding: 12px;
    }
    .content {
        width: 100% !important;
        max-width: 100% !important;
        display: block;
        margin: 0;
    }
    table {
        width: 100% !important;
        display: block;
        overflow-x: auto;
    }
}
@media only screen and (max-width: 480px) {
    .container {
        padding: 8px;
        gap: 10px;
    }
    .content {
        padding: 10px !important;
    }
    .responsive-title-bar {
        padding: 8px 10px;
    }
}
<?php echo str_replace(array('<style>','</style>','< /style>'), '', $seo_arr['6']); ?>
</style>
<?php echo $seo_arr['5']; ?>
</head>
<body>
<center>
<div class="main">
<?php if ($design_arr['1'] == 1) { ?>
<div class="header-image">
<?php
if (!empty($design_arr['0'])) {
    $filename = $design_arr['0'];
    echo '<img src="./admin/images/custom_images/' . $filename . '" />';
}
?>
</div>
<?php } ?>

<div class="container">
    <div class="content">
        <?php echo $privacy_terms_arr['0']; ?>
    </div>
</div>

<!--Footer -->
<div class="footer-container">
    <div class="footer"><?php echo $design_arr['11']; ?></div>
<?php if($design_arr['13']=='1'){ ?><div class="powered"><a href="https://hop.clickbank.net/?affiliate=<?php echo $design_arr['12']; ?>&vendor=fmwebs" target="_blank">Powered by: Free Monthly Websites</a></div><?php } ?>
</div> 
<!--Footer -->
</div>
</center>
<?php echo $seo_arr['3']; ?>
</body>
</html>
