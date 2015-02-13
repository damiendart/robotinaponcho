FROM ubuntu:latest
MAINTAINER Damien Dart <damiendart@pobox.com>
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update
RUN apt-get -y upgrade
RUN apt-get -y install apache2 libapache2-mod-php5
RUN a2enmod rewrite
EXPOSE 80
ADD public /var/www/robotinaponcho
ADD apache.conf /etc/apache2/sites-enabled/000-default.conf
CMD /usr/sbin/apache2ctl -D FOREGROUND
