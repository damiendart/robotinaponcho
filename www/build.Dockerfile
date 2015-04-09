# Dockerfile for building Damien Dart's personal website.
#
# Copyright (C) 2013-2015 Damien Dart, <damiendart@pobox.com>.
# This file is distributed under the MIT licence. For more information,
# please refer to the accompanying "LICENCE" file.

FROM ubuntu:latest
MAINTAINER Damien Dart <damiendart@pobox.com>
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update
RUN apt-get -y upgrade
RUN apt-get -y install build-essential ruby-full
RUN gem install bundler --no-rdoc --no-ri
WORKDIR /tmp
ADD Gemfile Gemfile
RUN bundle install --system
VOLUME /robotinaponcho-dev
WORKDIR /robotinaponcho-dev
CMD rake
