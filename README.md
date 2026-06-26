# BH Hostel Management System

A comprehensive, modern Laravel web application for managing hostel operations including batches, students, rooms, attendance, and leaves.

## Setup Instructions

Follow these steps to pull the project and run it locally on your machine.

### Prerequisites
Before you begin, ensure you have the following installed:
- **PHP** (8.2 or higher)
- **Composer**
- **Node.js** & **npm**
- **MySQL** (via XAMPP, WAMP, Laragon, or standalone)
- **Git**

### 1. Clone the Repository
Open your terminal or command prompt and run:
```bash
git clone <your-repository-url>
cd BH-Hostel-Management-System
```

### 2. Install PHP Dependencies
Install the required Laravel packages using Composer:
```bash
composer install
```

### 3. Install Node.js Dependencies
Install the frontend packages required by Vite:
```bash
npm install
```

### 4. Setup Environment Variables
Create a copy of the `.env.example` file and name it `.env`:
```bash
cp .env.example .env
```
*(On Windows Command Prompt, use `copy .env.example .env`)*

Open the `.env` file and configure your database connection. By default, it should look something like this:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hostel_management
DB_USERNAME=root
DB_PASSWORD=
```
*Note: Make sure your MySQL server is running and you have created a database named `hostel_management`.*

### 5. Generate Application Key
Generate a unique encryption key for the application:
```bash
php artisan key:generate
```

### 6. Run Database Migrations
Create the database tables:
```bash
php artisan migrate:fresh
```

### 7. Compile Frontend Assets
Build the Vite frontend assets for the dashboard and UI to work properly:
```bash
npm run build
```
*(Alternatively, you can run `npm run dev` in a separate terminal to watch for changes during development).*

### 8. Start the Local Development Server
Finally, start the Laravel server:
```bash
php artisan serve
```

You can now access the application by visiting [http://localhost:8000](http://localhost:8000) in your web browser.

---

### Default Admin Login (For Testing)
If you seeded the database with the default admin user:
- **Email/Username:** `admin` / `admin@example.com`
- **Password:** `password`
