<?php
/**
 * Google Analytics / GTM from .env
 *
 * @package Apexora
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Print GA4 + optional GTM in <head>.
 */
add_action(
	'wp_head',
	function () {
		$ga  = function_exists( 'apexora_env' ) ? apexora_env( 'GA_MEASUREMENT_ID' ) : '';
		$gtm = function_exists( 'apexora_env' ) ? apexora_env( 'GTM_CONTAINER_ID' ) : '';

		if ( $gtm !== '' && preg_match( '/^GTM-[A-Z0-9]+$/i', $gtm ) ) {
			?>
			<!-- Google Tag Manager -->
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','<?php echo esc_js( $gtm ); ?>');</script>
			<!-- End Google Tag Manager -->
			<?php
		}

		if ( $ga !== '' && preg_match( '/^G-[A-Z0-9]+$/i', $ga ) && $ga !== 'G-XXXXXXXXXX' ) {
			?>
			<!-- Google Analytics (GA4) from .env GA_MEASUREMENT_ID -->
			<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $ga ); ?>"></script>
			<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());
			gtag('config', '<?php echo esc_js( $ga ); ?>', { anonymize_ip: true });
			</script>
			<?php
		}
	},
	1
);

/**
 * GTM noscript body open.
 */
add_action(
	'wp_body_open',
	function () {
		$gtm = function_exists( 'apexora_env' ) ? apexora_env( 'GTM_CONTAINER_ID' ) : '';
		if ( $gtm === '' || ! preg_match( '/^GTM-[A-Z0-9]+$/i', $gtm ) ) {
			return;
		}
		?>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr( $gtm ); ?>"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		<?php
	},
	1
);
