<?php
/**
 * Events page.
 *
 * @package Apexora
 */

get_header();

$events = array(
	array(
		'date'  => '20 Agu 2026',
		'title' => 'Apexora Tech Meetup: Shipping Faster with CI/CD',
		'place' => 'Jakarta · Offline',
		'desc'  => 'Praktik pipeline, review culture, dan observability untuk tim produk.',
	),
	array(
		'date'  => '12 Sep 2026',
		'title' => 'Workshop: From Brief to MVP in 4 Weeks',
		'place' => 'Online · Zoom',
		'desc'  => 'Framework discovery, scoping, dan prioritas fitur untuk founder & PM.',
	),
	array(
		'date'  => '03 Okt 2026',
		'title' => 'Webinar: Security Basics for Product Teams',
		'place' => 'Online',
		'desc'  => 'Checklist keamanan praktis sebelum go-live ke production.',
	),
);
?>

<section class="border-b border-slate-line bg-ink-soft section-pad">
	<div class="site-container max-w-3xl">
		<p class="eyebrow"><?php esc_html_e( 'Events', 'apexora' ); ?></p>
		<h1 class="mt-4 display-title text-4xl md:text-5xl"><?php esc_html_e( 'Belajar bersama komunitas', 'apexora' ); ?></h1>
		<p class="mt-6 prose-muted"><?php esc_html_e( 'Meetup, workshop, dan webinar untuk developer, product manager, dan founder.', 'apexora' ); ?></p>
	</div>
</section>

<section class="section-pad" data-reveal>
	<div class="site-container space-y-10">
		<?php foreach ( $events as $event ) : ?>
			<article class="grid gap-4 border-b border-slate-line pb-10 md:grid-cols-[160px_1fr]">
				<p class="text-sm font-semibold uppercase tracking-wider text-teal-bright"><?php echo esc_html( $event['date'] ); ?></p>
				<div>
					<h2 class="font-display text-2xl font-semibold text-mist"><?php echo esc_html( $event['title'] ); ?></h2>
					<p class="mt-2 text-sm text-fog"><?php echo esc_html( $event['place'] ); ?></p>
					<p class="mt-3 text-fog"><?php echo esc_html( $event['desc'] ); ?></p>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>

<?php
get_footer();
