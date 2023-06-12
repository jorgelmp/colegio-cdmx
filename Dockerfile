FROM nginx:latest
RUN chmod -R 644 /usr/share/nginx/html
COPY src /usr/share/nginx/html
COPY . .