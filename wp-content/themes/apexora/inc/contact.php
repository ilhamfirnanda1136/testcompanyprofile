<?php
/**
 * Contact form handler (admin-post).
 *
 * @package Apexora
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'admin_post_nopriv_apexora_contact',
	'apexora_handle_contact'
);
add_action(
	'admin_post_apexora_contact',
	'apexora_handle_contact'
);

/**
 * Process contact form submission.
 */
function apexora_handle_contact(): void {
	if ( ! isset( $_POST['apexora_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['apexora_contact_nonce'] ) ), 'apexora_contact' ) ) {
		wp_die( esc_html__( 'Permintaan tidak valid.', 'apexora' ) );
	}

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( $name === '' || $email === '' || $message === '' || ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'sent', '0', home_url( '/kontak/' ) ) );
		exit;
	}

	$to      = function_exists( 'apexora_env' ) ? apexora_env( 'SITE_ORG_EMAIL', get_option( 'admin_email' ) ) : get_option( 'admin_email' );
	$subject = sprintf( '[%s] Pesan kontak dari %s', apexora_org_name(), $name );
	$body    = "Nama: {$name}\nEmail: {$email}\n\n{$message}";
	$headers = array( 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>' );

	wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'sent', '1', home_url( '/kontak/' ) ) );
	exit;
}
