# project-root/php/Dockerfile
FROM ubuntu:22.04

# 環境変数の設定 (apt-get用)
ENV DEBIAN_FRONTEND=noninteractive

# 1. OSツールのインストール、タイムゾーン設定
RUN apt-get update                                             \
 && apt-get -y upgrade                                         \
 && apt-get install -y tzdata                                  \
 && ln -fs /usr/share/zoneinfo/Asia/Tokyo /etc/localtime       \
 && dpkg-reconfigure -f noninteractive tzdata                  \
 && apt-get install -y sudo curl vim-tiny less grep            \
    # openssh-serverはsshコンテナに切り出すため、ここでは除外可能ですが、
    # 簡易デバッグのために残す選択肢もあります。今回は残します。
    openssh-server

# 2. PHP FPMとMySQLエクステンションのインストール
RUN apt-get install -y php8.1-fpm php8.1-mysql                  \
 && apt-get clean && rm -rf /var/lib/apt/lists/*


# 3. ユーザー sspuser/ssppass の作成 (元のDockerfileより)
RUN perl -i -pe 's/^HOME\_MODE\s\d+/HOME_MODE 0755/' /etc/login.defs && \
    useradd -D -s /bin/bash                                          && \
    useradd -m sspuser                                               && \
    gpasswd -a sspuser sudo
RUN echo 'sspuser:ssppass' |chpasswd
RUN sudo -u sspuser mkdir /home/sspuser/public_html


# 4. PHP設定変更 (display_errors = On)
#    元のDockerfileのパス: /etc/php/8.1/fpm/php.ini はそのまま使用
RUN perl -i -pe 's/^(\s*display_errors\s*\=\s*)Off/$1On/;' /etc/php/8.1/fpm/php.ini

# 5. PHP-FPMのソケットディレクトリの作成 (volumesでマウントするため必須)
RUN mkdir -p /var/run/php

# 既存のソケット設定をTCPポートに変更する RUN コマンドを追加
RUN sed -i 's/listen = \/run\/php\/php8.1-fpm.sock/listen = 9000/' /etc/php/8.1/fpm/pool.d/www.conf

# 6. PHP-FPMの実行コマンドを設定
CMD ["/usr/sbin/php-fpm8.1", "-F"]