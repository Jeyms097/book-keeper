# Book Keeper

**Book Keeper** is a Laravel 12-based CRUD application for managing **authors** and **books**.  
It features a clean UI, responsive components, AJAX form handling, and UX using [MDBootstrap](https://mdbootstrap.com/), [DataTables](https://datatables.net/), [Toastify](https://apvarun.github.io/toastify-js/), [SweetAlert2](https://sweetalert2.github.io/), and [jQuery](https://jquery.com/).

> This system uses **SQLite**, Laravel’s built-in lightweight database, making it easy to set up locally by just configuring a single line in your `.env` file.

## Example `.env` Setup (for SQLite)

After copying `.env.example` to `.env`, modify the database section like so: ```env -- DB_CONNECTION=sqlite
No need for database username/password when using SQLite.

---

## Take Note

This project uses a `.gitignore` that **excludes several critical and environment-specific files and directories**, meaning they will not be included in the cloned repository. You **must install Laravel 12 and dependencies locally** after cloning.

### Git-ignored files and directories: .log
.DS_Store
.env
.env.backup
.env.production
.phpactor.json
.phpunit.result.cache
/.fleet
/.idea
/.nova
/.phpunit.cache
/.vscode
/.zed
/auth.json
/node_modules
/public/build
/public/hot
/public/storage
/storage/.key
/storage/pail
/vendor
Homestead.json
Homestead.yaml
Thumbs.db

> Because of this, the following actions are required:
>
> - **Laravel 12 must be installed via Composer**  
> - You must run `composer install` to install PHP dependencies (since `/vendor` is ignored)  
> - You must run `npm install` to install JS dependencies (since `/node_modules` is ignored)  
> - You must set up your own `.env` file based on `.env.example`  
> - Make sure you have **PHP 8.1+**, **Composer**, and **Node.js** installed on your machine


## Features

- Create, Read, Update, Delete (CRUD) for authors and books
- Modern UI with **MDBootstrap**, **Select2**, **DataTables**, and **SweetAlert2**
- Modal-based AJAX editing
- Search/filter authors and books
- Database seeding with Faker (Dummy data -- generates 50 authors, each associated with 1 to 5 books for demonstration purposes.)
- Laravel Blade templating and resource controllers

---

## Requirements

- Laravel 12+
- PHP >= 8.1
- Composer
- Node.js and npm
- SQLite (or MySQL/PostgreSQL with config changes)

---

## Installation & Setup

Follow these steps to set up the app on local machine:

### Clone the Repository

```bash
git clone https://github.com/your-username/book-keeper.git
cd book-keeper

### Install Dependencies
composer install
npm install && npm run build

### Set Environment Variables
cp .env.example .env Then generate your app key: php artisan key:generate


### Set Up the Database
Use SQLite (default) 


### Run Migrations & Seeders
php artisan migrate --seed - This will create 50 authors automatic, each with 1–5 books.

### Running the Application
Start the Laravel development server  - php artisan serve


