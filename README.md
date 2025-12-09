# PHP Tinder App Backend

Technical Assignment for Hyperhire  
Build Date: 2025-12-08

This repository contains the **backend part** of a Tinder-like app built with **Laravel PHP**. It implements user recommendations, likes/dislikes, liked people list, and email notifications for popular people.

---

## Requirements

- PHP >= 8.2  
- Composer  
- MySQL / MariaDB  
- Laravel >= 10.x  
- Node.js / npm (optional, for frontend integration)  

---

## Installation

Clone the repository and install dependencies:

git clone https://github.com/dimaswildanR3/testhyperhire.git

cd testhyperhire
composer install

Copy .env.example to .env :

cp .env.example .env

---

## Environment Setup (.env)
Example .env:
```bash


APP_NAME=TinderApp
APP_ENV=local
APP_KEY=base64:YOUR_GENERATED_KEY
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
APP_TIMEZONE=Asia/Jakarta

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hyperhire
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

CACHE_STORE=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=dimaswildan1986@gmail.com
MAIL_PASSWORD=YOUR_MAIL_APP_PASSWORD
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=dimaswildan1986@gmail.com
MAIL_FROM_NAME="Tinder App"

QUEUE_CONNECTION=database
FILESYSTEM_DISK=local
```
---

## Database

Run migrations:

php artisan migrate

Tables:

people  (id, name, age, latitude, longitude, timestamps)  
pictures - people pictures (id, person_id, url, position, timestamps)  
likes - Likes/dislikes (id, person_id, user_id, is_like, timestamps)  

---

## API Endpoints

### People / Recommendations

Method    Endpoint                Description  
GET       /api/people             List of recommended people  
GET       /api/people/{id}        Single person details  

**Query Parameters:**

per_page (integer, default 10)  
lat (float, optional)  
lng (float, optional)  
radius_km (float, default 50)  

---

### Reaction (Like / Dislike)

Method    Endpoint                  Description  
POST      /api/people/{id}/like      Like a person  
POST      /api/people/{id}/dislike   Dislike a person  


### Liked People

Method    Endpoint                  Description  
GET       /api/liked               List of people liked by user  

**Query Parameters:**

user_id (integer, optional)  
per_page (integer, default 10)  

---

## Swagger Documentation

Generate docs:

php artisan l5-swagger:generate

Access Swagger UI:
http://127.0.0.1:8000/api/documentation

> All endpoints are annotated in controllers with @OA tags.

---

## Email Notifications

Laravel command:

php artisan notify:popular-people

Scheduler in app/Console/Kernel.php:

$schedule->command('notify:popular-people')->everyMinute();

Cron job example:

* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1

> Sends email if a person receives >50 likes.  
> Logs events in storage/logs/laravel.log.

---

## Testing

Start server:

php artisan serve

Use Postman or Swagger to test endpoints:

GET /api/people?per_page=10  
GET /api/people/{id}  
POST /api/people/{id}/like  
POST /api/people/{id}/dislike  
GET /api/liked?user_id=1  

Test notifications:

php artisan notify:popular-people

---

## Submission Instructions

Push code to GitHub repository  
Include .env.example  
Include README.md  
Provide Swagger UI link or instructions  
Send GitHub link to: UJJWAL@HYPERHIRE.IN

---

## Folder Structure

app/  
 ├─ Console/Commands/NotifyPopularPeople.php  
 ├─ Http/Controllers/  
 │    ├─ LikedController.php  
 │    ├─ ReactionController.php  
 │    └─ RecommendationController.php  
 ├─ Models/  
 │    ├─ Person.php  
 │    ├─ Picture.php  
 │    └─ Like.php  
database/  
 ├─ migrations/  
 └─ seeders/  
routes/  
 └─ api.php
