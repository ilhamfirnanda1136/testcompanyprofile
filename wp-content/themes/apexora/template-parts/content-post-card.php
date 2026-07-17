<?php
/**
 * Post card for blog listing / archive / homepage.
 *
 * @package Apexora
 */
?>
<article <?php post_class( 'flex flex-col border-b border-slate-line pb-8' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" class="mb-5 block overflow-hidden rounded-lg border border-slate-line">
			<?php the_post_thumbnail( 'apexora-card', array( 'class' => 'h-44 w-full object-cover transition hover:opacity-90' ) ); ?>
		</a>
	<?php endif; ?>

	<?php
	$cats = get_the_category();
	if ( ! empty( $cats ) ) :
		?>
		<p class="text-xs font-semibold uppercase tracking-wider text-teal-bright">
			<a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>"><?php echo esc_html( $cats[0]->name ); ?></a>
		</p>
	<?php endif; ?>

	<h2 class="mt-2 font-display text-xl font-semibold leading-snug">
		<a class="text-mist transition hover:text-teal-bright" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</h2>
	<p class="mt-2 text-xs text-fog"><?php echo esc_html( apexora_post_meta_line() ); ?></p>
	<div class="mt-3 flex-1 text-sm leading-relaxed text-fog"><?php the_excerpt(); ?></div>
	<a class="mt-4 text-sm font-semibold text-teal-bright hover:underline" href="<?php the_permalink(); ?>">
		<?php esc_html_e( 'Baca artikel', 'apexora' ); ?> →
	</a>
</article>
