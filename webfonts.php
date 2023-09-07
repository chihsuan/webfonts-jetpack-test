<?php
/**
 * Plugin Name: Fonts API Test Plugin
 * Plugin URI: https://github.com/wordpress/gutenberg
 * Description: Fonts API tester. Uses Jetpack's Google Fonts Provider package.
 * Requires at least: 5.9
 * Requires PHP: 5.6
 * Version: 1.0.0-ironprogrammer
 * Author: Gutenberg Team
 */

require_once __DIR__ . '/vendor/autoload.php';
const JETPACK_GOOGLE_FONTS_LIST = array(
	'Albert Sans',
	'Alegreya',
	'Arvo',
	'Bodoni Moda',
	'Cabin',
	'Chivo',
	'Commissioner',
	'Cormorant',
	'Courier Prime',
	'Crimson Pro',
	'DM Mono',
	'DM Sans',
	'Domine',
	'EB Garamond',
	'Epilogue',
	'Figtree',
	'Fira Sans',
	'Fraunces',
	'IBM Plex Mono',
	'IBM Plex Sans',
	'Inter',
	'Josefin Sans',
	'Jost',
	'Libre Baskerville',
	'Libre Franklin',
	'Literata',
	'Lora',
	'Merriweather',
	'Montserrat',
	'Newsreader',
	'Nunito',
	'Open Sans',
	'Overpass',
	'Petrona',
	'Piazzolla',
	'Playfair Display',
	'Plus Jakarta Sans',
	'Poppins',
	'Raleway',
	'Roboto Slab',
	'Roboto',
	'Rubik',
	'Sora',
	'Source Sans Pro',
	'Source Serif Pro',
	'Space Mono',
	'Texturina',
	'Work Sans',
);

/**
 * Register a curated selection of Google Fonts.
 *
 * @return void
 */
function jetpack_add_google_fonts_provider() {
  if ( ! function_exists( 'wp_register_font_provider' ) || ! function_exists( 'wp_register_webfonts' ) ) {
		return;
	}

	wp_register_font_provider( 'jetpack-google-fonts', '\Automattic\Jetpack\Fonts\Google_Fonts_Provider' );

	/**
	 * Curated list of Google Fonts.
	 *
	 * @module google-fonts
	 *
	 * @since 10.8
	 *
	 * @param array $fonts_to_register Array of Google Font names to register.
	 */
	$fonts_to_register = apply_filters( 'jetpack_google_fonts_list', JETPACK_GOOGLE_FONTS_LIST );

	foreach ( $fonts_to_register as $font_family ) {
		$fonts = array();

		$font_italic = array(
			'font-family'  => $font_family,
			'font-weight'  => '100 900',
			'font-style'   => 'normal',
			'font-display' => 'fallback',
			'provider'     => 'jetpack-google-fonts',
		);

		$font_normal = array(
			'font-family'  => $font_family,
			'font-weight'  => '100 900',
			'font-style'   => 'italic',
			'font-display' => 'fallback',
			'provider'     => 'jetpack-google-fonts',
		);

		// New WP Fonts API format since Gutenberg 14.9 requires keyed array
		// See https://github.com/Automattic/jetpack/issues/28063
		// Remove conditional once this experimental API makes it to WP Core, and after another core release.
		if ( class_exists( 'WP_Fonts' ) ) {
			$fonts = array(
				$font_family => array( $font_normal, $font_italic ),
			);
		} elseif ( class_exists( 'WP_Webfonts' ) ) {
			$fonts = array( $font_normal, $font_italic );
		}

		// New fonts register function since Gutenberg 15.0 or 15.1
		// See https://github.com/Automattic/jetpack/issues/28063#issuecomment-1387090575
		// Remove conditional once this experimental API makes it to WP Core, and after another core release.
		if ( function_exists( 'wp_register_fonts' ) ) {
			wp_register_fonts( $fonts );
		} else {
			wp_register_webfonts( $fonts );
		}
	}
}
add_action( 'after_setup_theme', 'jetpack_add_google_fonts_provider' );

