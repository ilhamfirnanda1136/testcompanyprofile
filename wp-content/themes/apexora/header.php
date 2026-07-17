<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'min-h-screen' ); ?>>
<?php wp_body_open(); ?>

<a class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded focus:bg-teal focus:px-3 focus:py-2 focus:text-ink" href="#main"><?php esc_html_e( 'Lewati ke konten', 'apexora' ); ?></a>

<header class="sticky top-0 z-40 border-b border-slate-line/80 bg-ink/85 backdrop-blur-md">
	<div class="site-container flex items-center justify-between gap-4 py-4">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="group flex items-center gap-3">
			<span class="flex h-10 w-10 items-center justify-center rounded-md bg-teal font-display text-lg font-bold text-ink transition group-hover:bg-teal-bright">A</span>
			<span class="font-display text-lg font-bold tracking-tight text-mist"><?php echo esc_html( apexora_org_name() ); ?></span>
		</a>

		<nav class="hidden lg:block" aria-label="<?php esc_attr_e( 'Navigasi utama', 'apexora' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'flex flex-wrap items-center gap-6',
					'fallback_cb'    => 'apexora_fallback_menu',
					'depth'          => 1,
					'link_before'    => '',
					'link_after'     => '',
				)
			);
			?>
		</nav>

		<a class="btn-primary hidden sm:inline-flex" href="<?php echo esc_url( home_url( '/kontak/' ) ); ?>"><?php esc_html_e( 'Mulai Proyek', 'apexora' ); ?></a>

		<button type="button" id="apexora-menu-toggle" class="inline-flex items-center justify-center rounded-md border border-slate-line p-2 text-mist lg:hidden" aria-expanded="false" aria-controls="apexora-mobile-nav">
			<span class="sr-only"><?php esc_html_e( 'Menu', 'apexora' ); ?></span>
			<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
		</button>
	</div>

	<div id="apexora-mobile-nav" class="hidden border-t border-slate-line bg-ink-soft lg:hidden">
		<div class="site-container py-4">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'flex flex-col gap-4',
					'fallback_cb'    => 'apexora_fallback_menu',
					'depth'          => 1,
				)
			);
			?>
		</div>
	</div>
</header>

<main id="main">
