<?php
require_once __DIR__ . '/ads_data.php';

if (function_exists('getHeroAds')) {
    $ads = getHeroAds();
} else {
    $ads = [];
}

if (!empty($ads)) {
    shuffle($ads);
    $ad = $ads[0];
} else {
    return;
}
?>

<style>
.hero-ad-wrap {
  width: 100%;
  clear: both;
  padding: 0 0 15px 0;
}
.hero-ad-separator {
  clear: both;
  line-height: 0;
  font-size: 0;
}
.hero-ad-separator-noside {
  clear: both;
  height: 12px;
  line-height: 0;
  font-size: 0;
}
.hero-ad-card {
  background: #f7f8fa;
  border: 1px solid #d9dde3;
  border-radius: 10px;
  padding: 15px 20px;
  box-sizing: border-box;
}

.hero-ad-content {
  display: grid;
  grid-template-columns: minmax(220px, 38%) 1fr;
  gap: 34px;
  align-items: center;
  justify-content: center;
  max-width: 950px;
  margin: 0 auto;
}

.hero-ad-image {
  text-align: center;
  justify-self: center;
}

.hero-ad-image img {
  width: 100%;
  max-width: 360px;
  height: auto;
  display: block;
  margin: 0 auto;
  border: 0;
}

.hero-ad-text {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  max-width: 520px;
}

.hero-ad-line1 {
  margin: 0 0 14px 0;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: clamp(21px, 3vw, 30px);
  line-height: 1.12;
  font-weight: 800;
  color: #0f172a;
  letter-spacing: -0.02em;
  text-align: center;
}

.hero-ad-line2 {
  margin: 0 0 14px 0;
  font-size: clamp(16px, 2.2vw, 21px);
  line-height: 1.3;
  font-weight: 700;
  color: #0f766e;
  text-align: center;
}

.hero-ad-line3 {
  margin: 0 0 20px 0;
  font-size: clamp(14px, 1.6vw, 17px);
  line-height: 1.5;
  font-weight: 500;
  color: #475569;
  text-align: center;
}

.hero-ad-button {
  display: inline-block;
  max-width: 400px;
  width: 100%;
  padding: 10px 20px;
  background: #23be81;
  color: #ffffff;
  font-size: 22px;
  font-weight: 800;
  text-decoration: none;
  text-align: center;
  border-radius: 14px;
  box-sizing: border-box;
}

.hero-ad-button,
.hero-ad-button:link,
.hero-ad-button:visited,
.hero-ad-button:active {
  font-size: 22px !important;
  color: #fff !important;
}

.hero-ad-button:hover {
  background: #44c894;
}

.hero-ad-button-wrapper {
  display: flex;
  justify-content: center;
}

@media (max-width: 900px) {
  .hero-ad-content {
    grid-template-columns: 1fr;
    gap: 24px;
  }

  .hero-ad-text {
    text-align: center;
    max-width: 100%;
  }

  .hero-ad-button {
    width: 100%;
    max-width: 520px;
  }
}
</style>

<div class="hero-ad-wrap">
  <div class="hero-ad-card">
    <div class="hero-ad-content">

      <div class="hero-ad-image">
        <a href="<?php echo htmlspecialchars($ad['url'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer">
          <img src="<?php echo htmlspecialchars($ad['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="">
        </a>
      </div>

      <div class="hero-ad-text">
      
<?php if (!empty($ad['description1'])): ?>
  <div class="hero-ad-line1"><?php echo htmlspecialchars($ad['description1'], ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<?php if (!empty($ad['description2'])): ?>
  <div class="hero-ad-line2"><?php echo htmlspecialchars($ad['description2'], ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<?php if (!empty($ad['description3'])): ?>
  <div class="hero-ad-line3"><?php echo htmlspecialchars($ad['description3'], ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

        <div class="hero-ad-button-wrapper">
          <a class="hero-ad-button"
             href="<?php echo htmlspecialchars($ad['url'], ENT_QUOTES, 'UTF-8'); ?>"
             target="_blank"
             rel="noopener noreferrer">
            <?php echo htmlspecialchars($ad['button_text'], ENT_QUOTES, 'UTF-8'); ?>
          </a>
        </div>
      </div>

    </div>
  </div>
</div>
