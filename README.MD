# Laravel E-Commerce Cart Package

This package is a **modular** and **extensible** library designed to strengthen **cart** management within the Laravel ecosystem. It is classified under the following headings:

* **Core Cart**: Functions to add, remove, update quantity, and clear cart items.
* **Persistence Layer**: Durable storage via a migration for `cart_items` with a JSON-enabled `options` column and the `CartItem` model.
* **Interface & Contracts**: Abstractions through `CartInterface`, `ProductResolverInterface`, and `TaxCalculatorInterface`.
* **Events System**: `ItemAdded`, `ItemUpdated`, `ItemRemoved`, and `CartCleared` events.
* **Calculators**: Subtotal, tax, and total calculation via `DefaultCartCalculator` and `DefaultTaxCalculator`.
* **Configurable Resolver**: Configure the model and tax rate (`tax_rate`) in `config/cart.php`.
* **Actions**: Extendable action framework with examples like `MailAction` for sending emails.
* **Facade & Helpers**: Provides a `Cart` facade and helper functions.

## 📦 Features

* **Cart Management**

    * Add/remove/update/clear items (`addItem`, `removeItem`, `updateQuantity`, `clear`)
    * List items (`items`) and calculate total (`total`)
* **Database Support**

    * `cart_items` table: `cart_id` (UUID), `item_id`, `quantity`, `unit_price`, `options` (JSON), timestamps
* **Event Dispatch**

    * `ItemAdded`, `ItemUpdated`, `ItemRemoved`, `CartCleared`
* **Actions**

    * Example `MailAction`—send email with sender, recipient, subject, and content parameters
* **Configuration**

    * Configure model and `tax_rate` via `config/cart.php`
* **Calculators**

    * `DefaultCartCalculator`: subtotal, tax, and grand total
    * `DefaultTaxCalculator`: percentage-based tax calculation
* **Facade**

    * Provides the `Cart` facade

## ⚙️ Installation

1. Require the package via Composer:

   ```bash
   composer require taskinbirtan/ecommerce.cart
   ```
2. Register the service provider and facade (if auto-discovery is disabled) in `config/app.php`:

   ```php
   Taskinbirtan\EcommerceCart\CartServiceProvider::class,

   'Cart' => Taskinbirtan\EcommerceCart\Facades\Cart::class,
   ```
3. Publish the configuration file:

   ```bash
   php artisan vendor:publish --provider="Taskinbirtan\EcommerceCart\CartServiceProvider" --tag=config
   ```
4. Run the migrations:

   ```bash
   php artisan migrate
   ```
> **Note:** The default migration file is named `1919_05_19_commemorate_ataturk.php` in honor of **Atatürk** and to celebrate **Youth and Sports Day**, commemorating the beginning of the Turkish War of Independence and marking the date this project was initiated.

## ⚙️ Configuration

`config/cart.php`:

```php
return [
    'product_model' => App\\Models\\Product::class,
    'tax_rate'      => 18, // percentage
];
```

## 🛠️ Usage

### Add an Item to the Cart

```php
use Cart;

Cart::addItem($productId, $quantity = 1, ['color' => 'red']);
```

### Remove an Item

```php
Cart::removeItem($productId);
```

### Update Quantity

```php
Cart::updateQuantity($productId, $newQuantity);
```

### Clear the Cart

```php
Cart::clear();
```

### List Items and Calculate Total

```php
$items = Cart::items();
$total = Cart::total();
```

## 🔔 Events

You can listen to the following events to react to cart changes:

* `Taskinbirtan\EcommerceCart\Events\ItemAdded`
* `Taskinbirtan\EcommerceCart\Events\ItemUpdated`
* `Taskinbirtan\EcommerceCart\Events\ItemRemoved`
* `Taskinbirtan\EcommerceCart\Events\CartCleared`

Example listener:

```php
public function handle(ItemAdded $event)
{
    // $event->item
}
```

## 📋 Test

This package can be tested with Pest & PHPUnit:

```bash
vendor/bin/pest
```

## 📝 Roadmap

In future versions, we aim to cover **e-commerce components beyond Cart** with the following modules:

* **Product Catalog**: CRUD operations, detail pages, variation support (color, size, etc.)
* **Category Management**: Multi-level category/ subcategory hierarchy and category-based filtering
* **Inventory & Stock Tracking**: Warehouse-based stock management, critical stock alerts
* **Order Management**: Creating orders, status updates, and customer notifications
* **Payment Integrations**: Stripe, PayPal, local banks, and installment options
* **Shipping & Logistics**: Carrier API integration, shipment tracking
* **Coupons & Discounts**: Percentage- and amount-based promo codes, usage rules
* **Customer Accounts**: Registration/login, profile, address book, order history
* **Invoicing & Returns**: PDF invoice generation, return request management
* **Multi-Language & Multi-Currency**: Localization infrastructure, currency rate updates
* **Reporting & Analytics**: Sales, customer, and stock reports with graphical displays
* **Search & Filtering Infrastructure**: Elasticsearch/Algolia integration, advanced filters
* **UI/UX Components**: Responsive theme and demo components (Tailwind, jQuery)
* **Security & Performance**: Rate limiting, cache (Redis), scalable architecture recommendations

## 🤝 Contributing

* Fork the repository
* Create a new branch (`git checkout -b feature/fooBar`)
* Commit your changes (`git commit -am 'Add some fooBar'`)
* Push to the branch (`git push origin feature/fooBar`)
* Open a pull request

## ☕ Buy Me a Coffee

If you like this package and want to support its development, you can buy me a coffee! ☕

[Buy Me a Coffee](https://www.buymeacoffee.com/taskinbirtan)

## 📝 License

MIT © taskinbirtan
