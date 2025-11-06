# Digi - Modular E-commerce Platform

Digi is a modern, modular e-commerce platform built with Laravel 12 and PHP 8.2+. It follows a modular architecture using the `nwidart/laravel-modules` package, making it highly scalable and maintainable.

## Table of Contents

- [Digi - Modular E-commerce Platform](#digi---modular-e-commerce-platform)
  - [Table of Contents](#table-of-contents)
  - [Project Overview](#project-overview)
  - [Key Features](#key-features)
  - [Technology Stack](#technology-stack)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
  - [Running the Application](#running-the-application)
    - [Development Mode](#development-mode)
    - [Production Build](#production-build)
    - [Individual Services](#individual-services)
  - [Project Structure](#project-structure)
  - [Available Modules](#available-modules)
  - [Development](#development)
    - [Module Development](#module-development)
    - [Code Standards](#code-standards)
    - [Adding New Modules](#adding-new-modules)
  - [Testing](#testing)
  - [License](#license)

## Project Overview

Digi is a comprehensive e-commerce solution designed with modularity in mind. Each feature is encapsulated in its own module, allowing for independent development, testing, and deployment. This architecture enables teams to work on different parts of the application simultaneously without conflicts.

## Key Features

- Modular architecture for scalable development
- User authentication and authorization system
- Product management with categories
- Shopping cart functionality
- Order processing system
- Payment integration
- Vendor management
- Customer support system
- Analytics and reporting
- Notification system
- Search and filtering capabilities

## Technology Stack

- **Backend**: Laravel 12, PHP 8.2+
- **Frontend**: Vite 6, Tailwind CSS 4, Alpine.js 3
- **Database**: MySQL (configurable)
- **API**: Laravel Sanctum for API authentication
- **Module System**: nwidart/laravel-modules
- **Testing**: PestPHP with Laravel plugin
- **Additional Libraries**: Swiper (sliders), Chart.js (data visualization)

## Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js 16 or higher
- NPM
- MySQL or another supported database
- Git

## Installation

1. Clone the repository:

   ```bash
   git clone <repository-url>
   cd Digi
   ```

2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Install Node dependencies:

   ```bash
   npm install
   ```

4. Copy and configure the environment file:

   ```bash
   cp .env.example .env
   ```

   Update the database and other configuration values in `.env` as needed.

5. Generate application key:

   ```bash
   php artisan key:generate
   ```

6. Run database migrations:

   ```bash
   php artisan migrate
   ```

7. Seed the database (optional):

   ```bash
   php artisan db:seed
   ```

## Running the Application

### Development Mode

To start the development server with all necessary services:

```bash
composer run dev
```

This command uses `concurrently` to run:

- PHP development server
- Vite dev server for frontend assets
- Laravel Pail for log streaming
- Queue listener for background jobs

### Production Build

To build frontend assets for production:

```bash
npm run build
```

### Individual Services

You can also run individual services separately:

- Start PHP development server: `php artisan serve`
- Start Vite dev server: `npm run dev`
- Start queue worker: `php artisan queue:work`
- Stream logs: `php artisan pail`

## Project Structure

```text
Digi/
├── app/                 # Core Laravel application files
├── Modules/             # Modular components (18 modules)
├── config/              # Configuration files
├── database/            # Migrations, seeds, and factories
├── public/              # Publicly accessible files
├── resources/           # Views, CSS, and JavaScript
├── routes/              # Application routes
├── storage/             # File storage
├── tests/               # Test files
├── .env.example         # Environment configuration example
├── composer.json        # PHP dependencies
├── package.json         # Node dependencies
└── vite.config.js       # Vite configuration
```

## Available Modules

The application is divided into the following modules:

- **Admin**: Administrative interface
- **AnalyticsAndReporting**: Data analytics and reporting features
- **Authorization**: User authentication and role-based access control
- **Business**: Business and vendor management
- **Cart**: Shopping cart functionality
- **Category**: Product categorization system
- **CommissionAndPayout**: Commission calculations and payout processing
- **ContentManagement**: Content management system
- **CustomerSupport**: Customer support and chat functionality
- **List**: Wishlist and listing features
- **Notification**: Notification system
- **Order**: Order processing and management
- **Payment**: Payment processing integration
- **Product**: Product management
- **PromotionAndCoupon**: Promotions and coupon system
- **Reaction**: Reviews and ratings
- **SearchAndFiltering**: Product search and filtering
- **User**: User profile and settings

## Development

### Module Development

Each module follows a consistent structure:

```text
Module/
├── app/                 # Module-specific PHP code
├── database/            # Module migrations and seeds
├── routes/              # Module routes
├── resources/           # Module views and assets
├── tests/               # Module tests
├── module.json          # Module configuration
└── package.json         # Module Node dependencies
```

### Code Standards

- PHP code follows PSR-12 standards
- Code is formatted using Laravel Pint
- Frontend code uses Tailwind CSS with utility-first approach

### Adding New Modules

To create a new module:

```bash
php artisan module:make ModuleName
```

## Testing

The project uses PestPHP for testing with Laravel integration.

Run all tests:

```bash
composer test
```

Or run tests with artisan:

```bash
php artisan test
```

## License

This project is open-sourced software licensed under the MIT license.
