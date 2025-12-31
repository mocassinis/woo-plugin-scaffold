<?php
/**
 * Frontend Class
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
 * Frontend Class
 *
 * Handles all public-facing functionality: hooks, shortcodes, frontend assets, etc.
 */
class Frontend {
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
		// Enqueue frontend assets.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );

		// Add custom content (example).
		// add_filter( 'the_content', array( $this, 'add_custom_content' ) );

		// Register shortcodes.
		// add_shortcode( 'plugin_tpl', array( $this, 'shortcode_handler' ) );
	}

	/**
	 * Enqueue frontend assets.
	 */
	public function enqueue_assets() {
		wp_enqueue_style(
			'plugin-tpl-frontend',
			Plugin::$url . 'css/styles.css',
			array(),
			Plugin::$version
		);

		wp_enqueue_script(
			'plugin-tpl-frontend',
			Plugin::$url . 'js/scripts.js',
			array( 'jquery' ),
			Plugin::$version,
			true
		);

		wp_localize_script(
			'plugin-tpl-frontend',
			'pluginTplFrontend',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'plugin-tpl-frontend' ),
			)
		);
	}

	/**
	 * Example: Add custom content to posts.
	 *
	 * @param string $content The post content.
	 * @return string
	 */
	public function add_custom_content( $content ) {
		// Add custom content before or after the main content.
		$custom_content = '<div class="plugin-tpl-custom">Custom content here</div>';

		return $content . $custom_content;
	}

	/**
	 * Example: Shortcode handler.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public function shortcode_handler( $atts ) {
		$atts = shortcode_atts(
			array(
				'title' => 'Default Title',
			),
			$atts,
			'plugin_tpl'
		);

		return '<div class="plugin-tpl-shortcode">' . esc_html( $atts['title'] ) . '</div>';
	}
}
