# Badminton Connect - Development Guide

## Build Commands
- Install dependencies: `composer install && npm install`
- Start dev server: `php artisan serve`
- Build frontend: `npm run build`
- Watch frontend: `npm run dev`
- Run migrations: `php artisan migrate`
- Seed database: `php artisan db:seed`
- Fresh migrations with seed: `php artisan migrate:fresh --seed`

## Testing Commands
- Run all tests: `php artisan test`
- Run specific test: `php artisan test --filter=TestName`

## Linting/Formatting
- PHP code formatting: `./vendor/bin/pint`

## Code Style Guidelines
- Follow PSR-4 and Laravel naming conventions
- Models: singular, PascalCase (e.g., User, Court)
- Controllers: plural, PascalCase, suffix with Controller
- Migrations: snake_case with descriptive names
- Database tables: plural, snake_case
- 4 space indentation for PHP files
- Use type hints where possible
- Use Filament conventions for admin resources