<?php

/**
 * Set namespace.
 */
namespace Nevma\Plugin_Tpl;

/**
 * Check that the file is not accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Sorry, but you can not directly access this file.' );
}

/**
 * Class Logger.
 *
 * Wrapper for WooCommerce Logger.
 */
class Logger {
	/**
	 * Logger instance.
	 *
	 * @var \WC_Logger_Interface
	 */
	private static $logger;

	/**
	 * Log source identifier.
	 *
	 * @var string
	 */
	private static $source = 'plugin-tpl';

	/**
	 * Get logger instance.
	 *
	 * @return \WC_Logger_Interface
	 */
	private static function get_logger() {
		if ( null === self::$logger ) {
			self::$logger = wc_get_logger();
		}

		return self::$logger;
	}

	/**
	 * Should we log?
	 *
	 * @return bool
	 */
	public static function should_log() {
		return defined( 'PLUGIN_TPL_DEBUG' ) && PLUGIN_TPL_DEBUG ? true : false;
	}

	/**
	 * Log a message.
	 *
	 * @param mixed  $message Message to log.
	 * @param string $level   Log level (debug, info, notice, warning, error, critical, alert, emergency).
	 */
	public static function log( $message, $level = 'info' ) {
		if ( ! self::should_log() ) {
			return;
		}

		if ( ! function_exists( 'wc_get_logger' ) ) {
			return;
		}

		if ( ! is_string( $message ) ) {
			$message = print_r( $message, true );
		}

		self::get_logger()->log( $level, $message, array( 'source' => self::$source ) );
	}

	/**
	 * Log debug message.
	 *
	 * @param mixed $message Message to log.
	 */
	public static function debug( $message ) {
		self::log( $message, 'debug' );
	}

	/**
	 * Log info message.
	 *
	 * @param mixed $message Message to log.
	 */
	public static function info( $message ) {
		self::log( $message, 'info' );
	}

	/**
	 * Log warning message.
	 *
	 * @param mixed $message Message to log.
	 */
	public static function warning( $message ) {
		self::log( $message, 'warning' );
	}

	/**
	 * Log error message.
	 *
	 * @param mixed $message Message to log.
	 */
	public static function error( $message ) {
		self::log( $message, 'error' );
	}
}
