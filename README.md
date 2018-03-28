#README

## docker(環境構築)
    docker-compose build
    docker-compose up -d
    docker-compose exec php bash
        php composer.phar install
            php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"
            php composer.phar require codeigniter/framework:3.1.8
            php composer.phar require --dev phpdocumentor/phpdocumentor
                vendor/bin/phpdoc run -d application/ -t documents

## docker(コマンド) 
    docker-compose down
    docker-compose exec nginx bash
    docker-compose exec php bash
    docker rm $(docker ps -aq)
    docker rmi -f $(docker images -aq)