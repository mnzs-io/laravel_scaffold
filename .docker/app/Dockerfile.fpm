# 🐘 BASE: Imagem PHP com FPM
FROM php:8.4-fpm

# 👤 USUÁRIO: Cria o usuário 'sail' com UID 1000 e adiciona a grupos necessários
RUN useradd -G www-data,root -u 1000 -d /home/sail sail

# 🧰 SISTEMA: Instala dependências do sistema operacional
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 🧩 PHP: Instala e configura extensões necessárias
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    sockets \
    zip

# 🐞 XDEBUG: Instala e habilita Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# 🧾 XDEBUG CONFIG: Copia a config personalizada
COPY ./xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN chown -R sail:sail /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY ./php.ini /usr/local/etc/php/

# 🎼 COMPOSER: Copia o Composer da imagem oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 🗃️ PERMISSÕES: Prepara diretórios para o usuário 'sail'
RUN mkdir -p /home/sail/.composer && \
    chown -R sail:sail /home/sail

# ⚙️ PHP-FPM: Altera o usuário do FPM de 'www-data' para 'sail'
RUN sed -i "s/user = www-data/user = sail/" /usr/local/etc/php-fpm.d/www.conf && \
    sed -i "s/group = www-data/group = sail/" /usr/local/etc/php-fpm.d/www.conf && \
    sed -i "s/;listen.owner = www-data/listen.owner = sail/" /usr/local/etc/php-fpm.d/www.conf && \
    sed -i "s/;listen.group = www-data/listen.group = sail/" /usr/local/etc/php-fpm.d/www.conf

# 📁 WORKDIR: Define o diretório de trabalho no projeto Laravel
WORKDIR /var/www/public

# 📂 DIRETÓRIOS: Cria e ajusta permissões dos diretórios de cache e storage do Laravel
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache && \
    chown -R sail:sail /var/www/storage /var/www/bootstrap/cache /var/www/public && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache /var/www/public

# 👤 USUÁRIO: Alterna para o usuário 'sail'
USER sail

# 🚀 START: Comando padrão de inicialização
CMD ["php-fpm"]
