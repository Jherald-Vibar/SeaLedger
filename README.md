# SeaLedger

Fish vendor inventory and sales management system built with Laravel, Tailwind CSS and jQuery.

## Setup

1. Start Apache and MySQL in XAMPP, then create an empty database named `sealedger` in phpMyAdmin.
2. Run these in the project folder:

```
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

For development use `npm run dev` in a second terminal instead of `npm run build`.

## Accounts

| Persona | Access | Login |
|---|---|---|
| Vendor | `/login` then `/admin/dashboard` | username `vendor`, password `SeaLedger123!` |
| Customer | `/` (no login, view only) | none |
