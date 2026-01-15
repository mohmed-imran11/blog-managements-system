# How to Create a Blog PHP & MySQL database

# PROJECT NAME: Blog Website Management System

# Structure folders

php-blog-website-main/
├── \_db/
│ └── blog_db.sql #Database dump (MySQL)
├── admin/ # Admin Dashboard
│ ├── data/ # CRUD Functions
│ │ ├── Category.php
│ │ ├── Comment.php
│ │ ├── Post.php
│ │ └── User.php
│ ├── inc/ # Admin Templates
│ │ ├── index.php
│ │ └── side-nav.php
│ ├── admin-login.php
│ ├── category-add.php
│ ├── category-edit.php
│ ├── post-add.php
│ ├── post-edit.php
│ └── ... (faylal kale oo admin ah)
├── css/ # Stylesheets
├── img/ # Static images
├── inc/ # Frontend shared templates
│ └── NavBar.php
├── js/ # JavaScript files
├── php/ # Backend Logic
│ ├── auth.php
│ ├── comment.php
│ ├── login.php
│ └── signup.php
├── uploads/ # Uploaded images (posts)
├── blog.php # Blog posts listing page
├── db_conn.php # PHP & MySQL connection
├── index.php # Home page
├── login.php # User login page
└── signup.php # User registration page

# PROJECT DESCRIPTION:

This project is a Blog Website Management System developed using PHP and MySQL.
The system implements role-based access control by separating users into
Admin and User roles to ensure proper content management and security.

Only the Admin has permission to create, edit, and delete blog posts.
Regular Users are allowed to view posts, like posts, and add comments.

# FEATURES:

# 1. Users & Roles

- User registration and login system
- Role-based access (Admin and User)

# 2. Posts

- Create posts (Admin only)
- Edit posts (Admin only)
- Delete posts (Admin only)
- View posts (Admin & Users)

# 3. Post Likes

- Users can like posts
- One like per user per post
- Like counter for each post

# 4. Comments

- Users can add comments to posts
- View comments related to each post

# 5. Categories

- Admin can create categories
- Posts are assigned to categories
- View posts by category

# DATABASE TABLES:

- users (admin, user)
- posts
- post_likes
- comments
- categories

# TECHNOLOGIES USED:

- PHP
- MySQL
- HTML
- CSS
- Bootstrap
- JavaScript

# SECURITY FEATURES:

- Password hashing
- Session-based authentication
- Role-based authorization

# PROJECT PURPOSE:

The purpose of this project is to build a secure and user-friendly blog website
with structured content management, allowing admins to publish posts while
users interact through likes and comments.

# go to browser:

http://localhost/php-blog-website-main/php-blog-website-main/

## Member group project

## CLASS NO: CA224

## NAME : ID :

Mohamed Imraan Hassan =============== C1220418
Anas Abdi Daahir ==================== C1221021
Anas Mohamed Ga'al ================== C1221236
Shafi'i Mohamed Ali ================= C1220425
