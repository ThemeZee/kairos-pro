<?php
/**
 * Customizer
 *
 * Setup the Customizer and theme options for the Pro plugin
 *
 * @package Harrison Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Customizer Class
 */
class Harrison_Pro_Customizer {

	/**
	 * Customizer Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Harrison Theme is not active.
		if ( ! current_theme_supports( 'harrison-pro' ) ) {
			return;
		}

		// Enqueue scripts and styles in the Customizer.
		add_action( 'customize_preview_init', array( __CLASS__, 'customize_preview_js' ) );
		add_action( 'customize_controls_print_styles', array( __CLASS__, 'customize_preview_css' ) );

		// Remove Upgrade section.
		remove_action( 'customize_register', 'harrison_customize_register_upgrade_settings' );
	}

	/**
	 * Get saved user settings from database or plugin defaults
	 *
	 * @return array
	 */
	static function get_theme_options() {

		// Merge Theme Options Array from Database with Default Options Array.
		$theme_options = wp_parse_args( get_option( 'harrison_theme_options', array() ), self::get_default_options() );

		// Return theme options.
		return $theme_options;
	}

	/**
	 * Returns the default settings of the plugin
	 *
	 * @return array
	 */
	static function get_default_options() {

		$default_options = array(
			'license_key'          => '',
			'license_status'       => 'inactive',
			'header_search'        => false,
			'author_bio'           => false,
			'scroll_to_top'        => false,
			'primary_color'        => '#c9493b',
			'secondary_color'      => '#e36355',
			'accent_color'         => '#078896',
			'highlight_color'      => '#5bb021',
			'light_gray_color'     => '#e4e4e4',
			'gray_color'           => '#848484',
			'dark_gray_color'      => '#242424',
			'page_color'           => '#ffffff',
			'header_color'         => '#ffffff',
			'navi_color'           => '#e36355',
			'link_color'           => '#c9493b',
			'link_hover_color'     => '#e36355',
			'button_color'         => '#c9493b',
			'button_hover_color'   => '#e36355',
			'title_color'          => '#202020',
			'title_hover_color'    => '#e36355',
			'footer_widgets_color' => '#252525',
			'footer_color'         => '#202020',
			'text_font'            => 'Barlow',
			'title_font'           => 'Barlow',
			'title_is_bold'        => true,
			'title_is_uppercase'   => false,
			'navi_font'            => 'Barlow',
			'navi_is_bold'         => false,
			'navi_is_uppercase'    => false,
		);

		return $default_options;
	}

	/**
	 * Embed JS file to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @return void
	 */
	static function customize_preview_js() {
		wp_enqueue_script( 'harrison-pro-customize-preview', HARRISON_PRO_PLUGIN_URL . 'assets/js/customize-preview.min.js', array( 'customize-preview' ), '20191114', true );
	}

	/**
	 * Embed CSS styles for the theme options in the Customizer
	 *
	 * @return void
	 */
	static function customize_preview_css() {
		wp_enqueue_style( 'harrison-pro-customizer-css', HARRISON_PRO_PLUGIN_URL . 'assets/css/customizer.css', array(), HARRISON_PRO_VERSION );
	}
}

// Run Class.
add_action( 'init', array( 'Harrison_Pro_Customizer', 'setup' ) );
