# nginx ver1.11.5
FROM nginx:1.11.5

# git
RUN apt-get update && apt-get install -y git vim


# 起動するnginxコンテナの指定パスにserver.confをコピー
COPY server.conf /etc/nginx/conf.d/server.conf