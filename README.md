# Auth API Documentation

## Overview
This is a REST API for user authentication and management built with Laravel and JWT authentication.

## Base URL

## Requirements

- PHP 8.2+
- Composer
- MySQL (or another supported database)

## Quick setup (local / Windows)

1. Clone the repository
   ```sh
   git clone https://github.com/edmofarias/auth-api
   ```

2. Install PHP dependencies
   ```sh
   composer install
   ```

3. Configure environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   php artisan jwt:secret
   ```

5. Configure the database
   - Edit the .env file and update DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD.

6. Run migrations (and optionally seed)
   ```sh
   php artisan migrate
   ```

7. Run the app locally
   ```sh
   php artisan serve
   ```
   By default the app will be available at http://127.0.0.1:8000.

## Running tests

- Use the Artisan test runner:
  ```sh
  php artisan test
  ```

## Endpoints

### Authentication

#### 1. Register User
**POST** `/register`

Register a new user account.

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response:**
```json
{
  "message": "User successfully registered",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
}
```

**Status Code:** `200 OK`

**Authentication Required:** ❌ No

---

#### 2. Login User
**POST** `/login`

Authenticate user and receive JWT token.

**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response:**
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "token_type": "bearer"
}
```

**Status Code:** `200 OK`

**Error Response:**
```json
{
  "error": "Invalid credentials"
}
```
**Status Code:** `401 Unauthorized`

**Authentication Required:** ❌ No

---

#### 3. Logout User
**POST** `/logout`

Invalidate JWT token and logout user.

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "message": "User successfully logged out"
}
```

**Status Code:** `200 OK`

**Authentication Required:** ✅ Yes

---

### User Management

#### 4. Get User
**GET** `/user/{userId}`

Retrieve user information by ID.

**Path Parameters:**
- `userId` (required): User ID

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "created_at": "2025-11-27T10:00:00Z",
  "updated_at": "2025-11-27T10:00:00Z"
}
```

**Status Code:** `200 OK`

**Error Response:**
```json
{
  "error": "User not found or unauthorized"
}
```
**Status Code:** `404 Not Found`

**Authentication Required:** ✅ Yes

---

#### 5. Update User
**PUT** `/user/{userId}`

Update user information.

**Path Parameters:**
- `userId` (required): User ID

**Request Body:**
```json
{
  "name": "Jane Doe",
  "email": "jane@example.com"
}
```

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "id": 1,
  "name": "Jane Doe",
  "email": "jane@example.com",
  "created_at": "2025-11-27T10:00:00Z",
  "updated_at": "2025-11-27T11:30:00Z"
}
```

**Status Code:** `200 OK`

**Error Response:**
```json
{
  "error": "User not found or unauthorized"
}
```
**Status Code:** `404 Not Found`

**Authentication Required:** ✅ Yes

---

#### 6. Delete User
**DELETE** `/user/{userId}`

Delete a user account.

**Path Parameters:**
- `userId` (required): User ID

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "message": "User deleted successfully"
}
```

**Status Code:** `200 OK`

**Error Response:**
```json
{
  "error": "User not found or unauthorized"
}
```
**Status Code:** `404 Not Found`

**Authentication Required:** ✅ Yes

---

## Error Handling

All errors follow this format:
```json
{
  "error": "Error message description"
}
```

Common HTTP Status Codes:
- `200 OK` - Request successful
- `400 Bad Request` - Invalid request data
- `401 Unauthorized` - Missing or invalid JWT token
- `404 Not Found` - Resource not found
- `500 Internal Server Error` - Server error

---


The API will be available at `http://localhost:8000/api`


