<?php
/**
 * Blog / posts index (Posts page from CMS Reading settings).
 *
 * @package Apexora
 */

get_header();
?>

<section class="border-b border-slate-line bg-ink-soft section-pad">
	<div class="site-container max-w-3xl">
		<p class="eyebrow"><?php esc_html_e( 'Blog', 'apexora' ); ?></p>
		<h1 class="mt-4 display-title text-4xl md:text-5xl">
			<?php
			if ( is_home() && ! is_front_page() ) {
				echo esc_html( get_the_title( (int) get_option( 'page_for_posts' ) ) ?: __( 'Artikel & Insights', 'apexora' ) );
			} else {
				esc_html_e( 'Artikel & Insights', 'apexora' );
			}
			?>
		</h1>
		<p class="mt-6 prose-muted">
			<?php esc_html_e( 'Artikel dari CMS WordPress — engineering, product, dan praktik software house.', 'apexora' ); ?>
		</p>
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
				<div><?php previous_posts_link( __( '← Artikel lebih baru', 'apexora' ) ); ?></div>
				<div><?php next_posts_link( __( 'Artikel lebih lama →', 'apexora' ) ); ?></div>
			</div>
		<?php else : ?>
			<p class="text-fog"><?php esc_html_e( 'Belum ada artikel. Tambahkan lewat WordPress Admin → Posts → Add New.', 'apexora' ); ?></p>
			<?php if ( current_user_can( 'edit_posts' ) ) : ?>
				<a class="btn-primary mt-6" href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>"><?php esc_html_e( 'Tulis Artikel', 'apexora' ); ?></a>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
