FROM php:8.2-cli
cat > Dockerfile <<'EOF'
FROM php:8.2-cli
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . /app

RUN composer install --no-dev --no-interaction --prefer-dist
RUN mkdir -p storage && ( [ -f storage/tickets.json ] || echo "[]" > storage/tickets.json )

EXPOSE 10000
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
