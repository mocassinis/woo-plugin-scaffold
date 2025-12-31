<?php

/**
 * Plugin Name:       Plugin - Template
 * Plugin URI:        https://github.com/mrxkon/plugin-tpl
 * Description:       Plugin - Template
 * Version:           1.0.0
 * Required at least: 5.6
 * Requires PHP:      7.4
 * WC requires at least: 6.0
 * WC tested up to:   9.5
 * Author:            Ioannis Kastorinis
 * Author URI:        https://github.com/mocassinis
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       plugin-tpl
 *
 * Copyright (C) 2021-Present
 * Ioannis Kastorinis (https://github.com/mocassinis).
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see https://www.gnu.org/licenses/.
 */

/**
 * Check that the file is not accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Sorry, but you can not directly access this file.' );
}

/**
 * Declare HPOS compatibility.
 */
add_action(
	'before_woocommerce_init',
	function() {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility(
				'custom_order_tables',
				__FILE__,
				true
			);
		}
	}
);

/**
 * Initialize the plugin.
 */
function plugin_tpl_init() {
	// Composer autoload.
	require_once __DIR__ . '/vendor/autoload.php';

	// Initialize plugin.
	\Nevma\Plugin_Tpl\Plugin::get_instance();
}
add_action( 'plugins_loaded', 'plugin_tpl_init' );

/**
 * Activation Hook.
 */
register_activation_hook( __FILE__, array( '\\Nevma\\Plugin_Tpl\\Plugin', 'activate' ) );

/**
 * Deactivation Hook.
 */
register_deactivation_hook( __FILE__, array( '\\Nevma\\Plugin_Tpl\\Plugin', 'deactivate' ) );

/**
 * Uninstall Hook.
 */
register_uninstall_hook( __FILE__, array( '\\Nevma\\Plugin_Tpl\\Plugin', 'uninstall' ) );
