until nc -z -v -w30 db 3306
do
  echo "Aguardando o MySQL iniciar..."
  sleep 5
done
