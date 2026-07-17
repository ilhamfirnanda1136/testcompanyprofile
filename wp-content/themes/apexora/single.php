<?php
/**
 * Single blog post — content from WordPress CMS (Posts).
 *
 * @package Apexora
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>
<article <?php post_class(); ?>>
	<header class="border-b border-slate-line bg-ink-soft section-pad">
		<div class="site-container max-w-3xl">
			<p class="eyebrow">
				<a class="hover:text-mist" href="<?php echo esc_url( apexora_blog_url() ); ?>"><?php esc_html_e( 'Blog', 'apexora' ); ?></a>
				<?php
				$cats = get_the_category();
				if ( ! empty( $cats ) ) :
					?>
					<span class="mx-2 text-slate-line">/</span>
					<a class="hover:text-mist" href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>"><?php echo esc_html( $cats[0]->name ); ?></a>
				<?php endif; ?>
			</p>
			<h1 class="mt-4 display-title text-4xl md:text-5xl"><?php the_title(); ?></h1>
			<p class="mt-5 text-sm text-fog"><?php echo esc_html( apexora_post_meta_line() ); ?></p>
		</div>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="site-container mt-10 max-w-4xl">
			<?php the_post_thumbnail( 'apexora-hero', array( 'class' => 'w-full rounded-lg border border-slate-line object-cover' ) ); ?>
		</div>
	<?php endif; ?>

	<div class="section-pad pt-12">
		<div class="site-container max-w-3xl">
			<div class="apexora-prose">
				<?php the_content(); ?>
			</div>

			<?php
			$tags = get_the_tags();
			if ( $tags ) :
				?>
				<div class="mt-12 flex flex-wrap gap-2 border-t border-slate-line pt-8">
					<?php foreach ( $tags as $tag ) : ?>
						<a class="rounded border border-slate-line px-3 py-1 text-xs text-fog transition hover:border-teal hover:text-teal-bright" href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>">
							#<?php echo esc_html( $tag->name ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<nav class="mt-12 flex flex-wrap justify-between gap-4 border-t border-slate-line pt-8 text-sm">
				<div class="text-fog"><?php previous_post_link( '%link', '← %title' ); ?></div>
				<div class="text-fog text-right"><?php next_post_link( '%link', '%title →' ); ?></div>
			</nav>

			<div class="mt-10">
				<a class="btn-ghost" href="<?php echo esc_url( apexora_blog_url() ); ?>"><?php esc_html_e( 'Semua Artikel', 'apexora' ); ?></a>
			</div>
		</div>
	</div>
</article>
<?php endwhile; ?>

<?php
get_footer();
