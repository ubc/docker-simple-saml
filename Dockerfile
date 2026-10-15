# PHP 8.3: PHP 8.1 lost security support on 2025-12-31, and SimpleSAMLphp's 2.5
# line requires PHP >= 8.3 (on 8.1, composer stops at 2.4.9.x).
FROM php:8.3-apache

# Install dependencies.
# bcmath: SimpleSAMLphp 2.5 pulls in simplesamlphp/xml-common, which requires
# ext-bcmath; without it `composer create-project` below fails outright.
RUN apt-get update && apt-get install -y --no-install-recommends \
    libxml2-dev \
    libssl-dev \
    git \
    unzip \
    wget \
    openssl \
    libsqlite3-dev \
    && docker-php-ext-install xml \
    && docker-php-ext-install mysqli pdo pdo_mysql pdo_sqlite bcmath \
    && a2enmod ssl rewrite \
    && rm -rf /var/lib/apt/lists/*

# Install Composer from its official image (no `curl | php` installer).
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set up SimpleSAMLphp.
# `^2.0` is a RANGE on purpose: every build takes the newest SimpleSAMLphp 2.x,
# so security fixes arrive with a rebuild. What notices an upgrade that breaks
# the IdP is the HEALTHCHECK below and a real sign-in, not a pin. To see which
# version a build installed:
#   docker exec <container> grep -m1 '"version"' /var/www/simplesamlphp/composer.json
WORKDIR /var/www
RUN composer create-project --no-interaction simplesamlphp/simplesamlphp:^2.0 simplesamlphp

# Create directories if they don't exist
RUN mkdir -p /var/www/simplesamlphp/config \
    /var/www/simplesamlphp/metadata \
    /var/www/simplesamlphp/cert \
    /var/www/simplesamlphp/log \
    /var/www/simplesamlphp/data \
    /tmp/simplesamlphp-cache \
    /tmp/simplesamlphp-sessions \
    /tmp/simplesamlphp-temp

# Configure Apache - use Alias instead of symlink
RUN echo 'ServerName localhost' >> /etc/apache2/apache2.conf
COPY config/apache/simplesamlphp.conf /etc/apache2/conf-available/simplesamlphp.conf
RUN a2enconf simplesamlphp

# Add startup script
COPY startup.sh /var/www/startup.sh
RUN chmod 755 /var/www/startup.sh

# Set permissions
RUN chown -R www-data:www-data /var/www/simplesamlphp/ /tmp/simplesamlphp-cache /tmp/simplesamlphp-sessions /tmp/simplesamlphp-temp
RUN chmod -R 755 /tmp/simplesamlphp-cache /tmp/simplesamlphp-sessions /tmp/simplesamlphp-temp

# Expose ports
EXPOSE 80 443

# Run the startup script instead of apache directly
CMD ["/var/www/startup.sh"]
