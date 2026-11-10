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
error_reporting(E_ALL);
ini_set('display_errors', 0);
// ini_set('log_errors', 1);
// ini_set('error_log', __DIR__ . '/error.log');


if($_SESSION['logged_in']!=true)
{
	header("location:index.php?flag=2");
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>Free Monthly Websites Admin Area</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="icon" href="images/favicon.png" type="image/png">
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
					<td height="30" align="center" valign="middle"><div id="link"><a id="link" href="logout.php"><b>Log Out</b></a></div></td>
				</tr>
				<tr>
					<td align="center" valign="middle"></td>
				</tr>
			</table>
			<!--Side Nav -->
		</td>
		<!--Side Nav -->
		<td width="706" align="left" valign="top" style="padding-left:10px; padding-right:10px; padding-top:20px; padding-bottom:20px"><div class="members_title"><strong>Welcome to Your Website Admin Area!</strong></div>

			<p align="center">
				<!--Main -->
				<!--Admin-Welcome -->
			<div id="target"></div>

			<!--Admin-Welcome -->
			<h1>Domain is Not Activated!</h1>
            <?php if ( $message == 'cant_connect' ): ?>
            <h5 style="color:red">PHP can not connect to API server! Please enable curl or allow_url_fopen PHP settings</h5>
            <?php endif; ?>
			<br>
			Please add your domain in the Members Area <a href="https://easybuildr.com/members/licenses/" target="_blank">Here</a>.
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
