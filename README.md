## WooCommerce Plugin Template

A modern, well-structured scaffold for building WooCommerce plugins with WordPress best practices built in.

This template provides a solid foundation for WooCommerce extensions with proper code organization, linting, and build tools configured out of the box.

---

![Tests](https://github.com/mrxkon/plugin-tpl/workflows/Checks/badge.svg)
[![PHP Compatibility 7.0+](https://img.shields.io/badge/PHP%20Compatibility-7.0+-8892BF)](https://github.com/PHPCompatibility/PHPCompatibility)
[![WordPress Coding Standards](https://img.shields.io/badge/WordPress%20Coding%20Standards-latest-blue)](https://github.com/WordPress/WordPress-Coding-Standards)

#### Setup

1. Install dependencies:
   ```bash
   composer install && npm install
   ```

2. Search and replace throughout the codebase:
   - `plugin-tpl` → your plugin slug
   - `Plugin_Tpl` → your plugin class name
   - `plugin_tpl` → your function/variable prefix

3. Enable WooCommerce dependency check by uncommenting lines 125-138 in `plugin-tpl.php`

4. Update plugin headers and metadata in:
   - `plugin-tpl.php` (add WooCommerce version headers)
   - `composer.json`
   - `package.json`

**Note:** This template is designed for WooCommerce plugin development and includes HPOS (High-Performance Order Storage) compatibility.

#### Available commands

**PHP Quality Tools:**
- `composer lint` - Run all PHP linters (syntax + PHPCS)
- `composer lint:php` - Check PHP syntax errors
- `composer lint:phpcs` - Check WordPress/WooCommerce coding standards
- `composer fix` - Auto-fix coding standard violations
- `composer analyze` - Run PHPStan static analysis
- `composer compat` - Check PHP 7.4+ compatibility
- `composer make-pot` - Generate translation POT file

**JavaScript/CSS:**
- `npm run lint` - Run all linters (PHP, CSS, JS)
	- `npm run php:lint` - Lint PHP files via Composer
	- `npm run css:lint` - Lint CSS files
	- `npm run js:lint` - Lint JavaScript files
- `npm run fix` - Auto-fix all files
	- `npm run php:fix` - Fix PHP files
	- `npm run css:fix` - Fix CSS files
	- `npm run js:fix` - Fix JavaScript files

**Build Tools:**
- `npm run copy` - Copy files to `build/{plugin-name}/` directory
- `npm run watch` - Watch for changes and auto-copy
- `npm run build` - Create production `.zip` file

#### Debug Logging

The template includes a Logger class that uses WooCommerce's built-in logging system.

**Enable logging:**
```php
define( 'PLUGIN_TPL_DEBUG', true );
```

**Usage:**
```php
use Xkon\Plugin_Tpl\Logger;

Logger::log( 'Message' );           // Default info level
Logger::debug( 'Debug info' );      // Debug level
Logger::info( 'Information' );      // Info level
Logger::warning( 'Warning' );       // Warning level
Logger::error( 'Error occurred' );  // Error level
```

**View logs:** WooCommerce > Status > Logs (look for source: `plugin-tpl`)

#### HPOS Compatibility

This template is compatible with WooCommerce High-Performance Order Storage (HPOS).

**What's included:**
- HPOS compatibility declaration in the main plugin file
- WooCommerce version headers (`WC requires at least`, `WC tested up to`)

**Important for development:**
- Always use `wc_get_order()` to retrieve orders
- Use WooCommerce CRUD methods: `$order->get_meta()`, `$order->update_meta_data()`, `$order->save()`
- Never use `get_post_meta()` or `update_post_meta()` for order data
- Use `wc_get_orders()` instead of `WP_Query` for querying orders

#### Modern Development Tools

**Code Quality:**
- ✅ **WooCommerce Coding Standards** - Via `woocommerce/woocommerce-sniffs`
- ✅ **WordPress Coding Standards** - Latest WPCS 3.0+
- ✅ **PHPStan Static Analysis** - Level 5 with WordPress/WooCommerce stubs
- ✅ **PHP 7.4+ Compatibility** - Modern PHP features supported
- ✅ **Security Rules** - Nonce verification, sanitization, and escaping checks

**What's Included:**
```bash
# Check code quality
composer lint              # All checks
composer analyze           # Static analysis
composer compat            # PHP compatibility

# Auto-fix issues
composer fix               # Fix coding standards
```

**PHPStan Configuration:**
- Level 5 analysis (balanced strictness)
- WordPress and WooCommerce stubs included
- Ignores common WordPress false positives
- See `phpstan.neon.dist` for configuration

