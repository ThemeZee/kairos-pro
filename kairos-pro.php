<?php
/*
Plugin Name: Kairos Pro
Plugin URI: http://themezee.com/addons/kairos-pro/
Description: Kairos Pro is an add-on plugin for Kairos including additional customization options for colors and typography as well as extra features like navigation menus, social icons and footer widgets.
Author: ThemeZee
Author URI: https://themezee.com/
Version: 1.1.1
Text Domain: kairos-pro
Domain Path: /languages/
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Kairos Pro
Copyright(C) 2020, ThemeZee.com - support@themezee.com
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Kairos_Pro Class
 *
 * @package Kairos Pro
 */
class Kairos_Pro {
	/**
	 * Call all Functions to setup the Plugin
	 *
	 * @uses Kairos_Pro::constants() Setup the constants needed
	 * @uses Kairos_Pro::includes() Include the required files
	 * @uses Kairos_Pro::setup_actions() Setup the hooks and actions
	 * @return void
	 */
	static function setup() {

		// Setup Constants.
		self::constants();

		// Setup Translation.
		add_action( 'plugins_loaded', array( __CLASS__, 'translation' ) );

		// Include Files.
		self::includes();

		// Setup Action Hooks.
		self::setup_actions();
	}

	/**
	 * Setup plugin constants
	 *
	 * @return void
	 */
	static function constants() {

		// Define Plugin Name.
		define( 'KAIROS_PRO_NAME', 'Kairos Pro' );

		// Define Version Number.
		define( 'KAIROS_PRO_VERSION', '1.1.1' );

		// Define Plugin Name.
		define( 'KAIROS_PRO_PRODUCT_ID', 214389 );

		// Define Update API URL.
		define( 'KAIROS_PRO_STORE_API_URL', 'https://themezee.com' );

		// Plugin Folder Path.
		define( 'KAIROS_PRO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

		// Plugin Folder URL.
		define( 'KAIROS_PRO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

		// Plugin Root File.
		define( 'KAIROS_PRO_PLUGIN_FILE', __FILE__ );
	}

	/**
	 * Load Translation File
	 *
	 * @return void
	 */
	static function translation() {
		load_plugin_textdomain( 'kairos-pro', false, dirname( plugin_basename( KAIROS_PRO_PLUGIN_FILE ) ) . '/languages/' );
	}

	/**
	 * Include required files
	 *
	 * @return void
	 */
	static function includes() {

		// Include Admin Classes.
		require_once KAIROS_PRO_PLUGIN_DIR . 'includes/admin/class-admin-notices.php';
		require_once KAIROS_PRO_PLUGIN_DIR . 'includes/admin/class-license-key.php';
		require_once KAIROS_PRO_PLUGIN_DIR . 'includes/admin/class-plugin-updater.php';

		// Include Customizer Classes.
		require_once KAIROS_PRO_PLUGIN_DIR . 'includes/customizer/class-customizer.php';

		// Include Pro Features.
		require_once KAIROS_PRO_PLUGIN_DIR . 'includes/modules/class-author-bio.php';
		require_once KAIROS_PRO_PLUGIN_DIR . 'includes/modules/class-block-colors.php';
		require_once KAIROS_PRO_PLUGIN_DIR . 'includes/modules/class-custom-fonts.php';
		require_once KAIROS_PRO_PLUGIN_DIR . 'includes/modules/class-footer-menu.php';
		require_once KAIROS_PRO_PLUGIN_DIR . 'includes/modules/class-footer-widgets.php';
		require_once KAIROS_PRO_PLUGIN_DIR . 'includes/modules/class-header-bar.php';
		require_once KAIROS_PRO_PLUGIN_DIR . 'includes/modules/class-header-search.php';
		require_once KAIROS_PRO_PLUGIN_DIR . 'includes/modules/class-scroll-to-top.php';
		require_once KAIROS_PRO_PLUGIN_DIR . 'includes/modules/class-social-icons.php';
		require_once KAIROS_PRO_PLUGIN_DIR . 'includes/modules/class-theme-colors.php';
		require_once KAIROS_PRO_PLUGIN_DIR . 'includes/modules/class-widget-areas.php';
	}

	/**
	 * Setup Action Hooks
	 *
	 * @see https://codex.wordpress.org/Function_Reference/add_action WordPress Codex
	 * @return void
	 */
	static function setup_actions() {

		// Enqueue Kairos Pro Stylesheet.
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_styles' ), 11 );

		// Add Custom CSS code to the Gutenberg editor.
		add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_editor_styles' ), 11 );

		// Add Settings link to Plugin actions.
		add_filter( 'plugin_action_links_' . plugin_basename( KAIROS_PRO_PLUGIN_FILE ), array( __CLASS__, 'plugin_action_links' ) );

		// Add automatic plugin updater from ThemeZee Store API.
		add_action( 'admin_init', array( __CLASS__, 'plugin_updater' ), 0 );
	}

	/**
	 * Enqueue Styles
	 *
	 * @return void
	 */
	static function enqueue_styles() {

		// Return early if Kairos Theme is not active.
		if ( ! current_theme_supports( 'kairos-pro' ) ) {
			return;
		}

		// Enqueue RTL or default Plugin Stylesheet.
		if ( is_rtl() ) {
			wp_enqueue_style( 'kairos-pro', KAIROS_PRO_PLUGIN_URL . 'assets/css/kairos-pro-rtl.css', array(), KAIROS_PRO_VERSION );
		} else {
			wp_enqueue_style( 'kairos-pro', KAIROS_PRO_PLUGIN_URL . 'assets/css/kairos-pro.css', array(), KAIROS_PRO_VERSION );
		}

		// Enqueue Custom CSS.
		wp_add_inline_style( 'kairos-pro', self::get_custom_css() );
	}

	/**
	 * Enqueue Editor Styles
	 *
	 * @return void
	 */
	static function enqueue_editor_styles() {

		// Return early if Kairos Theme is not active.
		if ( ! current_theme_supports( 'kairos-pro' ) ) {
			return;
		}

		// Enqueue Custom CSS.
		wp_add_inline_style( 'kairos-editor-styles', self::get_custom_css() );
	}

	/**
	 * Return custom CSS for color and font variables.
	 *
	 * @return void
	 */
	static function get_custom_css() {

		// Get Custom CSS.
		$custom_css = apply_filters( 'kairos_pro_custom_css_stylesheet', '' );

		// Sanitize CSS Code.
		$custom_css = wp_kses( $custom_css, array( '\'', '\"' ) );
		$custom_css = str_replace( '&gt;', '>', $custom_css );
		$custom_css = preg_replace( '/\n/', '', $custom_css );
		$custom_css = preg_replace( '/\t/', '', $custom_css );

		return $custom_css;
	}

	/**
	 * Add Settings link to the plugin actions
	 *
	 * @param array $actions Plugin action links.
	 * @return array $actions Plugin action links
	 */
	static function plugin_action_links( $actions ) {
		$settings_link = array(
			'settings' => sprintf( '<a href="%s">%s</a>', wp_customize_url() . '?autofocus[panel]=kairos_options_panel', esc_html__( 'Theme Options', 'kairos-pro' ) ),
		);

		return array_merge( $settings_link, $actions );
	}

	/**
	 * Plugin Updater
	 *
	 * @return void
	 */
	static function plugin_updater() {
		$theme_options = Kairos_Pro_Customizer::get_theme_options();

		// Check if license key was entered.
		if ( '' !== $theme_options['license_key'] ) :

			// Setup the updater.
			$kairos_pro_updater = new Kairos_Pro_Plugin_Updater( KAIROS_PRO_STORE_API_URL, __FILE__, array(
				'version'   => KAIROS_PRO_VERSION,
				'license'   => trim( $theme_options['license_key'] ),
				'item_name' => KAIROS_PRO_NAME,
				'item_id'   => KAIROS_PRO_PRODUCT_ID,
				'author'    => 'ThemeZee',
			) );

		endif;
	}
}

// Run Plugin.
Kairos_Pro::setup();
