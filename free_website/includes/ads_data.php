<?php
if (session_status() === PHP_SESSION_NONE) {
    session_save_path(__DIR__ . '/sessions');
session_start();
}

function getAds()
{
    return array(
        array(
            'url' => 'https://hop.clickbank.net/?affiliate=CB-ID&vendor=plrmonster&cbpage=ai-content-formula',
            'image' => 'images/ads/AI-Content-Creation-Formula-450.png',
            'description' => 'Discover a Proven System to Turn AI Into Income-Producing Digital Assets, Create Scalable Content Businesses, And Build Multiple Revenue Streams Faster Than Ever Without Technical Skills, Large Budgets, or Prior Experience Using Simple, Repeatable Frameworks',
            'button_text' => 'Check it Out!'
        ),
        array(
            'url' => 'https://hop.clickbank.net/?affiliate=CB-ID&vendor=plrmonster&cbpage=ai-goldmine',
            'image' => 'images/ads/AI-Automation-Goldmine-450.png',
            'description' => 'Build Automated Income Streams Using AI, Discover Profitable Opportunities, Create Content at Scale And Launch Smart Sales Systems That Work 24/7 - Without Technical Skills or Overwhelm Using a Proven, Step-By-Step Framework For Beginners',
            'button_text' => 'Check it Out!'
        ),
        array(
            'url' => 'https://hop.clickbank.net/?affiliate=CB-ID&vendor=plrmonster&cbpage=income-blueprint',
            'image' => 'images/ads/AI-Income-Blueprint-450.png',
            'description' => 'Unlock Powerful AI Income Strategies, Learn Proven Methods to Build Scalable Online Businesses, Create Digital Products, Automate Revenue Streams And Turn Simple Ideas Into Consistent Profit Using Practical, Beginner Friendly Systems That Work in Today’s Fast-Moving Digital Economy',
            'button_text' => 'Check it Out!'
        ),
        array(
            'url' => 'https://hop.clickbank.net/?affiliate=CB-ID&vendor=plrmonster&cbpage=hustle-blueprint',
            'image' => 'images/ads/AI-Side-Hustle-450.png',
            'description' => '100 Simple AI-Powered Side Hustles, Learn How to Create Content, Automate Tasks, Build Online Businesses And Generate Passive Income Streams Using Easy, Practical Methods Designed For Beginners Looking to Earn Faster in Today’s Digital Economy',
            'button_text' => 'Check it Out!'
        ),
        array(
            'url' => 'https://hop.clickbank.net/?affiliate=CB-ID&vendor=plrmonster&cbpage=list-unlocked',
            'image' => 'images/ads/List-Building-Unlocked-450.png',
            'description' => 'Unlock The Power of List Building to Grow Your Audience, Capture High-Quality Leads And Create Consistent Income Streams Through Proven Email Marketing Strategies, Automation And Targeted Campaigns That Build Trust, Engagement And Long Term Customer Relationships',
            'button_text' => 'Check it Out!'
        ),
        array(
            'url' => 'https://hop.clickbank.net/?affiliate=CB-ID&vendor=plrmonster&cbpage=ultimate-chatgpt',
            'image' => 'images/ads/Ultimate-ChatGPT-450.png',
            'description' => '500+ Powerful ChatGPT Prompts to Create High Converting Content, Generate Business Ideas, Write Ads, Emails And Social Media Posts. Automate Your Marketing Efforts Faster With Proven Templates Designed to Save Time And Boost Results Instantly',
            'button_text' => 'Check it Out!'
        ),
        array(
            'url' => 'https://hop.clickbank.net/?affiliate=CB-ID&vendor=plrmonster&cbpage=fresh',
            'image' => 'images/ads/Fresh-Online-Business-Ideas-450.png',
            'description' => 'Explore Fresh Online Business Ideas to Build a Profitable Second Income, Learn Proven Methods Like Freelancing, Affiliate Marketing, E-Commerce And Content Creation. Turn Your Skills Into Scalable Revenue Streams From Anywhere With Low Startup Costs',
            'button_text' => 'Check it Out!'
        ),
        array(
            'url' => 'https://hop.clickbank.net/?affiliate=CB-ID&vendor=plrmonster&cbpage=chatgpt-success',
            'image' => 'images/ads/Turn-ChatGPT-Second-Income-450.png',
            'description' => 'Transform ChatGPT Into a Powerful Income Tool, Discover Practical Ways to Earn Through Content Creation, Automation And Digital Services. Learn How to Build Scalable Revenue Streams Even Without Technical Skills Using Simple, Actionable Strategies',
            'button_text' => 'Check it Out!'
        ),
        array(
            'url' => 'https://hop.clickbank.net/?affiliate=CB-ID&vendor=plrmonster&cbpage=sales-funnel-profits',
            'image' => 'images/ads/Sales-Funnel-Profits-450.png',
            'description' => 'Master Sales Funnels From Beginner to Pro, Learn How to Attract Leads, Convert Prospects And Maximize Profits With Proven Strategies, Upsells, And Automation Techniques Designed to Turn Simple Products Into High-Converting, Scalable Income Systems',
            'button_text' => 'Check it Out!'
        ),
        array(
            'url' => 'https://hop.clickbank.net/?affiliate=CB-ID&vendor=plrmonster&cbpage=profiting-plr',
            'image' => 'images/ads/Profiting-From-PLR-450.png',
            'description' => 'Leverage Private Label Rights to Create Products Fast, Build Authority in Any Niche And Generate Multiple Income Streams Using Ready Made Content You Can Customize, Rebrand And Turn Into Profitable Digital Assets With Minimal Time And Effort',
            'button_text' => 'Check it Out!'
        ),
        array(
            'url' => 'https://hop.clickbank.net/?affiliate=CB-ID&vendor=plrmonster&cbpage=building-ebooks',
            'image' => 'images/ads/Building-Monetizing-Ebooks-Newbie-450.png',
            'description' => 'Create And Monetize High Quality eBooks, Learn How to Attract Traffic, Build Authority, Generate Leads, And Turn Simple Ideas Into Profitable Digital Products Using Proven Strategies For Writing, Marketing, And Scaling Your Online Income Streams',
            'button_text' => 'Check it Out!'
        ),
        array(
            'url' => 'https://hop.clickbank.net/?affiliate=CB-ID&vendor=plrmonster&cbpage=simple-web-traffic',
            'image' => 'images/ads/Simple-Web-Traffic-Newbie-450.png',
            'description' => 'Drive Consistent Website Traffic Using Proven Strategies, Learn How to Use SEO, Content Marketing, Social Media And Paid Ads to Attract Targeted Visitors, Build Your Audience And Turn Clicks Into Leads, Sales, And Long Term Online Business Growth',
            'button_text' => 'Check it Out!'
        ),
        array(
            'url' => 'https://hop.clickbank.net/?affiliate=CB-ID&vendor=plrmonster&cbpage=affiliate-marketing-newbie',
            'image' => 'images/ads/Affiliate-Marketing-Newbie-450.png',
            'description' => 'Learn How to Build a Profitable Affiliate Marketing Business, Discover Proven Strategies to Promote Products, Drive Targeted Traffic And Earn Consistent Commissions While Leveraging Multiple Channels to Create Scalable, Long Term Income Streams Online',
            'button_text' => 'Check it Out!'
        ),
        array(
            'url' => 'https://hop.clickbank.net/?affiliate=CB-ID&vendor=plrmonster&cbpage=easy-online-incomes',
            'image' => 'images/ads/Easy-Online-Incomes-450.png',
            'description' => 'Uncover Simple Online Income Streams, Learn How to Use Websites, Affiliate Marketing, Blogging And Digital Platforms to Generate Consistent Revenue And Discover Practical Methods to Turn Everyday Online Activities Into Profitable, Scalable Income Opportunities From Home',
            'button_text' => 'Check it Out!'
        ),
        array(
            'url' => 'https://hop.clickbank.net/?affiliate=CB-ID&vendor=plrmonster&cbpage=email-marketing-newbie',
            'image' => 'images/ads/Email-Marketing-Newbie-450.png',
            'description' => 'Master Email Marketing From Newbie to Pro, Learn How to Build Lists, Write High-Converting Emails, Automate Campaigns And Boost Engagement While Maintaining Control of Your Audience And Maximizing Long Term Profits With Proven Strategies And Tools',
            'button_text' => 'Check it Out!'
        )
    );
}

