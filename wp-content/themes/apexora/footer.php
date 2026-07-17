</main>

<footer class="border-t border-slate-line bg-ink-soft">
	<div class="site-container grid gap-10 py-14 md:grid-cols-3">
		<div>
			<p class="font-display text-2xl font-bold text-mist"><?php echo esc_html( apexora_org_name() ); ?></p>
			<p class="mt-3 max-w-sm prose-muted"><?php esc_html_e( 'Software house yang merancang produk digital yang andal, cepat, dan siap scale.', 'apexora' ); ?></p>
		</div>
		<div>
			<p class="eyebrow"><?php esc_html_e( 'Navigasi', 'apexora' ); ?></p>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'mt-4 flex flex-col gap-2',
					'fallback_cb'    => 'apexora_fallback_menu',
					'depth'          => 1,
				)
			);
			?>
		</div>
		<div>
			<p class="eyebrow"><?php esc_html_e( 'Kontak', 'apexora' ); ?></p>
			<ul class="mt-4 space-y-2 text-sm text-fog">
				<li><?php echo esc_html( function_exists( 'apexora_env' ) ? apexora_env( 'SITE_ORG_EMAIL', 'hello@apexora.id' ) : 'hello@apexora.id' ); ?></li>
				<li><?php echo esc_html( function_exists( 'apexora_env' ) ? apexora_env( 'SITE_ORG_PHONE', '+62-21-5550-1200' ) : '+62-21-5550-1200' ); ?></li>
				<li><?php echo esc_html( function_exists( 'apexora_env' ) ? apexora_env( 'SITE_ORG_ADDRESS', 'Jakarta, Indonesia' ) : 'Jakarta, Indonesia' ); ?></li>
			</ul>
		</div>
	</div>
	<div class="border-t border-slate-line">
		<div class="site-container flex flex-col gap-2 py-5 text-xs text-fog sm:flex-row sm:items-center sm:justify-between">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( apexora_org_name() ); ?>. <?php esc_html_e( 'All rights reserved.', 'apexora' ); ?></p>
			<p><?php esc_html_e( 'SEO · AEO · GEO · AIO ready', 'apexora' ); ?></p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
