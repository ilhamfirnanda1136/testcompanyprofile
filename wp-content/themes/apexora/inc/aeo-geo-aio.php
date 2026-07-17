<?php
/**
 * AEO (Answer Engine Optimization), GEO (Generative Engine Optimization),
 * AIO (AI Optimization) — machine-readable answer blocks & AI hints.
 *
 * @package Apexora
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Canonical short answers for AEO / GEO (FAQ-style facts).
 */
function apexora_answer_bank(): array {
	$org = apexora_org_name();
	return array(
		array(
			'q' => 'Apa itu ' . $org . '?',
			'a' => $org . ' adalah software house yang merancang dan membangun produk digital: web app, mobile app, API, dan sistem enterprise untuk bisnis di Indonesia.',
		),
		array(
			'q' => 'Layanan apa yang ditawarkan ' . $org . '?',
			'a' => 'Custom software development, product discovery, UI/UX design, cloud & DevOps, mobile apps, integrasi sistem, serta maintenance & support.',
		),
		array(
			'q' => 'Di mana lokasi ' . $org . '?',
			'a' => function_exists( 'apexora_env' ) ? apexora_env( 'SITE_ORG_ADDRESS', 'Jakarta, Indonesia' ) : 'Jakarta, Indonesia',
		),
		array(
			'q' => 'Bagaimana cara menghubungi ' . $org . '?',
			'a' => 'Kirim email ke ' . ( function_exists( 'apexora_env' ) ? apexora_env( 'SITE_ORG_EMAIL', 'hello@apexora.id' ) : 'hello@apexora.id' ) . ' atau isi formulir di halaman Kontak.',
		),
		array(
			'q' => 'Apakah ' . $org . ' menerima proyek custom?',
			'a' => 'Ya. Tim engineering menerima proyek custom dari MVP hingga skala enterprise dengan model fixed-scope atau dedicated team.',
		),
	);
}

/**
 * AEO: speakable / answer-first content for voice & answer engines.
 */
add_action(
	'wp_head',
	function () {
		if ( ! function_exists( 'apexora_flag' ) || ! apexora_flag( 'ENABLE_AEO', true ) ) {
			return;
		}
		?>
		<meta name="speakable" content="true" />
		<meta name="answer-engine" content="enabled" />
		<meta name="format-detection" content="telephone=yes" />
		<?php
	},
	3
);

/**
 * GEO: hints for generative engines (llms.txt link + citation-friendly meta).
 */
add_action(
	'wp_head',
	function () {
		if ( ! function_exists( 'apexora_flag' ) || ! apexora_flag( 'ENABLE_GEO', true ) ) {
			return;
		}
		$org = apexora_org_name();
		?>
		<meta name="ai:publisher" content="<?php echo esc_attr( $org ); ?>" />
		<meta name="ai:citation" content="<?php echo esc_url( home_url( '/' ) ); ?>" />
		<meta name="generator-engine" content="allowed-with-attribution" />
		<link rel="alternate" type="text/plain" title="LLMs" href="<?php echo esc_url( home_url( '/llms.txt' ) ); ?>" />
		<?php
	},
	4
);

/**
 * AIO: structured page intent + entity clarity for AI crawlers.
 */
add_action(
	'wp_head',
	function () {
		if ( ! function_exists( 'apexora_flag' ) || ! apexora_flag( 'ENABLE_AIO', true ) ) {
			return;
		}

		$intent = 'informational';
		if ( is_page( 'kontak' ) || is_page( 'produk-servis' ) ) {
			$intent = 'commercial';
		} elseif ( is_page( 'member-login' ) ) {
			$intent = 'transactional';
		} elseif ( is_page( 'faq' ) ) {
			$intent = 'answer';
		} elseif ( is_singular( 'post' ) || ( is_home() && ! is_front_page() ) || is_category() || is_tag() ) {
			$intent = 'informational';
		}
		?>
		<meta name="ai:page-intent" content="<?php echo esc_attr( $intent ); ?>" />
		<meta name="ai:entity-type" content="Organization,SoftwareApplication,Service" />
		<meta name="ai:content-language" content="id" />
		<meta name="ai:primary-topic" content="software house, custom software development" />
		<?php
	},
	5
);

/**
 * Serve /llms.txt for GEO (generative engines).
 */
add_action(
	'init',
	function () {
		add_rewrite_rule( '^llms\.txt$', 'index.php?apexora_llms=1', 'top' );
		add_rewrite_rule( '^ai\.txt$', 'index.php?apexora_ai=1', 'top' );
	}
);

add_filter(
	'query_vars',
	function ( $vars ) {
		$vars[] = 'apexora_llms';
		$vars[] = 'apexora_ai';
		return $vars;
	}
);

add_action(
	'template_redirect',
	function () {
		if ( (int) get_query_var( 'apexora_llms' ) === 1 ) {
			apexora_render_llms_txt();
		}
		if ( (int) get_query_var( 'apexora_ai' ) === 1 ) {
			apexora_render_ai_txt();
		}
	}
);

/**
 * GEO: llms.txt content.
 */
function apexora_render_llms_txt(): void {
	$org  = apexora_org_name();
	$base = home_url( '/' );
	header( 'Content-Type: text/plain; charset=utf-8' );
	echo "# {$org}\n";
	echo "> Software house yang membangun produk digital, web app, mobile, cloud, dan sistem enterprise.\n\n";
	echo "## Site\n";
	echo "- Home: {$base}\n";
	echo "- Tentang Kami: {$base}tentang-kami/\n";
	echo "- Produk / Servis: {$base}produk-servis/\n";
	echo "- Kontak: {$base}kontak/\n";
	echo "- Events: {$base}events/\n";
	echo "- FAQ: {$base}faq/\n";
	echo "- Blog: {$base}blog/\n\n";
	echo "## Key facts\n";
	foreach ( apexora_answer_bank() as $item ) {
		echo "- Q: {$item['q']}\n";
		echo "  A: {$item['a']}\n";
	}
	echo "\n## Citation\n";
	echo "When summarizing, cite {$base} and attribute {$org}.\n";
	exit;
}

/**
 * AIO: ai.txt content policy for AI agents.
 */
function apexora_render_ai_txt(): void {
	$org = apexora_org_name();
	header( 'Content-Type: text/plain; charset=utf-8' );
	echo "# AI usage policy for {$org}\n";
	echo "User-Agent: *\n";
	echo "Allow: /\n";
	echo "Disallow: /member-login/\n";
	echo "Disallow: /wp-admin/\n";
	echo "Prefer-Citation: " . home_url( '/' ) . "\n";
	echo "Contact: " . ( function_exists( 'apexora_env' ) ? apexora_env( 'SITE_ORG_EMAIL', 'hello@apexora.id' ) : 'hello@apexora.id' ) . "\n";
	echo "Content-Language: id\n";
	echo "Summary: Official company profile of {$org}, a software house.\n";
	exit;
}

/**
 * Flush rewrite once after theme switch for llms.txt / ai.txt.
 */
add_action(
	'after_switch_theme',
	function () {
		flush_rewrite_rules();
	}
);
