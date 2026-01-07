# LifeAchievements™ – Fejlesztői dokumentáció

## Tartalomjegyzék
1. [Bevezetés](#bevezetés)
2. [Rendszerarchitektúra](#rendszerarchitektúra)
3. [Használt technológiák](#használt-technológiák)
4. [Projekt struktúra](#projekt-struktúra)
5. [Backend – Laravel API](#backend--laravel-api)
6. [Adatbázis](#adatbázis)
7. [Seederek és gyári adatok](#seederek-és-gyári-adatok)
8. [Frontend – Vue.js alkalmazás](#frontend--vuejs-alkalmazás)
9. [Hitelesítés és token kezelés](#hitelesítés-és-token-kezelés)
10. [Stílusok és témaváltás](#stílusok-és-témaváltás)

---

## Bevezetés

A **LifeAchievements™** egy teljes stack webalkalmazás, amely a játékosított célkövetést támogatja. A rendszer két fő részből áll:

- **Backend** – REST API Laravel keretrendszerben
- **Frontend** – Vue.js alapú többoldalas alkalmazás (routinggal)

A projekt célja egy olyan felület biztosítása, ahol a felhasználók:
- regisztrálhatnak / bejelentkezhetnek,
- böngészhetik a kategóriákat és achievementeket,
- saját teljesítéseket rögzíthetnek,
- megtekinthetik személyes eredményeiket.

---

## Rendszerarchitektúra

A rendszer klasszikus kliens–szerver architektúrát használ:

Frontend (Vue.js) → REST API → Backend (Laravel) → ORM → Adatbázis (MySQL)

---

## Használt technológiák

### Backend
- Laravel 10+
- PHP 8.1+
- MySQL / MariaDB
- Sanctum – token alapú autentikáció

### Frontend
- Vue.js 3 (Composition API)
- Vue Router
- Pinia
- Tailwind CSS
- Axios

---

## Projekt struktúra

### Backend

```
backend/
 ├── app/
 │   ├── Http/
 │   ├── Models/
 │   └── Resources/
 ├── database/
 │   ├── migrations/
 │   ├── seeders/
 │   └── factories/
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
     └── App.vue
```

---

## Backend – Laravel API

### Fontosabb végpontok

| Metódus | URL | Leírás | Auth |
|--------|-----|--------|------|
| POST | /register | Regisztráció | ❌ |
| POST | /login | Bejelentkezés | ❌ |
| GET | /categories | Kategóriák listája | ❌ |
| GET | /achievements | Achievement lista | ❌ |
| POST | /achievements/{id}/complete | Teljesítés | ✔️ |
| GET | /my-achievements | User teljesítései | ✔️ |
| GET | /me | Aktív felhasználó | ✔️ |

---

## Adatbázis

### Táblák
- users
- categories
- achievements
- completed_achievements

`completed_achievements` mezők:
- id
- user_id
- achievement_id
- completion_date
- notes

---

## Seederek és gyári adatok

A `DatabaseSeeder.php` meghívja:
- kategória seedert
- achievement seedert
- optional: tesztfelhasználó

---

## Frontend – Vue.js alkalmazás

Az app oldalszerkezete:
- Landing
- Introduction
- Login / Signup
- Catalog
- Catalog/[id] - ez felel az achievement-ekért kategóriánként
- My Achievements
- Profile

---

## Hitelesítés és token kezelés

Laravel Sanctum kezeli a login után kapott tokent.

Frontend tárolás:

localStorage.setItem("token", token)
axios.defaults.headers.common["Authorization"] = `Bearer ${token}`
![tokenstore](https://cdn.imgchest.com/files/1e6ec7a58c8b.png)

---

## Stílusok és témaváltás

A logóra kattintva vált:
- Light Theme <-> Dark Theme

A Tailwind `dark:` prefix kezeli a sötét módot.

---

---

*A LifeAchievements™ projekt fejlesztéséért és megvalósításáért felelős, Szabó András és Ádám János IKT csapata.*
