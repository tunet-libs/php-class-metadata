ARG PHP_VERSION
FROM tunet/php:${PHP_VERSION}

ARG XDEBUG_VERSION
ARG COMPOSER_VERSION

RUN apk update \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
    && apk add --no-cache \
        linux-headers \
        git \
        make \
        zsh \
    && docker-php-ext-install opcache \
    && pecl update-channels \
    && pecl install \
        apcu \
        xdebug-${XDEBUG_VERSION} \
    && docker-php-ext-enable apcu \
    && docker-php-ext-enable xdebug \
    && pecl clear-cache \
    && rm -rf /tmp/* /var/cache/apk/* \
    && apk del .build-deps \
    # install composer
    && curl -OL https://getcomposer.org/download/${COMPOSER_VERSION}/composer.phar \
    && mv ./composer.phar /usr/bin/composer \
    && chmod +x /usr/bin/composer

COPY ./php.ini /usr/local/etc/php/php.ini

ARG LINUX_USER_ID

RUN addgroup --gid $LINUX_USER_ID docker \
    && adduser --uid $LINUX_USER_ID --ingroup docker --home /home/docker --shell /bin/zsh --disabled-password --gecos "" docker

USER $LINUX_USER_ID

RUN wget https://github.com/robbyrussell/oh-my-zsh/raw/65a1e4edbe678cdac37ad96ca4bc4f6d77e27adf/tools/install.sh -O - | zsh
RUN echo 'export ZSH=/home/docker/.oh-my-zsh' > ~/.zshrc \
    && echo 'ZSH_THEME="simple"' >> ~/.zshrc \
    && echo 'source $ZSH/oh-my-zsh.sh' >> ~/.zshrc \
    && echo 'PROMPT="%{$fg_bold[yellow]%}php:%{$fg_bold[blue]%}%(!.%1~.%~)%{$reset_color%} "' > ~/.oh-my-zsh/themes/simple.zsh-theme
