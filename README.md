Чтобы запустить проект:

1. Клонируйте репозиторий на локальную машину

2. Установите docker (если не установлен)

3. Перейдите в каталог `cd ./client/src` и установите зависимости `npm install --include=dev`

4. Вернитесь в корень проекта и перейдите в каталог `cd ./server/src`

5. Создайте .env с помощью `cp .env.example .env`

6. Сгенерируйте ключ `php artisan key:generate`

7. Запустите `docker-compose run composer install` чтобы установить зависимости

8. Запуcтите сервер `docker-compose up nginx -d` и убедитесь в его работоспособности перейдя на localhost:8000

9*. В случае появления ошибки типа The stream or file "/var/www/laravel/storage/logs/laravel.log" could not be opened in append mode: Failed to open stream: Permission denied...
  а) Откройте список запущенных контейнеров `docker ps` и найдите container_id контейнера php
  б) Выполните команду `docker exec {php container_id} chmod o+w ./storage -R`
  в) Выполните команду `docker exec {php container_id} chown 775 -R ./storage`

10. Заходите на клиент localhost:8080

