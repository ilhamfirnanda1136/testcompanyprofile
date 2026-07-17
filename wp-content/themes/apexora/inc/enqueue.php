<?php
/**
 * Enqueue Tailwind build + fonts + JS.
 *
 * @package Apexora
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style(
			'apexora-fonts',
			'https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&family=Syne:wght@600;700;800&display=swap',
			array(),
			null
		);

		$css_file = APEXORA_DIR . '/assets/css/app.css';
		$css_ver  = file_exists( $css_file ) ? (string) filemtime( $css_file ) : APEXORA_VERSION;

		wp_enqueue_style(
			'apexora-app',
			APEXORA_URI . '/assets/css/app.css',
			array( 'apexora-fonts' ),
			$css_ver
		);

		wp_enqueue_script(
			'apexora-main',
			APEXORA_URI . '/assets/js/main.js',
			array(),
			APEXORA_VERSION,
			array( 'strategy' => 'defer', 'in_footer' => true )
		);
	}
);
