<?php
/**
 * Theme Colors
 *
 * Adds theme color settings to Customizer and generates color CSS code
 *
 * @package Harrison Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme Colors Class
 */
class Harrison_Pro_Theme_Colors {

	/**
	 * Theme Colors Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Harrison Theme is not active.
		if ( ! current_theme_supports( 'harrison-pro' ) ) {
			return;
		}

		// Add Custom Color CSS code to custom stylesheet output.
		add_filter( 'harrison_pro_custom_css_stylesheet', array( __CLASS__, 'custom_colors_css' ) );

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
		$theme_options = Harrison_Pro_Customizer::get_theme_options();

		// Get Default Fonts from settings.
		$default_options = Harrison_Pro_Customizer::get_default_options();

		// Color Variables.
		$color_variables = '';

		// Set Page Background Color.
		if ( $theme_options['page_color'] !== $default_options['page_color'] ) {
			$color_variables .= '--page-background-color: ' . $theme_options['page_color'] . ';';

			// Check if a dark background color was chosen.
			if ( self::is_color_dark( $theme_options['page_color'] ) ) {
				$color_variables .= '--text-color: rgba(255, 255, 255, 0.9);';
				$color_variables .= '--medium-text-color: rgba(255, 255, 255, 0.7);';
				$color_variables .= '--light-text-color: rgba(255, 255, 255, 0.5);';
				$color_variables .= '--page-border-color: rgba(255, 255, 255, 0.1);';
				$color_variables .= '--page-light-bg-color: rgba(255, 255, 255, 0.05);';
			}
		}

		// Set Header Background Color.
		if ( $theme_options['header_color'] !== $default_options['header_color'] ) {
			$color_variables .= '--header-background-color: ' . $theme_options['header_color'] . ';';

			// Check if a dark background color was chosen.
			if ( self::is_color_dark( $theme_options['header_color'] ) ) {
				$color_variables .= '--header-text-color: rgba(255, 255, 255, 0.9);';
				$color_variables .= '--header-border-color: rgba(255, 255, 255, 0.1);';
			}
		}

		// Set Navigation Color.
		if ( $theme_options['navi_color'] !== $default_options['navi_color'] ) {
			$color_variables .= '--header-text-hover-color: ' . $theme_options['navi_color'] . ';';
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
		}

		// Set Title Hover Color.
		if ( $theme_options['title_hover_color'] !== $default_options['title_hover_color'] ) {
			$color_variables .= '--title-hover-color: ' . $theme_options['title_hover_color'] . ';';
		}

		// Set Footer Widgets Color.
		if ( $theme_options['footer_widgets_color'] !== $default_options['footer_widgets_color'] ) {
			$color_variables .= '--footer-widgets-background-color: ' . $theme_options['footer_widgets_color'] . ';';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['footer_widgets_color'] ) ) {
				$color_variables .= '--footer-widgets-text-color: rgba(0, 0, 0, 0.5);';
				$color_variables .= '--footer-widgets-link-color: rgba(0, 0, 0, 0.95);';
				$color_variables .= '--footer-widgets-link-hover-color: rgba(0, 0, 0, 0.5);';
				$color_variables .= '--footer-widgets-border-color: rgba(0, 0, 0, 0.1);';
			}
		}

		// Set Footer Copyright Color.
		if ( $theme_options['footer_color'] !== $default_options['footer_color'] ) {
			$color_variables .= '--footer-background-color: ' . $theme_options['footer_color'] . ';';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['footer_color'] ) ) {
				$color_variables .= '--footer-text-color: rgba(0, 0, 0, 0.5);';
				$color_variables .= '--footer-link-color: rgba(0, 0, 0, 0.95);';
				$color_variables .= '--footer-link-hover-color: rgba(0, 0, 0, 0.5);';
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
		$wp_customize->add_section( 'harrison_pro_section_theme_colors', array(
			'title'    => esc_html__( 'Theme Colors', 'harrison-pro' ),
			'priority' => 110,
			'panel'    => 'harrison_options_panel',
		) );

		// Get Default Colors from settings.
		$default_options = Harrison_Pro_Customizer::get_default_options();

		// Add Page Background Color setting.
		$wp_customize->add_setting( 'harrison_theme_options[page_color]', array(
			'default'           => $default_options['page_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'harrison_theme_options[page_color]', array(
				'label'    => esc_html_x( 'Page Background', 'Color Option', 'harrison-pro' ),
				'section'  => 'harrison_pro_section_theme_colors',
				'settings' => 'harrison_theme_options[page_color]',
				'priority' => 10,
			)
		) );

		// Add Header Color setting.
		$wp_customize->add_setting( 'harrison_theme_options[header_color]', array(
			'default'           => $default_options['header_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'harrison_theme_options[header_color]', array(
				'label'    => esc_html_x( 'Header Background', 'Color Option', 'harrison-pro' ),
				'section'  => 'harrison_pro_section_theme_colors',
				'settings' => 'harrison_theme_options[header_color]',
				'priority' => 20,
			)
		) );

		// Add Navigation Color setting.
		$wp_customize->add_setting( 'harrison_theme_options[navi_color]', array(
			'default'           => $default_options['navi_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'harrison_theme_options[navi_color]', array(
				'label'    => esc_html_x( 'Navigation', 'Color Option', 'harrison-pro' ),
				'section'  => 'harrison_pro_section_theme_colors',
				'settings' => 'harrison_theme_options[navi_color]',
				'priority' => 30,
			)
		) );

		// Add Link Color setting.
		$wp_customize->add_setting( 'harrison_theme_options[link_color]', array(
			'default'           => $default_options['link_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'harrison_theme_options[link_color]', array(
				'label'    => esc_html_x( 'Links', 'Color Option', 'harrison-pro' ),
				'section'  => 'harrison_pro_section_theme_colors',
				'settings' => 'harrison_theme_options[link_color]',
				'priority' => 40,
			)
		) );

		// Add Link Hover Color setting.
		$wp_customize->add_setting( 'harrison_theme_options[link_hover_color]', array(
			'default'           => $default_options['link_hover_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'harrison_theme_options[link_hover_color]', array(
				'label'    => esc_html_x( 'Link Hover', 'Color Option', 'harrison-pro' ),
				'section'  => 'harrison_pro_section_theme_colors',
				'settings' => 'harrison_theme_options[link_hover_color]',
				'priority' => 50,
			)
		) );

		// Add Button Color setting.
		$wp_customize->add_setting( 'harrison_theme_options[button_color]', array(
			'default'           => $default_options['button_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'harrison_theme_options[button_color]', array(
				'label'    => esc_html_x( 'Buttons', 'Color Option', 'harrison-pro' ),
				'section'  => 'harrison_pro_section_theme_colors',
				'settings' => 'harrison_theme_options[button_color]',
				'priority' => 60,
			)
		) );

		// Add Button Hover Color setting.
		$wp_customize->add_setting( 'harrison_theme_options[button_hover_color]', array(
			'default'           => $default_options['button_hover_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'harrison_theme_options[button_hover_color]', array(
				'label'    => esc_html_x( 'Button Hover', 'Color Option', 'harrison-pro' ),
				'section'  => 'harrison_pro_section_theme_colors',
				'settings' => 'harrison_theme_options[button_hover_color]',
				'priority' => 70,
			)
		) );

		// Add Titles Color setting.
		$wp_customize->add_setting( 'harrison_theme_options[title_color]', array(
			'default'           => $default_options['title_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'harrison_theme_options[title_color]', array(
				'label'    => esc_html_x( 'Titles', 'Color Option', 'harrison-pro' ),
				'section'  => 'harrison_pro_section_theme_colors',
				'settings' => 'harrison_theme_options[title_color]',
				'priority' => 80,
			)
		) );

		// Add Title Hover Color setting.
		$wp_customize->add_setting( 'harrison_theme_options[title_hover_color]', array(
			'default'           => $default_options['title_hover_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'harrison_theme_options[title_hover_color]', array(
				'label'    => esc_html_x( 'Title Hover', 'Color Option', 'harrison-pro' ),
				'section'  => 'harrison_pro_section_theme_colors',
				'settings' => 'harrison_theme_options[title_hover_color]',
				'priority' => 90,
			)
		) );

		// Add Footer Widgets Color setting.
		$wp_customize->add_setting( 'harrison_theme_options[footer_widgets_color]', array(
			'default'           => $default_options['footer_widgets_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'harrison_theme_options[footer_widgets_color]', array(
				'label'    => esc_html_x( 'Footer Widgets', 'Color Option', 'harrison-pro' ),
				'section'  => 'harrison_pro_section_theme_colors',
				'settings' => 'harrison_theme_options[footer_widgets_color]',
				'priority' => 100,
			)
		) );

		// Add Footer Copyright Color setting.
		$wp_customize->add_setting( 'harrison_theme_options[footer_color]', array(
			'default'           => $default_options['footer_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'harrison_theme_options[footer_color]', array(
				'label'    => esc_html_x( 'Footer Copyright', 'Color Option', 'harrison-pro' ),
				'section'  => 'harrison_pro_section_theme_colors',
				'settings' => 'harrison_theme_options[footer_color]',
				'priority' => 110,
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
add_action( 'init', array( 'Harrison_Pro_Theme_Colors', 'setup' ) );
