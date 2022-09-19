FROM ubuntu:latest

MAINTAINER Leonardo Marques <leonardo@paginaemconstrucao.com.br>

ENV LANG=pt_BR.UTF-8
ENV LANGUAGE=pt_BR:pt
ENV LC_ALL=pt_BR.UTF-8
ENV timezone=America/Sao_Paulo

RUN apt update && apt dist-upgrade -y

RUN apt update && apt install -y locales && rm -rf /var/lib/apt/lists/* \
	&& localedef -i pt_BR -c -f UTF-8 -A /usr/share/locale/locale.alias pt_BR.UTF-8

RUN apt update && DEBIAN_FRONTEND=noninteractive apt install apache2 apache2-utils \
    php php-xml php-cli php-xdebug php-intl php-mysql php-sqlite3 curl php-curl \
    git composer -y

RUN apt clean

RUN rm -rf /var/www/html/index.html

WORKDIR /var/www/html

EXPOSE 80 443

CMD ["/usr/sbin/apache2ctl", "start"]
