<?php
/**
 * Apexora Softworks theme bootstrap.
 *
 * @package Apexora
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'APEXORA_VERSION', '1.0.0' );
define( 'APEXORA_DIR', get_template_directory() );
define( 'APEXORA_URI', get_template_directory_uri() );

require_once APEXORA_DIR . '/inc/setup.php';
require_once APEXORA_DIR . '/inc/enqueue.php';
require_once APEXORA_DIR . '/inc/analytics.php';
require_once APEXORA_DIR . '/inc/seo.php';
require_once APEXORA_DIR . '/inc/aeo-geo-aio.php';
require_once APEXORA_DIR . '/inc/schema.php';
require_once APEXORA_DIR . '/inc/pages-setup.php';
require_once APEXORA_DIR . '/inc/blog.php';
require_once APEXORA_DIR . '/inc/contact.php';

/**
 * Add Tailwind-friendly classes to nav links.
 */
add_filter(
	'nav_menu_link_attributes',
	function ( $atts, $item ) {
		$classes = 'nav-link';
		if ( ! empty( $item->current ) || ! empty( $item->current_item_ancestor ) ) {
			$classes .= ' is-active';
		}
		$atts['class'] = isset( $atts['class'] ) ? $atts['class'] . ' ' . $classes : $classes;
		return $atts;
	},
	10,
	2
);
