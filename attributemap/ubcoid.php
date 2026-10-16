<?php
/**
 * UBC's own attribute, which SimpleSAMLphp's name2oid map cannot know.
 *
 * Used only by a Service Provider that opts in to OID attribute names (see
 * $ubc_oid_attribute_names in config/simplesamlphp/saml20-sp-remote.php).
 * core:AttributeMap loads maps by name from this directory and later maps win,
 * so `array( 'class' => 'core:AttributeMap', 'name2oid', 'ubcoid' )` converts
 * the standard attributes (uid, mail, givenName, sn, eduPersonAffiliation,
 * eduPersonPrincipalName, ...) with SimpleSAMLphp's own map, and this file
 * adds the UBC-specific one.
 *
 * urn:oid:1.3.6.1.4.1.60.6.1.6 is the OID passport-ubcshib reads as
 * ubcEduCwlPuid. Check the digits: a look-alike (1.3.6.1.4.1.60.1.1.1) matches
 * nothing the library maps, and the PUID then silently goes missing.
 *
 * cwlLoginName is deliberately not mapped: its OID is not confirmed, so an SP
 * that opts in still receives it under its friendly name.
 *
 * The Dockerfile copies this file into the image's attributemap/ directory.
 *
 * @package SimpleSAMLphp
 */

$attributemap = array(
	'ubcEduCwlPuid' => 'urn:oid:1.3.6.1.4.1.60.6.1.6',
);
