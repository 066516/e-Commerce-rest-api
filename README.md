# Laravel E-commerce Project

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

## Project Overview

This project is a full-featured e-commerce web application built using the Laravel PHP framework. It aims to provide a robust platform for online shopping, equipped with essential features to manage products, orders, customers, and more.

## Features

- **Product Management**: Easily add, edit, and manage products with detailed information such as pricing, descriptions, and categories.
- **Order Processing**: Seamless handling of customer orders with features for order status updates, invoices, and customer notifications.
- **User Authentication**: Secure user registration and authentication system.
- **Shopping Cart**: Persistent shopping cart functionality for users to add and manage items before checkout.
- **Payment Integration**: Integration with popular payment gateways for seamless transactions.
- **Admin Dashboard**: Comprehensive dashboard for administrators to monitor sales, manage inventory, and view analytics.

## Getting Started

Follow these instructions to set up and run the project on your local machine.

### Prerequisites

- PHP >= 7.4
- Composer
- MySQL or another compatible database system

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/your-repository.git
   cd your-repository
   ```
2.Install PHP dependencies:
   run
 ```bash
 composer install
```
3.Set up your environment variables:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ecommerce_db
DB_USERNAME=root
DB_PASSWORD=

```
4.Generate application key:

```bash
php artisan key:generate
```
5.Run database migrations and seeders:

```bash
php artisan migrate --seed
```
6.Start the development server:

```bash
php artisan serve
```
7.Access the application:
Open your web browser and navigate to http://localhost:8000.

