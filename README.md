<p align="center"><img src="public\index\i\main_image.png"></p>



## Платежный сервис

Технические особенности:

- Проект реализован на Laravel 10
- Версия PHP 8
- Версия базы данных MySQL-8.0-Win10.


Запуск проекта:

- Скачать репозиторий проекта с github
- Установить Composer (В корневой папке проекта выполнить команду:
composer install)
- Файл .env.example изменить на .env
- Сгенирировать ключ: php artisan key:generate
- Создать ДБ и указать название в DB_DATABASE
- Запустить миграцию: php artisan migrate
- Заполнить базу данных данными: php artisan db:seed
- Запустить проект через php artisan serve
- Произвести локальный запуск планировщика (каждый час): php artisan schedule:work
- Идти на http://localhost:8000/


Для проверочного входа пользователя используйте: email: proverka@proverka.ru и пароль: proverka

Для входа любого пользователя используйте email из посева  и пароль: password
