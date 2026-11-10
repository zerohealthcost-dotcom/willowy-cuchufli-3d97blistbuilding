<?php
declare(strict_types=1);

error_reporting(E_ERROR);
ini_set('display_errors', '1');

$design_arr = array();
$settings_file = __DIR__ . '/../admin/settings/design_settings.txt';

if (is_file($settings_file) && filesize($settings_file) > 0) {
    $contents = file_get_contents($settings_file);
    if ($contents !== false) {
        $design_arr = explode('#_1_#', $contents);
    }
}

$cbid = '';
if (!empty($design_arr[12])) {
    $cbid = trim($design_arr[12]);
}

require_once __DIR__ . '/../includes/ads_data.php';

$source = 'default';

if (isset($_GET['source'])) {
    $requested_source = strtolower(trim((string)$_GET['source']));

    if (in_array($requested_source, array('default', 'hero'), true)) {
        $source = $requested_source;
    }
}

$ads = getEvenlyRotatedAds(1, 'recommended', $source);

if (empty($ads) || empty($ads[0]['url'])) {
    http_response_code(500);
    exit('Ad rotation returned no URL.');
}

$url = $ads[0]['url'];

if ($cbid !== '') {
    $url = str_replace('CB-ID', rawurlencode($cbid), $url);
}

if (!filter_var($url, FILTER_VALIDATE_URL)) {
    http_response_code(500);
    exit('Generated ad URL is invalid.');
}

header('Location: ' . $url, true, 302);
exit;