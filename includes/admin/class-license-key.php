<?php
/**
 * License Key
 *
 * @package Harrison Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * License Key Class
 */
class Harrison_Pro_License_Key {
	/**
	 * Init Function
	 *
	 * @return void
	 */
	static function init() {

		// Register License Setting.
		add_action( 'init', array( __CLASS__, 'setup' ) );

		// Add License API functions.
		add_action( 'wp_ajax_themezee_activate_license', array( __CLASS__, 'activate_license' ) );
		add_action( 'wp_ajax_themezee_deactivate_license', array( __CLASS__, 'deactivate_license' ) );
		add_action( 'admin_init', array( __CLASS__, 'check_license' ) );
	}

	/**
	 * Actions Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Harrison Theme is not active.
		if ( ! current_theme_supports( 'harrison-pro' ) ) {
			return;
		}

		// Include Customizer Control Files.
		require_once HARRISON_PRO_PLUGIN_DIR . 'includes/customizer/class-customize-license-control.php';

		// Add License Settings in Customizer.
		add_action( 'customize_register', array( __CLASS__, 'license_settings' ) );
	}

	/**
	 * Add license setting in the Customizer
	 *
	 * @param object $wp_customize / Customizer Object.
	 */
	static function license_settings( $wp_customize ) {

		// Add License Key setting.
		$wp_customize->add_setting( 'harrison_theme_options[license_key]', array(
			'default'           => '',
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( new Harrison_Pro_Customize_License_Control(
			$wp_customize, 'harrison_theme_options[license_key]', array(
				'label'    => esc_html__( 'License Key', 'harrison-pro' ),
				'section'  => 'harrison_section_theme_info',
				'settings' => 'harrison_theme_options[license_key]',
				'priority' => 30,
			)
		) );
	}

	/**
	 * Activate license key
	 *
	 * @return void
	 */
	static function activate_license() {
		if ( ! isset( $_REQUEST['license_key'] ) ) {
			die();
		}

		// Get theme options from database.
		$theme_options = Harrison_Pro_Customizer::get_theme_options();

		$license = trim( sanitize_text_field( $_REQUEST['license_key'] ) );	

		if ( '' === $license ) {
			$theme_options['license_status'] = 'inactive';
			$theme_options['license_key']    = '';
			update_option( 'harrison_theme_options', $theme_options );
			die();
		}

		// Data to send in our API request.
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			'item_id'    => HARRISON_PRO_PRODUCT_ID,
			'url'        => home_url(),
		);

		// Call the custom API.
		$response = wp_remote_post( HARRISON_PRO_STORE_API_URL, array(
			'timeout'   => 25,
			'sslverify' => true,
			'body'      => $api_params,
		) );

		// Make sure the response came back okay.
		if ( is_wp_error( $response ) ) {
			echo $response;
			die();
		}

		// Decode the license data.
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// Update License Key and Status.
		$theme_options['license_status'] = $license_data->license;
		$theme_options['license_key']    = $license;
		update_option( 'harrison_theme_options', $theme_options );

		delete_transient( 'harrison_license_check' );

		echo $license_data->license;

		die();
	}

	/**
	 * Deactivate license key
	 *
	 * @return void
	 */
	static function deactivate_license() {
		if ( ! isset( $_REQUEST['license_key'] ) ) {
			die();
		}

		$license = trim( sanitize_text_field( $_REQUEST['license_key'] ) );

		if ( '' === $license ) {
			die();
		}

		// Data to send in our API request.
		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'    => $license,
			'item_id'    => HARRISON_PRO_PRODUCT_ID,
			'url'        => home_url(),
		);

		// Call the custom API.
		$response = wp_remote_post( HARRISON_PRO_STORE_API_URL, array(
			'timeout'   => 25,
			'sslverify' => true,
			'body'      => $api_params,
		) );

		// Make sure the response came back okay.
		if ( is_wp_error( $response ) ) {
			echo $response;
			die();
		}

		// Get theme options from database.
		$theme_options = Harrison_Pro_Customizer::get_theme_options();

		// Update License Status.
		$theme_options['license_status'] = 'inactive';
		update_option( 'harrison_theme_options', $theme_options );

		delete_transient( 'harrison_license_check' );

		echo 'inactive';

		die();
	}

	/**
	 * Check license key
	 *
	 * @return void
	 */
	static function check_license() {

		// Don't fire in Customizer.
		if ( is_customize_preview() ) {
			return;
		}

		$status = get_transient( 'harrison_license_check' );

		// Run the license check a maximum of once per day.
		if ( false === $status ) {

			// Get theme options from database.
			$theme_options = Harrison_Pro_Customizer::get_theme_options();
			$license_key   = $theme_options['license_key'];

			if ( '' !== $license_key and 'inactive' !== $theme_options['license_status'] ) {

				// Data to send in our API request.
				$api_params = array(
					'edd_action' => 'check_license',
					'license'    => $license_key,
					'item_id'    => HARRISON_PRO_PRODUCT_ID,
					'url'        => home_url(),
				);

				// Call the custom API.
				$response = wp_remote_post( HARRISON_PRO_STORE_API_URL, array(
					'timeout'   => 25,
					'sslverify' => true,
					'body'      => $api_params,
				) );

				// Make sure the response came back okay.
				if ( is_wp_error( $response ) ) {
					return false;
				}

				$license_data = json_decode( wp_remote_retrieve_body( $response ) );

				$status = $license_data->license;

			} else {

				$status = 'inactive';

			}

			// Update License Status.
			$theme_options['license_status'] = $status;
			update_option( 'harrison_theme_options', $theme_options );

			// Cache license check with transient.
			set_transient( 'harrison_license_check', $status, DAY_IN_SECONDS );
		}

		return $status;
	}
}

// Run Class.
Harrison_Pro_License_Key::init();
