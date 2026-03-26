# Admin Backend Setup - Quick Start Guide

## What Was Added

I've created a complete **phpMyAdmin-like admin backend** for managing your database tables and records. Here's what's now available:

### 1. **Files Created/Modified**

#### New Files:
- `app/Http/Middleware/IsAdmin.php` - Middleware to protect admin routes
- `app/Http/Controllers/AdminController.php` - Main controller handling CRUD operations
- `database/seeders/AdminSeeder.php` - Seeder to create test admin user
- `ADMIN_API.md` - Complete API documentation

#### Modified Files:
- `app/Models/User.php` - Added `isAdmin` to fillable and casts
- `bootstrap/app.php` - Registered `IsAdmin` middleware
- `routes/api.php` - Added admin route group with all CRUD endpoints

### 2. **Key Features**

✅ **Admin Access Control** - Only users with `isAdmin = true` can access admin endpoints  
✅ **Table Browsing** - View all available tables with record counts  
✅ **Record Management** - CRUD operations (Create, Read, Update, Delete) for any table  
✅ **Pagination** - Get 15 records per page by default, fully configurable  
✅ **Search** - Search across text columns in any table  
✅ **Sorting** - Sort by any column in ascending or descending order  
✅ **Generic API** - Single controller handles all 7 tables without duplication  
✅ **Error Handling** - Proper HTTP status codes and error messages  

### 3. **Available Admin Endpoints**

```
GET    /api/admin/tables              - List all tables
GET    /api/admin/tables/{table}/structure - Get table schema
GET    /api/admin/tables/{table}/records - Get paginated records (with search/sort)
GET    /api/admin/tables/{table}/records/{id} - Get single record
POST   /api/admin/tables/{table}/records - Create new record
PUT    /api/admin/tables/{table}/records/{id} - Update record
DELETE /api/admin/tables/{table}/records/{id} - Delete record
```

### 4. **Managed Tables**

- `users` - User accounts
- `categories` - Achievement categories
- `achievements` - Achievements catalog
- `badges` - Badges/rewards
- `completed_achievements` - User achievement progress
- `goals` - User achievement goals
- `friend_requests` - Friend connection requests

---

## How to Get Started

### Step 1: Create an Admin User
```bash
php artisan db:seed --class=AdminSeeder
```

**Login with:**
- Email: `admin@example.com`
- Password: `password`

⚠️ **Change this password immediately!**

### Step 2: Login to Get Token
```bash
curl -X POST "http://localhost:8000/api/login" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@example.com",
    "password": "password"
  }'
```

You'll get back:
```json
{
    "data": {
        "id": 1,
        "email": "admin@example.com",
        ...
    },
    "authorization": {
        "token": "YOUR_TOKEN_HERE",
        "type": "bearer"
    }
}
```

### Step 3: Use Admin API
Include the token in all admin requests:
```bash
Authorization: Bearer YOUR_TOKEN_HERE
```

### Step 4: Check Available Tables
```bash
curl -X GET "http://localhost:8000/api/admin/tables" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## Example API Calls

### Get All Users
```bash
GET /api/admin/tables/users/records
```

### Search for User
```bash
GET /api/admin/tables/users/records?search=admin&per_page=10
```

### Get Single User
```bash
GET /api/admin/tables/users/records/1
```

### Create Achievement
```bash
POST /api/admin/tables/achievements/records
{
    "category_id": 1,
    "name": "First Win",
    "description": "Win your first game",
    "xp": 50,
    "difficulty": "easy",
    "repeatable": false
}
```

### Edit User (Make Admin)
```bash
PUT /api/admin/tables/users/records/2
{
    "isAdmin": true
}
```

### Delete Achievement
```bash
DELETE /api/admin/tables/achievements/records/5
```

---

## Database Tables & Their Fillable Fields

| Table | Fillable Fields |
|-------|---|
| `users` | name, email, password, xp, bio, image, isAdmin |
| `categories` | name, description, icon, color |
| `achievements` | category_id, name, description, xp, difficulty, repeatable |
| `badges` | name, description, requirement_text |
| `completed_achievements` | user_id, achievement_id, completion_date, notes, completions |
| `goals` | user_id, achievement_id |
| `friend_requests` | sender_id, receiver_id, status |

---

## Security Notes

1. **Admin Middleware** enforces `isAdmin` check on all admin endpoints
2. **Passwords** are hashed and excluded from API responses
3. **Search excludes** sensitive fields automatically
4. **Token-based** authentication via Sanctum
5. **HTTP Status Codes** indicate success/failure clearly:
   - `200` - Success
   - `201` - Created
   - `404` - Not Found
   - `403` - Unauthorized

---

## Next Steps for Frontend

The frontend should:
1. Show login form to get authentication token
2. Display list of tables from `/api/admin/tables` in a left sidebar
3. When user clicks a table, fetch records from `/api/admin/tables/{table}/records`
4. Show pagination controls and sort options
5. Display search box for table search
6. Add buttons for:
   - **Edit** - Opens form with current data, POSTs to `PUT /api/admin/tables/{table}/records/{id}`
   - **Delete** - Calls `DELETE /api/admin/tables/{table}/records/{id}`
   - **Add New** - Form to `POST /api/admin/tables/{table}/records`

---

## Full Documentation

See `ADMIN_API.md` for complete API documentation with examples.
