#!/bin/bash

# Verifique o status do programa 'php' com o supervisorctl
STATUS=$(supervisorctl status php | awk '{print $2}')

# Caminho do arquivo 'worker'
WORKER_FILE="/var/www/html/storage/app/worker"

# Se o PHP estiver em execução, crie o arquivo 'worker'
if [ "$STATUS" == "RUNNING" ]; then
    echo "O PHP está em execução. Criando o arquivo 'worker'."
    touch "$WORKER_FILE"
    chown sail:sail "$WORKER_FILE"
else
    # Se o PHP não estiver em execução, remova o arquivo 'worker'
    echo "O PHP não está em execução. Removendo o arquivo 'worker'."
    rm -f "$WORKER_FILE"
fi
