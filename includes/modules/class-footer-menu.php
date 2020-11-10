<?php
/**
 * Footer Menu
 *
 * Displays credit link and footer text based on theme options
 * Registers and displays footer navigation
 *
 * @package Kairos Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Footer Menu Class
 */
class Kairos_Pro_Footer_Menu {

	/**
	 * Class Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Kairos Theme is not active.
		if ( ! current_theme_supports( 'kairos-pro' ) ) {
			return;
		}

		// Display footer navigation.
		add_action( 'kairos_footer_menu', array( __CLASS__, 'display_footer_menu' ) );
	}

	/**
	 * Display footer navigation menu
	 *
	 * @return void
	 */
	static function display_footer_menu() {

		// Check if there is a footer menu or social icons.
		if ( has_nav_menu( 'footer' ) || has_nav_menu( 'social-footer' ) ) : ?>

			<div class="footer-menus">

			<?php
			// Check if there is a footer menu.
			if ( has_nav_menu( 'footer' ) ) {

				echo '<nav id="footer-links" class="footer-navigation navigation clearfix" role="navigation">';

				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'footer-navigation-menu',
					'echo'           => true,
					'fallback_cb'    => '',
					'depth'          => 1,
				) );

				echo '</nav><!-- .footer-navigation -->';
			}

			// Check if there is a social icons footer menu.
			if ( has_nav_menu( 'social-footer' ) ) {

				echo '<div class="footer-social-menu-wrap social-menu-wrap">';

				Kairos_Pro_Social_Icons::display_social_icons_menu( 'social-footer' );

				echo '</div>';

			}
			?>

			</div>

			<?php
		endif;
	}

	/**
	 * Register footer navigation menu
	 *
	 * @return void
	 */
	static function register_footer_menu() {

		// Return early if Kairos Theme is not active.
		if ( ! current_theme_supports( 'kairos-pro' ) ) {
			return;
		}

		register_nav_menu( 'footer', esc_html__( 'Footer Navigation', 'kairos-pro' ) );
	}
}

// Run Class.
add_action( 'init', array( 'Kairos_Pro_Footer_Menu', 'setup' ) );

// Register footer navigation in backend.
add_action( 'after_setup_theme', array( 'Kairos_Pro_Footer_Menu', 'register_footer_menu' ), 30 );
