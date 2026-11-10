<?php
require_once __DIR__ . '/ads_data.php';

function getHomeAdsDisplaySetting()
{
	$settings_file = __DIR__ . '/../admin/settings/home_settings.txt';
    if (!file_exists($settings_file)) {
        return 2;
    }

    $home_arr = explode('#_1_#', file_get_contents($settings_file));
    $value = isset($home_arr[9]) ? trim((string)$home_arr[9]) : '2';

    return in_array($value, array('0', '1', '2'), true) ? (int)$value : 2;
}

$display_ads_home_page = getHomeAdsDisplaySetting();
$all_ads = getAds();
$ads_to_show = array();

if ($display_ads_home_page == 1) {
    $ads_to_show = getEvenlyRotatedAds(1, 'shared_page_ads');
} elseif ($display_ads_home_page == 2) {
    $ads_to_show = getEvenlyRotatedAds(2, 'shared_page_ads');
}
$is_single_ad = ($display_ads_home_page === 1);

if ($display_ads_home_page > 0 && !empty($ads_to_show)) {
?>
<style type="text/css">
.main-ads-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  width: 100%;
  margin: 20px 0 20px 0;
  padding: 0;
}
.main-ad-card {
  box-sizing: border-box;
  flex: 1 1 calc(50% - 10px);
  min-width: 280px;
  border: 1px solid #d9d9d9;
  border-radius: 8px;
  background: #ffffff;
  padding: 14px;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
}
.main-ad-inner {
  display: flex;
  align-items: flex-start;
  gap: 14px;
}
.main-ad-image {
  flex: 0 0 auto;
  width: 180px;
  max-width: 45%;
}
.main-ad-image a { text-decoration: none; }
.main-ad-image img {
  display: block;
  width: 100%;
  height: auto;
  border: none;
}
.main-ad-content {
  flex: 1 1 auto;
  min-width: 0;
}
.main-ad-description {
  margin: 0;
  font-size: 15px;
  color: #333333;
  line-height: 1.35em;
  text-align: left;
  max-height: 6.75em;
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 5;
  -webkit-box-orient: vertical;
  text-overflow: ellipsis;
}
.main-ad-button-wrapper { margin-top: 12px; }
.main-ad-button {
  display: inline-block;
  padding: 8px 16px;
  background: #23be81;
  color: #fff;
  font-size: 16px;
  font-weight: bold;
  text-align: center;
  text-decoration: none;
  border-radius: 5px;
  cursor: pointer;
}
.main-ad-card .main-ad-button,
.main-ad-card .main-ad-button:link,
.main-ad-card .main-ad-button:visited,
.main-ad-card .main-ad-button:active {
  color: #fff;
  font-size: 16px;
}
.main-ad-button:hover { background: #44c894; }

/* Single ad mode */
.main-ads-grid.main-ads-grid-single .main-ad-card {
  flex: 1 1 100%;
  max-width: 100%;
}
.main-ads-grid.main-ads-grid-single .main-ad-inner {
  gap: 25px;
}
.main-ads-grid.main-ads-grid-single .main-ad-image {
  width: 180px;
  max-width: 180px;
}
.main-ads-grid.main-ads-grid-single .main-ad-description {
  font-size: 22px;
  line-height: 1.2em;

  /* limit to 4 lines */
  max-height: 4.8em; /* 1.2em × 4 lines */
  overflow: hidden;

  display: -webkit-box;
  -webkit-line-clamp: 4;
  -webkit-box-orient: vertical;
}
.main-ads-grid.main-ads-grid-single .main-ad-button,
.main-ads-grid.main-ads-grid-single .main-ad-card .main-ad-button,
.main-ads-grid.main-ads-grid-single .main-ad-card .main-ad-button:link,
.main-ads-grid.main-ads-grid-single .main-ad-card .main-ad-button:visited,
.main-ads-grid.main-ads-grid-single .main-ad-card .main-ad-button:active {
  font-size: 22px;
}

@media (max-width: 700px) {
  .main-ad-card { flex-basis: 100%; }
  .main-ad-button-wrapper {
    width: 100%;
  }
  .main-ad-button {
    display: block;
    width: 100%;
    box-sizing: border-box;
  }

  /* In mobile/tablet single-ad mode, use the same sizing as 2-ad mode */
  .main-ads-grid.main-ads-grid-single .main-ad-image {
    width: 180px;
    max-width: 45%;
  }
  .main-ads-grid.main-ads-grid-single .main-ad-description {
    font-size: 15px;
    line-height: 1.35em;
    max-height: 6.75em;
    -webkit-line-clamp: 5;
  }
  .main-ads-grid.main-ads-grid-single .main-ad-button,
  .main-ads-grid.main-ads-grid-single .main-ad-card .main-ad-button,
  .main-ads-grid.main-ads-grid-single .main-ad-card .main-ad-button:link,
  .main-ads-grid.main-ads-grid-single .main-ad-card .main-ad-button:visited,
  .main-ads-grid.main-ads-grid-single .main-ad-card .main-ad-button:active {
    font-size: 16px;
  }
.main-ads-grid:not(.main-ads-grid-single) .main-ad-content,
.main-ads-grid:not(.main-ads-grid-single) .main-ad-description,
.main-ads-grid:not(.main-ads-grid-single) .main-ad-button-wrapper {
  text-align: center;
}
}

@media (max-width: 520px) {
  .main-ad-inner,
  .main-ads-grid.main-ads-grid-single .main-ad-inner {
    flex-direction: column;
  }
  .main-ad-image,
  .main-ads-grid.main-ads-grid-single .main-ad-image {
    width: 80%;
    max-width: 80%;
    margin: 0 auto;
  }
  .main-ad-content {
    width: 100%;
  }

  /* Keep single-ad mobile sizes the same as the 2-ad mobile layout, but limit to 4 lines */
  .main-ads-grid.main-ads-grid-single .main-ad-content {
    text-align: center;
  }
  .main-ads-grid.main-ads-grid-single .main-ad-description {
    font-size: 15px;
    line-height: 1.35em;
    text-align: center;
    max-height: 5.4em;
    -webkit-line-clamp: 4;
  }
  .main-ads-grid.main-ads-grid-single .main-ad-button-wrapper {
    text-align: center;
  }
  .main-ads-grid.main-ads-grid-single .main-ad-button,
  .main-ads-grid.main-ads-grid-single .main-ad-card .main-ad-button,
  .main-ads-grid.main-ads-grid-single .main-ad-card .main-ad-button:link,
  .main-ads-grid.main-ads-grid-single .main-ad-card .main-ad-button:visited,
  .main-ads-grid.main-ads-grid-single .main-ad-card .main-ad-button:active {
    font-size: 18px;
  }
.main-ads-grid:not(.main-ads-grid-single) .main-ad-content,
.main-ads-grid:not(.main-ads-grid-single) .main-ad-description,
.main-ads-grid:not(.main-ads-grid-single) .main-ad-button-wrapper {
  text-align: center;
}
.main-ad-description {
  max-height: 5.4em; /* 1.35em × 4 lines */
  overflow: hidden;

  display: -webkit-box;
  -webkit-line-clamp: 4;
  -webkit-box-orient: vertical;
}
}
</style>
<div class="main-ads-grid<?php echo $is_single_ad ? ' main-ads-grid-single' : ''; ?>">
  <?php foreach ($ads_to_show as $ad) { ?>
    <div class="main-ad-card">
      <div class="main-ad-inner">
        <div class="main-ad-image">
          <a href="<?php echo htmlspecialchars($ad['url'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer">
            <img src="<?php echo htmlspecialchars($ad['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="">
          </a>
        </div>
        <div class="main-ad-content">
          <div class="main-ad-description"><?php echo htmlspecialchars($ad['description'], ENT_QUOTES, 'UTF-8'); ?></div>
          <div class="main-ad-button-wrapper">
            <a class="main-ad-button" href="<?php echo htmlspecialchars($ad['url'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer"><?php echo $is_single_ad ? 'Click Here to Check it Out' : htmlspecialchars(isset($ad['button_text']) ? $ad['button_text'] : 'Check it Out!', ENT_QUOTES, 'UTF-8'); ?></a>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
</div>
<?php } ?>
