<?php
/**
 * SAML 2.0 IdP configuration for SimpleSAMLphp.
 *
 * ONE hosted IdP, whatever host name or port it is reached on. Its entityID
 * is configuration, never derived from the request: set IDP_ENTITY_ID in the
 * container's environment to change it. The default is the entityID this IdP
 * has always published when reached as localhost, so an SP that pins it keeps
 * working.
 *
 * @package SimpleSAMLphp
 */

$idp_entity_id = getenv( 'IDP_ENTITY_ID' ) ?: 'http://localhost:6122/simplesaml/saml2/idp/metadata.php';

$metadata[ $idp_entity_id ] = array(
	// Every host name. Until this was one entry there were two: `localhost`
	// got the entityID above, and any other host (127.0.0.1, or the `saml-idp`
	// host name from another container) got a `__DEFAULT__` entry whose
	// entityID was the literal string `__DYNAMIC:1__` and whose attribute list
	// lacked mail and cwlLoginName.
	'host'                  => '__DEFAULT__',

	'SingleLogoutService'   => 'http://localhost:6122/simplesaml/saml2/idp/SingleLogoutService.php',

	// The private key and certificate used by this IdP.
	'privatekey'            => 'server.pem',
	'certificate'           => 'server.crt',

	// The auth source used for authentication.
	'auth'                  => 'example-userpass',

	// Signing algorithm - RSA with SHA-256.
	'signature.algorithm'   => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',

	// Specify the format of attributes.
	'attributes.NameFormat' => 'urn:oasis:names:tc:SAML:2.0:attrname-format:basic',

	// What an SP receives if its entry in saml20-sp-remote.php has no
	// `attributes` list of its own (core:AttributeLimit, config.php). Every
	// entry there has one; this is only the fallback.
	'attributes'            => array(
		'uid',
		'eduPersonAffiliation',
		'eduPersonPrincipalName',
		'givenName',
		'sn',
		'employeeNumber',
		'studentNumber',
		'eduPersonTargetedId',
		'ubcEduCwlPuid',
		'mail',
		'cwlLoginName',
	),
);
