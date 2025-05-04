#!/usr/bin/env bash

# Atualiza UID do usuário 'sail', se necessário
if [ ! -z "$WWWUSER" ]; then
    usermod -u $WWWUSER sail
fi

# Cria diretório do Composer (caso não exista)
if [ ! -d /home/sail/.composer ]; then
    mkdir -p /home/sail/.composer
fi
chmod -R ugo+rw /home/sail/.composer

# Cria diretórios necessários para Supervisor
mkdir -p /var/log/supervisor
mkdir -p /var/run

# Aguarda o MySQL iniciar
until nc -z -v -w30 db 3306
do
  echo "⏳ Aguardando o MySQL iniciar..."
  sleep 5
done

echo "✅ MySQL está pronto!"

# Executa migrations e seeds (com o usuário correto)
cd /var/www
php artisan migrate:fresh --seed

# Se argumentos foram passados, executa com eles (útil pra override)
if [ $# -gt 0 ]; then
    if command -v gosu >/dev/null 2>&1; then
        exec gosu $WWWUSER "$@"
    else
        exec "$@"
    fi
else
    # Inicia o Supervisor como processo principal
    exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
fi
