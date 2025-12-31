<?php
/**
 * Main Plugin Class
 *
 * @package Nevma\Plugin_Tpl
 */

namespace Nevma\Plugin_Tpl;

/**
 * Check that the file is not accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Sorry, but you can not directly access this file.' );
}

/**
 * Main Plugin Class
 *
 * Handles plugin initialization and orchestrates all components.
 */
class Plugin {
	/**
	 * The plugin version.
	 *
	 * @var string
	 */
	public static $version = '1.0.0';

	/**
	 * The plugin directory.
	 *
	 * @var string
	 */
	public static $dir;

	/**
	 * The plugin url.
	 *
	 * @var string
	 */
	public static $url;

	/**
	 * The plugin instance.
	 *
	 * @var null|Plugin
	 */
	private static $instance = null;

	/**
	 * Admin instance.
	 *
	 * @var Admin
	 */
	private $admin;

	/**
	 * Frontend instance.
	 *
	 * @var Frontend
	 */
	private $frontend;

	/**
	 * WooCommerce instance.
	 *
	 * @var WooCommerce
	 */
	private $woocommerce;

	/**
	 * API instance.
	 *
	 * @var API
	 */
	private $api;

	/**
	 * Gets the plugin instance.
	 *
	 * @return Plugin
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		$this->set_constants();
		$this->load_dependencies();
		$this->init_components();
		$this->define_hooks();
	}

	/**
	 * Set plugin constants.
	 */
	private function set_constants() {
		self::$dir = wp_normalize_path( plugin_dir_path( dirname( __FILE__ ) ) );
		self::$url = plugin_dir_url( dirname( __FILE__ ) );
	}

	/**
	 * Load dependencies.
	 */
	private function load_dependencies() {
		// Composer autoload.
		require_once self::$dir . 'vendor/autoload.php';

		// Helper functions.
		require_once self::$dir . 'src/functions.php';
	}

	/**
	 * Initialize components.
	 */
	private function init_components() {
		// Admin.
		if ( is_admin() ) {
			$this->admin = new Admin();
		}

		// Frontend.
		if ( ! is_admin() ) {
			$this->frontend = new Frontend();
		}

		// WooCommerce (both admin and frontend).
		$this->woocommerce = new WooCommerce();

		// API (REST endpoints).
		$this->api = new API();
	}

	/**
	 * Define plugin hooks.
	 */
	private function define_hooks() {
		// You can add global hooks here.
	}

	/**
	 * Run on plugin activation.
	 */
	public static function activate() {
		// Activation logic here.
		// Example: Create database tables, set default options, etc.

		// Flush rewrite rules.
		flush_rewrite_rules();
	}

	/**
	 * Run on plugin deactivation.
	 */
	public static function deactivate() {
		// Deactivation logic here.
		plugin_tpl_log( 'Deactivating plugin.' );

		// Flush rewrite rules.
		flush_rewrite_rules();
	}

	/**
	 * Run on plugin uninstall.
	 */
	public static function uninstall() {
		// Uninstall logic here.
		// Example: Remove options, delete custom tables, etc.
	}
}
