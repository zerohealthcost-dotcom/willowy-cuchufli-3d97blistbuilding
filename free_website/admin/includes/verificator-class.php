<?php

class Verificator {

	private $license_invalid = "No licenses found for this domain!<br/>Please sign in to <a href='https://easybuildr.com/members/licenses/'>https://easybuildr.com/members/licenses/</a> and add <b>%domain%</b> domain there";
	private $license_ended = "You can't add more websites. You have run out of available licenses.";
	private $cant_connect = "cant_connect";
	private $base_url;
	private $error = false;
	private $download_type;
	private $verpath;
	private $type;

	function __construct( $url, $type )
	{
		$this->base_url = 'htt' . 'ps'. ':/' . '/' . $url . '/';
		$this->type = $type;
		$allow_url_open = ini_get( 'allow_url_fopen' );

		if ( !$allow_url_open or strtolower( $allow_url_open ) == 'off' ) {
			if ( ! function_exists( 'curl_version' ) ) {
				$this->error  = $this->cant_connect;
			} else {
				$this->download_type = 'curl';
			}
		} else if ( function_exists( 'curl_version' ) ) {
			$this->download_type = 'curl';
		} else {
			$this->download_type = 'basic';
		}

		$this->verpath = dirname( dirname( __FILE__ ) ) . '/settings/ver';
	}

	private function getResource()
	{
		return strtolower( $_SERVER['SERVER_NAME'] );
	}

	function canConnect()
	{
		if ( $this->error ){
			return $this->error;
		}

		return true;
	}

	function check( $reauth = false )
	{
		$data = $this->getInfo( $reauth );

		if ( is_object( $data ) and $data->status ) {
			if ( $data->status == 'OK' ) {
				return true;
			} else {
				if ( file_exists( $this->verpath ) ){
					unlink( $this->verpath );
				}

				if ( $data->error == 'no_license' ) {
					return str_replace(
						'%domain%',
						$_SERVER['SERVER_NAME'],
						$this->license_invalid
					);
				} else {
					return $this->license_ended;
				}
			}
		} else {
			return $this->license_invalid;
		}
	}

	function getInfo( $reauth )
	{
		if ( $reauth == false and $this->alreadyVerified() ){
			$data = new stdClass;
			$data->status = 'OK';
			return $data;
		}

		set_time_limit( 120 );
		if ( $this->download_type == 'basic' ) {
			$fetch_data = $this->getInfoBasic();
		} else {
			$fetch_data = $this->getInfoCURL();
		}
		if ( $fetch_data ) {
			$data = json_decode( $fetch_data );
			$this->processResponse( $data );
			return $data;
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

		$ch      = curl_init( $this->constructInfoURL() );
		curl_setopt_array( $ch, $options );
		$content = curl_exec( $ch );
		//echo  $this->constructInfoURL();
		//echo $content;exit;
		curl_close( $ch );
		return $content;
	}


	function getInfoBasic()
	{
		return file_get_contents( $this->constructInfoURL() );
	}


	function constructInfoURL()
	{
		$remote_url = urlencode( $_SERVER['SERVER_NAME'] );
		return $this->base_url . 'members/?wwl_type=' .  $this->type . '&wwl_verify=1&url=' . $remote_url ;
	}

	public function process( $message )
	{
		include __DIR__ . "/../nolicense_welcome.php";
		exit;
	}

	private function alreadyVerified()
	{
		if ( !file_exists( $this->verpath ) ){
			return false;
		}

		if ( md5( $this->getResource() ) != file_get_contents( $this->verpath ) ){
			return false;
		}

		return true;
	}

	private function processResponse( $data )
	{
		if  ( $data->status == 'OK' ) {
			$fl = fopen( $this->verpath, 'w' );
			fwrite( $fl, md5( $this->getResource() ) );
			fclose( $fl );
		}
	}


}