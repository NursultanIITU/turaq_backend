[//]: # (# [backend.tansarcapital.kz]&#40;https://backend.tansarcapital.kz&#41;)


### Приклад

Backend

|  Т            |    В       |
| ---------     | -----:     |
| Laravel       |   10       |


### Серверное ПО

| Т          |      В |
|------------|-------:|
| PHP        |    8.3 |
| PostgreSQL |     16 |
| Nginx      | 1.25.4 |
| Redis      |      7 |
| ELK        |  8.7.1 |

# Как развернуть Laravel локально?

#### 1. Клонируем проект
```code
git clone git@gitlab.ibecsystems.kz:parkovka/backend.git
```

#### 2. Копируем env.example и создаем .env и обновляем данные подключение к БД и ELK
```code
cp .env.example .env
```
#### 3. Заходим в проект и устанавливаем зависимости
```code
composer install && php artisan key:generate && php artisan jwt:secret
```
#### 4. Запускаем миграции
```code
php artisan migrate
```

#### 5. Запускаем сиды если нужны демо данные.
```code
php artisan db:seed
```

#### 6. Запускаем команду настройки пакета
```code
php artisan admin-kit:install
```

#### 7. Создать пользователя
```code
php artisan shield:super-admin
```

#### 7. Импортируем данные в ELK
```code
php artisan elastic:hot_refresh_search_indexes
```

##### Разворот проекта с помощью докера:
В разработке