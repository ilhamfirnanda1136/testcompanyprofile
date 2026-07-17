<?php
/**
 * Theme supports, menus, image sizes.
 *
 * @package Apexora
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'after_setup_theme',
	function () {
		load_theme_textdomain( 'apexora', APEXORA_DIR . '/languages' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support(
			'html5',
			array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
		);
		add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 240, 'flex-height' => true, 'flex-width' => true ) );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );

		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'apexora' ),
				'footer'  => __( 'Footer Menu', 'apexora' ),
			)
		);

		add_image_size( 'apexora-card', 640, 400, true );
		add_image_size( 'apexora-hero', 1600, 900, true );
	}
);

/**
 * Fallback primary nav when no menu is assigned.
 */
function apexora_fallback_menu(): void {
	$pages = array(
		'tentang-kami'  => __( 'Tentang Kami', 'apexora' ),
		'produk-servis' => __( 'Produk / Servis', 'apexora' ),
		'blog'          => __( 'Blog', 'apexora' ),
		'events'        => __( 'Events', 'apexora' ),
		'faq'           => __( 'FAQ', 'apexora' ),
		'kontak'        => __( 'Kontak', 'apexora' ),
		'member-login'  => __( 'Member Login', 'apexora' ),
	);

	echo '<ul class="flex flex-wrap items-center gap-6">';
	foreach ( $pages as $slug => $label ) {
		$url = ( 'blog' === $slug && function_exists( 'apexora_blog_url' ) )
			? apexora_blog_url()
			: home_url( '/' . $slug . '/' );
		$active = ( 'blog' === $slug )
			? ( ( is_home() || is_singular( 'post' ) || is_category() || is_tag() ) ? ' is-active' : '' )
			: ( is_page( $slug ) ? ' is-active' : '' );
		printf(
			'<li><a class="nav-link%s" href="%s">%s</a></li>',
			esc_attr( $active ),
			esc_url( $url ),
			esc_html( $label )
		);
	}
	echo '</ul>';
}

/**
 * Org name helper.
 */
function apexora_org_name(): string {
	if ( function_exists( 'apexora_env' ) ) {
		$name = apexora_env( 'SITE_ORG_NAME', '' );
		if ( $name !== '' ) {
			return $name;
		}
	}
	return get_bloginfo( 'name' ) ?: 'Apexora Softworks';
}
