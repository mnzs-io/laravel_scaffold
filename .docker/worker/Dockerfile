# Etapa 1: Base PHP com extensões necessárias
FROM php:8.4-cli

# Cria o usuário 'sail' com UID 1000
RUN useradd -G www-data,root -u 1000 -d /home/sail sail

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    libjpeg-dev \
    libfreetype6-dev \
    supervisor \
    && apt-get clean && rm -rf /var/lib/apt/lists/*


RUN apt-get update && apt-get install -y netcat-openbsd

# Instala extensões PHP necessárias
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


# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Ajusta permissões para o usuário sail usar o Composer
RUN mkdir -p /home/sail/.composer && \
    chown -R sail:sail /home/sail

# Corrige php-fpm pra rodar com o usuário sail em vez de www-data
# RUN sed -i "s/user = www-data/user = sail/" /usr/local/etc/php-fpm.d/www.conf && \
#     sed -i "s/group = www-data/group = sail/" /usr/local/etc/php-fpm.d/www.conf && \
#     sed -i "s/;listen.owner = www-data/listen.owner = sail/" /usr/local/etc/php-fpm.d/www.conf && \
#     sed -i "s/;listen.group = www-data/listen.group = sail/" /usr/local/etc/php-fpm.d/www.conf

# Define o diretório de trabalho para o Laravel
WORKDIR /var/www

# Prepara os diretórios que o Laravel precisa
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache /var/www/public && \
    chown -R sail:sail /var/www && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache /var/www/public

# Copia os arquivos de configuração do Supervisor e script de inicialização
COPY ./start-container.sh /usr/local/bin/start-container
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN chmod +x /usr/local/bin/start-container


# Expõe a porta do painel web do Supervisor (opcional)
EXPOSE 9001

# Comando padrão para iniciar com Supervisor
CMD ["/usr/local/bin/start-container"]

COPY ./wait-for-it.sh /usr/local/bin/wait-for-it
RUN chmod +x /usr/local/bin/wait-for-it
