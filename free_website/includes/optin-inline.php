<style>
.optin-note {
	line-height: 1 !important;
}

.optin-note p {
	line-height: inherit !important;
	margin: 0 !important;
}
</style>
<?php
//OPTIN AWEBER
if($optin_arr[9]=='aweber')
{
?>
<?php echo $sidebar_arr[15]; ?>
<?php echo $sidebar_arr[16]; ?>
<form action="https://www.aweber.com/scripts/addlead.pl" method="post" name="myform" target="_new" id="myform" accept-charset="UTF-8">
        <input type="hidden" name="listname" value="<?php echo $optin_arr['2']; ?>" />
        <input type="hidden" name="redirect" value="<?php echo $optin_arr['3']; ?>" />
        <input type="hidden" name="meta_adtracking" value="<?php echo $optin_arr['1']; ?>" />
        <input type="hidden" name="meta_message" value="1" />
        <input type="hidden" name="meta_required" value="name,email" />
        <input type="hidden" name="meta_forward_vars" value="0" />
        <input name="name" type="text" class="optin-form-side-input" placeholder="<?php echo $optin_arr['10']; ?>" autocomplete="name" />
        <input name="email" type="email" class="optin-form-side-input" placeholder="<?php echo $optin_arr['11']; ?>" autocomplete="email" />
<button type="submit" id="optin-form-side-button"><span><?php echo $optin_arr['12']; ?></span></button> 
        </form>
<div class="optin-note"><?php echo $sidebar_arr[18]; ?></div>
<?php
}
//OPTIN AWEBER
?>

<?php
//OPTIN GETRESPONSE
if($optin_arr[9]=='gr')
{
?>
<?php echo $sidebar_arr[15]; ?>
<?php echo $sidebar_arr[16]; ?>
<form action="https://app.getresponse.com/add_subscriber.html" accept-charset="utf-8" method="post" target="_new">
        <input name="custom_trackingcode" type="hidden" value="<?php echo $optin_arr['8']; ?>" />
        <input type="hidden" name="campaign_token" value="<?php echo $optin_arr['7']; ?>" />
        <input type="hidden" name="start_day" value="0" />
        <input type="hidden" name="thankyou_url" value="<?php echo $optin_arr['3']; ?>"/>
        <input type="text" name="name" class="optin-form-side-input" placeholder="<?php echo $optin_arr['10']; ?>" autocomplete="name" />
        <input type="email" name="email" class="optin-form-side-input" placeholder="<?php echo $optin_arr['11']; ?>" autocomplete="email"/>
<button type="submit" id="optin-form-side-button"><span><?php echo $optin_arr['12']; ?></span></button> 
        </form>
<div class="optin-note"><?php echo $sidebar_arr[18]; ?></div>
<?php
}
//OPTIN GETRESPONSE
?>
<?php
//OPTIN OTHER
if($optin_arr[9]=='ot')
{
?>
<?php echo $sidebar_arr[15]; ?>
<?php echo $sidebar_arr[16]; ?>
<?php echo $optin_arr['5']; ?>
<div class="optin-note"><?php echo $sidebar_arr[18]; ?></div>
<?php
}
//OPTIN OTHER
?>