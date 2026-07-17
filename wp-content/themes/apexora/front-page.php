<?php
/**
 * Front page — company profile hero + services preview.
 *
 * @package Apexora
 */

get_header();

$org = apexora_org_name();
?>

<section class="relative overflow-hidden hero-grid">
	<div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top,_rgba(20,184,166,0.18),_transparent_55%)]"></div>
	<div class="site-container relative section-pad">
		<p class="eyebrow fade-up"><?php echo esc_html( $org ); ?></p>
		<h1 class="mt-4 max-w-4xl display-title fade-up-delay">
			<?php esc_html_e( 'Software house untuk produk digital yang tumbuh bersama bisnis Anda.', 'apexora' ); ?>
		</h1>
		<p class="mt-6 max-w-2xl prose-muted fade-up-delay-2">
			<?php esc_html_e( 'Kami merancang, membangun, dan merawat web app, mobile, API, serta sistem enterprise — dari discovery hingga production.', 'apexora' ); ?>
		</p>
		<div class="mt-10 flex flex-wrap gap-4 fade-up-delay-2">
			<a class="btn-primary" href="<?php echo esc_url( home_url( '/kontak/' ) ); ?>"><?php esc_html_e( 'Diskusikan Proyek', 'apexora' ); ?></a>
			<a class="btn-ghost" href="<?php echo esc_url( home_url( '/produk-servis/' ) ); ?>"><?php esc_html_e( 'Lihat Servis', 'apexora' ); ?></a>
		</div>
	</div>
</section>

<section class="border-t border-slate-line section-pad" data-reveal>
	<div class="site-container">
		<p class="eyebrow"><?php esc_html_e( 'Yang kami bangun', 'apexora' ); ?></p>
		<h2 class="mt-3 font-display text-3xl font-bold text-mist md:text-4xl"><?php esc_html_e( 'Dari ide ke produk yang siap scale', 'apexora' ); ?></h2>
		<div class="mt-12 grid gap-10 md:grid-cols-3">
			<?php
			$pillars = array(
				array( 'Custom Software', 'Aplikasi web & sistem internal yang disesuaikan proses bisnis Anda.' ),
				array( 'Product Studio', 'Discovery, prototyping, MVP, hingga iterasi berbasis data.' ),
				array( 'Cloud & DevOps', 'Deploy andal, observability, CI/CD, dan keamanan operasional.' ),
			);
			foreach ( $pillars as $pillar ) :
				?>
				<article>
					<h3 class="font-display text-xl font-semibold text-teal-bright"><?php echo esc_html( $pillar[0] ); ?></h3>
					<p class="mt-3 text-fog"><?php echo esc_html( $pillar[1] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="border-t border-slate-line bg-ink-soft section-pad" data-reveal>
	<div class="site-container grid items-center gap-12 lg:grid-cols-2">
		<div>
			<p class="eyebrow"><?php esc_html_e( 'Kenapa Apexora', 'apexora' ); ?></p>
			<h2 class="mt-3 font-display text-3xl font-bold text-mist md:text-4xl"><?php esc_html_e( 'Engineering yang jelas, delivery yang terukur', 'apexora' ); ?></h2>
			<p class="mt-5 prose-muted"><?php esc_html_e( 'Setiap engagement punya roadmap, definition of done, dan komunikasi rutin — sehingga stakeholder selalu tahu status produk.', 'apexora' ); ?></p>
			<a class="btn-primary mt-8" href="<?php echo esc_url( home_url( '/tentang-kami/' ) ); ?>"><?php esc_html_e( 'Tentang Kami', 'apexora' ); ?></a>
		</div>
		<div class="relative min-h-[280px] overflow-hidden rounded-lg border border-slate-line bg-ink">
			<div class="absolute inset-0 bg-[linear-gradient(135deg,rgba(13,148,136,0.35),transparent_50%),linear-gradient(225deg,rgba(245,158,11,0.15),transparent_40%)]"></div>
			<div class="relative flex h-full min-h-[280px] flex-col justify-end p-8">
				<p class="font-display text-5xl font-bold text-mist">12+</p>
				<p class="mt-2 text-fog"><?php esc_html_e( 'tahun pengalaman kolektif tim engineering', 'apexora' ); ?></p>
			</div>
		</div>
	</div>
</section>

<section class="border-t border-slate-line section-pad" data-reveal>
	<div class="site-container">
		<p class="eyebrow"><?php esc_html_e( 'Jawaban singkat', 'apexora' ); ?></p>
		<h2 class="mt-3 font-display text-3xl font-bold text-mist"><?php esc_html_e( 'Siap untuk answer engines', 'apexora' ); ?></h2>
		<div class="mt-10 space-y-6">
			<?php foreach ( array_slice( apexora_answer_bank(), 0, 3 ) as $item ) : ?>
				<article class="border-b border-slate-line pb-6">
					<h3 class="font-display text-lg font-semibold text-mist"><?php echo esc_html( $item['q'] ); ?></h3>
					<p class="mt-2 text-fog"><?php echo esc_html( $item['a'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
		<a class="btn-ghost mt-8" href="<?php echo esc_url( home_url( '/faq/' ) ); ?>"><?php esc_html_e( 'Semua FAQ', 'apexora' ); ?></a>
	</div>
</section>

<section class="border-t border-slate-line bg-ink-soft section-pad" data-reveal>
	<div class="site-container">
		<div class="flex flex-wrap items-end justify-between gap-4">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Blog', 'apexora' ); ?></p>
				<h2 class="mt-3 font-display text-3xl font-bold text-mist md:text-4xl"><?php esc_html_e( 'Artikel terbaru dari CMS', 'apexora' ); ?></h2>
			</div>
			<a class="btn-ghost" href="<?php echo esc_url( apexora_blog_url() ); ?>"><?php esc_html_e( 'Semua Artikel', 'apexora' ); ?></a>
		</div>

		<?php
		$latest = new WP_Query(
			array(
				'post_type'           => 'post',
				'posts_per_page'      => 3,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
			)
		);
		?>

		<?php if ( $latest->have_posts() ) : ?>
			<div class="mt-12 grid gap-10 md:grid-cols-3">
				<?php
				while ( $latest->have_posts() ) :
					$latest->the_post();
					get_template_part( 'template-parts/content', 'post-card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php else : ?>
			<p class="mt-8 text-fog"><?php esc_html_e( 'Belum ada artikel. Tambahkan lewat Admin → Posts.', 'apexora' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