function getHeroAds()
{
    return array(
        array(
            'url' => 'https://hop.clickbank.net/?affiliate=CB-ID&vendor=easybuildr',
            'image' => 'images/ads/Easy-Page-Buildr-550.png',
            'description1' => 'The Simplest And Fastest Page + Funnel Builder Ever Created!',
            'description2' => '',
            'description3' => 'Simply Upload Your Site Log in And Edit - That’s it!',
            'button_text' => 'Click Here to See Just How Simple + Fast This Really is!'
        ),
        array(
            'url' => 'https://hop.clickbank.net/?affiliate=CB-ID&vendor=easybuildr',
            'image' => 'images/ads/Easy-Page-Buildr-550.png',
            'description1' => 'The Simplest And Fastest Page + Funnel Builder Ever Created!',
            'description2' => '',
            'description3' => 'Simply Upload Your Site Log in And Edit - That’s it!',
            'button_text' => 'Click Here to See Just How Simple + Fast This Really is!'
        )
    );
}

function getAdPool($source = 'default')
{
    return ($source === 'hero') ? getHeroAds() : getAds();
}

function getEvenlyRotatedAds($count, $pool = 'default', $source = 'default')
{
    $ads = getAdPool($source);
    $total = count($ads);
    $count = (int)$count;

    if ($count <= 0 || $total === 0) {
        return array();
    }

    $count = min($count, $total);

    if (!isset($_SESSION['ad_rotation']) || !is_array($_SESSION['ad_rotation'])) {
        $_SESSION['ad_rotation'] = array();
    }

    $pool_key = $source . '::' . $pool;

    if (!isset($_SESSION['ad_rotation'][$pool_key]) || !is_array($_SESSION['ad_rotation'][$pool_key])) {
        $_SESSION['ad_rotation'][$pool_key] = array(
            'order' => array(),
            'position' => 0,
            'total' => 0
        );
    }

    $state = &$_SESSION['ad_rotation'][$pool_key];

    $needs_reset = false;
    if (empty($state['order']) || !is_array($state['order'])) {
        $needs_reset = true;
    }
    if (!isset($state['total']) || (int)$state['total'] !== $total) {
        $needs_reset = true;
    }
    if (!isset($state['position']) || !is_numeric($state['position'])) {
        $needs_reset = true;
    }

    if ($needs_reset) {
        $state['order'] = range(0, $total - 1);
        shuffle($state['order']);
        $state['position'] = 0;
        $state['total'] = $total;
    }

    $selected = array();
    $selected_indexes = array();

    while (count($selected) < $count) {
        if ($state['position'] >= count($state['order'])) {
            $remaining_indexes = array_values(array_diff(range(0, $total - 1), $selected_indexes));
            if (empty($remaining_indexes)) {
                $remaining_indexes = range(0, $total - 1);
            }
            $state['order'] = $remaining_indexes;
            shuffle($state['order']);
            $state['position'] = 0;
            $state['total'] = $total;
        }

        $ad_index = $state['order'][$state['position']];
        $state['position']++;

        if (in_array($ad_index, $selected_indexes, true) && $count <= $total) {
            continue;
        }

        $selected_indexes[] = $ad_index;
        $selected[] = $ads[$ad_index];
    }

    return $selected;
}
?>
