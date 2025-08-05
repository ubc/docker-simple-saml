FROM php:8.1-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libxml2-dev \
    libssl-dev \
    git \
    unzip \
    wget \
    openssl \
    libsqlite3-dev \
    && docker-php-ext-install xml \
    && docker-php-ext-install mysqli pdo pdo_mysql pdo_sqlite \
    && a2enmod ssl rewrite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set up SimpleSAMLphp
WORKDIR /var/www
RUN composer create-project simplesamlphp/simplesamlphp:^2.0 simplesamlphp

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