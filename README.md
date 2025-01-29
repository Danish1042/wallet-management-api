# Simple Wallet Management API

## 📌 Overview
This is a **Simple Wallet Management API** built with **Laravel 11** and **PHP 8.2**. It allows users to create wallets, deposit/withdraw funds, transfer money between users, and fetch transaction histories via a RESTful API.

---

## 🚀 Features
- **User Management** (Create User, Get User Details)
- **Wallet Operations** (Deposit, Withdraw)
- **Transaction Handling** (Fund Transfers, Fetch Transaction History)
- **Error Handling** (Validation, Insufficient Funds Handling)
- **Database Transactions** to ensure data integrity
- **Eloquent Models & MySQL Storage**

---

## 🛠️ Tech Stack
- **Laravel 11**
- **PHP 8.2**
- **MySQL**
- **Eloquent ORM**
- **Postman API Documentation**

---

## 📥 Installation Guide

### Step 1: Clone the Repository
```sh
git clone https://github.com/Danish1042/wallet-management-api
cd wallet-management-api
```

### Step 2: Install Dependencies
```sh
composer install
```

### Step 3: Set Up Environment Variables
Copy the `.env.example` file and rename it to `.env`:
```sh
cp .env.example .env
```
Update your database credentials inside `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wallet_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Step 4: Generate Application Key
```sh
php artisan key:generate
```

### Step 5: Run Migrations
```sh
php artisan migrate
```

### Step 6: Serve the Application
```sh
php artisan serve
```
API is now available at: **`http://127.0.0.1:8000/api/`**

---

## 📖 API Documentation

### 🧑 User APIs

#### 1️⃣ Create a User
**Endpoint:** `POST /api/users`
```json
{
  "name": "John Doe",
  "initial_balance": 1000
}
```
**Response:**
```json
{
  "status": true,
  "message": "User created successfully",
  "user": {
    "id": 1,
    "name": "John Doe",
    "balance": 1000
  }
}
```

#### 2️⃣ Get User Details
**Endpoint:** `GET /api/users/{id}`

---

### 💰 Wallet APIs

#### 3️⃣ Deposit Funds
**Endpoint:** `POST /api/wallets/{userId}/deposit`
```json
{
  "amount": 500
}
```

#### 4️⃣ Withdraw Funds
**Endpoint:** `POST /api/wallets/{userId}/withdraw`
```json
{
  "amount": 200
}
```

---

### 🔄 Transactions APIs

#### 5️⃣ Transfer Funds Between Users
**Endpoint:** `POST /api/transactions/transfer`
```json
{
  "from_user_id": 1,
  "to_user_id": 2,
  "amount": 300
}
```

#### 6️⃣ Get User Transactions
**Endpoint:** `GET /api/transactions/{userId}`

---

## 🛠️ Error Handling
- **Invalid User ID:** `404 Not Found`
- **Insufficient Funds:** `400 Bad Request`
- **Database Errors:** `500 Internal Server Error`

---

## ✅ Best Practices Followed
- **Database Transactions (`DB::transaction`)** to ensure atomicity
- **Request Validation (`FormRequest` classes)** to enforce proper input
- **Eloquent ORM** for cleaner database interactions
- **Consistent API Response Structure**

---

## 📌 Postman Collection
You can import the Postman Collection from the provided **`postman_collection.json`** file.

---

## 📝 License
This project is **open-source** and free to use.

---

## 📞 Support & Contact
For any issues or feature requests, please create an issue in the repository.

---

🚀 **Now your Laravel Wallet Management API is ready to use!** 🚀

