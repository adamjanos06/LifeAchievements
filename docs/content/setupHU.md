## 1. Másold le a felhőből
git clone "https://github.com/adamjanos06/LifeAchievements.git"

## 2. Futtasd a bash parancsot
bash start.sh

## 3. RFuttasd a migrációs és seeder fájlokat
docker compose exec backend fish
php artisan migrate:fresh --seed

## 4. Lépj be egy már meglévő fiókkal vagy regisztálj egy új felhasználót
Admin user: 
    email: admin@example.com
    password: admin
Test user:
    email: test@test.com
    password: password
