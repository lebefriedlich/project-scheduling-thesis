# Project Scheduling Thesis

A Laravel-based web application to manage and schedule academic activities (teaching schedules, proposal/final seminars, thesis defenses) with Livewire components, Excel import, and email notifications.

## Overview
- Manage core entities: Periods, Lecturers, Locations, Teaching Schedules, Seminars (Proposal/Final), and Thesis.
- Admin UI built with Livewire for fast, reactive interactions.
- Import teaching schedules from Excel via the import module.
- Automated email notifications for scheduling and rejection events.

## Key Features
- Period management (`Periode`) to group schedules.
- Lecturer (`Lecturer`) and location (`Location`) master data.
- Teaching schedules (`TeachingSchedule`) with Excel import ([app/Imports/TeachingScheduleFullImport.php](app/Imports/TeachingScheduleFullImport.php)).
- Proposal seminar (`Sempro`), final seminar/defense (`Semhas`), and thesis (`Skripsi`) scheduling.
- Email notifications: [ScheduleNotification](app/Mail/ScheduleNotification.php), [ScheduleRejectionNotification](app/Mail/ScheduleRejectionNotification.php).
- Admin interface powered by Livewire (components in [app/Livewire/Admin](app/Livewire/Admin)).

## Tech Stack
- Laravel (primary framework)
- Livewire (interactive components without a full SPA)
- Vite (frontend build tooling)
- Pest/PHPUnit (testing)
- Maatwebsite Excel (Excel import)

## Prerequisites
- PHP 8.2+ and Composer
- Node.js 18+ and npm
- MySQL/MariaDB (or a database compatible with your Laravel config)
- Common PHP extensions for Laravel (pdo, mbstring, openssl, tokenizer, etc.)

## Quick Setup
1. Clone or download this project.
2. Install PHP dependencies:
	```bash
	composer install
	```
3. Create environment configuration:
	- Copy `.env.example` to `.env` (or create `.env` if missing).
	- Fill in `APP_URL`, `DB_*`, and mailer settings (`MAIL_*`).
4. Generate the application key:
	```bash
	php artisan key:generate
	```
5. Run migrations (optionally seed basic data):
	```bash
	php artisan migrate --seed
	```
6. Install frontend dependencies and build assets:
	```bash
	npm install
	npm run build
	```
	For development:
	```bash
	npm run dev
	```
7. Start the local server:
	```bash
	php artisan serve
	```

## Mail Configuration
To enable email notifications, set the following variables in `.env`:
- `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_ENCRYPTION`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME`.

Related mailer classes:
- [app/Mail/ScheduleNotification.php](app/Mail/ScheduleNotification.php)
- [app/Mail/ScheduleRejectionNotification.php](app/Mail/ScheduleRejectionNotification.php)

## Teaching Schedule Import
- Excel import support is available in [app/Imports/TeachingScheduleFullImport.php](app/Imports/TeachingScheduleFullImport.php).
- Use the admin interface to upload files (if provided). If no route/UI exists yet, add a controller action that leverages this importer.

## Key Directory Structure
- Backend: [app](app)
  - Models: [app/Models](app/Models)
  - Controllers & Middleware: [app/Http](app/Http)
  - Livewire Admin Components: [app/Livewire/Admin](app/Livewire/Admin)
  - Mail: [app/Mail](app/Mail)
- Application routes: [routes/web.php](routes/web.php)
- Configuration: [config](config)
- Database migrations: [database/migrations](database/migrations)
- Views & assets: [resources/views](resources/views), [resources/js](resources/js), [resources/css](resources/css)

## Contributing
Contributions are welcome. Please open a pull request with a clear description and include tests when possible.
