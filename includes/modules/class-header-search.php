<?php
/**
 * Header Search
 *
 * Displays header search in main navigation menu
 *
 * @package Harrison Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header Search Class
 */
class Harrison_Pro_Header_Search {

	/**
	 * Header Search Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Harrison Theme is not active.
		if ( ! current_theme_supports( 'harrison-pro' ) ) {
			return;
		}

		// Enqueue Header Search JavaScript.
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_script' ) );

		// Add search icon on main navigation menu.
		add_action( 'harrison_after_navigation', array( __CLASS__, 'add_header_search_icon' ) );

		// Add search form on header area.
		add_action( 'harrison_after_header', array( __CLASS__, 'add_header_search_form' ) );

		// Add Header Search checkbox in Customizer.
		add_action( 'customize_register', array( __CLASS__, 'header_search_settings' ) );

		// Hide Header Search if disabled.
		add_filter( 'body_class', array( __CLASS__, 'hide_header_search' ) );
	}

	/**
	 * Enqueue Scroll-To-Top JavaScript
	 *
	 * @return void
	 */
	static function enqueue_script() {

		// Get Theme Options from Database.
		$theme_options = Harrison_Pro_Customizer::get_theme_options();

		// Embed header search JS if enabled.
		if ( ( true === $theme_options['header_search'] || is_customize_preview() ) && ! self::is_amp() ) :

			wp_enqueue_script( 'harrison-pro-header-search', HARRISON_PRO_PLUGIN_URL . 'assets/js/header-search.js', array( 'jquery' ), HARRISON_PRO_VERSION, true );

		endif;
	}

	/**
	 * Add search icon to navigation menu
	 *
	 * @return void
	 */
	static function add_header_search_icon() {

		// Get Theme Options from Database.
		$theme_options = Harrison_Pro_Customizer::get_theme_options();

		// Show header search if activated.
		if ( true === $theme_options['header_search'] || is_customize_preview() ) : ?>

			<div class="header-search-button">

				<button class="header-search-icon" aria-controls="header-search" aria-expanded="false" <?php self::amp_search_toggle(); ?>>
					<?php echo harrison_get_svg( 'search' ); ?>
					<span class="screen-reader-text"><?php esc_html_e( 'Search', 'harrison-pro' ); ?></span>
				</button>

			</div>

			<?php
		endif;
	}

	/**
	 * Add search form to header area
	 *
	 * @return void
	 */
	static function add_header_search_form() {

		// Get Theme Options from Database.
		$theme_options = Harrison_Pro_Customizer::get_theme_options();

		// Show header search if activated.
		if ( true === $theme_options['header_search'] || is_customize_preview() ) :
			?>

			<div class="header-search-dropdown" <?php self::amp_search_is_toggled(); ?>>
				<div class="header-search-main">
					<div class="header-search-form">
						<?php get_search_form(); ?>
					</div>
				</div>
			</div>

			<?php
		endif;
	}

	/**
	 * Adds header search checkbox setting
	 *
	 * @param object $wp_customize / Customizer Object.
	 */
	static function header_search_settings( $wp_customize ) {

		// Add Header Search Headline.
		$wp_customize->add_control( new Harrison_Customize_Header_Control(
			$wp_customize, 'harrison_theme_options[header_search_title]', array(
				'label'    => esc_html__( 'Header Search', 'harrison-pro' ),
				'section'  => 'harrison_section_layout',
				'settings' => array(),
				'priority' => 30,
			)
		) );

		// Add Header Search setting and control.
		$wp_customize->add_setting( 'harrison_theme_options[header_search]', array(
			'default'           => false,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'harrison_sanitize_checkbox',
		) );

		$wp_customize->add_control( 'harrison_theme_options[header_search]', array(
			'label'    => esc_html__( 'Enable search field in header', 'harrison-pro' ),
			'section'  => 'harrison_section_layout',
			'settings' => 'harrison_theme_options[header_search]',
			'type'     => 'checkbox',
			'priority' => 40,
		) );
	}

	/**
	 * Hide Header Search if deactivated.
	 *
	 * @param array $classes / Body Classes.
	 * @return array $classes
	 */
	static function hide_header_search( $classes ) {

		// Get Theme Options from Database.
		$theme_options = Harrison_Pro_Customizer::get_theme_options();

		// Add class if header search is enabled.
		if ( true === $theme_options['header_search'] ) {
			$classes[] = 'header-search-enabled';
		}

		// Add class if header search and main navigation menu is present.
		if ( true === $theme_options['header_search'] && has_nav_menu( 'primary' ) ) {
			$classes[] = 'header-search-and-main-navigation-active';
		}

		// Hide Author Bio in Customizer for instant live preview.
		if ( is_customize_preview() && false === $theme_options['header_search'] ) {
			$classes[] = 'header-search-hidden';
		}

		return $classes;
	}

	/**
	 * Checks if AMP page is rendered.
	 */
	static function is_amp() {
		return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
	}

	/**
	 * Adds amp support for search toggle.
	 */
	static function amp_search_toggle() {
		if ( self::is_amp() ) {
			echo "[aria-expanded]=\"headerSearchExpanded? 'true' : 'false'\" ";
			echo 'on="tap:AMP.setState({headerSearchExpanded: !headerSearchExpanded})"';
		}
	}

	/**
	 * Adds amp support for search form.
	 */
	static function amp_search_is_toggled() {
		if ( self::is_amp() ) {
			echo "[class]=\"'header-search-dropdown' + ( headerSearchExpanded ? ' toggled-on' : '' )\"";
		}
	}
}

// Run Class.
add_action( 'init', array( 'Harrison_Pro_Header_Search', 'setup' ) );
