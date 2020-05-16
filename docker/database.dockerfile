FROM mysql:5.7

COPY ./docker/mysql.local.sql /docker-entrypoint-initdb.d/
