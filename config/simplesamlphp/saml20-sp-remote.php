<?php
/**
 * SAML 2.0 SP configuration for SimpleSAMLphp.
 *
 * @package SimpleSAMLphp
 */

$local_apps = array(
	// Original entityIDs for named apps.
	'https://tlef-biocbot'  => 'http://localhost:8050',
	'https://tlef-create'   => 'http://localhost:8051',
	'https://tlef-grasp'    => 'http://localhost:8052',
	'https://tlef-engeai'   => 'http://localhost:8020',

	// Localhost entityIDs used by SP Issuer in AuthnRequest.
	'http://localhost:8050' => 'http://localhost:8050',
	'http://localhost:8051' => 'http://localhost:8051',
	'http://localhost:8052' => 'http://localhost:8052',
	'http://localhost:8020' => 'http://localhost:8020',
	'http://localhost:5001' => 'http://localhost:5001',
);

$default_attributes = array(
	'uid',
	'eduPersonAffiliation',
	'eduPersonPrincipalName',
	'givenName',
	'sn',
);

// Now create a metadata entry for each local app.
foreach ( $local_apps as $app_id => $base_url ) {
	$metadata[ $app_id ] = array(
		'AssertionConsumerService' => array(
			array(
				'index'    => 0,
				'Binding'  => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
				'Location' => $base_url . '/auth/saml/callback',
			),
		),
		'SingleLogoutService'      => array(
			array(
				'Binding'  => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
				'Location' => $base_url . '/auth/logout',
			),
		),
		'NameIDFormat'             => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
		'simplesaml.attributes'    => true,
		'attributes'               => $default_attributes,
		'saml20.sign.assertion'    => true,
		'saml20.sign.response'     => true,
		'validate.authnrequest'    => false,
		'validate.logout'          => false,
	);
}

// Override ACS URL for the passport-ubcshib example app to match its route
$metadata['http://localhost:3000']['AssertionConsumerService'][0]['Location'] = 'http://localhost:3000/auth/ubcshib/callback';
