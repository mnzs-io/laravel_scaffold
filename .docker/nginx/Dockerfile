FROM nginx

RUN useradd -G www-data,root -u 1000 -d /home/sail sail
RUN mkdir /var/www

RUN chown -R sail:sail /var/www
