# Contact Management System (Laravel 11)

A simple contact management system built with Laravel 11. Features include user authentication, user-specific contacts, AJAX search, pagination, and a modern UI using Tailwind CSS.

## Features
- User registration, login, and logout
- Contacts are private to each user
- Add, edit, delete contacts
- AJAX search across all contact fields
- Pagination (no DataTables)
- Delete confirmation modal
- Responsive Tailwind CSS design

## Requirements
- PHP 8.2+
- Composer
- Node.js & npm
- SQLite (default) or MySQL/PostgreSQL (optional)

## Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd contact-sys
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Copy and configure environment**
   ```bash
   cp .env.example .env
   # Edit .env as needed (default uses SQLite)
   php artisan key:generate
   ```

4. **Set up the database**
   - For SQLite (default):
     ```bash
     touch database/database.sqlite
     ```
   - For MySQL/PostgreSQL: update `.env` accordingly.

5. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```
   This will create tables and seed 20 demo contacts for the test user.

6. **Build frontend assets**
   ```bash
   npm run build
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

8. **Login**
   - Use the seeded test user:
     - Email: `test@example.com`
     - Password: `password` (set in your UserFactory or registration)

## Useful Commands
- Run all migrations: `php artisan migrate`
- Seed the database: `php artisan db:seed`
- Refresh DB & reseed: `php artisan migrate:fresh --seed`
- Build assets: `npm run build`

## Notes
- Contacts are only visible to their owner.
- AJAX search and pagination are enabled by default.
- No DataTables or third-party table plugins are used.
