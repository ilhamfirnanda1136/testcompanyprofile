<?php
/**
 * Template for produk-servis page.
 *
 * @package Apexora
 */

get_header();
?>

<section class="border-b border-slate-line bg-ink-soft section-pad">
	<div class="site-container max-w-3xl">
		<p class="eyebrow"><?php esc_html_e( 'Produk / Servis', 'apexora' ); ?></p>
		<h1 class="mt-4 display-title text-4xl md:text-5xl"><?php esc_html_e( 'Layanan end-to-end untuk produk digital', 'apexora' ); ?></h1>
		<p class="mt-6 prose-muted"><?php esc_html_e( 'Pilih engagement sesuai kebutuhan — dari discovery singkat hingga dedicated engineering team.', 'apexora' ); ?></p>
	</div>
</section>

<section class="section-pad" data-reveal>
	<div class="site-container grid gap-12 md:grid-cols-2">
		<?php
		$services = array(
			array( 'Custom Software Development', 'Aplikasi web, portal internal, marketplace, dan sistem operasional sesuai workflow bisnis.' ),
			array( 'Product Discovery & MVP', 'Riset masalah, prototype, validasi, dan rilis MVP dalam siklus singkat.' ),
			array( 'UI/UX Design', 'Design system, user flow, dan interface yang jelas untuk user teknis maupun non-teknis.' ),
			array( 'Mobile App Development', 'Aplikasi iOS/Android native atau cross-platform dengan fokus performa dan UX.' ),
			array( 'Cloud & DevOps', 'Infrastructure as code, CI/CD, monitoring, backup, dan hardening keamanan.' ),
			array( 'Maintenance & Support', 'SLA, bugfix, improvement backlog, dan knowledge transfer ke tim internal.' ),
		);
		foreach ( $services as $svc ) :
			?>
			<article class="border-b border-slate-line pb-8">
				<h2 class="font-display text-2xl font-semibold text-mist"><?php echo esc_html( $svc[0] ); ?></h2>
				<p class="mt-3 text-fog"><?php echo esc_html( $svc[1] ); ?></p>
			</article>
		<?php endforeach; ?>
	</div>
	<div class="site-container mt-14">
		<a class="btn-primary" href="<?php echo esc_url( home_url( '/kontak/' ) ); ?>"><?php esc_html_e( 'Minta Proposal', 'apexora' ); ?></a>
	</div>
</section>

<?php
get_footer();
