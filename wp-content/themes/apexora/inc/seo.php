<?php
/**
 * Classic SEO: meta description, robots, Open Graph, Twitter, canonical.
 *
 * @package Apexora
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Per-page SEO meta map (slug => data).
 */
function apexora_seo_page_map(): array {
	$org = apexora_org_name();
	return array(
		'home'           => array(
			'title'       => $org . ' — Software House & Digital Product Studio',
			'description' => $org . ' membangun produk digital, web app, mobile, dan sistem enterprise dengan fokus kualitas, keamanan, dan growth.',
			'keywords'    => 'software house, web development, mobile app, digital product, jakarta',
		),
		'tentang-kami'   => array(
			'title'       => 'Tentang Kami | ' . $org,
			'description' => 'Kenali visi, misi, dan tim engineering ' . $org . ' — software house yang membantu bisnis bertransformasi digital.',
			'keywords'    => 'tentang software house, profil perusahaan IT, tim engineering',
		),
		'produk-servis'  => array(
			'title'       => 'Produk & Servis | ' . $org,
			'description' => 'Layanan custom software, product discovery, cloud, DevOps, UI/UX, dan maintenance dari ' . $org . '.',
			'keywords'    => 'jasa software house, custom software, devops, ui ux, cloud',
		),
		'kontak'         => array(
			'title'       => 'Kontak | ' . $org,
			'description' => 'Hubungi ' . $org . ' untuk konsultasi proyek software, partnership, atau dukungan teknis.',
			'keywords'    => 'kontak software house, konsultasi IT, hubungi developer',
		),
		'events'         => array(
			'title'       => 'Events | ' . $org,
			'description' => 'Workshop, meetup, dan webinar teknologi dari ' . $org . ' untuk komunitas developer dan bisnis.',
			'keywords'    => 'tech event, workshop developer, meetup software',
		),
		'faq'            => array(
			'title'       => 'FAQ | ' . $org,
			'description' => 'Jawaban singkat tentang proses kerja, timeline, harga, dan engagement model di ' . $org . '.',
			'keywords'    => 'faq software house, harga development, proses proyek IT',
		),
		'member-login'   => array(
			'title'       => 'Member Login | ' . $org,
			'description' => 'Portal login member dan klien ' . $org . ' untuk mengakses dashboard proyek.',
			'keywords'    => 'member login, client portal, project dashboard',
			'robots'      => 'noindex,nofollow',
		),
		'blog'           => array(
			'title'       => 'Blog & Artikel | ' . $org,
			'description' => 'Artikel engineering, product, dan praktik software house dari tim ' . $org . '.',
			'keywords'    => 'blog software house, artikel IT, engineering insights',
		),
	);
}

/**
 * Resolve SEO data for current view.
 */
function apexora_current_seo(): array {
	$map  = apexora_seo_page_map();
	$org  = apexora_org_name();
	$slug = 'home';

	$defaults = array(
		'title'       => get_bloginfo( 'name' ),
		'description' => get_bloginfo( 'description' ),
		'keywords'    => 'software house, web development',
		'robots'      => 'index,follow,max-image-preview:large',
	);

	if ( is_singular( 'post' ) ) {
		$post    = get_queried_object();
		$excerpt = '';
		if ( $post instanceof WP_Post ) {
			$excerpt = $post->post_excerpt
				? $post->post_excerpt
				: wp_trim_words( wp_strip_all_tags( $post->post_content ), 28 );
		}
		return array_merge(
			$defaults,
			array(
				'title'       => get_the_title( $post ) . ' | ' . $org,
				'description' => $excerpt ?: ( 'Artikel dari ' . $org ),
				'keywords'    => 'artikel, blog, ' . $org,
			)
		);
	}

	if ( is_home() && ! is_front_page() ) {
		$slug = 'blog';
	} elseif ( is_category() || is_tag() || is_author() || is_date() ) {
		return array_merge(
			$defaults,
			array(
				'title'       => wp_strip_all_tags( get_the_archive_title() ) . ' | ' . $org,
				'description' => wp_strip_all_tags( get_the_archive_description() ) ?: ( 'Arsip artikel ' . $org ),
			)
		);
	} elseif ( is_front_page() ) {
		$slug = 'home';
	} elseif ( is_page() ) {
		$slug = get_post_field( 'post_name', get_queried_object_id() );
	}

	return isset( $map[ $slug ] ) ? array_merge( $defaults, $map[ $slug ] ) : $defaults;
}

/**
 * Document title filter — skip override when empty custom title for archives handled above.
 */
add_filter(
	'pre_get_document_title',
	function ( $title ) {
		$seo = apexora_current_seo();
		return ! empty( $seo['title'] ) ? $seo['title'] : $title;
	}
);

/**
 * Emit SEO meta tags.
 */
add_action(
	'wp_head',
	function () {
		$seo  = apexora_current_seo();
		if ( is_singular() ) {
			$url = get_permalink();
		} elseif ( is_home() && ! is_front_page() ) {
			$url = apexora_blog_url();
		} elseif ( is_category() || is_tag() || is_author() || is_date() ) {
			$url = get_pagenum_link();
		} else {
			$url = home_url( '/' );
		}
		$org  = apexora_org_name();
		$og   = function_exists( 'apexora_env' ) ? apexora_env( 'SITE_DEFAULT_OG_IMAGE', '' ) : '';
		$tw   = function_exists( 'apexora_env' ) ? apexora_env( 'SITE_TWITTER_HANDLE', '@apexora' ) : '@apexora';

		if ( $og && ! preg_match( '#^https?://#', $og ) ) {
			$og = home_url( $og );
		}
		if ( ! $og ) {
			$og = APEXORA_URI . '/assets/img/og-default.svg';
		}

		if ( has_post_thumbnail() ) {
			$thumb = get_the_post_thumbnail_url( null, 'full' );
			if ( $thumb ) {
				$og = $thumb;
			}
		}
		?>
		<meta name="description" content="<?php echo esc_attr( $seo['description'] ); ?>" />
		<meta name="keywords" content="<?php echo esc_attr( $seo['keywords'] ); ?>" />
		<meta name="robots" content="<?php echo esc_attr( $seo['robots'] ); ?>" />
		<meta name="author" content="<?php echo esc_attr( $org ); ?>" />
		<link rel="canonical" href="<?php echo esc_url( $url ); ?>" />

		<meta property="og:locale" content="id_ID" />
		<meta property="og:type" content="<?php echo is_front_page() ? 'website' : 'article'; ?>" />
		<meta property="og:site_name" content="<?php echo esc_attr( $org ); ?>" />
		<meta property="og:title" content="<?php echo esc_attr( $seo['title'] ); ?>" />
		<meta property="og:description" content="<?php echo esc_attr( $seo['description'] ); ?>" />
		<meta property="og:url" content="<?php echo esc_url( $url ); ?>" />
		<meta property="og:image" content="<?php echo esc_url( $og ); ?>" />

		<meta name="twitter:card" content="summary_large_image" />
		<meta name="twitter:site" content="<?php echo esc_attr( $tw ); ?>" />
		<meta name="twitter:title" content="<?php echo esc_attr( $seo['title'] ); ?>" />
		<meta name="twitter:description" content="<?php echo esc_attr( $seo['description'] ); ?>" />
		<meta name="twitter:image" content="<?php echo esc_url( $og ); ?>" />
		<?php
	},
	2
);
