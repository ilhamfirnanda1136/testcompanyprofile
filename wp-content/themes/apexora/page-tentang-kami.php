<?php
/**
 * Template Name: Tentang Kami
 * Template for page slug tentang-kami
 *
 * @package Apexora
 */

get_header();
$org = apexora_org_name();
?>

<section class="border-b border-slate-line bg-ink-soft section-pad">
	<div class="site-container max-w-3xl">
		<p class="eyebrow"><?php esc_html_e( 'Tentang Kami', 'apexora' ); ?></p>
		<h1 class="mt-4 display-title text-4xl md:text-5xl"><?php echo esc_html( $org ); ?></h1>
		<p class="mt-6 prose-muted"><?php esc_html_e( 'Kami adalah software house yang menggabungkan product thinking dan engineering discipline. Fokus kami: membangun perangkat lunak yang dipakai sehari-hari oleh pengguna bisnis — bukan hanya demo yang bagus di slide.', 'apexora' ); ?></p>
	</div>
</section>

<section class="section-pad" data-reveal>
	<div class="site-container grid gap-12 md:grid-cols-2">
		<div>
			<h2 class="font-display text-2xl font-bold text-mist"><?php esc_html_e( 'Visi', 'apexora' ); ?></h2>
			<p class="mt-4 text-fog"><?php esc_html_e( 'Menjadi partner teknologi yang dipercaya untuk mengubah ide bisnis menjadi produk digital yang berkelanjutan.', 'apexora' ); ?></p>
		</div>
		<div>
			<h2 class="font-display text-2xl font-bold text-mist"><?php esc_html_e( 'Misi', 'apexora' ); ?></h2>
			<p class="mt-4 text-fog"><?php esc_html_e( 'Menghadirkan kualitas kode, kejelasan komunikasi, dan outcome yang terukur pada setiap proyek — dari startup hingga enterprise.', 'apexora' ); ?></p>
		</div>
	</div>
</section>

<section class="border-t border-slate-line bg-ink-soft section-pad" data-reveal>
	<div class="site-container">
		<h2 class="font-display text-3xl font-bold text-mist"><?php esc_html_e( 'Nilai kerja', 'apexora' ); ?></h2>
		<ul class="mt-10 grid gap-8 md:grid-cols-3">
			<li>
				<h3 class="font-display text-lg font-semibold text-teal-bright"><?php esc_html_e( 'Clarity', 'apexora' ); ?></h3>
				<p class="mt-2 text-fog"><?php esc_html_e( 'Scope, prioritas, dan risiko selalu transparan.', 'apexora' ); ?></p>
			</li>
			<li>
				<h3 class="font-display text-lg font-semibold text-teal-bright"><?php esc_html_e( 'Craft', 'apexora' ); ?></h3>
				<p class="mt-2 text-fog"><?php esc_html_e( 'Kode, desain, dan infrastruktur dikerjakan dengan standar produksi.', 'apexora' ); ?></p>
			</li>
			<li>
				<h3 class="font-display text-lg font-semibold text-teal-bright"><?php esc_html_e( 'Ownership', 'apexora' ); ?></h3>
				<p class="mt-2 text-fog"><?php esc_html_e( 'Kami bertanggung jawab sampai fitur benar-benar dipakai user.', 'apexora' ); ?></p>
			</li>
		</ul>
	</div>
</section>

<?php
get_footer();
