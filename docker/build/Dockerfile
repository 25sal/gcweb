FROM ubuntu:20.04
ENV DEBIAN_FRONTEND=noninteractive 

WORKDIR /var/www/html
RUN mkdir Simulations
# COPY package.json .
RUN apt update
RUN apt -y upgrade
RUN apt -y install apache2 mysql-server php php-mysql php-yaml php-sqlite3 git
RUN git clone https://github.com/25sal/gcweb.git
RUN chown -R root:www-data gcweb
ARG GIT_UPDATE=unknown
RUN cd gcweb && git pull
RUN cp -r gcweb/demo/templates/users /home/
RUN chown -R www-data:www-data /home/users
RUN cp gcweb/scripts/apache2.conf /etc/apache2/
EXPOSE 80

COPY gcsimulator_ui.sql /docker-entrypoint-initdb.d/init.sql


RUN sed -i "s/127.0.0.1/0.0.0.0/g" /etc/mysql/mysql.conf.d/mysqld.cnf \
 && mkdir /var/run/mysqld \
 && chown -R mysql:mysql /var/run/mysqld
 
VOLUME ["/var/lib/mysql"]
 
EXPOSE 3306

CMD ["mysqld_safe"]
CMD ["/usr/sbin/apachectl", "-D", "FOREGROUND"]
#CMD ["/var/www/html/gcweb/scripts/initdb.sh"]
# CMD [ "npm", "start" ]

# COPY . .
