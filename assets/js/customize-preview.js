/**
 * Customizer Preview JS
 *
 * Reloads changes on Theme Customizer Preview asynchronously for better usability
 *
 * @package Kairos Pro
 */

( function( $ ) {

	/* Header Search checkbox */
	wp.customize( 'kairos_theme_options[header_search]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				$( 'body' ).addClass( 'header-search-hidden' );
				$( 'body' ).removeClass( 'header-search-enabled' );
				$( 'body' ).removeClass( 'header-search-and-main-navigation-active' );
			} else {
				$( 'body' ).addClass( 'header-search-enabled' );
				$( 'body' ).removeClass( 'header-search-hidden' );

				if ( $( '.site-header .header-main .primary-navigation' ).length > 0 ) {
					$( 'body' ).addClass( 'header-search-and-main-navigation-active' );
				}
			}
		} );
	} );

	/* Author Bio checkbox */
	wp.customize( 'kairos_theme_options[author_bio]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				$( 'body' ).addClass( 'author-bio-hidden' );
			} else {
				$( 'body' ).removeClass( 'author-bio-hidden' );
			}
		} );
	} );

	/* Primary Color Option */
	wp.customize( 'kairos_theme_options[primary_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--primary-color', newval );
		} );
	} );

	/* Secondary Color Option */
	wp.customize( 'kairos_theme_options[secondary_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--secondary-color', newval );
		} );
	} );

	/* Tertiary Color Option */
	wp.customize( 'kairos_theme_options[tertiary_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--tertiary-color', newval );
		} );
	} );

	/* Accent Color Option */
	wp.customize( 'kairos_theme_options[accent_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--accent-color', newval );
		} );
	} );

	/* Highlight Color Option */
	wp.customize( 'kairos_theme_options[highlight_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--highlight-color', newval );
		} );
	} );

	/* Light Gray Color Option */
	wp.customize( 'kairos_theme_options[light_gray_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--light-gray-color', newval );
		} );
	} );

	/* Gray Color Option */
	wp.customize( 'kairos_theme_options[gray_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--gray-color', newval );
		} );
	} );

	/* Dark Gray Color Option */
	wp.customize( 'kairos_theme_options[dark_gray_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--dark-gray-color', newval );
		} );
	} );

	/* Page Background Color Option */
	wp.customize( 'kairos_theme_options[page_color]', function( value ) {
		value.bind( function( newval ) {
			var text_color, medium_text_color, light_text_color, border_color, light_bg_color;

			if( isColorDark( newval ) ) {
				text_color        = 'rgba(255, 255, 255, 0.9)';
				medium_text_color = 'rgba(255, 255, 255, 0.7)';
				light_text_color  = 'rgba(255, 255, 255, 0.5)';
				border_color      = 'rgba(255, 255, 255, 0.1)';
				light_bg_color    = 'rgba(255, 255, 255, 0.05)';
			} else {
				text_color        = 'rgba(0, 0, 0, 0.9)';
				medium_text_color = 'rgba(0, 0, 0, 0.7)';
				light_text_color  = 'rgba(0, 0, 0, 0.5)';
				border_color      = 'rgba(0, 0, 0, 0.1)';
				light_bg_color    = 'rgba(0, 0, 0, 0.05)';
			}

			document.documentElement.style.setProperty( '--page-background-color', newval );
			document.documentElement.style.setProperty( '--text-color', text_color );
			document.documentElement.style.setProperty( '--medium-text-color', medium_text_color );
			document.documentElement.style.setProperty( '--light-text-color', light_text_color );
			document.documentElement.style.setProperty( '--page-border-color', border_color );
			document.documentElement.style.setProperty( '--page-light-bg-color', light_bg_color );
		} );
	} );

	/* Header Color Option */
	wp.customize( 'kairos_theme_options[header_color]', function( value ) {
		value.bind( function( newval ) {
			var text_color, border_color;

			if( isColorDark( newval ) ) {
				text_color = 'rgba(255, 255, 255, 0.9)';
				border_color = 'rgba(255, 255, 255, 0.1)';
			} else {
				text_color = 'rgba(0, 0, 0, 0.9)';
				border_color = 'rgba(0, 0, 0, 0.1)';
			}

			document.documentElement.style.setProperty( '--header-background-color', newval );
			document.documentElement.style.setProperty( '--header-text-color', text_color );
			document.documentElement.style.setProperty( '--header-border-color', border_color );
		} );
	} );

	/* Navigation Color Option */
	wp.customize( 'kairos_theme_options[navi_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--header-text-hover-color', newval );
		} );
	} );

	/* Link Color Option */
	wp.customize( 'kairos_theme_options[link_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--link-color', newval );
		} );
	} );

	/* Link Color Hover Option */
	wp.customize( 'kairos_theme_options[link_hover_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--link-hover-color', newval );
		} );
	} );

	/* Button Color Option */
	wp.customize( 'kairos_theme_options[button_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--button-color', newval );
		} );
	} );

	/* Button Color Hover Option */
	wp.customize( 'kairos_theme_options[button_hover_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--button-hover-color', newval );
		} );
	} );

	/* Title Color Option */
	wp.customize( 'kairos_theme_options[title_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--title-color', newval );
		} );
	} );

	/* Title Hover Color Option */
	wp.customize( 'kairos_theme_options[title_hover_color]', function( value ) {
		value.bind( function( newval ) {
			document.documentElement.style.setProperty( '--title-hover-color', newval );
		} );
	} );

	/* Footer Widgets Color Option */
	wp.customize( 'kairos_theme_options[footer_widgets_color]', function( value ) {
		value.bind( function( newval ) {
			var text_color, link_color, link_hover_color, border_color;

			if( isColorLight( newval ) ) {
				text_color = 'rgba(0, 0, 0, 0.5)';
				link_color = 'rgba(0, 0, 0, 0.95)';
				link_hover_color = 'rgba(0, 0, 0, 0.5)';
				border_color = 'rgba(0, 0, 0, 0.1)';
			} else {
				text_color = 'rgba(255, 255, 255, 0.5)';
				link_color = 'rgba(255, 255, 255, 0.95)';
				link_hover_color = 'rgba(255, 255, 255, 0.5)';
				border_color = 'rgba(255, 255, 255, 0.1)';
			}

			document.documentElement.style.setProperty( '--footer-widgets-background-color', newval );
			document.documentElement.style.setProperty( '--footer-widgets-text-color', text_color );
			document.documentElement.style.setProperty( '--footer-widgets-link-color', link_color );
			document.documentElement.style.setProperty( '--footer-widgets-link-hover-color', link_hover_color );
			document.documentElement.style.setProperty( '--footer-widgets-border-color', border_color );
		} );
	} );

	/* Footer Color Option */
	wp.customize( 'kairos_theme_options[footer_color]', function( value ) {
		value.bind( function( newval ) {
			var text_color, link_color, link_hover_color, border_color;

			if( isColorLight( newval ) ) {
				text_color = 'rgba(0, 0, 0, 0.5)';
				link_color = 'rgba(0, 0, 0, 0.95)';
				link_hover_color = 'rgba(0, 0, 0, 0.5)';
				border_color = 'rgba(0, 0, 0, 0.1)';
			} else {
				text_color = 'rgba(255, 255, 255, 0.5)';
				link_color = 'rgba(255, 255, 255, 0.95)';
				link_hover_color = 'rgba(255, 255, 255, 0.5)';
				border_color = 'rgba(255, 255, 255, 0.1)';
			}

			document.documentElement.style.setProperty( '--footer-background-color', newval );
			document.documentElement.style.setProperty( '--footer-text-color', text_color );
			document.documentElement.style.setProperty( '--footer-link-color', link_color );
			document.documentElement.style.setProperty( '--footer-link-hover-color', link_hover_color );
			document.documentElement.style.setProperty( '--footer-border-color', border_color );
		} );
	} );

	/* Theme Fonts */
	wp.customize( 'kairos_theme_options[text_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "https://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='kairos-pro-custom-text-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#kairos-pro-custom-text-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#kairos-pro-custom-text-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set Font.
			var systemFont = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
			var newFont = newval === 'SystemFontStack' ? systemFont : newval;

			// Set CSS.
			document.documentElement.style.setProperty( '--text-font', newFont );
		} );
	} );

	/* Title Font */
	wp.customize( 'kairos_theme_options[title_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "https://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='kairos-pro-custom-title-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#kairos-pro-custom-title-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#kairos-pro-custom-title-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set Font.
			var systemFont = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
			var newFont = newval === 'SystemFontStack' ? systemFont : newval;

			// Set CSS.
			document.documentElement.style.setProperty( '--title-font', newFont );
		} );
	} );

	/* Title Font Weight */
	wp.customize( 'kairos_theme_options[title_is_bold]', function( value ) {
		value.bind( function( newval ) {
			var fontWeight = newval ? 'bold' : 'normal';
			document.documentElement.style.setProperty( '--title-font-weight', fontWeight );
		} );
	} );

	/* Title Text Transform */
	wp.customize( 'kairos_theme_options[title_is_uppercase]', function( value ) {
		value.bind( function( newval ) {
			var textTransform = newval ? 'uppercase' : 'none';
			document.documentElement.style.setProperty( '--title-text-transform', textTransform );
		} );
	} );

	/* Navigation Font */
	wp.customize( 'kairos_theme_options[navi_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "https://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='kairos-pro-custom-navi-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#kairos-pro-custom-navi-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#kairos-pro-custom-navi-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set Font.
			var systemFont = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
			var newFont = newval === 'SystemFontStack' ? systemFont : newval;

			// Set CSS.
			document.documentElement.style.setProperty( '--navi-font', newFont );
		} );
	} );

	/* Navi Font Weight */
	wp.customize( 'kairos_theme_options[navi_is_bold]', function( value ) {
		value.bind( function( newval ) {
			var fontWeight = newval ? 'bold' : 'normal';
			document.documentElement.style.setProperty( '--navi-font-weight', fontWeight );
		} );
	} );

	/* Navi Text Transform */
	wp.customize( 'kairos_theme_options[navi_is_uppercase]', function( value ) {
		value.bind( function( newval ) {
			var textTransform = newval ? 'uppercase' : 'none';
			document.documentElement.style.setProperty( '--navi-text-transform', textTransform );
		} );
	} );

	/* Widget Title Font */
	wp.customize( 'kairos_theme_options[widget_title_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "https://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='kairos-pro-custom-widget-title-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#kairos-pro-custom-widget-title-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#kairos-pro-custom-widget-title-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set Font.
			var systemFont = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
			var newFont = newval === 'SystemFontStack' ? systemFont : newval;

			// Set CSS.
			document.documentElement.style.setProperty( '--widget-title-font', newFont );
		} );
	} );

	/* Widget Title Font Weight */
	wp.customize( 'kairos_theme_options[widget_title_is_bold]', function( value ) {
		value.bind( function( newval ) {
			var fontWeight = newval ? 'bold' : 'normal';
			document.documentElement.style.setProperty( '--widget-title-font-weight', fontWeight );
		} );
	} );

	/* Widget Title Text Transform */
	wp.customize( 'kairos_theme_options[widget_title_is_uppercase]', function( value ) {
		value.bind( function( newval ) {
			var textTransform = newval ? 'uppercase' : 'none';
			document.documentElement.style.setProperty( '--widget-title-text-transform', textTransform );
		} );
	} );

	function hexdec( hexString ) {
		hexString = ( hexString + '' ).replace( /[^a-f0-9]/gi, '' );
		return parseInt( hexString, 16 );
	}

	function getColorBrightness( hexColor ) {

		// Remove # string.
		hexColor = hexColor.replace( '#', '' );

		// Convert into RGB.
		var r = hexdec( hexColor.substring( 0, 2 ) );
		var g = hexdec( hexColor.substring( 2, 4 ) );
		var b = hexdec( hexColor.substring( 4, 6 ) );

		return ( ( ( r * 299 ) + ( g * 587 ) + ( b * 114 ) ) / 1000 );
	}

	function isColorLight( hexColor ) {
		return ( getColorBrightness( hexColor ) > 130 );
	}

	function isColorDark( hexColor ) {
		return ( getColorBrightness( hexColor ) <= 130 );
	}

} )( jQuery );
