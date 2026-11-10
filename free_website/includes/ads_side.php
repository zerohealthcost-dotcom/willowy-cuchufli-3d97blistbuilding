<?php
if (!isset($sidebar_arr) || !is_array($sidebar_arr)) {
    $sidebar_arr = array();
    $settings_file = '../admin/settings/sidebar_settings.txt';
    if (file_exists($settings_file)) {
        $sidebar_arr = explode('#_1_#', file_get_contents($settings_file));
    }
}

require_once __DIR__ . '/ads_data.php';

$all_ads = getAds();
$ad_count = isset($sidebar_arr[22]) ? (int)$sidebar_arr[22] : 0;
$ad_count = max(0, min($ad_count, count($all_ads)));
$ads_to_show = getEvenlyRotatedAds($ad_count, 'shared_page_ads');

if (!empty($ads_to_show)) {
?>
<style type="text/css">
.ad-list { width: 100%; }
.ad-container {
  width: 100%;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
  margin-bottom: 20px;
}
.ad-container:last-child { margin-bottom: 0; }
.ad-image { text-align: center; padding-top: 2px; }
.ad-image img {
  width: 80%;
  max-width: 100%;
  height: auto;
  border: none;
}
.ad-image a { text-decoration: none; }
.ad-description {
  margin: 3px 2px 0 2px;
  font-size: 14px;
  color: #333333;
  text-align: center;
  line-height: 1.2em;
  max-height: 4.8em;
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 4;
  -webkit-box-orient: vertical;
  text-overflow: ellipsis;
}
.ad-button-wrapper { text-align: center; margin-top: 3px; }
.ad-button {
  display: inline-block;
  width: 100%;
  padding: 6px 0;
  margin-top: 10px;
  background: #23be81;
  color: #fff;
  font-size: 18px;
  font-weight: bold;
  text-align: center;
  text-decoration: none;
  border-radius: 5px;
  cursor: pointer;
}
.ad-container .ad-button,
.ad-container .ad-button:link,
.ad-container .ad-button:visited,
.ad-container .ad-button:active {
  color: #fff;
  font-size: 18px;
}
.ad-button:hover { background: #44c894; }
</style>
<div class="ad-list">
  <?php foreach ($ads_to_show as $ad) { ?>
    <div class="ad-container">
      <div class="ad-image">
        <a href="<?php echo htmlspecialchars($ad['url'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer">
          <img src="<?php echo htmlspecialchars($ad['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="">
        </a>
      </div>
      <div class="ad-description"><?php echo htmlspecialchars($ad['description'], ENT_QUOTES, 'UTF-8'); ?></div>
      <div class="ad-button-wrapper">
        <a class="ad-button" href="<?php echo htmlspecialchars($ad['url'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer"><?php echo htmlspecialchars(isset($ad['button_text']) ? $ad['button_text'] : 'Check it Out!', ENT_QUOTES, 'UTF-8'); ?></a>
      </div>
    </div>
  <?php } ?>
</div>
<?php } ?>
