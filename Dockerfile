# Dockerfile untuk situs static (HTML/CSS/JS) -> Nginx
FROM php:8.2-apache
COPY . /var/www/html/
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
