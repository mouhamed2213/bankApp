#FROM ubuntu:24.04
#
#LABEL maintainer="Taylor Otwell"
#
#ARG WWWGROUP
#ARG NODE_VERSION=22
#ARG MYSQL_CLIENT="mysql-client"
#ARG POSTGRES_VERSION=17
#
#WORKDIR /var/www/html
#
#ENV DEBIAN_FRONTEND=noninteractive
#ENV TZ=UTC
#ENV SUPERVISOR_PHP_COMMAND="/usr/bin/php -d variables_order=EGPCS /var/www/html/artisan serve --host=0.0.0.0 --port=80"
#ENV SUPERVISOR_PHP_USER="sail"
#
#RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
#
#RUN echo "Acquire::http::Pipeline-Depth 0;" > /etc/apt/apt.conf.d/99custom && \
#    echo "Acquire::http::No-Cache true;" >> /etc/apt/apt.conf.d/99custom && \
#    echo "Acquire::BrokenProxy    true;" >> /etc/apt/apt.conf.d/99custom
#
#RUN apt-get update && apt-get upgrade -y \
#    && mkdir -p /etc/apt/keyrings \
#    && apt-get install -y gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python3 dnsutils librsvg2-bin fswatch ffmpeg nano  \
#    && curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0xb8dc7e53946656efbce4c1dd71daeaab4ad4cab6' | gpg --dearmor | tee /etc/apt/keyrings/ppa_ondrej_php.gpg > /dev/null \
#    && echo "deb [signed-by=/etc/apt/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu noble main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
#    && apt-get update \
#    && apt-get install -y php8.4-cli php8.4-dev \
#       php8.4-pgsql php8.4-sqlite3 php8.4-gd \
#       php8.4-curl php8.4-mongodb \
#       php8.4-imap php8.4-mysql php8.4-mbstring \
#       php8.4-xml php8.4-zip php8.4-bcmath php8.4-soap \
#       php8.4-intl php8.4-readline \
#       php8.4-ldap \
#       php8.4-msgpack php8.4-igbinary php8.4-redis php8.4-swoole \
#       php8.4-memcached php8.4-pcov php8.4-imagick php8.4-xdebug \
#    && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
#    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
#    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
#    && apt-get update \
#    && apt-get install -y nodejs \
#    && npm install -g npm \
#    && npm install -g pnpm \
#    && npm install -g bun \
#    && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | gpg --dearmor | tee /etc/apt/keyrings/yarn.gpg >/dev/null \
#    && echo "deb [signed-by=/etc/apt/keyrings/yarn.gpg] https://dl.yarnpkg.com/debian/ stable main" > /etc/apt/sources.list.d/yarn.list \
#    && curl -sS https://www.postgresql.org/media/keys/ACCC4CF8.asc | gpg --dearmor | tee /etc/apt/keyrings/pgdg.gpg >/dev/null \
#    && echo "deb [signed-by=/etc/apt/keyrings/pgdg.gpg] http://apt.postgresql.org/pub/repos/apt noble-pgdg main" > /etc/apt/sources.list.d/pgdg.list \
#    && apt-get update \
#    && apt-get install -y yarn \
#    && apt-get install -y $MYSQL_CLIENT \
#    && apt-get install -y postgresql-client-$POSTGRES_VERSION \
#    && apt-get -y autoremove \
#    && apt-get clean \
#    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
#
#RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.4
#
#RUN userdel -r ubuntu
#RUN groupadd --force -g $WWWGROUP sail
#RUN useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 sail
#
#COPY start-container /usr/local/bin/start-container
#COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
#COPY php.ini /etc/php/8.4/cli/conf.d/99-sail.ini
#RUN chmod +x /usr/local/bin/start-container
#
#EXPOSE 80/tcp
#
#ENTRYPOINT ["start-container"]
# ---- Base Stage ----
# Utilise une image de base avec PHP 8.3 et Composer
FROM composer:2 as base

# Installe les extensions PHP nécessaires pour Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo pdo_mysql gd zip

# ---- Vendor Stage ----
# Crée une étape séparée pour installer les dépendances PHP
FROM base as vendor

WORKDIR /app
COPY database/ database/
COPY composer.json composer.json
COPY composer.lock composer.lock

# Installe les dépendances de production uniquement
RUN composer install --ignore-platform-reqs --no-interaction --no-plugins --no-scripts --prefer-dist


# ---- Node Stage ----
# Crée une étape séparée pour compiler les assets JS/CSS
FROM node:20-alpine as node

WORKDIR /app
COPY package.json package.json
COPY package-lock.json package-lock.json
COPY vite.config.js vite.config.js
COPY tailwind.config.js tailwind.config.js
COPY postcss.config.js postcss.config.js
COPY resources/ resources/

# Installe les dépendances et compile pour la production
RUN npm ci
RUN npm run build


# ---- Final Stage ----
# Crée l'image finale en utilisant une image PHP-FPM optimisée
FROM php:8.3-fpm-alpine as final

# Installe les dépendances système et les extensions PHP
RUN apk add --no-cache \
    nginx \
    supervisor \
    libzip-dev \
    libpng-dev \
    && docker-php-ext-install pdo pdo_mysql gd zip

# Copie les fichiers de configuration pour Nginx et PHP-FPM
COPY .docker/nginx.conf /etc/nginx/nginx.conf
COPY .docker/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

WORKDIR /app

# Copie les dépendances et les assets des étapes précédentes
COPY --from=vendor /app/vendor/ ./vendor/
COPY --from=node /app/public/build ./public/build

# Copie le reste du code de l'application
COPY . .

# Définit les permissions correctes pour le stockage et le cache
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache
RUN chmod -R 775 /app/storage /app/bootstrap/cache

# Expose le port 8080 (standard pour Railway/Render)
EXPOSE 8080

# Commande pour démarrer Nginx et PHP-FPM avec Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor.conf"]

# Fichier de configuration pour Supervisor
COPY .docker/supervisord.conf /etc/supervisor.conf
