Установка проекта:

1. git clone https://github.com/arivlav/cpotest
2. устанавливаем необходимые библиотеки: composer install
3. настраиваем .env для соединения с базой
4. генерируем ключ приложения: php artisan key:generate
5. запускаем миграции: php artisan migrate
6. наполняем базу демо-данными: php artisan db:seed
7. тестовый логин: email test@example.com
                   пароль 12345678 
                   роут test.ru/api/login
