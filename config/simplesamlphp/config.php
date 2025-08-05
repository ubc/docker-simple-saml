<?php
/**
 * This is the main configuration file for SimpleSAMLphp.
 *
 * @package SimpleSAMLphp
 */

$config = array(
	'auth.adminpassword'          => 'admin123',

	'technicalcontact_name'       => 'UBC Developer',
	'technicalcontact_email'      => 'dev@example.com',

	'secretsalt'                  => 'yoursupersecuresalthere',

	'auth.adminpassword.hash'     => 'sha256',

	'enable.saml20-idp'           => true,

	'loggingdir'                  => '/var/www/simplesamlphp/log/',
	'logging.level'               => \SimpleSAML\Logger::DEBUG,
	'logging.handler'             => 'file',
	'logging.logfile'             => 'simplesamlphp.log',

	'cachedir'                    => '/tmp/simplesamlphp-cache',

	'tempdir'                     => '/tmp/simplesamlphp-temp',

	'baseurlpath'                 => 'simplesaml/',

	'theme.use'                   => 'ubc-clf-7:ubc-clf-7',

	// Tell SimpleSAMLphp to load metadata from the config directory.
	'metadata.sources'            => array(
		array( 'type' => 'flatfile' ),
		array(
			'type'      => 'flatfile',
			'directory' => 'config',
		),
	),

	// IMPORTANT: Add this line to set the correct base hostname.
	'basehostname'                => 'http://localhost:8080',

	// Set production to false for development.
	'production'                  => false,

	'session.cookie.secure'       => false,

	'signature.algorithm'         => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',

	'language.default'            => 'en',

	'organization'                => array(
		'name'        => array( 'en' => 'UBC Development IdP' ),
		'displayname' => array( 'en' => 'UBC Development' ),
		'url'         => array( 'en' => 'http://localhost:8080' ),
	),

	'debug'                       => array(
		'saml'        => true,
		'backtraces'  => true,
		'validatexml' => false,
	),

	'store.type'                  => 'sql',
	'store.sql.dsn'               => 'sqlite:/var/www/simplesamlphp/data/sqlitedatabase.sq3',
	'store.sql.username'          => null,
	'store.sql.password'          => null,
	'store.sql.prefix'            => 'simplesaml',

	'session.phpsession.savepath' => '/tmp/simplesamlphp-sessions',

	'admin.protectindexpage'      => false,
	'admin.protectmetadata'       => false,

	'trusted.url.domains'         => array( 'localhost' ),
	'memcache_store.servers'      => array( array( 'hostname' => '127.0.0.1' ) ),

	'module.enable'               => array(
		'exampleauth' => true,
		'core'        => true,
		'saml'        => true,
		'admin'       => true,
		'ubc-clf-7'   => true,
	),
);
