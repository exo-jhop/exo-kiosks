# 🧾 Exo POS

Exo POS is a Point of Sale (POS) system built with Laravel and Filamentphp. It provides a seamless interface for managing orders, products, and revenue efficiently.

---

## 🚀 Features

-   Order management with dynamic stats
-   Category & Product CRUD
-   Real-time revenue updates
-   Real-time order notifications
-   Background queue processing

---

## 🛠️ Installation & Setup

git clone git@github.com:exo-jhop/exo-kiosks.git
cd exo-pos
composer install
npm install
cp .env.example .env
php artisan key:generate

# Edit .env and set your DB credentials (example below):

# DB_CONNECTION=mysql

# DB_HOST=mysql

# DB_PORT=3306

# DB_DATABASE=exo_kiosks

# DB_USERNAME=sail

# DB_PASSWORD=password

php artisan migrate:fresh --seed
npm run dev
php artisan serve
php artisan queue:work

---

## 🔐 Admin Panel

Access the admin interface at http://127.0.0.1/admin/login  
Default Admin Credentials:  
Email: admin@gmail.com  
Password: admin

---

## 🖥️ Kiosk Interface

Customer-facing kiosk can be accessed at: http://127.0.0.1

---

## 🧰 Helpful Artisan Commands

php artisan optimize:clear
php artisan queue:work
php artisan migrate:fresh --seed
php artisan route:list
