FROM nginx:latest
COPY ./nginx/conf.d /etc/nginx/conf.d
COPY ./static-html-directory/start-page/index.html /usr/share/nginx/html


