FROM alpine:3.7
RUN apk add --no-cache supervisor

# trust this project public key to trust the packages.
ADD https://php.codecasts.rocks/php-alpine.rsa.pub /etc/apk/keys/php-alpine.rsa.pub

## you may join the multiple run lines here to make it a single layer

# make sure you can use HTTPS
RUN apk --update add ca-certificates

# add the repository, make sure you replace the correct versions if you want.
RUN echo "@php https://php.codecasts.rocks/v3.7/php-7.2" >> /etc/apk/repositories

# install php and some extensions
# notice the @php is required to avoid getting default php packages from alpine instead.
RUN apk add --update php7@php
RUN apk add --update php7-common@php
RUN apk add --update php7-mbstring@php
RUN apk add --update php7-iconv@php
RUN apk add --update libevent@php
RUN apk add --update yaml@php
RUN apk add --update php7-ctype@php
RUN apk add --update php7-json@php
RUN apk add --update php7-bcmath@php
RUN apk add --update php7-sockets@php
RUN apk add --update php7-dom@php
RUN apk add --update php7-pdo_mysql@php

RUN ln -s /usr/bin/php7 /usr/bin/php

ENTRYPOINT ["/usr/bin/supervisord", "-n"]

