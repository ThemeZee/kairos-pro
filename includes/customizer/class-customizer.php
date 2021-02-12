<?php
/**
 * Customizer
 *
 * Setup the Customizer and theme options for the Pro plugin
 *
 * @package Occasio Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Customizer Class
 */
class Occasio_Pro_Customizer {

	/**
	 * Customizer Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Occasio Theme is not active.
		if ( ! current_theme_supports( 'occasio-pro' ) ) {
			return;
		}

		// Enqueue scripts and styles in the Customizer.
		add_action( 'customize_preview_init', array( __CLASS__, 'customize_preview_js' ) );
		add_action( 'customize_controls_print_styles', array( __CLASS__, 'customize_preview_css' ) );

		// Remove Upgrade section.
		remove_action( 'customize_register', 'occasio_customize_register_upgrade_settings' );
	}

	/**
	 * Get saved user settings from database or plugin defaults
	 *
	 * @return array
	 */
	static function get_theme_options() {

		// Merge Theme Options Array from Database with Default Options Array.
		return wp_parse_args( get_option( 'occasio_theme_options', array() ), self::get_default_options() );
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
			'header_bar_color'          => '#2a4861',
			'header_color'              => '#2a4861',
			'link_color'                => '#5d7b94',
			'link_hover_color'          => '#2a4861',
			'button_color'              => '#2a4861',
			'button_hover_color'        => '#5d7b94',
			'title_color'               => '#2a4861',
			'title_hover_color'         => '#5d7b94',
			'sidebar_comments_color'    => '#ededef',
			'footer_widgets_color'      => '#2a4861',
			'footer_color'              => '#2a4861',
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
		wp_enqueue_script( 'occasio-pro-customize-preview', OCCASIO_PRO_PLUGIN_URL . 'assets/js/customize-preview.min.js', array( 'customize-preview' ), '20210212', true );
	}

	/**
	 * Embed CSS styles for the theme options in the Customizer
	 *
	 * @return void
	 */
	static function customize_preview_css() {
		wp_enqueue_style( 'occasio-pro-customizer-css', OCCASIO_PRO_PLUGIN_URL . 'assets/css/customizer.css', array(), '20210212' );
	}
}

// Run Class.
add_action( 'init', array( 'Occasio_Pro_Customizer', 'setup' ) );
