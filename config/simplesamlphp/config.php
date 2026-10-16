<?php
/**
 * This is the main configuration file for SimpleSAMLphp.
 *
 * @package SimpleSAMLphp
 */

$config = array(
	// Both of these default to the public values this repository has always
	// shipped. Set SSP_ADMIN_PASSWORD and SSP_SECRET_SALT in the container's
	// environment to use your own; an unset or empty variable keeps the default.
	'auth.adminpassword'          => getenv( 'SSP_ADMIN_PASSWORD' ) ?: 'admin123',

	'technicalcontact_name'       => 'UBC Developer',
	'technicalcontact_email'      => 'dev@example.com',

	'secretsalt'                  => getenv( 'SSP_SECRET_SALT' ) ?: 'yoursupersecuresalthere',

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
	'basehostname'                => 'http://localhost:6122',

	// Set production to false for development.
	'production'                  => false,

	'session.cookie.secure'       => false,

	'signature.algorithm'         => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',

	'language.default'            => 'en',

	'organization'                => array(
		'name'        => array( 'en' => 'UBC Development IdP' ),
		'displayname' => array( 'en' => 'UBC Development' ),
		'url'         => array( 'en' => 'http://localhost:6122' ),
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

	// Release to each Service Provider only the attributes its entry in
	// saml20-sp-remote.php lists, as real CWL releases only what an app is
	// registered for. Without this filter every SP receives every attribute
	// of the person, and an app that works here can fail against CWL.
	//
	// AttributeLimit compares the SP's `attributes` list with the attribute
	// names as they stand at priority 50: the friendly names in
	// authsources.php. An SP that opts in to UBC's OID names
	// ($ubc_oid_attribute_names in saml20-sp-remote.php) renames them at
	// priority 60, AFTER this filter. Run the rename first, or name users'
	// attributes by OID, and nothing matches the friendly list, so nothing is
	// released.
	//
	// Two traps: an EMPTY `attributes` list means "no limit" (everything is
	// released), and a MISSING one falls back to the IdP's own list in
	// saml20-idp-hosted.php.
	'authproc.idp'                => array(
		50 => array( 'class' => 'core:AttributeLimit' ),
	),

	// Where the IdP may send a browser, above all a sign-out's ReturnTo:
	// localhost and 127.0.0.1, on any port. These are regular expressions
	// (trusted.url.regex), anchored at both ends by SimpleSAMLphp and matched
	// against the URL's host and port, so `localhost.example.com` is refused.
	// Without the regex SimpleSAMLphp matches host:port exactly, so a
	// `singleLogout?ReturnTo=http://localhost:8050` failed with `500 URL not
	// allowed` and left the IdP session alive: the next sign-in in that
	// browser came straight back as the same person, with no password.
	'trusted.url.domains'         => array( 'localhost(:[0-9]+)?', '127\.0\.0\.1(:[0-9]+)?' ),
	'trusted.url.regex'           => true,

	'memcache_store.servers'      => array( array( 'hostname' => '127.0.0.1' ) ),

	'module.enable'               => array(
		'exampleauth' => true,
		'core'        => true,
		'saml'        => true,
		'admin'       => true,
		'ubc-clf-7'   => true,
	),
);
