<?php
/**
 * Simple .env loader for Apexora (no Composer).
 * Safe to include from wp-config and as MU-plugin.
 */

if ( ! function_exists( 'apexora_load_env_file' ) ) {
	/**
	 * Parse KEY=VALUE lines from .env.
	 */
	function apexora_load_env_file( string $path ): void {
		if ( ! is_readable( $path ) ) {
			return;
		}

		$lines = file( $path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
		if ( ! $lines ) {
			return;
		}

		foreach ( $lines as $line ) {
			$line = trim( $line );
			if ( $line === '' || str_starts_with( $line, '#' ) ) {
				continue;
			}
			if ( ! str_contains( $line, '=' ) ) {
				continue;
			}

			[ $name, $value ] = explode( '=', $line, 2 );
			$name  = trim( $name );
			$value = trim( $value, " \t\"'" );

			if ( $name === '' ) {
				continue;
			}

			putenv( "{$name}={$value}" );
			$_ENV[ $name ]    = $value;
			$_SERVER[ $name ] = $value;

			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}
	}
}

if ( ! function_exists( 'apexora_env' ) ) {
	/**
	 * Read env with fallback.
	 */
	function apexora_env( string $key, string $default = '' ): string {
		if ( defined( $key ) ) {
			return (string) constant( $key );
		}
		$val = getenv( $key );
		return ( $val !== false && $val !== '' ) ? (string) $val : $default;
	}
}

if ( ! function_exists( 'apexora_flag' ) ) {
	/**
	 * Boolean feature flag from env.
	 */
	function apexora_flag( string $key, bool $default = true ): bool {
		$val = strtolower( apexora_env( $key, $default ? 'true' : 'false' ) );
		return in_array( $val, array( '1', 'true', 'yes', 'on' ), true );
	}
}

$apexora_env_root = defined( 'ABSPATH' ) ? ABSPATH : dirname( __DIR__, 2 ) . '/';
apexora_load_env_file( $apexora_env_root . '.env' );
