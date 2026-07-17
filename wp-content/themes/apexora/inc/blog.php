<?php
/**
 * Blog helpers — connected to WordPress Posts CMS.
 *
 * @package Apexora
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Blog posts page URL (Posts page in Settings > Reading).
 */
function apexora_blog_url(): string {
	$posts_page_id = (int) get_option( 'page_for_posts' );
	if ( $posts_page_id > 0 ) {
		return get_permalink( $posts_page_id );
	}
	return home_url( '/blog/' );
}

/**
 * Estimated reading time in minutes.
 */
function apexora_reading_time( ?int $post_id = null ): int {
	$post_id = $post_id ?: get_the_ID();
	$content = get_post_field( 'post_content', $post_id );
	$words   = str_word_count( wp_strip_all_tags( (string) $content ) );
	return max( 1, (int) ceil( $words / 200 ) );
}

/**
 * Formatted post meta line.
 */
function apexora_post_meta_line( ?int $post_id = null ): string {
	$post_id = $post_id ?: get_the_ID();
	$date    = get_the_date( '', $post_id );
	$author  = get_the_author_meta( 'display_name', (int) get_post_field( 'post_author', $post_id ) );
	$mins    = apexora_reading_time( $post_id );
	return sprintf(
		/* translators: 1: date, 2: author, 3: minutes */
		__( '%1$s · %2$s · %3$d min baca', 'apexora' ),
		$date,
		$author,
		$mins
	);
}

/**
 * Excerpt length for blog cards.
 */
add_filter(
	'excerpt_length',
	static function () {
		return 28;
	}
);

add_filter(
	'excerpt_more',
	static function () {
		return '…';
	}
);

/**
 * Ensure Blog page exists and is assigned as posts page.
 */
function apexora_ensure_blog_page(): int {
	$existing_id = (int) get_option( 'page_for_posts' );
	if ( $existing_id > 0 && get_post_status( $existing_id ) ) {
		return $existing_id;
	}

	$page = get_page_by_path( 'blog' );
	if ( $page ) {
		$id = (int) $page->ID;
	} else {
		$id = (int) wp_insert_post(
			array(
				'post_title'   => 'Blog',
				'post_name'    => 'blog',
				'post_content' => '',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_author'  => 1,
			)
		);
	}

	if ( $id > 0 && ! is_wp_error( $id ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_for_posts', $id );
		if ( ! get_option( 'page_on_front' ) ) {
			$home = get_page_by_path( 'beranda' );
			if ( $home ) {
				update_option( 'page_on_front', (int) $home->ID );
			}
		}
	}

	return $id;
}

/**
 * Seed a few sample posts if none exist (demo CMS content).
 */
function apexora_maybe_seed_blog_posts(): void {
	$count = (int) wp_count_posts( 'post' )->publish;
	if ( $count > 0 ) {
		return;
	}

	$samples = array(
		array(
			'title'   => 'Cara Software House Memilih Stack yang Tepat',
			'content' => "Memilih stack bukan soal tren, tapi soal konteks bisnis, tim, dan horizon produk.\n\nDi Apexora, kami mulai dari constraint: timeline, skill internal klien, kebutuhan integrasi, dan biaya operasional. Baru setelah itu kami usulkan arsitektur yang realistis untuk MVP maupun skala enterprise.\n\nKesimpulannya: stack yang baik adalah yang bisa dioperasikan tim Anda setelah go-live.",
			'cats'    => array( 'Engineering' ),
		),
		array(
			'title'   => 'Dari Brief ke MVP dalam 4–8 Minggu',
			'content' => "MVP yang sehat punya satu job utama: menguji asumsi terbesar dengan risiko terkecil.\n\nProses kami biasanya: discovery singkat, prioritas fitur, prototype, lalu sprint delivery dengan demo mingguan. Stakeholder selalu tahu apa yang sudah selesai dan apa yang ditunda.\n\nDengan ritme itu, keputusan produk lebih cepat dan biaya tidak bocor ke fitur yang belum dibutuhkan.",
			'cats'    => array( 'Product' ),
		),
		array(
			'title'   => 'Checklist Keamanan Sebelum Go-Live',
			'content' => "Sebelum production, pastikan autentikasi, otorisasi, secret management, backup, monitoring, dan dependency update sudah ada pemiliknya.\n\nKeamanan bukan fitur terakhir — itu bagian dari definition of done. Tim Apexora menyertakan checklist ringan di setiap rilis agar risiko operasional terkontrol sejak hari pertama.",
			'cats'    => array( 'Security' ),
		),
	);

	foreach ( $samples as $sample ) {
		$cat_ids = array();
		foreach ( $sample['cats'] as $cat_name ) {
			$term = term_exists( $cat_name, 'category' );
			if ( ! $term ) {
				$term = wp_insert_term( $cat_name, 'category' );
			}
			if ( ! is_wp_error( $term ) ) {
				$cat_ids[] = (int) ( is_array( $term ) ? $term['term_id'] : $term );
			}
		}

		wp_insert_post(
			array(
				'post_title'   => $sample['title'],
				'post_content' => $sample['content'],
				'post_status'  => 'publish',
				'post_type'    => 'post',
				'post_author'  => 1,
				'post_category'=> $cat_ids,
			)
		);
	}
}

/**
 * Add Blog to primary menu if missing.
 */
function apexora_ensure_blog_in_menu(): void {
	$blog_id = apexora_ensure_blog_page();
	if ( $blog_id <= 0 ) {
		return;
	}

	$locations = get_theme_mod( 'nav_menu_locations', array() );
	$menu_id   = isset( $locations['primary'] ) ? (int) $locations['primary'] : 0;
	if ( $menu_id <= 0 ) {
		$menu = wp_get_nav_menu_object( 'Apexora Primary' );
		$menu_id = $menu ? (int) $menu->term_id : 0;
	}
	if ( $menu_id <= 0 ) {
		return;
	}

	$items = wp_get_nav_menu_items( $menu_id );
	if ( is_array( $items ) ) {
		foreach ( $items as $item ) {
			if ( (int) $item->object_id === $blog_id ) {
				return;
			}
		}
	}

	wp_update_nav_menu_item(
		$menu_id,
		0,
		array(
			'menu-item-title'     => 'Blog',
			'menu-item-object'    => 'page',
			'menu-item-object-id' => $blog_id,
			'menu-item-type'      => 'post_type',
			'menu-item-status'    => 'publish',
			'menu-item-position'  => 3,
		)
	);
}

/**
 * Run blog setup once (and on theme switch).
 */
function apexora_setup_blog_feature(): void {
	apexora_ensure_blog_page();
	apexora_maybe_seed_blog_posts();
	apexora_ensure_blog_in_menu();
}

add_action( 'after_switch_theme', 'apexora_setup_blog_feature' );

add_action(
	'init',
	static function () {
		if ( get_option( 'apexora_blog_setup_done' ) === '1' ) {
			return;
		}
		apexora_setup_blog_feature();
		update_option( 'apexora_blog_setup_done', '1' );
	}
);
