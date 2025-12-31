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

**Note:** This template is designed for WooCommerce plugin development.

#### Available commands
- `npm run lint` - Runs all lints.
	- `php:lint` - Lints all `.php` files.
	- `css:lint` - Lints all css files inside the `css` directory.
	- `js:lint` - Lints all css files inside the `js` directory.
- `npm run fix` - Runs all fixes.
	- `php:fix`  - Fixes all `.php` files.
	- `css:fix` - Fixes any issues inside the `css` directory.
	- `js:fix` - Fixes any issues inside the `js` directory.
- `php:compat` - Checks all `.php` files inside the `src` directory for compatibility with PHP 7.0+.
- `npm run copy` - Copies `css`, `js`, `php`, `vendor` directories & `{plugin-name}.php` into `build/{plugin-name}` directory.
- `npm run watch` - Watches for file changes and runs `npm run copy`.
- `npm run build` - Runs `npm run copy` and creates a `{plugin-name}.zip` inside the `build` directory.

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

