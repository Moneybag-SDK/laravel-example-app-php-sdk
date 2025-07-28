# Laravel E-Commerce App with Moneybag Payment Gateway

This is a complete e-commerce application built with Laravel that integrates the Moneybag payment gateway for processing payments in Bangladesh.

## Features

- 🛒 Product listing with shopping cart functionality
- 💳 Complete checkout process with customer information forms
- 🏦 Moneybag payment gateway integration (BDT currency)
- 📦 Order management and tracking system
- 📊 Payment status monitoring and transaction history
- 🔍 Comprehensive Moneybag transaction viewer
- 🐳 Docker containerization for easy deployment

## Requirements

### Native Installation
- PHP 8.3 or higher with extensions: `sqlite3`, `mbstring`, `xml`, `dom`, `gd`, `bcmath`
- Composer
- SQLite

### Docker Installation (Recommended)
- Docker
- Docker Compose

## Installation Options

### Option 1: Docker Installation (Recommended)

1. **Clone and build:**
   ```bash
   git clone git@github.com:Moneybag-SDK/laravel-example-app-php-sdk.git
   cd laravel-example-app-php-sdk
   docker compose build
   docker compose up -d
   ```

2. **Access the application:**
   - Open your browser: http://localhost:8090

3. **Update Moneybag credentials:**
   - Edit `.env.docker` and update `MONEYBAG_MERCHANT_API_KEY`
   - Restart: `docker compose restart`

### Option 2: Native Installation

1. Install dependencies:
   ```bash
   composer install --ignore-platform-reqs
   ```

2. Configure environment:
   - The `.env` file is already configured for SQLite
   - Update the Moneybag credentials in `.env`:
     ```
     MONEYBAG_MERCHANT_API_KEY=your_merchant_api_key_here
     MONEYBAG_API_URL=https://staging.api.moneybag.com.bd/api/v2
     ```

3. Generate application key:
   ```bash
   php artisan key:generate
   ```

4. Run database migrations:
   ```bash
   php artisan migrate
   ```

5. Seed the database with sample products:
   ```bash
   php artisan db:seed
   ```

6. Start the development server:
   ```bash
   php artisan serve
   ```

7. Visit `http://localhost:8000` to see the application.

## Docker Commands

- `docker compose build` - Build Docker images
- `docker compose up -d` - Start containers in detached mode
- `docker compose down` - Stop and remove containers
- `docker compose restart` - Restart all containers
- `docker compose logs -f` - View container logs
- `docker compose exec app bash` - Access app container shell
- `docker compose ps` - Check container status

## Usage

1. **Browse Products:** Visit the homepage to see available products
2. **Shopping Cart:** Add products to cart with desired quantities
3. **Checkout Process:** 
   - Fill in customer information (name, email, phone)
   - Enter shipping address with city, state, postal code
   - Proceed to Moneybag payment gateway
4. **Payment:** Complete payment through Moneybag's secure payment system
5. **Order Tracking:** View order status and payment history
6. **Transaction Monitoring:** Access comprehensive Moneybag transaction logs

## Project Structure

- **Models**: 
  - `Product` - Product catalog management
  - `Order` - Order information and customer details
  - `OrderItem` - Individual items within orders
  - `MoneybagTransaction` - Payment transaction tracking
- **Controllers**: 
  - `ProductController` - Product listing and details
  - `CartController` - Shopping cart management
  - `CheckoutController` - Checkout and payment processing
  - `OrderController` - Order management and viewing
  - `MoneybagTransactionController` - Transaction monitoring
- **Views**: Responsive Blade templates with BDT currency support
- **Database**: SQLite with comprehensive e-commerce schema
- **Docker**: Multi-container setup with PHP-FPM and Nginx

## Moneybag Integration

The application uses the Moneybag PHP SDK (v1.0.0-beta.1) to process payments. The integration includes:

- Checkout session creation using CheckoutRequest
- Redirect to Moneybag checkout page
- Payment verification using transaction ID
- Order status updates (pending, paid, failed)
- Support for BDT currency

Key implementation details:
- Only requires `merchant_api_key` for sandbox environment
- Uses the sandbox API URL: `https://sandbox.api.moneybag.com.bd/api/v2`
- Implements proper payment verification on success callback

## Application URLs

- **Homepage:** http://localhost:8090 (Docker) or http://localhost:8000 (Native)
- **Products:** `/products` - Browse all available products
- **Shopping Cart:** `/cart` - View and manage cart items  
- **Checkout:** `/checkout` - Complete purchase process
- **Orders:** `/orders` - View order history
- **Moneybag Transactions:** `/moneybag/transactions` - Monitor payment transactions

## Notes

- This is a demo application using the Moneybag SDK beta version
- Docker setup includes automated database seeding with sample products
- Uses SQLite for data persistence with proper transaction logging
- Implements comprehensive error handling and payment status tracking
- Payment credentials should be kept secure in production environments
- All prices and transactions are processed in Bangladeshi Taka (BDT)

## Support

For Moneybag SDK issues or questions, contact: developer@fitl.com
