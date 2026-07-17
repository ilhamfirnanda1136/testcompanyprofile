<?php
/**
 * Default page template.
 *
 * @package Apexora
 */

get_header();
?>

<section class="section-pad">
	<div class="site-container max-w-3xl">
		<?php while ( have_posts() ) : the_post(); ?>
			<h1 class="display-title text-4xl md:text-5xl"><?php the_title(); ?></h1>
			<div class="mt-8 prose-muted space-y-4 [&_a]:text-teal-bright [&_h2]:font-display [&_h2]:text-2xl [&_h2]:text-mist [&_p]:text-fog">
				<?php the_content(); ?>
			</div>
		<?php endwhile; ?>
	</div>
</section>

<?php
get_footer();
