# Dockerfile for testing Damien Dart's personal website.
#
# NOTE: I no longer use this; I keep it around as a reference on how to
# set up my development environment.
#
# Copyright (C) 2013-2016 Damien Dart, <damiendart@pobox.com>.
# This file is distributed under the MIT licence. For more information,
# please refer to the accompanying "LICENCE" file.

FROM ubuntu:latest
MAINTAINER Damien Dart <damiendart@pobox.com>
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update
RUN apt-get -y upgrade
RUN apt-get -y install apache2 build-essential cpanminus git
RUN cpanm HTML::Template URI
RUN a2enmod cgid rewrite
ADD apache.conf /etc/apache2/sites-enabled/000-default.conf
VOLUME /var/www/robotinaponcho
EXPOSE 80
CMD /usr/sbin/apache2ctl -D FOREGROUND
