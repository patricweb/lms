docker-compose up -d --build

docker exec -it lms_management_system bash

composer install
npm install
npm run dev

cp .env.example .env

php artisan key:generate
php artisan storage:link
php artisan migrate