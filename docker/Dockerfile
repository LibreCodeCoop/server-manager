FROM nginx:1.12

#  default conf for proxy service
COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf

# Proxy configurations
COPY ./nginx/includes/ /etc/nginx/includes/

# NOT FOUND response
COPY ./nginx/backend-not-found.html /var/www/html/backend-not-found.html
