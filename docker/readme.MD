### Первый запуск проекта на Docker
- Docker уже установлен в системе.
- Docker-proxy(Предварительно скачать и установить).
- Скачиваем проект с gitlab.stone-labs.com.

Для того чтобы скачать зависимость git@gitlab.stone-labs.com:Driveline/driveline-calculation.git
> Нужны ssh ключи, которые зарегестированы на gitlab.stone-labs.com и положить в
> - docker/ssh/stone_labs_com (600)
> - docker/ssh/stone_labs_com.pub

1. Запускаем Docker-proxy
2. Через программу работы с БД (Valentina Studio... etc) создаём и загружаем БД scango
3. Открываем в редакторе файл .env и настраиваем некоторые п.п.
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=scango
DB_USERNAME={user}
DB_PASSWORD={password}
CACHE_DRIVER=memcached
MEMCACHED_HOST=memcached

*** остальные настройки спрашиваем у DevOps специалиста. 
```

4. Запускаем консоль в папки docker проекта
```
Запускаем проект
bash start.sh

Заходим в docker контейнер проекта
docker exec -it scango bash

COMPOSER_MEMORY_LIMIT=-1 composer install --optimize-autoloader

php artisan storage:link

npm install
npm run dev
* npm cache clean --force

для навигации внутри -> mc

exit
вышли из docker контейнера

bash stop.sh
остановили проект
```

## Ежедневная работа  
### http://scango.divo

1. Запускаем Docker-proxy
2. Запускаем проект из папки docker "bash start.sh", в корне проекта
> job job job job job job job job 
5. Останавливаем Docker проекта "bash stop.sh" 
6. Останавливаем Docker-proxy
