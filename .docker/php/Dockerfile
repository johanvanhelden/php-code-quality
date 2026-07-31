FROM php:8.5-cli

WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    zip \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get clean

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Match the host user so bind-mounted files stay writable
RUN usermod -u 1000 www-data

USER www-data

CMD ["tail", "-f", "/dev/null"]
