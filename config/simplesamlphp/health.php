<?php
/**
 * A simple health check endpoint.
 *
 * @package SimpleSAMLphp
 */

header( 'Content-Type: application/json' );
echo json_encode(
	array(
		'status'    => 'ok',
		'timestamp' => time(),
	)
);
