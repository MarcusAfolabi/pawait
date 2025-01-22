# Documentation for Installing the Laravel API Backend

## Prerequisites
Before proceeding with the installation, ensure the following tools and environments are set up on your local machine:

1. **PHP**: Version 8.2 or higher.
2. **Composer**: Dependency management tool for PHP.
3. **Database Server**: MySQL or MariaDB.
4. **Node.js and npm**: For managing front-end assets (optional for this API).
5. **Git**: For cloning the repository.
6. **Web Server**: Apache or Nginx with Laravel configuration (such as Herd, Laragon or Xamp).

---

## Step-by-Step Installation Guide

### 1. Clone the Repository
Clone the Laravel API repository to your local machine:
```bash
git clone https://github.com/MarcusAfolabi/pawait.git
cd pawait
```

### 2. Install Dependencies
Install the necessary PHP dependencies using Composer:
```bash
composer install
```

### 3. Configure Environment Variables
1. Copy the `.env.example` file to `.env`:
   ```bash
   cp .env.example .env
   ```
2. Open the `.env` file in a text editor and configure the following variables:
   - **Database Settings**:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=your_database_name
     DB_USERNAME=your_database_user
     DB_PASSWORD=your_database_password

    
     ```
   - **API Key**:
     ```env
    OPENWEATHER_API_KEY='a73fc4cadb24a441bf20e98add69bb31'
    OPENWEATHER_BASE_URL='https://api.openweathermap.org/data/2.5/weather'
    OPENWEATHER_ONECALL_BASE_URL='https://api.openweathermap.org/data/3.0/onecall'
     ```

### 4. Generate Application Key
Run the following command to generate the application key:
```bash
php artisan key:generate
```

### 5. Run Database Migrations
Set up the database tables by running migrations:
```bash
php artisan migrate
```

### 6. (Optional) Seed the Database
If the application requires initial data, seed the database:
```bash
php artisan db:seed
```

### 7. Serve the Application Locally
To test the application, start the development server:
```bash
php artisan serve
```
Access the application at [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

## Deployment Steps

### 1. Set Up a Web Server
- Use **Apache** or **Nginx** to serve the Laravel application.
- Ensure the `public` folder is set as the document root.

### 2. Configure File Permissions
Set appropriate permissions for the `storage` and `bootstrap/cache` directories:
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 3. Configure `.env` for Production
Update the `.env` file with production settings, including the database and API keys.

### 4. Run Optimizations
For production environments, optimize the application:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Testing the API
1. Use tools like Postman or cURL to test the API endpoints.
2. Example request to test weather endpoint:
   ```bash
   curl http://127.0.0.1:8000/api/v1/weather?city=Nairobi&units=metric
   ```

---

## Troubleshooting
1. **Database Connection Issues**:
   - Ensure the database credentials in `.env` are correct.
   - Verify the database server is running.

2. **Missing Dependencies**:
   - Run `composer install` to ensure all PHP packages are installed.

3. **Permission Errors**:
   - Ensure proper permissions for `storage` and `bootstrap/cache` directories.

4. **Debugging**:
   - Enable debug mode in `.env` for development:
     ```env
     APP_DEBUG=true
     ```

---

For further assistance, contact the developer or refer to the Laravel [official documentation](https://laravel.com/docs).

