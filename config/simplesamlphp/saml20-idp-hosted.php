<?php
/**
 * SAML 2.0 IdP configuration for SimpleSAMLphp.
 *
 * @package SimpleSAMLphp
 */

// First, try with a __DEFAULT__ host specifier.
$metadata['__DYNAMIC:1__'] = array(
	'host'                  => '__DEFAULT__',

	// The private key and certificate used by this IdP.
	'privatekey'            => 'server.pem',
	'certificate'           => 'server.crt',

	// The auth source used for authentication.
	'auth'                  => 'example-userpass',

	// Signing algorithm - RSA with SHA-256.
	'signature.algorithm'   => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',

	// Specify the format of attributes.
	'attributes.NameFormat' => 'urn:oasis:names:tc:SAML:2.0:attrname-format:basic',

	// Define which attributes to send to SPs.
	'attributes'            => array(
		'uid',
		'eduPersonAffiliation',
		'eduPersonPrincipalName',
		'givenName',
		'sn',
		'employeeNumber',
		'studentNumber',
		'eduPersonTargetedId',
	),
);

// Also add a specific hostname entry for localhost.
$metadata['https://localhost:8443/simplesaml/saml2/idp/metadata.php'] = array(
	'host'                  => 'localhost',

	// The private key and certificate used by this IdP.
	'privatekey'            => 'server.pem',
	'certificate'           => 'server.crt',

	// The auth source used for authentication.
	'auth'                  => 'example-userpass',

	// Signing algorithm - RSA with SHA-256.
	'signature.algorithm'   => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',

	// Specify the format of attributes.
	'attributes.NameFormat' => 'urn:oasis:names:tc:SAML:2.0:attrname-format:basic',

	// Define which attributes to send to SPs.
	'attributes'            => array(
		'uid',
		'eduPersonAffiliation',
		'eduPersonPrincipalName',
		'givenName',
		'sn',
		'employeeNumber',
		'studentNumber',
		'eduPersonTargetedId',
	),
);

// Also add a HTTP entry for localhost.
$metadata['http://localhost:8080/simplesaml/saml2/idp/metadata.php'] = array(
	'host'                  => 'localhost',

	// The private key and certificate used by this IdP.
	'privatekey'            => 'server.pem',
	'certificate'           => 'server.crt',

	// The auth source used for authentication.
	'auth'                  => 'example-userpass',

	// Signing algorithm - RSA with SHA-256.
	'signature.algorithm'   => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',

	// Specify the format of attributes.
	'attributes.NameFormat' => 'urn:oasis:names:tc:SAML:2.0:attrname-format:basic',

	// Define which attributes to send to SPs.
	'attributes'            => array(
		'uid',
		'eduPersonAffiliation',
		'eduPersonPrincipalName',
		'givenName',
		'sn',
		'employeeNumber',
		'studentNumber',
		'eduPersonTargetedId',
	),
);
