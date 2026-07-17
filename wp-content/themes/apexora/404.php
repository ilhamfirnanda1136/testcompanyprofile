<?php
/**
 * 404 template.
 *
 * @package Apexora
 */

get_header();
?>

<section class="section-pad">
	<div class="site-container max-w-xl text-center">
		<p class="eyebrow">404</p>
		<h1 class="mt-4 display-title text-4xl"><?php esc_html_e( 'Halaman tidak ditemukan', 'apexora' ); ?></h1>
		<p class="mt-4 prose-muted"><?php esc_html_e( 'URL mungkin berubah atau halaman sudah dihapus.', 'apexora' ); ?></p>
		<a class="btn-primary mt-8" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Kembali ke Beranda', 'apexora' ); ?></a>
	</div>
</section>

<?php
get_footer();
