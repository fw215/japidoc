#README

## docker(環境構築)
    docker-compose build
    docker-compose up -d

## docker(コマンド) 
    docker-compose down
    docker-compose exec nginx bash
    docker-compose exec php bash
    docker rm $(docker ps -aq)
    docker rmi -f $(docker images -aq)