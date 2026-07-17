<?php
/**
 * Category / tag / date archives.
 *
 * @package Apexora
 */

get_header();
?>

<section class="border-b border-slate-line bg-ink-soft section-pad">
	<div class="site-container max-w-3xl">
		<p class="eyebrow"><?php esc_html_e( 'Arsip', 'apexora' ); ?></p>
		<h1 class="mt-4 display-title text-4xl md:text-5xl"><?php the_archive_title(); ?></h1>
		<?php if ( get_the_archive_description() ) : ?>
			<div class="mt-6 prose-muted"><?php the_archive_description(); ?></div>
		<?php endif; ?>
	</div>
</section>

<section class="section-pad">
	<div class="site-container">
		<?php if ( have_posts() ) : ?>
			<div class="grid gap-10 md:grid-cols-2 lg:grid-cols-3">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', 'post-card' );
				endwhile;
				?>
			</div>
			<div class="mt-14 flex flex-wrap items-center justify-between gap-4 border-t border-slate-line pt-8 text-sm text-fog">
				<div><?php previous_posts_link( __( '← Lebih baru', 'apexora' ) ); ?></div>
				<div><?php next_posts_link( __( 'Lebih lama →', 'apexora' ) ); ?></div>
			</div>
		<?php else : ?>
			<p class="text-fog"><?php esc_html_e( 'Tidak ada artikel di arsip ini.', 'apexora' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
