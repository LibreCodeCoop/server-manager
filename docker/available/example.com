server {
  listen 80;
  server_name example.com;

  location / {
    include /etc/nginx/includes/proxy.conf;
    proxy_pass http://example_com;
  }

  access_log off;
  error_log  /var/log/nginx/error.log error;
}
