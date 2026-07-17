<?php
/**
 * Member Login page — wraps wp-login for branded portal entry.
 *
 * @package Apexora
 */

get_header();

$redirect = home_url( '/' );
$login_url = wp_login_url( $redirect );
$lost_url  = wp_lostpassword_url( $redirect );
?>

<section class="border-b border-slate-line bg-ink-soft section-pad">
	<div class="site-container max-w-xl">
		<p class="eyebrow"><?php esc_html_e( 'Member Login', 'apexora' ); ?></p>
		<h1 class="mt-4 display-title text-4xl md:text-5xl"><?php esc_html_e( 'Portal klien & member', 'apexora' ); ?></h1>
		<p class="mt-6 prose-muted"><?php esc_html_e( 'Masuk untuk mengakses area member. Halaman ini di-noindex agar tidak masuk hasil pencarian publik.', 'apexora' ); ?></p>
	</div>
</section>

<section class="section-pad">
	<div class="site-container max-w-md">
		<?php if ( is_user_logged_in() ) : ?>
			<p class="text-mist"><?php esc_html_e( 'Anda sudah login.', 'apexora' ); ?></p>
			<a class="btn-primary mt-6" href="<?php echo esc_url( admin_url() ); ?>"><?php esc_html_e( 'Ke Dashboard', 'apexora' ); ?></a>
			<a class="btn-ghost mt-4" href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>"><?php esc_html_e( 'Logout', 'apexora' ); ?></a>
		<?php else : ?>
			<form class="space-y-4" method="post" action="<?php echo esc_url( $login_url ); ?>">
				<label class="block">
					<span class="text-sm text-fog"><?php esc_html_e( 'Username atau Email', 'apexora' ); ?></span>
					<input class="mt-1 w-full rounded-md border border-slate-line bg-ink px-4 py-3 text-mist outline-none focus:border-teal" type="text" name="log" required autocomplete="username" />
				</label>
				<label class="block">
					<span class="text-sm text-fog"><?php esc_html_e( 'Password', 'apexora' ); ?></span>
					<input class="mt-1 w-full rounded-md border border-slate-line bg-ink px-4 py-3 text-mist outline-none focus:border-teal" type="password" name="pwd" required autocomplete="current-password" />
				</label>
				<label class="flex items-center gap-2 text-sm text-fog">
					<input type="checkbox" name="rememberme" value="forever" />
					<?php esc_html_e( 'Ingat saya', 'apexora' ); ?>
				</label>
				<input type="hidden" name="redirect_to" value="<?php echo esc_url( $redirect ); ?>" />
				<button class="btn-primary w-full" type="submit" name="wp-submit"><?php esc_html_e( 'Masuk', 'apexora' ); ?></button>
			</form>
			<p class="mt-6 text-sm text-fog">
				<a class="text-teal-bright hover:underline" href="<?php echo esc_url( $lost_url ); ?>"><?php esc_html_e( 'Lupa password?', 'apexora' ); ?></a>
			</p>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
