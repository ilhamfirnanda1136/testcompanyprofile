<?php
/**
 * Auto-create company profile pages, menu, and homepage on theme activation.
 *
 * @package Apexora
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Page definitions.
 */
function apexora_default_pages(): array {
	return array(
		'tentang-kami'  => array(
			'title'   => 'Tentang Kami',
			'content' => '<!-- wp:paragraph --><p>Apexora Softworks adalah software house yang membantu bisnis merancang, membangun, dan menskalakan produk digital.</p><!-- /wp:paragraph -->',
		),
		'produk-servis' => array(
			'title'   => 'Produk / Servis',
			'content' => '<!-- wp:paragraph --><p>Layanan custom software, discovery, UI/UX, cloud, mobile, dan support berkelanjutan.</p><!-- /wp:paragraph -->',
		),
		'kontak'        => array(
			'title'   => 'Kontak',
			'content' => '<!-- wp:paragraph --><p>Hubungi tim kami untuk konsultasi proyek.</p><!-- /wp:paragraph -->',
		),
		'events'        => array(
			'title'   => 'Events',
			'content' => '<!-- wp:paragraph --><p>Workshop, meetup, dan webinar teknologi.</p><!-- /wp:paragraph -->',
		),
		'faq'           => array(
			'title'   => 'FAQ',
			'content' => '<!-- wp:paragraph --><p>Pertanyaan yang sering diajukan seputar engagement dan proses kerja.</p><!-- /wp:paragraph -->',
		),
		'member-login'  => array(
			'title'   => 'Member Login',
			'content' => '<!-- wp:paragraph --><p>Portal login member dan klien.</p><!-- /wp:paragraph -->',
		),
		'beranda'       => array(
			'title'   => 'Beranda',
			'content' => '',
		),
		'blog'          => array(
			'title'   => 'Blog',
			'content' => '',
		),
	);
}

/**
 * Create pages + menu when theme is activated.
 */
add_action(
	'after_switch_theme',
	function () {
		$created = array();
		foreach ( apexora_default_pages() as $slug => $page ) {
			$existing = get_page_by_path( $slug );
			if ( $existing ) {
				$created[ $slug ] = $existing->ID;
				continue;
			}
			$id = wp_insert_post(
				array(
					'post_title'   => $page['title'],
					'post_name'    => $slug,
					'post_content' => $page['content'],
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_author'  => 1,
				)
			);
			if ( ! is_wp_error( $id ) ) {
				$created[ $slug ] = $id;
			}
		}

		if ( ! empty( $created['beranda'] ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $created['beranda'] );
		}

		if ( ! empty( $created['blog'] ) ) {
			update_option( 'page_for_posts', $created['blog'] );
		}

		if ( function_exists( 'apexora_maybe_seed_blog_posts' ) ) {
			apexora_maybe_seed_blog_posts();
		}

		$menu_name = 'Apexora Primary';
		$menu      = wp_get_nav_menu_object( $menu_name );
		$menu_id   = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu( $menu_name );

		$order_slugs = array( 'tentang-kami', 'produk-servis', 'blog', 'events', 'faq', 'kontak', 'member-login' );
		$existing_items = wp_get_nav_menu_items( $menu_id );
		$has_items      = is_array( $existing_items ) && count( $existing_items ) > 0;

		if ( ! $has_items ) {
			$pos = 1;
			foreach ( $order_slugs as $slug ) {
				if ( empty( $created[ $slug ] ) ) {
					continue;
				}
				wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-title'     => get_the_title( $created[ $slug ] ),
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $created[ $slug ],
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
						'menu-item-position'  => $pos++,
					)
				);
			}
		}

		$locations            = get_theme_mod( 'nav_menu_locations', array() );
		$locations['primary'] = $menu_id;
		$locations['footer']  = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );

		// Site identity defaults.
		if ( ! get_option( 'blogname' ) || get_option( 'blogname' ) === 'WordPress' ) {
			update_option( 'blogname', apexora_org_name() );
		}
		update_option( 'blogdescription', 'Software house untuk produk digital yang scalable.' );

		flush_rewrite_rules();
	}
);

/**
 * Admin notice if env GA still placeholder.
 */
add_action(
	'admin_notices',
	function () {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$ga = function_exists( 'apexora_env' ) ? apexora_env( 'GA_MEASUREMENT_ID' ) : '';
		if ( $ga === '' || $ga === 'G-XXXXXXXXXX' ) {
			echo '<div class="notice notice-warning"><p><strong>Apexora:</strong> Set <code>GA_MEASUREMENT_ID</code> di file <code>.env</code> root WordPress untuk mengaktifkan Google Analytics.</p></div>';
		}
	}
);
