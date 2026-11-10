<?php

$config = array(	
	//config
	'upgradeURL' => 'https://freemonthlywebsites.com/update/fmw3-free/',
	'current_version' => '3.0',
	'contact_email_txt' => "Can't access upgrade server. Please contact server administrator here - https://johnthornhill.ladesk.com",
	//texts
	'new_available_txt' => "New Version Available!",
	'up_to_date_txt' => "Your Version is up to Date!",
	'no_download_txt' => 'There is automatic upgrade problem - allow_url_fopen php.ini directive is set to Off and curl is not installed, automatic upgrades are not available. Please install curl or set allow_url_fopen to On or upgrade install manually',
	'download_write_txt' => 'Upload path does not exist or is not avaialable, please check it: %s',
	'install_write_txt' => 'Some files are not writable, please make them writeable and try again: %s',
	'cant_backup' => "Something gone wrong, can't create backup.",
	'cant_download' => "Something went wrong - Can't download upgrade package.",
	'cant_backup_security' => "Can't create backup security file.",
	'version_txt'	=> 'Your Current Version is %s. The New Version is %s.', 
	'download_backup_txt' => 'Download Backup!',
	'backup_warning_txt' => 'Please Backup Your Website Before Updating!',
	'run_upgrade_txt' => 'Auto-Update Your Website Now!',
	'manual_upgrade_txt' => 'You can upgrade manually, new version can be downloaded here:',
	'upgraded_txt' => 'Site Upgraded!',
	'cur_version_txt' => 'Version:',
	'wrong_extra_actions' => 'Something went wrong, setup not finalized properly',
//UPDATER FILES		
'package_files' => array(
    'admin',
    'content_pages',
    'files',
    'images',
    'includes',
    'recommended',
    'uploads',
    '.htaccess',
    'content.php',
    'index.php',
    'privacy.php',
    'show.php',
    'showpage.php',
    'terms.php'
)
);