<?php
// This is a simple test file to initiate IdP-first login flow
// Shows debug information and provides a button for IdP-initiated SSO

// Turn on error reporting for debugging
ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );
error_reporting( E_ALL );

// Include SimpleSAMLphp's autoloader
require_once '/var/www/simplesamlphp/lib/_autoload.php';

// Manually load the configuration to initialize the logger
\SimpleSAML\Configuration::getInstance();

// Entity ID of the SP you want to log into
$spEntityId = 'https://your-app1-entity-id';

// URL the user should be redirected to after authentication (RelayState)
$returnTo = 'http://localhost:8050/';

// Construct the URL
$ssoUrl  = 'http://localhost:8080/simplesaml/saml2/idp/SSOService.php';
$ssoUrl .= '?spentityid=' . urlencode( $spEntityId );
$ssoUrl .= '&RelayState=' . urlencode( $returnTo );

// Display debug information
echo '<html><head><title>SAML IdP Test Page</title>';
echo '<style>
    body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
    h1 { color: #333; }
    .section { margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
    .button {
        display: inline-block;
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
    }
    pre { background-color: #f5f5f5; padding: 10px; overflow: auto; }
</style>';
echo '</head><body>';
echo '<h1>SAML IdP Test Page</h1>';

echo '<div class="section">';
echo '<h2>System Information</h2>';
echo '<p>Current time: ' . date( 'Y-m-d H:i:s' ) . '</p>';
echo '<p>PHP Version: ' . phpversion() . '</p>';
echo '<p>Server: ' . $_SERVER['SERVER_SOFTWARE'] . '</p>';
echo '</div>';

echo '<div class="section">';
echo '<h2>SimpleSAMLphp Configuration</h2>';
echo '<p>Testing IdP-initiated SSO to SP: <strong>' . htmlspecialchars( $spEntityId ) . '</strong></p>';
echo '<p>Return URL (RelayState): <strong>' . htmlspecialchars( $returnTo ) . '</strong></p>';
echo '</div>';

echo '<div class="section">';
echo '<h2>IdP-Initiated SSO</h2>';
echo '<p>Click the button below to initiate a SAML login flow from the IdP:</p>';
echo '<a class="button" href="' . htmlspecialchars( $ssoUrl ) . '">Start IdP-Initiated SSO</a>';
echo '</div>';

echo '<div class="section">';
echo '<h2>Useful Links</h2>';
echo '<ul>';
echo '<li><a href="/simplesaml/">SimpleSAMLphp Home</a></li>';
echo '<li><a href="/simplesaml/module.php/core/authenticate.php?as=example-userpass">Test Authentication</a></li>';
echo '<li><a href="/simplesaml/saml2/idp/metadata.php">IdP Metadata</a></li>';
echo '<li><a href="http://localhost:8050/metadata">SP Metadata</a></li>';
echo '</ul>';
echo '</div>';

echo '<div class="section">';
echo '<h2>SSO URL Details</h2>';
echo '<pre>' . htmlspecialchars( $ssoUrl ) . '</pre>';
echo '</div>';

echo '</body></html>';
