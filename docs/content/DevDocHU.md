# 🌟 LifeAchievements™ – Fejlesztői dokumentáció

## Tartalomjegyzék
1. [Bevezetés](#bevezetés)
2. [Rendszerarchitektúra](#rendszerarchitektúra)
3. [Használt technológiák](#használt-technológiák)
4. [Projekt struktúra](#projekt-struktúra)
5. [Backend – Laravel API](#backend--laravel-api)
6. [Adatbázis](#adatbázis)
7. [Seederek és gyári adatok](#seederek-és-gyári-adatok)
8. [Frontend – Vue.js alkalmazás](#frontend--vuejs-alkalmazás)
9. [Állapotkezelés és logika](#állapotkezelés)
10. [Hitelesítés és token kezelés](#hitelesítés)
11. [Új rendszerek](#új-rendszerek)
12. [UI/UX és témaváltás](#ui-ux-és-témaváltás)

---

## Bevezetés

A **LifeAchievements™** egy full-stack webalkalmazás, amely a játékosított célkövetést támogatja.

A rendszer célja:
- életcélok nyomonkövetése
- motiváció növelése
- közösségi funkciók biztosítása

A projektnek két fő része van:
- **Backend** – Laravel REST API
- **Frontend** – Vue.js SPA

---

## Rendszerarchitektúra

A rendszer klasszikus kliens–szerver architektúrát használ:

Frontend (Vue 3) --> REST API (Laravel) --> Eloquent ORM --> MySQL adatbázis

- JSOn alapú komunikáció
- Bearer token autentikáció

---

## Használt technológiák

### Backend
- Laravel 10+
- PHP 8.1+
- MySQL / MariaDB
- Laravel Sanctum

### Frontend
- Vue.js 3 (Composition API)
- Vue Router
- Tailwind CSS
- Fetch API
- localStorage

---

## Projekt struktúra

### Backend

```
backend/
 ├── app/
 │   ├── Http/Controllers/
 │   ├── Models/
 │   └── Resources/
 ├── database/
 │   ├── migrations/
 │   ├── seeders/
 ├── routes/api.php
 └── composer.json
```

### Frontend

```
frontend/
 ├── src/
 ├── components/
 ├── layouts/
 ├── pages/
 ├── router/
 ├── utils/
 └── App.vue
```

---

## Backend – Laravel API

### Fontosabb végpontok

| Method | Endpoint | Leírás | Auth |
|--------|--------|--------|------|
| POST | /register | Regisztráció | ❌ |
| POST | /login | Login | ❌ |
| GET | /categories | Kategóriák | ❌ |
| GET | /achievements | Achievement lista | ❌ |
| POST | /achievements/{id}/complete | Teljesítés | ✔️ |
| GET | /my-achievements | Saját achievementek | ✔️ |
| GET | /goals | Goals lista | ✔️ |
| POST | /goals/{achievement} | Mentés | ✔️ |
| DELETE | /goals/{achievement} | Törlés | ✔️ |
| GET | /friends | Barátok | ✔️ |
| GET | /friend-requests | Kérések | ✔️ |
| POST | /friends | Request küldés | ✔️ |
| POST | /friend-requests/{id}/accept | Elfogadás | ✔️ |
| DELETE | /friend-requests/{id} | Törlés | ✔️ |
| GET | /leaderboard | Ranglista | ❌ |
| GET | /me | Aktív user | ✔️ |

---

## Adatbázis

### Táblák
- users
- categories
- achievements
- completed_achievements
- goals
- friend_requests
- badges
- badge_user

`completed_achievements` mezők:
- id
- user_id
- achievement_id
- completion_date
- notes

---

## Seederek és gyári adatok

A `DatabaseSeeder.php` meghívja:
- CategorySeeder (színek + ikonok)
- AchievementSeeder
- teszt felhasználók

---

## Frontend – Vue.js alkalmazás

Az app oldalszerkezete:
- Landing
- Login / Signup
- Catalog
- Catalog/[id] - ez felel az achievement-ekért kategóriánként
- My Achievements
- Goals
- Leaderboard
- Profile

---

## Állapotkezelés

- `ref()` és `computed()`
- komponens alapú state
- localStorage

---

## Hitelesítés

Laravel Sanctum kezeli a login után kapott tokent.

Token tárolás:

localStorage.setItem("token", token)

Header:

Authorization: Bearer {token}

---

## Új rendszerek

### 🎯 Goals
- achievement mentés
- remove funkció
- auto törlés completionkor

---

### 👥 Friends
- request rendszer
- incoming / outgoing
- accept / cancel

---

### 🏆 Leaderboard
- XP alapú rangsor
- top felhasználók

---

### 🏅 Badge rendszer
- backend trigger
- frontend popup
- esemény alapú

---

## UI-UX és témaváltás

### Dark mode
- `html.dark`
- Tailwind `dark:` prefix

---

### UI jellemzők
- modal alapú működés
- dinamikus színek
- hover effektek
- scroll panelek

---

### UX
- empty state-ek
- visszajelzések
- animációk

---

## Összegzés

✔ full-stack rendszer
✔ REST API + SPA
✔ gamification
✔ social feature-ök
✔ skálázható architektúra

---

## 👨‍💻 Fejlesztők

- Szabó András
- Nagy Bernát
- Ádám János
---

*A LifeAchievements™ projekt fejlesztéséért és megvalósításáért felelős, Szabó András és Ádám János IKT csapata.*
