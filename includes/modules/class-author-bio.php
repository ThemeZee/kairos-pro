<?php
/**
 * Author Bio
 *
 * Displays author bio below single posts
 * Registers and displays footer navigation
 *
 * @package Occasio Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Author Bio Class
 */
class Occasio_Pro_Author_Bio {

	/**
	 * Author Bio Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Occasio Theme is not active.
		if ( ! current_theme_supports( 'occasio-pro' ) ) {
			return;
		}

		// Remove default footer text function and replace it with new one.
		add_action( 'occasio_author_bio', array( __CLASS__, 'author_bio' ) );

		// Add Author Bio checkbox in Customizer.
		add_action( 'customize_register', array( __CLASS__, 'author_bio_settings' ) );

		// Hide Author Bio if disabled.
		add_filter( 'body_class', array( __CLASS__, 'hide_author_bio' ) );
	}

	/**
	 * Displays author bio.
	 *
	 * @return void
	 */
	static function author_bio() {

		// Get Theme Options from Database.
		$theme_options = Occasio_Pro_Customizer::get_theme_options();

		// Show author bio if activated.
		if ( true === $theme_options['author_bio'] || is_customize_preview() ) : ?>

			<div class="entry-author clearfix">
				<div class="author-avatar">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), 256 ); ?>
				</div>

				<div class="author-info">

					<div class="author-heading">
						<h4 class="author-title entry-title"><?php printf( esc_html__( 'About %s', 'occasio-pro' ), '<span class="author-name">' . get_the_author() . '</span>' ); ?></h4>
						<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
							<?php esc_html_e( 'View all posts', 'occasio-pro' ); ?>
						</a>
					</div>

					<p class="author-bio">
						<?php the_author_meta( 'description' ); ?>
					</p>

				</div>
			</div><!-- .author-box -->

			<?php
		endif;
	}

	/**
	 * Adds author bio checkbox setting
	 *
	 * @param object $wp_customize / Customizer Object.
	 */
	static function author_bio_settings( $wp_customize ) {

		// Add Author Bio setting and control.
		$wp_customize->add_setting( 'occasio_theme_options[author_bio]', array(
			'default'           => false,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'occasio_sanitize_checkbox',
		) );

		$wp_customize->add_control( 'occasio_theme_options[author_bio]', array(
			'label'    => __( 'Display author bio', 'occasio-pro' ),
			'section'  => 'occasio_section_post',
			'settings' => 'occasio_theme_options[author_bio]',
			'type'     => 'checkbox',
			'priority' => 145,
		) );
	}

	/**
	 * Hide Author Bio if deactivated.
	 *
	 * @param array $classes / Body Classes.
	 * @return array $classes
	 */
	static function hide_author_bio( $classes ) {

		// Get Theme Options from Database.
		$theme_options = Occasio_Pro_Customizer::get_theme_options();

		// Hide Author Bio in Customizer for instant live preview.
		if ( is_customize_preview() && false === $theme_options['author_bio'] ) {
			$classes[] = 'author-bio-hidden';
		}

		return $classes;
	}
}

// Run Class.
add_action( 'init', array( 'Occasio_Pro_Author_Bio', 'setup' ) );
