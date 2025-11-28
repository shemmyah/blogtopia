# 🌸 Blogtopia — A Simple & Clean Blogging Platform

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-ff2d20?style=for-the-badge&logo=laravel" />
  <img src="https://img.shields.io/badge/PHP-8.x-8892bf?style=for-the-badge&logo=php" />
  <img src="https://img.shields.io/badge/MySQL-5.x-00758f?style=for-the-badge&logo=mysql" />
</p>

Blogtopia is a modern and minimal blogging platform built with **Laravel**.
It allows users to write posts, customize profiles, and enjoy a clean, distraction-free blogging experience.

---

## ✨ Features

- 📝 Create, edit & delete posts  
- 🔒 Public & private posts  
- 👤 User profiles (avatar, header, bio)  
- ❤️ Likes & interactions  
- 🔔 Notification system  
- 🖼️ Image uploads  
- 📱 Fully responsive  
- 📄 Pagination for posts  
- 🎨 Clean and simple UI  

---

## 🛠 Tech Stack

| Technology | Purpose |
|-----------|---------|
| **Laravel 11** | Backend framework |
| **Blade Templates** | Templating engine |
| **Bootstrap / Tailwind** | UI styling |
| **MySQL** | Database |
| **Laravel Auth** | User authentication |

---

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/shemmyah/blogtopia.git
cd blogtopia
```
### 2. Install Dependencies
```bash
composer install
npm install
```
### 3. Build Frontend Assets
```bash
npm run build
```
### 4. Create Environment File
```bash
cp .env.example .env
php artisan key:generate
```
### 5. Configure Database in .env
```bash
DB_DATABASE=blogtopia
DB_USERNAME=root
DB_PASSWORD=
```
### 6. Run Migrations
```bash
php artisan migrate
```
### 7. Start the Application
```bash
php artisan serve
```

## 📸 Screenshots

<p align="center">
  <img src="screenshots/home.png" width="30%" />
  <img src="screenshots/home2.png" width="30%" />
  <img src="screenshots/post-show.png" width="30%" />
</p>

<p align="center">
  <img src="screenshots/post-show.png" width="30%" />
  <img src="screenshots/post-show-drop.png" width="30%" />
  <img src="screenshots/post-show-comment.png" width="30%" />
</p>



