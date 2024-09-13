# Use the official MySQL 8.3.0 image
FROM mysql:8.3.0

# Set environment variables
ENV MYSQL_DATABASE=ct07_db \
    MYSQL_ROOT_PASSWORD=admin \
    MYSQL_USER=ad_db_ct07 \
    MYSQL_PASSWORD=admin \
    MYSQL_ALLOW_EMPTY_PASSWORD=yes \
    TZ=Asia/Ho_Chi_Minh  

RUN microdnf install -y vim


# Configure MySQL to log to a specific directory
RUN mkdir -p /var/log/mysql
RUN touch /var/log/mysql/mysql.log
RUN chown -R mysql:mysql /var/log/mysql/mysql.log && chmod -R 666 /var/log/mysql/mysql.log

# # Copy the data.sql file to the Docker container
COPY ./Data/dump/*.sql /docker-entrypoint-initdb.d/
# Set permissions to make sure the script is executable
RUN chmod +x /docker-entrypoint-initdb.d/*.sql

# Expose MySQL port
EXPOSE 3306