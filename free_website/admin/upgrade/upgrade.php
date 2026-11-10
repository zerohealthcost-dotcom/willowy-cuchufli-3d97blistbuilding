<?php

class Upgrader {

	private $settings;
	private $dirfiles;
	public $error, $success, $download_type, $upload_path, $download_path, $backup_path, $website_path;
	
	function __construct( $settings )
	{
		$this->settings = $settings;
		$this->success = true;
		$allow_url_open = ini_get( 'allow_url_fopen' );
		if ( !$allow_url_open or strtolower( $allow_url_open ) == 'off' ) {
			if ( !function_exists( 'curl_version' ) ){
				$this->success = false;
				$this->error = $this->settings[ 'no_download_txt' ];
			} else {
				$this->download_type = 'curl';
			}
		} else {
			if ( function_exists( 'curl_version' ) ){
				$this->download_type = 'curl';
			} else {
				$this->download_type = 'basic';
			}
		}
		
		$dirname = dirname( __FILE__ );
		$this->website_path = dirname( dirname( $dirname ) );

		$this->upload_path = $dirname . '/tmp/';
		$this->backup_path = $dirname . '/backup/';
		$this->last_checked_file = $dirname . '/last_checked.txt';
		
		if ( !file_exists( $this->upload_path ) ){
			mkdir( $this->upload_path, 0777 );
		}
		
		if ( !file_exists( $this->upload_path ) or !is_writable( $this->upload_path ) ){
			$this->success = false;
			$this->error = $this->settings[ 'download_write_txt' ] . $this->upload_path;
		}

		if ( !file_exists( $this->backup_path ) ){
			mkdir( $this->backup_path, 0777 );
		}
		
		if ( !file_exists( $this->backup_path ) or !is_writable( $this->backup_path ) ){
			$this->success = false;
			$this->error = sprintf( $this->settings[ 'download_write_txt' ], $this->backup_path );
		} else {
			if ( !file_exists( $this->backup_path . '/.htaccess' ) ){
				$fl = fopen( $this->backup_path . '/.htaccess', 'w' );
				fwrite( $fl, "<Files *.zip>\norder deny,allow\ndeny from all\n</Files>" );
				fclose( $fl );
			}
			if ( !file_exists( $this->backup_path . '/.htaccess' ) ){
				$this->success = false;
				$this->error = $this->settings[ 'cant_backup_security' ];				
			}
		}		
		
		if ( !file_exists( $this->last_checked_file ) ){		
			$file = fopen ( $this->last_checked_file, 'w' );
			fwrite( $file, time() );
			fclose( $file );
		}
		
		if ( !file_exists( $this->last_checked_file ) or !is_writable( $this->last_checked_file ) ){	
			$this->success = false;
			$this->error = sprintf( $this->settings[ 'install_write_txt' ], $this->last_checked_file );
		}
	}

	
	function checkForUpgrades() 
	{
		$upgrade_info = $this->getInfo();
		if ( is_object( $upgrade_info ) ){
			if ( $upgrade_info->need_upgrade ){
				$this->download_path = $upgrade_info->package_url;
				return array( 
					'status' => 1, 
					'message' => $this->settings[ 'new_available_txt' ], 
					'current_version' => $upgrade_info->current_version
				);
			} else {
				return array( 'status' => 0, 'message' => $this->settings[ 'up_to_date_txt' ] );
			}
		} else {
			return array( 'status' => -1, 'message' => $this->settings[ 'contact_email_txt' ] );				
		}
	}
	
	
	function upgrade()
	{
		if ( $this->canUpgrade() ){
			$status = $this->downloadPackage();
			if ( $status ){
				$status = $this->unpackPackage();
				if ( $status ){
					return $this->processExtraActions();		
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	
	function downloadPackage()
	{
		if ( file_exists( $this->getUploadPath() ) ){
			unlink( $this->getUploadPath() );
		}
		
		if ( $this->download_type == 'basic' ){
			$fetch_data = $this->downloadBasic();
		} else {
			$fetch_data = $this->downloadCURL();
		}		
		
		if ( !file_exists( $this->getUploadPath() ) ){
			$this->error = $this->settings[ 'cant_download' ];
			return false;
		}
		return true;
	}


	function unpackPackage()
	{
		require_once dirname( __FILE__ ) . '/lib/Zip.php';
		$zip = new Zip();
		try {
			$zip->unzip_file( $this->getUploadPath() );
			$zip->unzip_to( $this->website_path );
		} catch ( Exception $e ) {
			$this->error = $e->getMessage();
			return false;
		}
		return true;
	}
	

	function processExtraActions()
	{
		require_once dirname( __FILE__ ) . '/extra.php';
		if ( $extra_response ){
			return $extra_response;
		} else {
			$this->error = $this->settings[ 'wrong_extra_actions' ];
			return false;			
		}
	}
	

	function getDirContents( $dir )
	{
		$files = scandir($dir);
		foreach( $files as $key => $value ){
			$path = realpath( $dir . DIRECTORY_SEPARATOR . $value );
			if( !is_dir( $path ) ) {
				$this->dirfiles[] = $path;
			} else if ( $value != "." and $value != ".." ) {
				$this->getDirContents( $path );
				$this->dirfiles[] = $path;
			}
		}

		return $this->dirfiles;
	}
	
		
	function canUpgrade()
	{
		$error_list = '';
		$package_files = $this->getDirContents( $this->website_path );

		foreach( $this->settings[ 'package_files' ] as $file ){
			if ( file_exists( $this->website_path . $file ) and !is_writable( $this->website_path . $file ) ){
				$this->success = false;
				$error_list .= $this->website_path . $file . '<br/>';
			}		
		}
		if ( $error_list ){
			$this->error = sprintf( 
				$this->settings[ 'install_write_txt' ], 
				'<br/><br/><span style="font-size:11px">' . $error_list . '</span>'
			);
			return false;
		}
		return true;
	}
	
	
	function getInfo()
	{
		$fetch_data = '';
		set_time_limit(120);
		if ( $this->download_type == 'basic' ){
			$fetch_data = $this->getInfoBasic();
		} else {
			$fetch_data = $this->getInfoCURL();
		}
		if ( $fetch_data ){
			return json_decode( $fetch_data );
		} else {
			return array();
		}
	}
	
	
	function getInfoCURL()
	{
       $options = array(
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_POST           => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT        => 120
        );
        $ch = curl_init( $this->constructInfoURL() );
		curl_setopt_array( $ch, $options );
		$content = curl_exec( $ch );
		curl_close( $ch );		
		return $content;
	}
	
	
	function getInfoBasic()	
	{
		return file_get_contents( $this->constructInfoURL() );
	}
	
	
	function constructInfoURL()
	{
		return $this->settings[ 'upgradeURL' ] . '?cv=' . $this->settings[ 'current_version' ];
	}
	
	
	function getUploadPath()
	{
		return $this->upload_path . '/package.zip';
	}
	
	
	function downloadCURL()
	{
		global $upgrade_file;

		function curlWriteFile($cp, $data) {
			global $upgrade_file;
			$len = fwrite( $upgrade_file, $data );
			return $len;
		}
		
		$upgrade_file = fopen( $this->getUploadPath(), 'w+' );

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $this->download_path );			
		curl_setopt( $ch, CURLOPT_FILE, $upgrade_file );
		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		curl_setopt( $ch, CURLOPT_TIMEOUT, 120 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_WRITEFUNCTION, 'curlWriteFile');
		curl_exec($ch);
		echo curl_error($ch);
		curl_close($ch);
		fclose( $upgrade_file );
	}
	
	
	function downloadBasic()
	{
		
		file_put_contents( $this->getUploadPath(), fopen( $this->download_path, 'rb' ) );
	}
	
	
	function getBackupInfo()
	{
		if ( file_exists( $this->getBackupFilename() ) ){
			unlink( $this->getBackupFilename() );
		}
		
		//happens when user logs into admin dashboard, not a big deal...
		try {
			$this->prepareBackup();
		} catch ( Exception $e ) {
			return array( 'success' => 0, 'message' => $e->getMessage() );
		}
		
		if ( !file_exists( $this->getBackupFilename() ) ){
			return array( 'success' => 0, 'message' => $this->settings[ 'cant_backup' ] );
		} else {
			return array( 
				'success' => 1
			);
		}
	}
	
	
	function getBackupFilename()
	{
		return $this->backup_path . '/website-backup.zip';
	}
	
	
	function prepareBackup()
	{
		require dirname( __FILE__ ) . '/lib/Zip.php';
	    $zip = new Zip();

		$zip->zip_files(
			$this->getFilesList(),
			$this->getBackupFilename(),
            $this->website_path
		);
	}

	private function getFilesList()
	{
		$files = array_map(
			'trim',
			file( dirname( __FILE__ ) . '/upgradelist.txt' ) //BACKUP FILES
		);

		$result = [];

		foreach( $files as $file ){
			$result[] = $this->website_path . '/' . $file;
		}
		return $result;
	}
}