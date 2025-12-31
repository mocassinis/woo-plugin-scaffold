<?php
/**
 * Admin Class
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
 * Admin Class
 *
 * Handles all admin-related functionality: menus, settings, meta boxes, admin assets, etc.
 */
class Admin {
	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->init_hooks();
	}

	/**
	 * Initialize hooks.
	 */
	private function init_hooks() {
		// Admin menu.
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );

		// Admin scripts and styles.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );

		// Settings initialization.
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Add admin menu.
	 */
	public function add_admin_menu() {
		add_menu_page(
			__( 'Plugin Template', 'plugin-tpl' ),
			__( 'Plugin Tpl', 'plugin-tpl' ),
			'manage_options',
			'plugin-tpl',
			array( $this, 'render_admin_page' ),
			'dashicons-admin-generic',
			30
		);
	}

	/**
	 * Render admin page.
	 */
	public function render_admin_page() {
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<p><?php esc_html_e( 'Welcome to the plugin template admin page.', 'plugin-tpl' ); ?></p>

			<!-- Add your admin page content here -->
			<div class="card">
				<h2><?php esc_html_e( 'Settings', 'plugin-tpl' ); ?></h2>
				<p><?php esc_html_e( 'Configure your plugin settings here.', 'plugin-tpl' ); ?></p>
			</div>
		</div>
		<?php
	}

	/**
	 * Register settings.
	 */
	public function register_settings() {
		// Register your settings here.
		// Example:
		// register_setting( 'plugin_tpl_options', 'plugin_tpl_setting' );
	}

	/**
	 * Enqueue admin assets.
	 *
	 * @param string $hook_suffix The current admin page.
	 */
	public function enqueue_assets( $hook_suffix ) {
		// Enqueue only on plugin pages.
		if ( 'toplevel_page_plugin-tpl' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_style(
			'plugin-tpl-admin',
			Plugin::$url . 'css/styles.css',
			array(),
			Plugin::$version
		);

		wp_enqueue_script(
			'plugin-tpl-admin',
			Plugin::$url . 'js/scripts.js',
			array( 'jquery' ),
			Plugin::$version,
			true
		);

		wp_localize_script(
			'plugin-tpl-admin',
			'pluginTplAdmin',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'plugin-tpl-admin' ),
			)
		);
	}
}
