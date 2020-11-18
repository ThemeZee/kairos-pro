<?php
/**
 * Theme Colors
 *
 * Adds theme color settings to Customizer and generates color CSS code
 *
 * @package Kairos Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme Colors Class
 */
class Kairos_Pro_Theme_Colors {

	/**
	 * Theme Colors Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Kairos Theme is not active.
		if ( ! current_theme_supports( 'kairos-pro' ) ) {
			return;
		}

		// Add Custom Color CSS code to custom stylesheet output.
		add_filter( 'kairos_pro_custom_css_stylesheet', array( __CLASS__, 'custom_colors_css' ) );

		// Add Custom Color Settings.
		add_action( 'customize_register', array( __CLASS__, 'color_settings' ) );
	}

	/**
	 * Adds Color CSS styles in the head area to override default colors
	 *
	 * @param String $custom_css Custom Styling CSS.
	 * @return string CSS code
	 */
	static function custom_colors_css( $custom_css ) {

		// Get Theme Options from Database.
		$theme_options = Kairos_Pro_Customizer::get_theme_options();

		// Get Default Fonts from settings.
		$default_options = Kairos_Pro_Customizer::get_default_options();

		// Color Variables.
		$color_variables = '';

		// Set Header Bar Background Color.
		if ( $theme_options['header_bar_color'] !== $default_options['header_bar_color'] ) {
			$color_variables .= '--header-bar-background-color: ' . $theme_options['header_bar_color'] . ';';

			// Check if a dark background color was chosen.
			if ( self::is_color_light( $theme_options['header_bar_color'] ) ) {
				$color_variables .= '--header-bar-text-color: #151515;';
				$color_variables .= '--header-bar-text-hover-color: rgba(0, 0, 0, 0.5);';
				$color_variables .= '--header-bar-border-color: rgba(0, 0, 0, 0.1);';
			}
		}

		// Set Header Background Color.
		if ( $theme_options['header_color'] !== $default_options['header_color'] ) {
			$color_variables .= '--header-background-color: ' . $theme_options['header_color'] . ';';

			// Check if a dark background color was chosen.
			if ( self::is_color_light( $theme_options['header_color'] ) ) {
				$color_variables .= '--header-text-color: #151515;';
				$color_variables .= '--header-text-hover-color: rgba(0, 0, 0, 0.5);';
				$color_variables .= '--header-border-color: rgba(0, 0, 0, 0.1);';
			}
		}

		// Set Link Color.
		if ( $theme_options['link_color'] !== $default_options['link_color'] ) {
			$color_variables .= '--link-color: ' . $theme_options['link_color'] . ';';
		}

		// Set Link Hover Color.
		if ( $theme_options['link_hover_color'] !== $default_options['link_hover_color'] ) {
			$color_variables .= '--link-hover-color: ' . $theme_options['link_hover_color'] . ';';
		}

		// Set Button Color.
		if ( $theme_options['button_color'] !== $default_options['button_color'] ) {
			$color_variables .= '--button-color: ' . $theme_options['button_color'] . ';';
		}

		// Set Button Hover Color.
		if ( $theme_options['button_hover_color'] !== $default_options['button_hover_color'] ) {
			$color_variables .= '--button-hover-color: ' . $theme_options['button_hover_color'] . ';';
		}

		// Set Title Color.
		if ( $theme_options['title_color'] !== $default_options['title_color'] ) {
			$color_variables .= '--title-color: ' . $theme_options['title_color'] . ';';
			$color_variables .= '--widget-title-color: ' . $theme_options['title_color'] . ';';
		}

		// Set Title Hover Color.
		if ( $theme_options['title_hover_color'] !== $default_options['title_hover_color'] ) {
			$color_variables .= '--title-hover-color: ' . $theme_options['title_hover_color'] . ';';
			$color_variables .= '--widget-title-hover-color: ' . $theme_options['title_hover_color'] . ';';
		}

		// Set Sidebar & Comments Color.
		if ( $theme_options['sidebar_comments_color'] !== $default_options['sidebar_comments_color'] ) {
			$color_variables .= '--widget-background-color: ' . $theme_options['sidebar_comments_color'] . ';';
			$color_variables .= '--post-meta-background-color: ' . $theme_options['sidebar_comments_color'] . ';';
			$color_variables .= '--comments-background-color: ' . $theme_options['sidebar_comments_color'] . ';';
		}

		// Set Footer Widgets Color.
		if ( $theme_options['footer_widgets_color'] !== $default_options['footer_widgets_color'] ) {
			$color_variables .= '--footer-widgets-background-color: ' . $theme_options['footer_widgets_color'] . ';';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['footer_widgets_color'] ) ) {
				$color_variables .= '--footer-widgets-text-color: #151515;';
				$color_variables .= '--footer-widgets-link-color: rgba(0, 0, 0, 0.6);';
				$color_variables .= '--footer-widgets-link-hover-color: #151515;';
				$color_variables .= '--footer-widgets-border-color: rgba(0, 0, 0, 0.1);';
			}
		}

		// Set Footer Copyright Color.
		if ( $theme_options['footer_color'] !== $default_options['footer_color'] ) {
			$color_variables .= '--footer-background-color: ' . $theme_options['footer_color'] . ';';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['footer_color'] ) ) {
				$color_variables .= '--footer-text-color: rgba(0, 0, 0, 0.6);';
				$color_variables .= '--footer-link-color: #151515;';
				$color_variables .= '--footer-link-hover-color: rgba(0, 0, 0, 0.6);';
				$color_variables .= '--footer-border-color: rgba(0, 0, 0, 0.1);';
			}
		}

		// Set Color Variables.
		if ( '' !== $color_variables ) {
			$custom_css .= ':root {' . $color_variables . '}';
		}

		return $custom_css;
	}

	/**
	 * Adds all color settings in the Customizer
	 *
	 * @param object $wp_customize / Customizer Object.
	 */
	static function color_settings( $wp_customize ) {

		// Add Section for Theme Colors.
		$wp_customize->add_section( 'kairos_pro_section_theme_colors', array(
			'title'    => esc_html__( 'Theme Colors', 'kairos-pro' ),
			'priority' => 110,
			'panel'    => 'kairos_options_panel',
		) );

		// Get Default Colors from settings.
		$default_options = Kairos_Pro_Customizer::get_default_options();

		// Add Header Bar Color setting.
		$wp_customize->add_setting( 'kairos_theme_options[header_bar_color]', array(
			'default'           => $default_options['header_bar_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'kairos_theme_options[header_bar_color]', array(
				'label'    => esc_html_x( 'Top Navigation', 'Color Option', 'kairos-pro' ),
				'section'  => 'kairos_pro_section_theme_colors',
				'settings' => 'kairos_theme_options[header_bar_color]',
				'priority' => 10,
			)
		) );

		// Add Header Color setting.
		$wp_customize->add_setting( 'kairos_theme_options[header_color]', array(
			'default'           => $default_options['header_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'kairos_theme_options[header_color]', array(
				'label'    => esc_html_x( 'Header', 'Color Option', 'kairos-pro' ),
				'section'  => 'kairos_pro_section_theme_colors',
				'settings' => 'kairos_theme_options[header_color]',
				'priority' => 20,
			)
		) );

		// Add Link Color setting.
		$wp_customize->add_setting( 'kairos_theme_options[link_color]', array(
			'default'           => $default_options['link_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'kairos_theme_options[link_color]', array(
				'label'    => esc_html_x( 'Links', 'Color Option', 'kairos-pro' ),
				'section'  => 'kairos_pro_section_theme_colors',
				'settings' => 'kairos_theme_options[link_color]',
				'priority' => 40,
			)
		) );

		// Add Link Hover Color setting.
		$wp_customize->add_setting( 'kairos_theme_options[link_hover_color]', array(
			'default'           => $default_options['link_hover_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'kairos_theme_options[link_hover_color]', array(
				'label'    => esc_html_x( 'Link Hover', 'Color Option', 'kairos-pro' ),
				'section'  => 'kairos_pro_section_theme_colors',
				'settings' => 'kairos_theme_options[link_hover_color]',
				'priority' => 50,
			)
		) );

		// Add Button Color setting.
		$wp_customize->add_setting( 'kairos_theme_options[button_color]', array(
			'default'           => $default_options['button_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'kairos_theme_options[button_color]', array(
				'label'    => esc_html_x( 'Buttons', 'Color Option', 'kairos-pro' ),
				'section'  => 'kairos_pro_section_theme_colors',
				'settings' => 'kairos_theme_options[button_color]',
				'priority' => 60,
			)
		) );

		// Add Button Hover Color setting.
		$wp_customize->add_setting( 'kairos_theme_options[button_hover_color]', array(
			'default'           => $default_options['button_hover_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'kairos_theme_options[button_hover_color]', array(
				'label'    => esc_html_x( 'Button Hover', 'Color Option', 'kairos-pro' ),
				'section'  => 'kairos_pro_section_theme_colors',
				'settings' => 'kairos_theme_options[button_hover_color]',
				'priority' => 70,
			)
		) );

		// Add Titles Color setting.
		$wp_customize->add_setting( 'kairos_theme_options[title_color]', array(
			'default'           => $default_options['title_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'kairos_theme_options[title_color]', array(
				'label'    => esc_html_x( 'Titles', 'Color Option', 'kairos-pro' ),
				'section'  => 'kairos_pro_section_theme_colors',
				'settings' => 'kairos_theme_options[title_color]',
				'priority' => 80,
			)
		) );

		// Add Title Hover Color setting.
		$wp_customize->add_setting( 'kairos_theme_options[title_hover_color]', array(
			'default'           => $default_options['title_hover_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'kairos_theme_options[title_hover_color]', array(
				'label'    => esc_html_x( 'Title Hover', 'Color Option', 'kairos-pro' ),
				'section'  => 'kairos_pro_section_theme_colors',
				'settings' => 'kairos_theme_options[title_hover_color]',
				'priority' => 90,
			)
		) );

		// Add Sidebar & Comments Color setting.
		$wp_customize->add_setting( 'kairos_theme_options[sidebar_comments_color]', array(
			'default'           => $default_options['sidebar_comments_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'kairos_theme_options[sidebar_comments_color]', array(
				'label'    => esc_html_x( 'Sidebar & Comments', 'Color Option', 'kairos-pro' ),
				'section'  => 'kairos_pro_section_theme_colors',
				'settings' => 'kairos_theme_options[sidebar_comments_color]',
				'priority' => 100,
			)
		) );

		// Add Footer Widgets Color setting.
		$wp_customize->add_setting( 'kairos_theme_options[footer_widgets_color]', array(
			'default'           => $default_options['footer_widgets_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'kairos_theme_options[footer_widgets_color]', array(
				'label'    => esc_html_x( 'Footer Widgets', 'Color Option', 'kairos-pro' ),
				'section'  => 'kairos_pro_section_theme_colors',
				'settings' => 'kairos_theme_options[footer_widgets_color]',
				'priority' => 110,
			)
		) );

		// Add Footer Copyright Color setting.
		$wp_customize->add_setting( 'kairos_theme_options[footer_color]', array(
			'default'           => $default_options['footer_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'kairos_theme_options[footer_color]', array(
				'label'    => esc_html_x( 'Footer Copyright', 'Color Option', 'kairos-pro' ),
				'section'  => 'kairos_pro_section_theme_colors',
				'settings' => 'kairos_theme_options[footer_color]',
				'priority' => 120,
			)
		) );
	}

	/**
	 * Returns color brightness.
	 *
	 * @param int Number of brightness.
	 */
	static function get_color_brightness( $hex_color ) {

		// Remove # string.
		$hex_color = str_replace( '#', '', $hex_color );

		// Convert into RGB.
		$r = hexdec( substr( $hex_color, 0, 2 ) );
		$g = hexdec( substr( $hex_color, 2, 2 ) );
		$b = hexdec( substr( $hex_color, 4, 2 ) );

		return ( ( ( $r * 299 ) + ( $g * 587 ) + ( $b * 114 ) ) / 1000 );
	}

	/**
	 * Check if the color is light.
	 *
	 * @param bool True if color is light.
	 */
	static function is_color_light( $hex_color ) {
		return ( self::get_color_brightness( $hex_color ) > 130 );
	}

	/**
	 * Check if the color is dark.
	 *
	 * @param bool True if color is dark.
	 */
	static function is_color_dark( $hex_color ) {
		return ( self::get_color_brightness( $hex_color ) <= 130 );
	}
}

// Run Class.
add_action( 'init', array( 'Kairos_Pro_Theme_Colors', 'setup' ) );
