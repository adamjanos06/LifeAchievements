# 🌟 LifeAchievements™ – Developer Documentation

## Table of Contents
1. [Introduction](#introduction)
2. [System Architecture](#system-architecture)
3. [Technologies Used](#technologies-used)
4. [Project Structure](#project-structure)
5. [Backend – Laravel API](#backend--laravel-api)
6. [Database](#database)
7. [Seeders and Initial Data](#seeders-and-initial-data)
8. [Frontend – Vue.js Application](#frontend--vuejs-application)
9. [State Management and Logic](#state-management)
10. [Authentication and Token Handling](#authentication)
11. [New Systems](#new-systems)
12. [UI/UX and Theme Switching](#ui-ux-and-theme-switching)

---

## Introduction

**LifeAchievements™** is a full-stack web application that supports gamified goal tracking.

The goal of the system:
- tracking life goals
- increasing motivation
- providing social features

The project consists of two main parts:
- **Backend** – Laravel REST API
- **Frontend** – Vue.js SPA

---

## System Architecture

The system uses a classic client–server architecture:

Frontend (Vue 3) --> REST API (Laravel) --> Eloquent ORM --> MySQL database

- JSON-based communication
- Bearer token authentication

---

## Technologies Used

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

## Project Structure

### Backend

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

### Main Endpoints

| Method | Endpoint | Description | Auth |
|--------|--------|--------|------|
| POST | /register | Registration | ❌ |
| POST | /login | Login | ❌ |
| GET | /categories | Categories | ❌ |
| GET | /achievements | Achievement list | ❌ |
| POST | /achievements/{id}/complete | Completion | ✔️ |
| GET | /my-achievements | User achievements | ✔️ |
| GET | /goals | Goals list | ✔️ |
| POST | /goals/{achievement} | Save | ✔️ |
| DELETE | /goals/{achievement} | Delete | ✔️ |
| GET | /friends | Friends | ✔️ |
| GET | /friend-requests | Requests | ✔️ |
| POST | /friends | Send request | ✔️ |
| POST | /friend-requests/{id}/accept | Accept | ✔️ |
| DELETE | /friend-requests/{id} | Delete | ✔️ |
| GET | /leaderboard | Leaderboard | ❌ |
| GET | /me | Active user | ✔️ |

---

## Database

### Tables
- users
- categories
- achievements
- completed_achievements
- goals
- friend_requests
- badges
- badge_user

`completed_achievements` fields:
- id
- user_id
- achievement_id
- completion_date
- notes

---

## Seeders and Initial Data

`DatabaseSeeder.php` calls:
- CategorySeeder (colors + icons)
- AchievementSeeder
- test users

---

## Frontend – Vue.js Application

Application pages:
- Landing
- Login / Signup
- Catalog
- Catalog/[id] - responsible for achievements by category
- My Achievements
- Goals
- Leaderboard
- Profile

---

## State Management

- `ref()` and `computed()`
- component-based state
- localStorage

---

## Authentication

Laravel Sanctum handles the token after login.

Token storage:

localStorage.setItem("token", token)

Header:

Authorization: Bearer {token}

---

## New Systems

### 🎯 Goals
- save achievements
- remove functionality
- auto removal on completion

---

### 👥 Friends
- request system
- incoming / outgoing
- accept / cancel

---

### 🏆 Leaderboard
- XP-based ranking
- top users

---

### 🏅 Badge system
- backend-triggered
- frontend popup
- event-based

---

## UI-UX and Theme Switching

### Dark mode
- `html.dark`
- Tailwind `dark:` prefix

---

### UI features
- modal-based interaction
- dynamic colors
- hover effects
- scroll panels

---

### UX
- empty states
- feedback
- animations

---

## Summary

✔ full-stack system  
✔ REST API + SPA  
✔ gamification  
✔ social features  
✔ scalable architecture  

---

## 👨‍💻 Developers

- András Szabó
- Bernát Nagy
- János Ádám
---

*A LifeAchievements™ projekt fejlesztéséért és megvalósításáért felelős, Szabó András és Ádám János IKT csapata.*
