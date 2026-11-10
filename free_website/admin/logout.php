<?php
/*
 * ?? COPYRIGHT NOTICE
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
session_destroy();
header("location:index.php");
exit;
?>