## Code Challenge Laravel API

Git Location:
https://github.com/krali/orainteractive.git

composer install
php artisan migrate
php artisan key:generate
php artisan jwt:generate

Change .env.example to .env. Update any environment variables based on your installation this file is compatible with homestead.

API

POST {url}/api/users/register
	name, email, password, password_confirmation
POST {url}/api/users/login
	email, password
GET {url}/api/users/me
PUT {url}/api/users/me
	name, email
POST {url}/api/chats
	name
GET {url}/api/chats?q=Chat&page=1&limit=20
POST {url}/api/chats/{chatid}/messages
	message
GET {url}/api/chats/{chatid}/messages?page=1&limit=20