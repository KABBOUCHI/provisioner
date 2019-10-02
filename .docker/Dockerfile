FROM ubuntu:18.04

RUN apt-get update \
    && apt-get install -y locales \
    && locale-gen en_US.UTF-8

RUN apt-get install -y software-properties-common git curl zip unzip

ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8
ENV DEBIAN_FRONTEND noninteractive

RUN apt-add-repository ppa:ondrej/php -y

RUN apt-get update

RUN apt-get install -y php7.3-cli

CMD ["/bin/bash"]
