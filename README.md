# TestShopMegasite

A Laravel-based e-commerce application with Livewire and Filament admin panel.

## Prerequisites

- Docker
- Docker Compose
- Git

## Quick Start with Laravel Sail


1.Install Composer dependencies (without requiring PHP installed locally):
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    composer:latest composer install --ignore-platform-reqs
```

2. Copy `.env.example` to `.env`:
```bash
cp .env.example .env
```


3. Start Laravel Sail:
```bash
# Alias to sail  (run via alias on Mac os can be long)
 alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

```bash
# Start all containers
sail up -d
```

4. Set up the application:
```bash
# Generate application key
sail artisan key:generate

# Run database migrations
sail artisan migrate

# Run database seeder
sail artisan db:seed

# Install Node.js dependencies and build assets
sail npm install
sail npm run dev

# Create storage link
sail artisan storage:link
```

6. Access the application:
- Main site: http://127.0.0.1/products
- Admin panel: http://127.0.0.1/admin




Роздуми під час тестового

- Було б класно добавити ще один статус (для відхилених замовлень).
  Та повісити івент для повернення кілікості товарів у stock
  - Та для статусів використати цей пакет https://spatie.be/docs/laravel-model-states/v2/01-introduction.
  - Щоб керувати зміною статусами більш гнучко
- Для картинок(1)
  - Булоб добре добавити Job при створені продукту для нарізки картинок на різні розміри
  - А на FE відповідно ці розміри використовувати
- Для картинок(2)
  - Або створити універсальний ендпоінт для виводу картинок. Який приймає потрібний розмір картинки і нарізає цю картинку
  - Нову картинку зберігаємо в кеш
- Процес checkout
  - Думаю було б добре блокувати кількість товару за певним користувачем на +-5 хв. Приклад вибір місця в кінотеатрі.
  - Але це потрібно узгоджувати. (Не для тестового точно!)
- Для збереження характеристик було б добре використати патерн EAV 

