# LifeAchievements™ – Developer Documentation

## Table of Contents
1. [Introduction](#introduction)
2. [System Architecture](#system-architecture)
3. [Used Technologies](#used-technologies)
4. [Project Structure](#project-structure)
5. [Backend – Laravel API](#backend--laravel-api)
6. [Database](#database)
7. [Seeders and Factory Data](#seeders-and-factory-data)
8. [Frontend – Vue.js Application](#frontend--vuejs-application)
9. [Authentication and Token Handling](#authentication-and-token-handling)
10. [Styles and Theme Switching](#styles-and-theme-switching)

---

## Introduction

**LifeAchievements™** is a full-stack web application designed to support gamified goal tracking.  
The system consists of two main parts:

- **Backend** – REST API built with the Laravel framework  
- **Frontend** – multi-page application built with Vue.js (with routing)

The goal of the project is to provide a platform where users can:
- register and log in,
- browse categories and achievements,
- record completed achievements,
- view their personal results.

---

## System Architecture

The system uses a classical client–server architecture:

Frontend (Vue.js) → REST API → Backend (Laravel) → ORM → Database (MySQL)

---

## Used Technologies

### Backend
- Laravel 10+
- PHP 8.1+
- MySQL / MariaDB
- Sanctum – token-based authentication

### Frontend
- Vue.js 3 (Composition API)
- Vue Router
- Pinia
- Tailwind CSS
- Axios

---

## Project Structure

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

### Important Endpoints

| Method | URL | Description | Auth |
|--------|-----|-------------|------|
| POST | /register | Registration | ❌ |
| POST | /login | Login | ❌ |
| GET | /categories | List of categories | ❌ |
| GET | /achievements | List of achievements | ❌ |
| POST | /achievements/{id}/complete | Mark achievement completed | ✔️ |
| GET | /my-achievements | User’s completed achievements | ✔️ |
| GET | /me | Active user | ✔️ |

---

## Database

### Tables
- users
- categories
- achievements
- completed_achievements

`completed_achievements` fields:
- id
- user_id
- achievement_id
- completion_date
- notes

---

## Seeders and Factory Data

`DatabaseSeeder.php` calls:
- category seeder
- achievement seeder
- optional: test user seeder

---

## Frontend – Vue.js Application

Application page structure:
- Landing
- Introduction
- Login / Signup
- Catalog
- Catalog/[id] – responsible for category-specific achievements
- My Achievements
- Profile

---

## Authentication and Token Handling

Laravel Sanctum manages the token received after login.

Frontend storage:

```
localStorage.setItem("token", token)
axios.defaults.headers.common["Authorization"] = `Bearer ${token}`
```

---

## Styles and Theme Switching

Clicking the logo switches:
- Light Theme ↔ Dark Theme

Tailwind’s `dark:` prefix controls dark mode styling.

---

*The LifeAchievements™ project was developed and implemented by the IT team of András Szabó and János Ádám.*
