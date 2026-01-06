# E-Commerce Application

A full-featured e-commerce application built with Laravel 11, Inertia.js, and React, featuring a clean architecture with Repository and Service patterns.

## 🚀 Features

- **User Authentication**: Registration, login, email verification
- **Product Management**: Browse products, view details, manage inventory
- **Shopping Cart**: Add/update/remove items, real-time stock validation
- **Order Processing**: Checkout, order history, order management
- **Admin Dashboard**: Statistics, product management, order tracking
- **Email Notifications**: Low stock alerts, daily sales reports
- **Job Queues**: Asynchronous email processing
- **Stock Management**: Real-time inventory tracking with low stock alerts

## 📋 Requirements

- PHP 8.2+
- Composer
- Node.js 18+ & NPM
- MySQL/PostgreSQL
- Redis (optional, for queue driver)

## 🛠️ Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd my-ecommerce-app
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database
Update `.env` with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Configure Mail (Optional)
For email features:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@ecommerce.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 6. Run Migrations & Seeders
```bash
php artisan migrate:fresh --seed
```

### 7. Create Storage Link
```bash
php artisan storage:link
```

### 8. Build Frontend Assets
```bash
npm run build
# or for development
npm run dev
```

### 9. Start the Application
```bash
php artisan serve
```

Visit: `http://localhost:8000`

## 👤 Default Credentials

After seeding:
- **Admin**:
  - Email: `admin@example.com`
  - Password: `12345678`

## 📁 Project Structure

### Architecture Layers

#### **Repository Layer** (Data Access)
Located in `app/Repositories/`

Handles all database operations:
- `BaseRepository` - Common CRUD operations
- `ProductRepository` - Product-specific queries
- `CartItemRepository` - Cart operations
- `OrderRepository` - Order queries
- `UserRepository` - User data access

**Usage**: Direct database access for reading/querying data.

#### **Service Layer** (Business Logic)
Located in `app/Services/`

Contains business rules and complex operations:
- `ProductService` - Product business logic (stock reservation)
- `CartItemService` - Cart operations (add, update, stock checks)
- `OrderService` - Order processing workflow
- `ReportService` - Analytics and reporting
- `AuthService` - Authentication logic

**Usage**: All write operations and business logic go through services.

#### **Controller Layer** (HTTP Handling)
Located in `app/Http/Controllers/`

Handles HTTP requests and responses:
- Validate input using Form Requests
- Call appropriate services
- Return Inertia responses or redirects

### Key Concepts

**Repository Pattern**:
```php
// ✅ Use repository for simple reads
$products = $this->productRepository->all();

// ✅ Use service for business operations
$this->cartService->add($userId, $productId, $quantity);
```

**Service Pattern**:
```php
// Service handles business logic
public function add($userId, $productId, $quantity): void
{
    DB::transaction(function () use ($userId, $productId, $quantity) {
        // Check stock
        // Update cart
        // Reserve inventory
    });
}
```

## Database

### Tables

#### `products`
- `id` - Primary key
- `name` - Product name
- `description` - Product description
- `price` - Decimal(10,2)
- `stock_quantity` - Available inventory
- `reserved_quantity` - Reserved for carts
- `created_at`, `updated_at`

#### `cart_items`
- `id` - Primary key
- `user_id` - Foreign key to users
- `product_id` - Foreign key to products
- `quantity` - Item quantity
- `created_at`, `updated_at`

**Indexes**: `(product_id, user_id)` for fast lookups

#### `orders`
- `id` - Primary key
- `user_id` - Foreign key to users
- `total_amount` - Order total
- `status` - Order status (pending, completed, cancelled)
- `created_at`, `updated_at`

#### `order_items`
- `id` - Primary key
- `order_id` - Foreign key to orders
- `product_id` - Foreign key to products
- `quantity` - Quantity ordered
- `price_at_time_of_purchase` - Price snapshot
- `created_at`, `updated_at`

#### `product_images`
- `id` - Primary key
- `product_id` - Foreign key to products
- `image_path` - Path to image file
- `created_at`, `updated_at`

#### `settings`
- `id` - Primary key
- `low_stock_threshold` - Threshold for low stock alerts
- `admin_email` - Admin notification email
- `created_at`, `updated_at`

#### `users`
- `id` - Primary key
- `name` - User's full name
- `email` - Unique email address
- `password` - Hashed password
- `role` - Enum: `admin`, `user`
- `email_verified_at` - Email verification timestamp
- `remember_token`
- `created_at`, `updated_at`

## User Roles

- **`admin`**: Full access to dashboard, settings, all orders, product management
- **`user`**: Can browse products, manage cart, place orders, view own orders

## Modules

### Dashboard
**Route**: `/dashboard`
- **Admin View**:
  - Total users count
  - Total orders count
  - Low stock products count
  - Product listing
- **User View**:
  - Product catalog
  - Add to cart functionality

