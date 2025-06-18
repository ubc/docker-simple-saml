#!/bin/bash

echo "Starting SimpleSAMLphp startup script..."

echo "Checking for certificates..."
# Check if certificates exist
if [ ! -f /var/www/simplesamlphp/cert/server.crt ] || [ ! -f /var/www/simplesamlphp/cert/server.pem ]; then
    echo "Certificates not found. Generating self-signed certificates..."

    # Create directory if it doesn't exist
    mkdir -p /var/www/simplesamlphp/cert

    # Generate private key
    openssl genrsa -out /var/www/simplesamlphp/cert/server.pem 2048

    # Generate certificate
    openssl req -new -x509 -key /var/www/simplesamlphp/cert/server.pem \
        -out /var/www/simplesamlphp/cert/server.crt -days 3650 \
        -subj "/C=CA/ST=BC/L=Vancouver/O=UBC/OU=IT/CN=localhost"

    # Copy cert to client directory if mounted
    if [ -d /var/www/client/cert ]; then
        cp /var/www/simplesamlphp/cert/server.crt /var/www/client/cert/
    fi
fi
echo "Completed checking for certificates. You will need to copy the server.crt file to your application to allow it to trust the IDP."


# Ensure correct permissions on metadata, cache, log, and cert directories
# Use try/catch to handle permission errors gracefully
echo "Setting directory permissions..."
chown -R www-data:www-data /var/www/simplesamlphp/metadata || echo "Warning: Could not set ownership on metadata directory"
chown -R www-data:www-data /tmp/simplesamlphp-cache || echo "Warning: Could not set ownership on cache directory"
chown -R www-data:www-data /tmp/simplesamlphp-sessions || echo "Warning: Could not set ownership on sessions directory"
chown -R www-data:www-data /tmp/simplesamlphp-temp || echo "Warning: Could not set ownership on temp directory"

chmod -R 755 /var/www/simplesamlphp/metadata || echo "Warning: Could not set permissions on metadata directory"
# Make the log directory world-writable to solve bind mount permission issues
chmod -R 777 /var/www/simplesamlphp/log || echo "Warning: Could not set permissions on log directory"
chmod -R 755 /var/www/simplesamlphp/cert || echo "Warning: Could not set permissions on cert directory"
chmod -R 755 /tmp/simplesamlphp-cache || echo "Warning: Could not set permissions on cache directory"
chmod -R 755 /tmp/simplesamlphp-sessions || echo "Warning: Could not set permissions on sessions directory"
chmod -R 755 /tmp/simplesamlphp-temp || echo "Warning: Could not set permissions on temp directory"

# Make sure the cert files are readable - ignore errors for mounted volumes
chmod 644 /var/www/simplesamlphp/cert/server.crt || echo "Warning: Could not set permissions on server.crt"
chmod 600 /var/www/simplesamlphp/cert/server.pem || echo "Warning: Could not set permissions on server.pem"
echo "Completed setting directory permissions."

echo "Checking for custom scripts..."
# Check if custom scripts are correctly mounted
if [ -f /var/www/simplesamlphp/www/custom/test-idp-init.php ]; then
    echo "IdP test script found at the correct location"
    # Copy it to the public directory for easier access
    cp /var/www/simplesamlphp/www/custom/test-idp-init.php /var/www/simplesamlphp/public/
    chown www-data:www-data /var/www/simplesamlphp/public/test-idp-init.php
    chmod 644 /var/www/simplesamlphp/public/test-idp-init.php
    cp /var/www/simplesamlphp/www/custom/test.php /var/www/simplesamlphp/public/
    chown www-data:www-data /var/www/simplesamlphp/public/test.php
    chmod 644 /var/www/simplesamlphp/public/test.php
    echo "Copied test-idp-init.php to public directory"
else
    echo "WARNING: IdP test script not found"
fi

# Print server status
echo "Starting Apache..."

# Start Apache
exec apache2-foreground