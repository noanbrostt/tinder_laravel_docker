# Usar imagem oficial do Nginx
FROM nginx:alpine

# Copiar o arquivo de configuração do Nginx
COPY ./docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf
COPY ./brutos/public/ /var/www/public/

# Expor porta 80 para o Nginx
EXPOSE 8098
