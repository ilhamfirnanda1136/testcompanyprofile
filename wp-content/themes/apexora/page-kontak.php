<?php
/**
 * Kontak page.
 *
 * @package Apexora
 */

get_header();

$email   = function_exists( 'apexora_env' ) ? apexora_env( 'SITE_ORG_EMAIL', 'hello@apexora.id' ) : 'hello@apexora.id';
$phone   = function_exists( 'apexora_env' ) ? apexora_env( 'SITE_ORG_PHONE', '+62-21-5550-1200' ) : '+62-21-5550-1200';
$address = function_exists( 'apexora_env' ) ? apexora_env( 'SITE_ORG_ADDRESS', 'Jakarta, Indonesia' ) : 'Jakarta, Indonesia';
$sent    = isset( $_GET['sent'] ) && $_GET['sent'] === '1';
?>

<section class="border-b border-slate-line bg-ink-soft section-pad">
	<div class="site-container max-w-3xl">
		<p class="eyebrow"><?php esc_html_e( 'Kontak', 'apexora' ); ?></p>
		<h1 class="mt-4 display-title text-4xl md:text-5xl"><?php esc_html_e( 'Mari diskusikan proyek Anda', 'apexora' ); ?></h1>
		<p class="mt-6 prose-muted"><?php esc_html_e( 'Ceritakan tantangan bisnis atau ide produk — kami akan merespons dengan next step yang jelas.', 'apexora' ); ?></p>
	</div>
</section>

<section class="section-pad">
	<div class="site-container grid gap-12 lg:grid-cols-2">
		<div>
			<ul class="space-y-6 text-fog">
				<li><span class="eyebrow block"><?php esc_html_e( 'Email', 'apexora' ); ?></span><a class="mt-1 inline-block text-mist hover:text-teal-bright" href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
				<li><span class="eyebrow block"><?php esc_html_e( 'Telepon', 'apexora' ); ?></span><a class="mt-1 inline-block text-mist hover:text-teal-bright" href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
				<li><span class="eyebrow block"><?php esc_html_e( 'Lokasi', 'apexora' ); ?></span><span class="mt-1 block text-mist"><?php echo esc_html( $address ); ?></span></li>
			</ul>
		</div>
		<div>
			<?php if ( $sent ) : ?>
				<p class="rounded-md border border-teal/40 bg-teal/10 px-4 py-3 text-teal-bright"><?php esc_html_e( 'Terima kasih. Pesan Anda sudah kami terima.', 'apexora' ); ?></p>
			<?php endif; ?>
			<form class="mt-2 space-y-4" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="apexora_contact" />
				<?php wp_nonce_field( 'apexora_contact', 'apexora_contact_nonce' ); ?>
				<label class="block">
					<span class="text-sm text-fog"><?php esc_html_e( 'Nama', 'apexora' ); ?></span>
					<input required name="name" class="mt-1 w-full rounded-md border border-slate-line bg-ink px-4 py-3 text-mist outline-none focus:border-teal" type="text" />
				</label>
				<label class="block">
					<span class="text-sm text-fog"><?php esc_html_e( 'Email', 'apexora' ); ?></span>
					<input required name="email" class="mt-1 w-full rounded-md border border-slate-line bg-ink px-4 py-3 text-mist outline-none focus:border-teal" type="email" />
				</label>
				<label class="block">
					<span class="text-sm text-fog"><?php esc_html_e( 'Pesan', 'apexora' ); ?></span>
					<textarea required name="message" rows="5" class="mt-1 w-full rounded-md border border-slate-line bg-ink px-4 py-3 text-mist outline-none focus:border-teal"></textarea>
				</label>
				<button class="btn-primary" type="submit"><?php esc_html_e( 'Kirim Pesan', 'apexora' ); ?></button>
			</form>
		</div>
	</div>
</section>

<?php
get_footer();
