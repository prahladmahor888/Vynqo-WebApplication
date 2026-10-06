# 🚀 Sangfy Web Application — Production Deployment Guide (`sangfy.prahlix.com`)

This guide details the complete process for deploying the Sangfy web application to production on **`sangfy.prahlix.com`**.

---

## 📋 Server Requirements
- **Domain:** `sangfy.prahlix.com` (pointing via DNS A Record to your server IP)
- **PHP:** >= 8.2 with extensions: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `curl`, `fileinfo`
- **Database:** MySQL >= 8.0 or MariaDB >= 10.5
- **Web Server:** Nginx or Apache
- **Composer:** Latest v2
- **SSL Certificate:** Free Let's Encrypt / Certbot for `sangfy.prahlix.com`

---

## 🛠️ Step-by-Step Deployment Steps

### Step 1: Clone Repository & Install Dependencies
```bash
cd /var/www
git clone <your-repo-url> sangfy
cd sangfy

# Install production PHP dependencies (no dev tools)
composer install --no-dev --optimize-autoloader
```

### Step 2: Configure Environment (.env)
```bash
cp .env.example .env
nano .env
```
Ensure the following production settings:
```env
APP_NAME=Sangfy
APP_ENV=production
APP_KEY=base64:... # (Generated in Step 3)
APP_DEBUG=false
APP_URL=https://sangfy.prahlix.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sangfy_prod
DB_USERNAME=sangfy_user
DB_PASSWORD=YourStrongDatabasePassword!

SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
```

### Step 3: Generate App Key & Run Database Migrations
```bash
php artisan key:generate
php artisan migrate --force --seed
```

### Step 4: Production Optimization & Caching
```bash
# Cache configuration, routes, and views
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### Step 5: Directory Permissions
```bash
sudo chown -R www-data:www-data /var/www/sangfy
sudo chmod -R 775 /var/www/sangfy/storage /var/www/sangfy/bootstrap/cache /var/www/sangfy/public/downloads
```

---

## 🌐 Nginx Server Configuration (`/etc/nginx/sites-available/sangfy.conf`)

```nginx
server {
    listen 80;
    server_name sangfy.prahlix.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name sangfy.prahlix.com;
    root /var/www/sangfy/public;

    ssl_certificate /etc/letsencrypt/live/sangfy.prahlix.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/sangfy.prahlix.com/privkey.pem;

    add_header X-Frame-Options "DENY" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;

    index index.php index.html;
    charset utf-8;

    client_max_body_size 150M;

    # Protect hidden files (.env, .git)
    location ~ /\.(?!well-known).* {
        deny all;
    }

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### SSL Generation (Certbot):
```bash
sudo certbot --nginx -d sangfy.prahlix.com
```

---

## 🔄 Live Deployment Update Script (`deploy.sh`)
```bash
#!/bin/bash
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo systemctl reload php8.2-fpm
sudo systemctl reload nginx
echo "🚀 Sangfy (sangfy.prahlix.com) successfully deployed!"
```
