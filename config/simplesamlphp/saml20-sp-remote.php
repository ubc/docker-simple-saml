<?php
/**
 * SAML 2.0 SP configuration for SimpleSAMLphp.
 *
 * Each entry's `attributes` list is exactly what the IdP releases to that SP
 * (core:AttributeLimit in config.php), as real CWL releases only what an app
 * is registered for. Give every entry a NON-EMPTY list: an empty list releases
 * everything, and a missing one falls back to the IdP's own list in
 * saml20-idp-hosted.php.
 *
 * @package SimpleSAMLphp
 */

$local_apps = array(
	// Original entityIDs for named apps.
	'https://tlef-biocbot'  => 'http://localhost:8050',
	'https://tlef-create'   => 'http://localhost:8051',
	'https://tlef-grasp'    => 'http://localhost:8070',
	'https://tlef-engeai'   => 'http://localhost:8020',

	// Localhost entityIDs used by SP Issuer in AuthnRequest.
	'http://localhost:8050' => 'http://localhost:8050',
	'http://localhost:8051' => 'http://localhost:8051',
	'http://localhost:8052' => 'http://localhost:8052',
	'http://localhost:8020' => 'http://localhost:8020',
	'http://localhost:5001' => 'http://localhost:5001',
	'http://localhost:8070' => 'http://localhost:8070',

	// tlef-financebot boilerplate (runs on PORT=6118, uses passport-ubcshib).
	'http://localhost:6118' => 'http://localhost:6118',

	// The passport-ubcshib example app and tlef-starter's default SAML_ISSUER.
	// Its ACS is overridden below. (Before this line existed, that override
	// created a bare entry with no attribute list.)
	'http://localhost:3000' => 'http://localhost:3000',
);

// What a local app receives unless its entry says otherwise. ubcEduCwlPuid
// and mail are here because apps on passport-ubcshib key people by PUID, and
// fail with `Missing ubcEduCwlPuid attribute` without it.
$default_attributes = array(
	'uid',
	'eduPersonAffiliation',
	'eduPersonPrincipalName',
	'givenName',
	'sn',
	'ubcEduCwlPuid',
	'mail',
);

// UBC's real attribute names, for an SP that opts in. Real CWL sends
// attributes under OID names (urn:oid:...) with the `uri` NameFormat. This IdP
// sends friendly names (uid, mail, ...) unless an SP's entry opts in, because
// apps written against it read friendly names. To test an app against CWL's
// naming, merge this into its entry AFTER the entry is defined, e.g.
//
//   $metadata['http://localhost:8050'] = array_merge( $metadata['http://localhost:8050'], $ubc_oid_attribute_names );
//
// (array_merge replaces an `authproc` the entry already has.) Keep the entry's
// `attributes` list in FRIENDLY names: core:AttributeLimit (config.php, priority
// 50) filters on them first, and this rename runs after it, at 60. Swap that
// order, or list OIDs in `attributes`, and nothing is released at all.
// ubcEduCwlPuid's OID comes from ../../attributemap/ubcoid.php.
$ubc_oid_attribute_names = array(
	'attributes.NameFormat' => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
	'authproc'              => array(
		60 => array( 'class' => 'core:AttributeMap', 'name2oid', 'ubcoid' ),
	),
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
		// Sign the IdP's LogoutRequest/LogoutResponse, as real CWL does.
		'sign.logout'              => true,
	);
}

// Override ACS URL for the passport-ubcshib example app to match its route
$metadata['http://localhost:3000']['AssertionConsumerService'][0]['Location'] = 'http://localhost:3000/auth/ubcshib/callback';

// tlef-financebot boilerplate — passport-ubcshib posts to /auth/ubcshib/callback.
$metadata['http://localhost:6118']['AssertionConsumerService'][0]['Location'] = 'http://localhost:6118/auth/ubcshib/callback';

// canvas-bridge — needs ubcEduCwlPuid and mail, both now in the default attributes.
$metadata['http://localhost:6060'] = array(
	'AssertionConsumerService' => array(
		array(
			'index'    => 0,
			'Binding'  => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
			'Location' => 'http://localhost:6060/auth/saml/callback',
		),
	),
	'SingleLogoutService'      => array(
		array(
			'Binding'  => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
			'Location' => 'http://localhost:6060/auth/logout',
		),
	),
	'NameIDFormat'             => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
	'simplesaml.attributes'    => true,
	'attributes'               => $default_attributes,
	'saml20.sign.assertion'    => true,
	'saml20.sign.response'     => true,
	'validate.authnrequest'    => false,
	'validate.logout'          => false,
	'sign.logout'              => true,
);

// Vibonarium gateway SP — needs ubcEduCwlPuid (primary key), mail, and cwlLoginName.
$metadata['http://localhost:4000'] = array(
	'AssertionConsumerService' => array(
		array(
			'index'    => 0,
			'Binding'  => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
			'Location' => 'http://localhost:4000/auth/ubcshib/callback',
		),
	),
	'SingleLogoutService'      => array(
		array(
			'Binding'  => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
			'Location' => 'http://localhost:4000/auth/logout',
		),
	),
	'NameIDFormat'             => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
	'simplesaml.attributes'    => true,
	'attributes'               => array_merge( $default_attributes, array( 'cwlLoginName' ) ),
	'saml20.sign.assertion'    => true,
	'saml20.sign.response'     => true,
	'validate.authnrequest'    => false,
	'validate.logout'          => false,
	'sign.logout'              => true,
);

// CodingWorkspace local prototype (saml-dev-idp mode). Entity ID must match
// CODINGWORKSPACE_SAML_DEV_ENTITY_ID / the spentityid the app sends to SSOService.php.
$metadata['http://127.0.0.1:8768/CodingWorkspace/saml/metadata'] = array(
	'AssertionConsumerService' => array(
		array(
			'index'    => 0,
			'Binding'  => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
			'Location' => 'http://127.0.0.1:8768/CodingWorkspace/saml/acs',
		),
	),
	'SingleLogoutService'      => array(
		array(
			'Binding'  => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
			'Location' => 'http://127.0.0.1:8768/CodingWorkspace/saml/logout',
		),
	),
	'NameIDFormat'             => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
	'simplesaml.attributes'    => true,
	'attributes'               => array_merge( $default_attributes, array( 'cwlLoginName' ) ),
	'saml20.sign.assertion'    => true,
	'saml20.sign.response'     => true,
	'validate.authnrequest'    => false,
	'validate.logout'          => false,
	'sign.logout'              => true,
);

// Open WebUI — SAML SSO Event function SP (functions/saml_sso.py in the
// openwebui repo). minisaml expects exactly one signature, so sign the
// Response only, not the Assertion.
$metadata['http://localhost:3000/saml/metadata'] = array(
	'AssertionConsumerService' => array(
		array(
			'index'    => 0,
			'Binding'  => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
			'Location' => 'http://localhost:3000/saml/acs',
		),
	),
	'NameIDFormat'             => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
	'simplesaml.attributes'    => true,
	'attributes'               => array(
		'uid',
		'mail',
		'givenName',
		'sn',
		'eduPersonAffiliation',
		'eduPersonPrincipalName',
		'eduPersonEntitlement',
		'isMemberOf',
		'ubcEduCwlPuid',
	),
	'saml20.sign.response'     => true,
	'saml20.sign.assertion'    => false,
	'validate.authnrequest'    => false,
);
