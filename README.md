# LMS
LMS - система управления обучения имеющая 2 роли (преподаватель и студент). Позволяет управлять курсами, материалами. Создавать материала типа текст, загружать изображение, видео, составлять тест

Перед разверткой необходимо поднять safespace

## Развертка

```cp .env.example .env```

```docker compose up -d```

## Настройка

```docker compose exec app bash```

```php artisan migrate --seed```

