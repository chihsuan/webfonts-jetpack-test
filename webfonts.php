<?php
/**
 * Plugin Name: Web API Plugin Tester
 * Plugin URI: https://github.com/test/test
 * Description: Tests a plugin interacting with the API. Uses Jetpack's Google Fonts Provider package.
 * Requires at least: 5.9
 * Requires PHP: 5.6
 * Version: 1.0.0-mmr
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

add_action(
	'after_setup_theme',
	function() {
		/*
		if ( ! function_exists( 'wp_register_webfont_provider' ) || ! function_exists( 'wp_register_webfonts' ) ) {
			return;
		}

		wp_register_webfont_provider( 'jetpack-google-fonts', '\Automattic\Jetpack\Fonts\Google_Fonts_Provider' );
		 */
		if ( ! function_exists( 'wp_register_font_provider' ) || ! function_exists( 'wp_register_fonts' ) ) {
			return;
		}

		wp_register_font_provider( 'jetpack-google-fonts', '\Automattic\Jetpack\Fonts\Google_Fonts_Provider' );

		foreach ( JETPACK_GOOGLE_FONTS_LIST as $font_family ) {
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
			// Remove conditional once WP 6.2 is the minimum version (must confirm this made it into 6.2)
			if ( class_exists( 'WP_Fonts' ) ) {
				$fonts = array(
					$font_family => array( $font_normal, $font_italic ),
				);
			} elseif ( class_exists( 'WP_Webfonts' ) ) {
				$fonts = array( $font_normal, $font_italic );
			}

			// New fonts register function since Gutenberg 15.0 or 15.1
			// See https://github.com/Automattic/jetpack/issues/28063#issuecomment-1387090575
			// Remove conditional once WP 6.2 is the minimum version (must confirm this made it into 6.2)
			if ( function_exists( 'wp_register_fonts' ) ) {
				wp_register_fonts( $fonts );
			} else {
				wp_register_webfonts( $fonts );
			}
		}
	}
);

add_filter( 'wp_resource_hints', '\Automattic\Jetpack\Fonts\Utils::font_source_resource_hint', 10, 2 );
add_filter( 'pre_render_block', '\Automattic\Jetpack\Fonts\Introspectors\Blocks::enqueue_block_fonts', 10, 2 );
add_action( 'init', '\Automattic\Jetpack\Fonts\Introspectors\Global_Styles::enqueue_global_styles_fonts', 22 );

if ( ! function_exists( 'gutenberg_get_global_styles' ) ) {
	/**
	 * Polyfill: Jetpack's package uses the Gutenberg function instead of
	 * the WordPress Core function. The function was removed from Gutenberg
	 * when `lib/compat/wordpress-6.0/` was removed.
	 *
	 * Function to get the styles resulting of merging core, theme, and user data.
	 *
	 * @param array $path    Path to the specific style to retrieve. Optional.
	 *                       If empty, will return all styles.
	 * @param array $context {
	 *     Metadata to know where to retrieve the $path from. Optional.
	 *
	 *     @type string $block_name Which block to retrieve the styles from.
	 *                              If empty, it'll return the styles for the global context.
	 *     @type string $origin     Which origin to take data from.
	 *                              Valid values are 'all' (core, theme, and user) or 'base' (core and theme).
	 *                              If empty or unknown, 'all' is used.
	 * }
	 *
	 * @return array The styles to retrieve.
	 */
	function gutenberg_get_global_styles( $path = array(), $context = array() ) {
		return wp_get_global_styles( $path, $context );
	}
}
