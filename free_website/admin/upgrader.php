<?php

require_once './upgrade/config.php';
require_once './upgrade/upgrade.php';

$upgrader = new Upgrader( $config );

if ( $upgrader->success ){
	$upgrade_status = $upgrader->checkForUpgrades();
	if ( $upgrade_status[ 'status' ] == 1 ){
		if ( isset( $_GET[ 'run_upgrade' ] ) ){
			$result = $upgrader->upgrade();
			if ( $upgrader->error == '' ){
				showMessage( $config[ 'upgraded_txt' ], $result );
			} else {
				showError( $upgrader->error );
			}
		} else {
			$text = sprintf( 
				$config[ 'version_txt' ],
				$config[ 'current_version' ],
				$upgrade_status[ 'current_version' ]
			);
			$backup_status = $upgrader->getBackupInfo();
			if ( $backup_status[ 'success' ] ) {
				$text .= '<br/><br/><b>' . $config[ 'backup_warning_txt' ] . '</b><br/><br/>';
				$text .= '<a href="?download_backup=1">' . $config[ 'download_backup_txt' ] . '</a><br/><br/>';
				$text .= '<a href="?run_upgrade=1">' . $config[ 'run_upgrade_txt' ] . '</a><br/><br/>';
				$text .= '<span style="color:gray;font-size:11px">' . $config[ 'manual_upgrade_txt' ] . '</span><br/>';
				$text .= '<a style="color:gray;font-size:11px" href="' . $upgrader->download_path . '">' . $upgrader->download_path . '</a><br/>';
			} else {
				showError( $backup_status[ 'message' ] );
			}
			showMessage( $upgrade_status[ 'message' ], $text );
		}
	} else if ( $upgrade_status[ 'status' ] == 0 ){
		echo '<span style="display:block;color:gray;text-align:center;font-size:12px;margin:0 auto">';
		echo $config[ 'cur_version_txt' ] . ' ' . $config[ 'current_version' ];
		echo '</span>';
	} else if ( $upgrade_status[ 'status' ] == -1 ){
		showError( $backup_status[ 'message' ] );
	}
} else {
	showError( $upgrader->error );

}


function showError( $error ){
?>
<div style="max-width:100%;width:90%;margin:0 auto;padding:10px;border:1px solid red;min-height:100px;color:red">
	<h3 style="text-align:center">Upgrader Error</h3>
	<p style="text-align:center;color:black;line-height:1.5"><?=$error;?></p>
</div>
<?php	
}


function showMessage( $header, $message ){
?>
<div style="max-width:100%;width:90%;margin:0 auto;padding:10px;border:1px solid green;min-height:100px;color:green">
	<h3 style="text-align:center"><?=$header;?></h3>
	<p style="text-align:center;color:black;line-height:1.5"><?=$message;?></p>
</div>
<?php	
}