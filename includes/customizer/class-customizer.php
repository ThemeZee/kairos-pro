<?php
/**
 * Customizer
 *
 * Setup the Customizer and theme options for the Pro plugin
 *
 * @package Kairos Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Customizer Class
 */
class Kairos_Pro_Customizer {

	/**
	 * Customizer Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Kairos Theme is not active.
		if ( ! current_theme_supports( 'kairos-pro' ) ) {
			return;
		}

		// Enqueue scripts and styles in the Customizer.
		add_action( 'customize_preview_init', array( __CLASS__, 'customize_preview_js' ) );
		add_action( 'customize_controls_print_styles', array( __CLASS__, 'customize_preview_css' ) );

		// Remove Upgrade section.
		remove_action( 'customize_register', 'kairos_customize_register_upgrade_settings' );
	}

	/**
	 * Get saved user settings from database or plugin defaults
	 *
	 * @return array
	 */
	static function get_theme_options() {

		// Merge Theme Options Array from Database with Default Options Array.
		return wp_parse_args( get_option( 'kairos_theme_options', array() ), self::get_default_options() );
	}

	/**
	 * Returns the default settings of the plugin
	 *
	 * @return array
	 */
	static function get_default_options() {
		return array(
			'license_key'               => '',
			'license_status'            => 'inactive',
			'header_search'             => false,
			'author_bio'                => false,
			'scroll_to_top'             => false,
			'primary_color'             => '#2a4861',
			'secondary_color'           => '#5d7b94',
			'tertiary_color'            => '#90aec7',
			'accent_color'              => '#60945d',
			'highlight_color'           => '#915d94',
			'light_gray_color'          => '#ededef',
			'gray_color'                => '#84848f',
			'dark_gray_color'           => '#24242f',
			'page_color'                => '#ffffff',
			'header_color'              => '#ffffff',
			'navi_color'                => '#e36355',
			'link_color'                => '#c9493b',
			'link_hover_color'          => '#e36355',
			'button_color'              => '#c9493b',
			'button_hover_color'        => '#e36355',
			'title_color'               => '#202020',
			'title_hover_color'         => '#e36355',
			'footer_widgets_color'      => '#252525',
			'footer_color'              => '#202020',
			'text_font'                 => 'Barlow',
			'title_font'                => 'Barlow',
			'title_is_bold'             => true,
			'title_is_uppercase'        => false,
			'navi_font'                 => 'Barlow',
			'navi_is_bold'              => false,
			'navi_is_uppercase'         => false,
			'widget_title_font'         => 'Barlow',
			'widget_title_is_bold'      => true,
			'widget_title_is_uppercase' => false,
		);
	}

	/**
	 * Embed JS file to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @return void
	 */
	static function customize_preview_js() {
		wp_enqueue_script( 'kairos-pro-customize-preview', KAIROS_PRO_PLUGIN_URL . 'assets/js/customize-preview.js', array( 'customize-preview' ), '20201117', true );
	}

	/**
	 * Embed CSS styles for the theme options in the Customizer
	 *
	 * @return void
	 */
	static function customize_preview_css() {
		wp_enqueue_style( 'kairos-pro-customizer-css', KAIROS_PRO_PLUGIN_URL . 'assets/css/customizer.css', array(), KAIROS_PRO_VERSION );
	}
}

// Run Class.
add_action( 'init', array( 'Kairos_Pro_Customizer', 'setup' ) );
