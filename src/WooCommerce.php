<?php
/**
 * WooCommerce Class
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
 * WooCommerce Class
 *
 * Handles all WooCommerce integrations: products, orders, cart, checkout, emails, etc.
 */
class WooCommerce {
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
		// Product hooks.
		// add_action( 'woocommerce_product_options_general_product_data', array( $this, 'add_product_field' ) );
		// add_action( 'woocommerce_process_product_meta', array( $this, 'save_product_field' ) );

		// Order hooks.
		// add_action( 'woocommerce_new_order', array( $this, 'on_new_order' ) );
		// add_action( 'woocommerce_order_status_changed', array( $this, 'on_order_status_changed' ), 10, 4 );

		// Cart hooks.
		// add_action( 'woocommerce_before_cart', array( $this, 'before_cart_content' ) );

		// Checkout hooks.
		// add_action( 'woocommerce_before_checkout_form', array( $this, 'before_checkout_form' ) );
		// add_filter( 'woocommerce_checkout_fields', array( $this, 'add_checkout_field' ) );
		// add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'save_checkout_field' ) );

		// Email hooks.
		// add_action( 'woocommerce_email_after_order_table', array( $this, 'add_email_content' ), 10, 4 );
	}

	/**
	 * Example: Add custom product field.
	 */
	public function add_product_field() {
		woocommerce_wp_text_input(
			array(
				'id'          => '_custom_product_field',
				'label'       => __( 'Custom Field', 'plugin-tpl' ),
				'placeholder' => __( 'Enter value', 'plugin-tpl' ),
				'desc_tip'    => true,
				'description' => __( 'This is a custom product field.', 'plugin-tpl' ),
			)
		);
	}

	/**
	 * Example: Save custom product field.
	 *
	 * @param int $post_id Product ID.
	 */
	public function save_product_field( $post_id ) {
		$product = wc_get_product( $post_id );

		if ( ! $product ) {
			return;
		}

		$custom_field = isset( $_POST['_custom_product_field'] ) ? sanitize_text_field( wp_unslash( $_POST['_custom_product_field'] ) ) : '';
		$product->update_meta_data( '_custom_product_field', $custom_field );
		$product->save();
	}

	/**
	 * Example: Handle new order.
	 *
	 * @param int $order_id Order ID.
	 */
	public function on_new_order( $order_id ) {
		$order = wc_get_order( $order_id );

		if ( ! $order ) {
			return;
		}

		// Do something with the new order.
		plugin_tpl_log( 'New order created: ' . $order_id );
	}

	/**
	 * Example: Handle order status change.
	 *
	 * @param int    $order_id   Order ID.
	 * @param string $old_status Old status.
	 * @param string $new_status New status.
	 * @param object $order      Order object.
	 */
	public function on_order_status_changed( $order_id, $old_status, $new_status, $order ) {
		// Handle order status changes.
		plugin_tpl_log(
			sprintf(
				'Order %d status changed from %s to %s',
				$order_id,
				$old_status,
				$new_status
			)
		);
	}

	/**
	 * Example: Add content before cart.
	 */
	public function before_cart_content() {
		echo '<div class="plugin-tpl-cart-notice">';
		echo esc_html__( 'Custom cart message', 'plugin-tpl' );
		echo '</div>';
	}

	/**
	 * Example: Add custom checkout field.
	 *
	 * @param array $fields Checkout fields.
	 * @return array
	 */
	public function add_checkout_field( $fields ) {
		$fields['billing']['custom_checkout_field'] = array(
			'type'        => 'text',
			'label'       => __( 'Custom Field', 'plugin-tpl' ),
			'placeholder' => __( 'Enter value', 'plugin-tpl' ),
			'required'    => false,
			'class'       => array( 'form-row-wide' ),
			'clear'       => true,
		);

		return $fields;
	}

	/**
	 * Example: Save custom checkout field.
	 *
	 * @param int $order_id Order ID.
	 */
	public function save_checkout_field( $order_id ) {
		if ( ! empty( $_POST['custom_checkout_field'] ) ) {
			$order = wc_get_order( $order_id );

			if ( $order ) {
				$order->update_meta_data(
					'_custom_checkout_field',
					sanitize_text_field( wp_unslash( $_POST['custom_checkout_field'] ) )
				);
				$order->save();
			}
		}
	}

	/**
	 * Example: Add content to order emails.
	 *
	 * @param object $order         Order object.
	 * @param bool   $sent_to_admin Sent to admin.
	 * @param bool   $plain_text    Plain text.
	 * @param object $email         Email object.
	 */
	public function add_email_content( $order, $sent_to_admin, $plain_text, $email ) {
		$custom_field = $order->get_meta( '_custom_checkout_field' );

		if ( $custom_field ) {
			echo '<p><strong>' . esc_html__( 'Custom Field:', 'plugin-tpl' ) . '</strong> ' . esc_html( $custom_field ) . '</p>';
		}
	}
}
