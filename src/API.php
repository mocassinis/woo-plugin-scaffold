<?php
/**
 * API Class
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
 * API Class
 *
 * Handles REST API endpoints and AJAX handlers.
 */
class API {
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
		// REST API endpoints.
		add_action( 'rest_api_init', array( $this, 'register_rest_routes' ) );

		// AJAX handlers.
		add_action( 'wp_ajax_plugin_tpl_action', array( $this, 'ajax_handler' ) );
		add_action( 'wp_ajax_nopriv_plugin_tpl_action', array( $this, 'ajax_handler' ) );
	}

	/**
	 * Register REST API routes.
	 */
	public function register_rest_routes() {
		register_rest_route(
			'plugin-tpl/v1',
			'/example',
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_example' ),
				'permission_callback' => array( $this, 'check_permission' ),
			)
		);

		register_rest_route(
			'plugin-tpl/v1',
			'/example',
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'create_example' ),
				'permission_callback' => array( $this, 'check_permission' ),
				'args'                => array(
					'title' => array(
						'required'          => true,
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
					),
				),
			)
		);
	}

	/**
	 * Permission callback for REST endpoints.
	 *
	 * @return bool
	 */
	public function check_permission() {
		return current_user_can( 'manage_options' );
	}

	/**
	 * GET endpoint example.
	 *
	 * @param \WP_REST_Request $request Request object.
	 * @return \WP_REST_Response
	 */
	public function get_example( $request ) {
		$data = array(
			'message' => 'Hello from the REST API!',
			'user'    => wp_get_current_user()->user_login,
		);

		return new \WP_REST_Response( $data, 200 );
	}

	/**
	 * POST endpoint example.
	 *
	 * @param \WP_REST_Request $request Request object.
	 * @return \WP_REST_Response
	 */
	public function create_example( $request ) {
		$title = $request->get_param( 'title' );

		// Process the data...
		$data = array(
			'success' => true,
			'title'   => $title,
			'message' => 'Data created successfully',
		);

		return new \WP_REST_Response( $data, 201 );
	}

	/**
	 * AJAX handler example.
	 */
	public function ajax_handler() {
		// Verify nonce.
		check_ajax_referer( 'plugin-tpl-ajax', 'nonce' );

		// Get and sanitize data.
		$data = isset( $_POST['data'] ) ? sanitize_text_field( wp_unslash( $_POST['data'] ) ) : '';

		// Process the request...
		$response = array(
			'success' => true,
			'message' => 'AJAX request processed',
			'data'    => $data,
		);

		wp_send_json_success( $response );
	}
}
