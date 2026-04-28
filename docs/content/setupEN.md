## 1. Clone the repository
git clone "https://github.com/adamjanos06/LifeAchievements.git"

## 2. Run the bash script
bash start.sh

## 3. Run the migrations and seeders
docker compose exec backend fish
php artisan migrate:fresh --seed

## 4. Log in with either one of the existing users or register a new account
Admin user: 
- email: admin@example.com
- password: admin

Test user:
- email: test@test.com
- password: password
