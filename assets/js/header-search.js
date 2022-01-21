/**
 * Header Search JS
 *
 * @package Occasio Pro
 */

( function() {

	document.addEventListener( 'DOMContentLoaded', function() {

		// Find header search elements.
		var searchIcon = document.querySelector( '#masthead .header-main .header-search-button .header-search-icon' );
		var searchForm = document.querySelector( '.site #header-search-dropdown' );

		// Return early if header search is missing.
		if ( searchIcon === null ) {
			return;
		}

		// Display Search Form when search icon is clicked.
		searchIcon.addEventListener( 'click', function(e) {
			searchForm.classList.toggle( 'toggled-on' );
			searchForm.querySelector( '.header-search-form .search-form .search-field' ).focus();
			searchIcon.setAttribute( 'aria-expanded', searchForm.classList.contains( 'toggled-on' ) );
			e.stopPropagation();
		});

		// Do not close search form if click is inside header search element.
		searchForm.addEventListener( 'click', function(e) {
			e.stopPropagation();
		});

		// Close search form if click is outside header search element.
		document.addEventListener( 'click', function() {
			searchForm.classList.remove( 'toggled-on' );
			searchIcon.setAttribute( 'aria-expanded', 'false' );
		});

		// Close search form if Escape key is pressed.
		document.addEventListener( 'keyup', function(e) {
			if ( 'Escape' === e.key ) {
				searchForm.classList.remove( 'toggled-on' );
				searchIcon.setAttribute( 'aria-expanded', 'false' );
			}
		});
	} );

} )();
