# Admin API Documentation

This document describes the admin API endpoints for managing database tables and records, similar to phpMyAdmin.

## Setup

### 1. Create an Admin User
Run the admin seeder to create a test admin user:
```bash
php artisan db:seed --class=AdminSeeder
```

**Default admin credentials:**
- Email: `admin@example.com`
- Password: `password`

⚠️ **IMPORTANT:** Change the admin password immediately in production!

### 2. Authenticate
Login with admin credentials to get a token:
```bash
POST /api/login
{
    "email": "admin@example.com",
    "password": "password"
}
```

Include the token in the `Authorization: Bearer {token}` header for all admin requests.

---

## API Endpoints

### Base URL
All admin endpoints are prefixed with `/api/admin/`

### 1. Get All Tables
Returns a list of all available tables and their record counts.

```
GET /api/admin/tables
Authorization: Bearer {token}
```

**Response:**
```json
{
    "data": [
        {
            "name": "users",
            "count": 5
        },
        {
            "name": "achievements",
            "count": 12
        },
        {
            "name": "categories",
            "count": 3
        }
    ]
}
```

---

### 2. Get Table Structure
Returns column information for a specific table.

```
GET /api/admin/tables/{table}/structure
```

**Parameters:**
- `table` (string): Table name (e.g., `users`, `achievements`, `categories`, `badges`, `completed_achievements`, `goals`, `friend_requests`)

**Response:**
```json
{
    "table": "users",
    "columns": [
        "id",
        "name",
        "email",
        "password",
        "xp",
        "isAdmin",
        "bio",
        "image",
        "created_at",
        "updated_at"
    ],
    "fillable": [
        "name",
        "email",
        "password",
        "xp",
        "bio",
        "image",
        "isAdmin"
    ]
}
```

---

### 3. Get Table Records (with Pagination & Search)
Returns paginated records from a specific table.

```
GET /api/admin/tables/{table}/records
Authorization: Bearer {token}
```

**Query Parameters:**
- `table` (string): Table name
- `per_page` (integer, default: 15): Records per page
- `page` (integer, default: 1): Page number
- `search` (string): Search across text columns
- `sort_by` (string, default: id): Column to sort by
- `sort_order` (string, default: asc): `asc` or `desc`

**Example:**
```
GET /api/admin/tables/users/records?per_page=10&page=1&search=admin&sort_by=name&sort_order=asc
```

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "name": "Admin User",
            "email": "admin@example.com",
            "xp": 0,
            "isAdmin": true,
            "bio": "System Administrator",
            "image": null,
            "created_at": "2024-01-15T10:30:00Z",
            "updated_at": "2024-01-15T10:30:00Z"
        }
    ],
    "columns": [
        "id",
        "name",
        "email",
        "password",
        "xp",
        "isAdmin",
        "bio",
        "image",
        "created_at",
        "updated_at"
    ],
    "pagination": {
        "total": 5,
        "per_page": 10,
        "current_page": 1,
        "last_page": 1
    }
}
```

---

### 4. Get Single Record
Returns details for a specific record.

```
GET /api/admin/tables/{table}/records/{id}
Authorization: Bearer {token}
```

**Parameters:**
- `table` (string): Table name
- `id` (integer): Record ID

**Response:**
```json
{
    "data": {
        "id": 1,
        "name": "Admin User",
        "email": "admin@example.com",
        "xp": 0,
        "isAdmin": true,
        "created_at": "2024-01-15T10:30:00Z",
        "updated_at": "2024-01-15T10:30:00Z"
    },
    "columns": ["id", "name", "email", "password", "xp", "isAdmin", "bio", "image", "created_at", "updated_at"]
}
```

---

### 5. Create New Record
Creates a new record in a table.

```
POST /api/admin/tables/{table}/records
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "New User",
    "email": "newuser@example.com",
    "password": "securepassword",
    "xp": 100,
    "isAdmin": false,
    "bio": "A new user"
}
```

**Response:**
```json
{
    "message": "Record created successfully",
    "data": {
        "id": 6,
        "name": "New User",
        "email": "newuser@example.com",
        "xp": 100,
        "isAdmin": false,
        "created_at": "2024-01-15T11:00:00Z",
        "updated_at": "2024-01-15T11:00:00Z"
    }
}
```

---

### 6. Update Record
Updates an existing record.

```
PUT /api/admin/tables/{table}/records/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "Updated Name",
    "xp": 150
}
```

**Parameters:**
- `table` (string): Table name
- `id` (integer): Record ID

**Response:**
```json
{
    "message": "Record updated successfully",
    "data": {
        "id": 6,
        "name": "Updated Name",
        "email": "newuser@example.com",
        "xp": 150,
        "isAdmin": false,
        "created_at": "2024-01-15T11:00:00Z",
        "updated_at": "2024-01-15T11:05:00Z"
    }
}
```

---

### 7. Delete Record
Deletes a record from a table.

```
DELETE /api/admin/tables/{table}/records/{id}
Authorization: Bearer {token}
```

**Parameters:**
- `table` (string): Table name
- `id` (integer): Record ID

**Response:**
```json
{
    "message": "Record deleted successfully"
}
```

---

## Available Tables

| Table Name | Model | Fillable Fields |
|---|---|---|
| `users` | `User` | name, email, password, xp, bio, image, isAdmin |
| `categories` | `Category` | name, description, icon, color |
| `achievements` | `Achievement` | category_id, name, description, xp, difficulty, repeatable |
| `badges` | `Badge` | name, description, requirement_text |
| `completed_achievements` | `CompletedAchievement` | user_id, achievement_id, completion_date, notes, completions |
| `goals` | `Goal` | user_id, achievement_id |
| `friend_requests` | `friend_request` | sender_id, receiver_id, status |

---

## Error Handling

### Unauthorized (Not Admin)
```json
{
    "message": "Unauthorized. Admin access required."
}
```
Status: `403`

### Table Not Found
```json
{
    "error": "Table not found"
}
```
Status: `404`

### Record Not Found
```json
{
    "error": "Record not found"
}
```
Status: `404`

---

## Usage Examples

### Example 1: Get all users with admin status
```bash
curl -X GET "http://localhost:8000/api/admin/tables/users/records" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json"
```

### Example 2: Search for achievements by name
```bash
curl -X GET "http://localhost:8000/api/admin/tables/achievements/records?search=badge&per_page=20" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Example 3: Create a new category
```bash
curl -X POST "http://localhost:8000/api/admin/tables/categories/records" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Sports",
    "description": "Sports-related achievements",
    "icon": "sports",
    "color": "#FF5733"
  }'
```

### Example 4: Edit a user (set admin)
```bash
curl -X PUT "http://localhost:8000/api/admin/tables/users/records/2" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "isAdmin": true
  }'
```

### Example 5: Delete a record
```bash
curl -X DELETE "http://localhost:8000/api/admin/tables/achievements/records/5" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## Security Notes

1. **Admin-only access:** All admin endpoints require authentication and `isAdmin` flag set to `true`
2. **Password handling:** Passwords are hashed and will not be shown in responses
3. **Token-based auth:** Use Sanctum tokens for API authentication
4. **Sensitive fields:** Some columns (like `remember_token`) are automatically excluded from search

---

## Notes for Frontend Integration

The frontend should:
1. Display a list of available tables from `/api/admin/tables`
2. Allow selection of a table to view records via `/api/admin/tables/{table}/records`
3. Show pagination controls for navigation
4. Provide search/filter functionality
5. Show edit/delete buttons for each record
6. Have an "Add New" button that calls the create endpoint
7. Handle sorting by column name via `sort_by` and `sort_order` parameters
