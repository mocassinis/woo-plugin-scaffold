<?php
/**
 * Helper Functions
 *
 * @package Nevma\Plugin_Tpl
 */

/**
 * Check that the file is not accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Sorry, but you can not directly access this file.' );
}

/**
 * Log a message using WooCommerce logger.
 *
 * @param mixed  $message Message to log.
 * @param string $level   Log level (debug, info, notice, warning, error, critical, alert, emergency).
 */
function plugin_tpl_log( $message, $level = 'info' ) {
	// Check if debugging is enabled.
	if ( ! defined( 'PLUGIN_TPL_DEBUG' ) || ! PLUGIN_TPL_DEBUG ) {
		return;
	}

	// Check if WooCommerce logger is available.
	if ( ! function_exists( 'wc_get_logger' ) ) {
		return;
	}

	// Convert non-strings to string.
	if ( ! is_string( $message ) ) {
		$message = print_r( $message, true ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
	}

	// Get logger instance and log message.
	$logger = wc_get_logger();
	$logger->log( $level, $message, array( 'source' => 'plugin-tpl' ) );
}

/**
 * Get plugin option.
 *
 * @param string $key     Option key.
 * @param mixed  $default Default value.
 * @return mixed
 */
function plugin_tpl_get_option( $key, $default = '' ) {
	$options = get_option( 'plugin_tpl_options', array() );

	return isset( $options[ $key ] ) ? $options[ $key ] : $default;
}

/**
 * Update plugin option.
 *
 * @param string $key   Option key.
 * @param mixed  $value Option value.
 * @return bool
 */
function plugin_tpl_update_option( $key, $value ) {
	$options         = get_option( 'plugin_tpl_options', array() );
	$options[ $key ] = $value;

	return update_option( 'plugin_tpl_options', $options );
}

/**
 * Check if WooCommerce is active.
 *
 * @return bool
 */
function plugin_tpl_is_woocommerce_active() {
	return class_exists( 'WooCommerce' );
}

/**
 * Get order meta (HPOS-compatible).
 *
 * @param int    $order_id Order ID.
 * @param string $key      Meta key.
 * @param bool   $single   Whether to return a single value.
 * @return mixed
 */
function plugin_tpl_get_order_meta( $order_id, $key, $single = true ) {
	$order = wc_get_order( $order_id );

	if ( ! $order ) {
		return $single ? '' : array();
	}

	return $order->get_meta( $key, $single );
}

/**
 * Update order meta (HPOS-compatible).
 *
 * @param int    $order_id Order ID.
 * @param string $key      Meta key.
 * @param mixed  $value    Meta value.
 * @return bool
 */
function plugin_tpl_update_order_meta( $order_id, $key, $value ) {
	$order = wc_get_order( $order_id );

	if ( ! $order ) {
		return false;
	}

	$order->update_meta_data( $key, $value );
	$order->save();

	return true;
}

/**
 * Get product meta.
 *
 * @param int    $product_id Product ID.
 * @param string $key        Meta key.
 * @param bool   $single     Whether to return a single value.
 * @return mixed
 */
function plugin_tpl_get_product_meta( $product_id, $key, $single = true ) {
	$product = wc_get_product( $product_id );

	if ( ! $product ) {
		return $single ? '' : array();
	}

	return $product->get_meta( $key, $single );
}

/**
 * Update product meta.
 *
 * @param int    $product_id Product ID.
 * @param string $key        Meta key.
 * @param mixed  $value      Meta value.
 * @return bool
 */
function plugin_tpl_update_product_meta( $product_id, $key, $value ) {
	$product = wc_get_product( $product_id );

	if ( ! $product ) {
		return false;
	}

	$product->update_meta_data( $key, $value );
	$product->save();

	return true;
}

/**
 * Sanitize array.
 *
 * @param array $array Array to sanitize.
 * @return array
 */
function plugin_tpl_sanitize_array( $array ) {
	if ( ! is_array( $array ) ) {
		return array();
	}

	return array_map( 'sanitize_text_field', $array );
}

/**
 * Format price.
 *
 * @param float $price Price to format.
 * @return string
 */
function plugin_tpl_format_price( $price ) {
	if ( ! function_exists( 'wc_price' ) ) {
		return number_format( (float) $price, 2 );
	}

	return wc_price( $price );
}
