<?php
/**
 * This file defines which modules are enabled.
 *
 * Note that 'module.enable' is the correct format for SimpleSAMLphp 2.x
 *
 * @package SimpleSAMLphp
 */

$config = array(
	'module.enable' => array(
		'core'        => true,
		'saml'        => true,
		'admin'       => true,
		'exampleauth' => true,
		'cron'        => true,
	),
);
