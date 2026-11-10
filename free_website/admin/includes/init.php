<?php

require_once __DIR__ . '/verificator-class.php';

global $reauth;

$verify = new Verificator(
	'easybuildr.com',
	'per_domain'
);

$verify_connection = $verify->canConnect();
if ( $verify_connection !== true ) {
	$verify->process($verify_connection);
}

$verify_result = $verify->check( $reauth );

if ( $verify_result !== true ) {

	$verify->process($verify_result);
}

