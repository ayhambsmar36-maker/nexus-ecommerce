# Nexus Commerce Platform

A modern, modular e-commerce platform built with **Laravel 11**, 
**Filament**, and **Laravel Sanctum**. Designed with a 
**Modular Monolith** architecture to support multiple stores, 
product variants, and a full-featured RESTful API.

---

## Overview

Nexus is a production-ready e-commerce backend that provides:

- **Admin Panel** (Filament) for store owners and staff
- **RESTful API** for customers (mobile apps, SPAs)
- **Modular Architecture** for scalability and maintainability
- **Role-Based Access Control** (RBAC) for different user types
- **Multi-Store Ready** (architecture supports it, single-store by default)

---

## Key Features

### 🛍️ Catalog Management
- Hierarchical categories (parent/child)
- Products with multiple attributes (color, size, material, etc.)
- Automatic product variant generation (Cartesian product)
- Per-variant pricing, SKU, and inventory
- Low-stock alerts and stock tracking

### 🛒 Cart System
- Customer-only cart (authentication required)
- Add, update, remove items
- Automatic cart archiving after order
- Quantity validation against stock

### 📦 Order Management
- Order creation from cart with atomic transactions
- Order lifecycle: `pending → paid → shipped → delivered → cancelled`
- Snapshot of product data (name, SKU, price) at purchase time
- Order cancellation with stock restoration
- Bulk order status management via Filament

### 🔐 Authentication & Authorization
- **Sanctum** for customer API authentication (Bearer tokens)
- **Session-based** auth for admin panel (Filament)
- **Role-Based Access Control** (Super Admin, Admin, Staff)
- Custom policies for each resource

### 🎨 Admin Panel (Filament)
- Product, Category, Attribute management
- Order management with status actions
- User & role management
- Dashboard with statistics widgets
- RTL support (Arabic interface)

### 🌐 RESTful API
- Clean JSON responses
- API Resources for consistent formatting
- Custom exceptions with proper HTTP status codes
- Versioned endpoints (`/api/v1/`)
- Search, filter, and pagination support

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| **Framework** | Laravel 11+ |
| **PHP** | 8.2+ |
| **Admin Panel** | Filament 3 |
| **API Auth** | Laravel Sanctum |
| **Modules** | nwidart/laravel-modules |
| **Permissions** | spatie/laravel-permission |
| **Debugging** | Laravel Telescope |
| **Database** | MySQL 8 / PostgreSQL |
| **Queue** | Database (Redis-ready) |
| **Cache** | Database (Redis-ready) |

---

## Architecture

The project follows a **Modular Monolith** architecture:


Each module is self-contained with its own:
- Models, Migrations, Services
- Controllers, Routes, Requests
- Resources, Exceptions

---

## Installation

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 8+ or PostgreSQL
- Node.js 18+ (for Filament assets)

### Setup

```bash
# Clone
git clone https://github.com/ayhambsmar36-maker/nexus-ecommerce-platform.git
cd nexus-commerce-platform

# Install dependencies
composer install
npm install

# Environment
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate
php artisan db:seed

# Filament assets
php artisan filament:assets

# Storage
php artisan storage:link

# Run
php artisan serve