### Cart
**Route**: `/cart-items`
- View cart items
- Update quantities (with real-time stock validation)
- Remove items
- Proceed to checkout

### Orders
**Routes**: `/orders/*`
- **Admin**: View all orders
- **User**: View own order history
- Order details with items

### Settings (Admin Only)
**Route**: `/settings`
- Configure low stock threshold
- Update admin email

## Jobs & Queues

### Background Jobs

#### `SendLowStockEmail`
Sends email alerts when product stock falls below threshold.

**Dispatch**:
```php
SendLowStockEmail::dispatch($product, $threshold);
```

#### `SendDailySalesReportEmail`
Sends daily sales summary to admin users.

**Scheduled**: Every day at 6 PM (18:00)

**Configuration**: See `routes/console.php`

### Running Queue Worker

```bash
# Start queue worker
php artisan queue:work

# Run queue in background (production)
php artisan queue:work --daemon

# Restart queue workers (after code changes)
php artisan queue:restart
```

## Scheduled Tasks

Tasks are defined in `routes/console.php`:

```php
// Daily sales report at 6 PM
Schedule::command('send-email:daily-sales-report')->dailyAt('18:00');
```

### Running the Scheduler

**Development**:
```bash
php artisan schedule:work
```

**Production** (Add to crontab):
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

## API Endpoints

### Cart Operations

**Add to Cart**
```
POST /cart-items
Body: { product_id, quantity }
```

**Update Cart Item**
```
PATCH /cart-items/{id}
Body: { quantity }
```

**Remove from Cart**
```
DELETE /cart-items/{id}
```

### Orders

**Place Order**
```
POST /orders
Body: { order_items: [{ product_id, quantity, price }] }
```

**View Orders**
```
GET /orders
```

## Frontend (Inertia + React)

### Key Components

**Product Card**: `resources/js/Components/UI/AdminPanel/Products/Card.jsx`
- Displays product info
- Add to cart / Update cart
- Real-time stock display

**Slideshow**: `resources/js/Components/UI/Slideshow.jsx`
- Product image carousel

### Custom Hooks

**`useAddCartItem`**: Add products to cart
**`useUpdateCartItem`**: Update cart quantities
**`useDestroyCartItem`**: Remove from cart

### Styling

- **Tailwind CSS** for utility-first styling
- Configuration: `tailwind.config.js`
- Custom styles: `resources/css/app.css`

## Validation Rules

### Custom Rules

**`WithinStockQuantity`**: `app/Rules/WithinStockQuantity.php`
- Validates quantity against available stock
- Used in cart and order operations

## Exception Handling

### Custom Exceptions

**`InsufficientStockException`**: `app/Exceptions/Cart/InsufficientStockException.php`
- Thrown when requested quantity exceeds stock

**`LowStockException`**: `app/Exceptions/LowStockException.php`
- Used for low stock notifications

## Email Templates

Located in `resources/views/emails/`

- **Low Stock Alert**: `low-stock.blade.php`
- **Daily Sales Report**: `reports/daily-sales.blade.php`

## Best Practices Used

### 1. Repository Pattern
✅ Separate data access from business logic
✅ Reusable query methods
✅ Easy to test and mock

### 2. Service Layer
✅ Centralized business logic
✅ Transaction management
✅ Single responsibility

### 3. Form Requests
✅ Validation logic separated from controllers
✅ Authorization in one place
✅ Custom error messages

### 4. Job Queues
✅ Asynchronous email sending
✅ Better user experience
✅ Retry failed jobs

### 5. Database Optimization
✅ Proper indexing on foreign keys
✅ Pessimistic locking for stock management
✅ Efficient queries with scopes

## Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# With coverage
php artisan test --coverage
```

## Deployment

### Production Checklist

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false`
3. Configure proper database credentials
4. Set up queue worker as systemd service
5. Add scheduler to crontab
6. Run `php artisan config:cache`
7. Run `php artisan route:cache`
8. Run `php artisan view:cache`
9. Run `npm run build`
10. Set proper file permissions

### Queue Worker (Systemd)

Create `/etc/systemd/system/laravel-worker.service`:
```ini
[Unit]
Description=Laravel Queue Worker
After=network.target

[Service]
Type=simple
User=www-data
WorkingDirectory=/var/www/my-ecommerce-app
ExecStart=/usr/bin/php artisan queue:work --daemon
Restart=always

[Install]
WantedBy=multi-user.target
```

## Troubleshooting

### Common Issues

**Queue jobs not processing**:
```bash
php artisan queue:restart
php artisan queue:work
```

**Assets not loading**:
```bash
npm run build
php artisan storage:link
```

**Database errors**:
```bash
php artisan migrate:fresh --seed
```

**Cache issues**:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is open-sourced software licensed under the MIT license.

## Support

For issues and questions, please open an issue on the GitHub repository.
