<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Side to Side Web Dashboard

## Overview
The "Side to Side" web dashboard is an administrative platform for managing game-related content, advertisements, user interactions, and statistics. It provides an intuitive interface for administrators to control and customize different aspects of the "Side to Side" game while ensuring smooth user engagement.

## Features

### 1. **User & Team Management**
- View and manage registered users.
- Add, edit, and remove team members.
- Assign roles and permissions.

### 2. **Content Management**
- Control and organize game-related content blocks.
- Manage blog posts, articles, and updates.
- Upload images and customize displayed content.

### 3. **Advertisements & Sponsorships**
- Create, manage, and display sponsored ads.
- Track ad performance and engagement.

### 4. **Game Features Control**
- Modify reward system settings.
- Manage leaderboard functionality.
- Customize skins, backgrounds, and trophies.

### 5. **Dashboard Statistics & Analytics**
- Monitor total visits, daily visits, and total downloads.
- Track the number of active users and new users per month.

### 6. **Post & Blog Management**
- Add and manage game-related posts.
- Edit and delete existing posts.
- View all published content.

## Technologies Used
- **Backend**: Laravel (PHP Framework)
- **Frontend**: HTML, CSS, JavaScript
- **Database**: MySQL
- **Version Control**: Git

## Installation Guide
### Prerequisites:
- PHP 8+
- Composer
- Node.js & NPM
- MySQL Database

### Setup Steps:
1. Clone the repository:
   ```sh
   git clone https://github.com/your-repo/side-to-side-dashboard.git
   cd side-to-side-dashboard
   ```
2. Install dependencies:
   ```sh
   composer install
   npm install
   ```
3. Copy the environment file:
   ```sh
   cp .env.example .env
   ```
4. Generate the application key:
   ```sh
   php artisan key:generate
   ```
5. Configure database settings in `.env`.
6. Run migrations and seed data:
   ```sh
   php artisan migrate --seed
   ```
7. Start the development server:
   ```sh
   php artisan serve
   ```

## Screenshots
Below are some screenshots illustrating different sections of the dashboard:

- **Admin Dashboard Overview**
- **User & Team Management**
- **Advertisements Management**
- **Game Content Control (Rewards, Leaderboards, Skins, etc.)**
- **Blog & Post Management**

## Conclusion
This project provides a robust and scalable dashboard for managing various aspects of the "Side to Side" game, ensuring easy content customization, user engagement, and advertisement handling.

