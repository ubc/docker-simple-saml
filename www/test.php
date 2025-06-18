<?php
// This is a debug file to display SimpleSAMLphp configuration
// Place it in your www/custom directory

// Bootstrap SimpleSAMLphp
require_once '/var/www/simplesamlphp/lib/_autoload.php';

// Set error display
ini_set( 'display_errors', 1 );
error_reporting( E_ALL );

// Get the configuration
$config = \SimpleSAML\Configuration::getInstance();

// Output HTML header
echo '<!DOCTYPE html>
<html>
<head>
    <title>SimpleSAMLphp Debug</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        h1, h2 { color: #333; }
        .section { margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        pre { background-color: #f5f5f5; padding: 10px; overflow: auto; }
    </style>
</head>
<body>
    <h1>SimpleSAMLphp Debug Information</h1>';

// Display server information
echo '<div class="section">
    <h2>Server Information</h2>
    <pre>';
echo 'PHP Version: ' . phpversion() . "\n";
echo 'Server: ' . $_SERVER['SERVER_SOFTWARE'] . "\n";
echo 'Hostname: ' . gethostname() . "\n";
echo 'Document Root: ' . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo 'Current Script: ' . $_SERVER['SCRIPT_FILENAME'] . "\n";
echo 'Request URI: ' . $_SERVER['REQUEST_URI'] . "\n";
echo '</pre>
</div>';

// Display SimpleSAMLphp configuration
echo '<div class="section">
    <h2>SimpleSAMLphp Configuration</h2>
    <pre>';
echo 'Version: ' . $config->getVersion() . "\n";
echo 'Base URL Path: ' . $config->getString( 'baseurlpath' ) . "\n";
echo 'Base Hostname: ' . $config->getString( 'basehostname', 'NOT SET' ) . "\n";
echo 'Production Mode: ' . ( $config->getBoolean( 'production', true ) ? 'Yes' : 'No' ) . "\n";
echo 'Admin Protected: ' . ( $config->getBoolean( 'admin.protectindexpage', true ) ? 'Yes' : 'No' ) . "\n";
$debug = $config->getArray( 'debug', array() );
echo 'Debug SAML: ' . ( isset( $debug['saml'] ) && $debug['saml'] ? 'Yes' : 'No' ) . "\n";
echo 'Log Level: ' . $config->getInteger( 'logging.level', 4 ) . "\n";
echo '</pre>
</div>';

// Try to load and display IdP metadata
echo '<div class="section">
    <h2>IdP Metadata</h2>
    <pre>';
try {
	$metadataHandler = \SimpleSAML\Metadata\MetaDataStorageHandler::getMetadataHandler();
	$entityIDs       = $metadataHandler->getList( 'saml20-idp-hosted' );

	if ( empty( $entityIDs ) ) {
		echo "No IdP metadata found.\n";
	} else {
		echo "Found IdP entityIDs:\n";
		foreach ( $entityIDs as $entityID => $metadata ) {
			echo '- ' . $entityID . "\n";

			// Try to load this entity's full metadata
			try {
				$idpMetadata = $metadataHandler->getMetaDataConfig( $entityID, 'saml20-idp-hosted' );
				echo '  Host: ' . $idpMetadata->getString( 'host', 'NOT SET' ) . "\n";
				echo '  Auth: ' . $idpMetadata->getString( 'auth', 'NOT SET' ) . "\n";
				echo '  Cert: ' . ( $idpMetadata->hasValue( 'certificate' ) ? 'Present' : 'Missing' ) . "\n";
				echo '  Key: ' . ( $idpMetadata->hasValue( 'privatekey' ) ? 'Present' : 'Missing' ) . "\n";
			} catch ( Exception $e ) {
				echo '  Error loading metadata: ' . $e->getMessage() . "\n";
			}
		}
	}

	// Also check SP metadata
	$spEntityIDs = $metadataHandler->getList( 'saml20-sp-remote' );
	echo "\nFound SP entityIDs:\n";
	foreach ( $spEntityIDs as $entityID => $metadata ) {
		echo '- ' . $entityID . "\n";
	}
} catch ( Exception $e ) {
	echo 'Error: ' . $e->getMessage() . "\n";
	echo 'Trace: ' . $e->getTraceAsString() . "\n";
}

echo '</pre>
</div>';

// Display certificate info
echo '<div class="section">
    <h2>Certificate Information</h2>
    <pre>';
$certPath = '/var/www/simplesamlphp/cert/server.crt';
if ( file_exists( $certPath ) ) {
	$cert = file_get_contents( $certPath );
	$data = openssl_x509_parse( $cert );
	if ( $data ) {
		echo "Valid certificate found:\n";
		echo 'Subject: ' . $data['subject']['CN'] . "\n";
		echo 'Issuer: ' . $data['issuer']['CN'] . "\n";
		echo 'Valid From: ' . date( 'Y-m-d H:i:s', $data['validFrom_time_t'] ) . "\n";
		echo 'Valid To: ' . date( 'Y-m-d H:i:s', $data['validTo_time_t'] ) . "\n";
	} else {
		echo "Failed to parse certificate data.\n";
	}
} else {
	echo "Certificate file not found at $certPath\n";
}
echo '</pre>
</div>';

// Footer
echo '<div class="section">
    <h2>Links</h2>
    <ul>
        <li><a href="/simplesaml/">SimpleSAMLphp Home</a></li>
        <li><a href="/simplesaml/module.php/core/authenticate.php?as=example-userpass">Test Authentication</a></li>
        <li><a href="/simplesaml/saml2/idp/metadata.php">IdP Metadata</a></li>
        <li><a href="/simplesaml/saml2/idp/SSOService.php?spentityid=https://your-app1-entity-id&RelayState=http://localhost:8050/">Test SSO</a></li>
    </ul>
</div>';

echo '</body></html>';
