[![Actions Status](https://github.com/MiranaM/php-project-57/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/MiranaM/php-project-57/actions)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=MiranaM_php-project-57&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=MiranaM_php-project-57)

# Task Manager

## Описание

Task Manager – система управления задачами, подобная http://www.redmine.org/. Она позволяет ставить задачи, назначать исполнителей и менять их статусы. Для работы с системой требуется регистрация и аутентификация.

## Демо

[Ссылка на задеплоенное приложение на render.com](https://php-project-57-j8mr.onrender.com)

---

## Как развернуть проект

```bash
# Клонируйте репозиторий
git clone https://github.com/MiranaM/php-project-57
cd php-project-57

# Установите зависимости
composer install

# Скопируйте переменные окружения
cp .env.example .env

# Сгенерируйте APP_KEY
php artisan key:generate

# Настройте параметры подключения к БД (PostgreSQL) в .env

# Запустите миграции и заполните таблицы начальными данными
php artisan migrate --seed

# Запустите локальный сервер (или используйте Docker)
php artisan serve
```

Откройте в браузере [http://localhost:8000](http://localhost:8000)

**Docker:**

```bash
docker compose up -d
```

---

## Запуск тестов

```bash
./vendor/bin/phpunit
```
