<?php
/**
 * Header Bar
 *
 * @package Occasio Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header Bar Class
 */
class Occasio_Pro_Header_Bar {

	/**
	 * Class Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Occasio Theme is not active.
		if ( ! current_theme_supports( 'occasio-pro' ) ) {
			return;
		}

		// Display Header Bar.
		add_action( 'occasio_before_header', array( __CLASS__, 'display_header_bar' ), 20 );
	}

	/**
	 * Displays top navigation and social menu on header bar
	 *
	 * @return void
	 */
	static function display_header_bar() {

		// Get theme options.
		$theme_options = Occasio_Pro_Customizer::get_theme_options();

		// Check if there is content for the header bar.
		if ( has_nav_menu( 'secondary' ) || has_nav_menu( 'social-header' ) ) : ?>

			<div id="header-top" class="header-bar-wrap">

				<div id="header-bar" class="header-bar">

					<?php
					// Check if there is a social icons top menu.
					if ( has_nav_menu( 'social-header' ) ) :
						?>

						<div class="header-social-menu-wrap social-menu-wrap">

							<?php Occasio_Pro_Social_Icons::display_social_icons_menu( 'social-header' ); ?>

						</div>

						<?php
					endif;

					// Check if there is a top navigation menu.
					if ( has_nav_menu( 'secondary' ) ) :
						?>

						<button class="secondary-menu-toggle menu-toggle" aria-controls="secondary-menu" aria-expanded="false" <?php self::amp_menu_toggle(); ?>>
							<?php
							echo occasio_get_svg( 'ellipsis' );
							echo occasio_get_svg( 'close' );
							?>
							<span class="menu-toggle-text"><?php esc_html_e( 'Menu', 'occasio-pro' ); ?></span>
						</button>

						<div class="secondary-navigation">

							<nav class="top-navigation" role="navigation" <?php self::amp_menu_is_toggled(); ?> aria-label="<?php esc_attr_e( 'Secondary Menu', 'occasio-pro' ); ?>">

								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'secondary',
										'menu_id'        => 'secondary-menu',
										'container'      => false,
									)
								);
								?>
							</nav><!-- .top-navigation -->

						</div><!-- .secondary-navigation -->

						<?php
					endif;
					?>

				</div>

			</div>

			<?php
		endif;
	}

	/**
	 * Register navigation menus
	 *
	 * @return void
	 */
	static function register_nav_menus() {

		// Return early if Occasio Theme is not active.
		if ( ! current_theme_supports( 'occasio-pro' ) ) {
			return;
		}

		register_nav_menus( array(
			'secondary' => esc_html__( 'Top Navigation', 'occasio-pro' ),
		) );
	}

	/**
	 * Adds amp support for menu toggle.
	 */
	static function amp_menu_toggle() {
		if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
			echo "[aria-expanded]=\"secondaryMenuExpanded? 'true' : 'false'\" ";
			echo 'on="tap:AMP.setState({secondaryMenuExpanded: !secondaryMenuExpanded})"';
		}
	}

	/**
	 * Adds amp support for mobile dropdown navigation menu.
	 */
	static function amp_menu_is_toggled() {
		if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
			echo "[class]=\"'top-navigation' + ( secondaryMenuExpanded ? ' toggled-on' : '' )\"";
		}
	}
}

// Run Class.
add_action( 'init', array( 'Occasio_Pro_Header_Bar', 'setup' ) );

// Register navigation menus in backend.
add_action( 'after_setup_theme', array( 'Occasio_Pro_Header_Bar', 'register_nav_menus' ), 20 );
