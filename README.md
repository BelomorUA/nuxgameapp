markdown
Copy code
# NuxGameApp

## Project Setup

### 1. Create a Project Folder
```bash

- mkdir nuxgameapp
- cd nuxgameapp
```
### 2. Download Laravel into the Project Folder
```bash
composer create-project --prefer-dist laravel/laravel .
```
### 3. Clone the Repository Files into the Project Folder
```bash
-git init
-git remote add origin https://github.com/BelomorUA/nuxgameapp.git
-git pull origin main
```
### 4. Install Node.js Dependencies and Run the Compilation
```bash
-npm install
-npm run dev
```
### 5. Configure the .env File
```plaintext
Set up the database connection in the .env file:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```
### 6. Run Laravel Migrations
```bash
php artisan migrate
```
### 7. Start the Laravel Server
```bash
php artisan serve
```
### 8. Open the Project in the Browser
Open your browser and navigate to: http://127.0.0.1:8000
