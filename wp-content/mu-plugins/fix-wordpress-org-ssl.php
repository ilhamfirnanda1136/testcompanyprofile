<?php
/**
 * Plugin Name: Fix WordPress.org SSL (Laragon local)
 * Description: Perbaiki koneksi update ke WordPress.org di Windows/Laragon dan sembunyikan warning dashboard lokal.
 * Author: Apexora Softworks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Deteksi environment lokal.
 */
function apexora_is_local_env(): bool {
	$host = wp_parse_url( home_url(), PHP_URL_HOST );
	if ( ! is_string( $host ) || $host === '' ) {
		return true;
	}

	return (bool) preg_match(
		'/(^localhost$|\.local$|\.test$|\.localhost$|^127\.0\.0\.1$|^::1$)/i',
		$host
	);
}

/**
 * Paksa IPv4 + CA bundle untuk request cURL (hindari hang IPv6 di Windows).
 */
add_action(
	'http_api_curl',
	static function ( $handle ): void {
		if ( ! is_resource( $handle ) && ! ( $handle instanceof CurlHandle ) ) {
			return;
		}

		if ( defined( 'CURL_IPRESOLVE_V4' ) ) {
			curl_setopt( $handle, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
		}

		$ca = ini_get( 'curl.cainfo' ) ?: ini_get( 'openssl.cafile' );
		if ( ! $ca || ! is_readable( $ca ) ) {
			$ca = 'C:/laragon2/etc/ssl/cacert.pem';
		}

		if ( is_readable( $ca ) ) {
			curl_setopt( $handle, CURLOPT_CAINFO, $ca );
			curl_setopt( $handle, CURLOPT_SSL_VERIFYPEER, true );
			curl_setopt( $handle, CURLOPT_SSL_VERIFYHOST, 2 );
		}
	},
	10,
	1
);

/**
 * Perpanjang timeout khusus domain WordPress.org.
 */
add_filter(
	'http_request_args',
	static function ( $args, $url ) {
		if ( is_string( $url ) && str_contains( $url, 'api.wordpress.org' ) ) {
			$args['timeout'] = max( (int) ( $args['timeout'] ?? 5 ), 30 );
		}
		return $args;
	},
	10,
	2
);

/**
 * Di lokal + WP_DEBUG: swallow warning koneksi WordPress.org saja.
 */
if ( apexora_is_local_env() ) {
	$apexora_prev_handler = set_error_handler(
		static function ( int $errno, string $errstr, string $errfile = '', int $errline = 0 ) use ( &$apexora_prev_handler ): bool {
			if ( ( E_USER_WARNING === $errno || E_USER_NOTICE === $errno )
				&& str_contains( $errstr, 'WordPress could not establish a secure connection to WordPress.org' )
			) {
				return true;
			}

			if ( is_callable( $apexora_prev_handler ) ) {
				return (bool) $apexora_prev_handler( $errno, $errstr, $errfile, $errline );
			}

			return false;
		},
		E_USER_WARNING | E_USER_NOTICE
	);
}
