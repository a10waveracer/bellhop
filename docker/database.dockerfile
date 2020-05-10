FROM mysql:5.6

COPY ./docker/mysql.local.sql /docker-entrypoint-initdb.d/
