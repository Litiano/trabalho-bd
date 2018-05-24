# Instruções básicas:
- docker ps -a #para ver os containers.
- docker exec -it $CONTAINER_ID bash #para entrar no bash do container

## No bash do container SqlServer:
- /opt/mssql-tools/bin/sqlcmd -S localhost -U sa -P senhaDb123 -Q "If(db_id(N'trabalho_db') IS NULL) create database trabalho_db;"

## No bash do container Apache
- composer install #para instalar as dependecias do Laravel
- php artisan migrate #para criar as tabelas do SqlServer
- php artisan precess:file #para processar o arquivo CSV


