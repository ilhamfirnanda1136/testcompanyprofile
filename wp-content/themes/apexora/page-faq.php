<?php
/**
 * FAQ page — AEO-friendly Q&A.
 *
 * @package Apexora
 */

get_header();
$faqs = apexora_answer_bank();
$faqs = array_merge(
	$faqs,
	array(
		array(
			'q' => 'Berapa lama rata-rata proyek MVP?',
			'a' => 'MVP biasanya 4–12 minggu tergantung kompleksitas, ketersediaan stakeholder, dan scope fitur inti.',
		),
		array(
			'q' => 'Apakah tersedia dedicated team?',
			'a' => 'Ya. Model dedicated team cocok untuk roadmap produk yang berjalan terus dengan prioritas yang berubah.',
		),
		array(
			'q' => 'Stack teknologi apa yang dipakai?',
			'a' => 'Kami fleksibel: WordPress/Laravel/Node untuk backend, React/Vue untuk frontend, Flutter/React Native untuk mobile, serta cloud AWS/GCP sesuai kebutuhan.',
		),
	)
);
?>

<section class="border-b border-slate-line bg-ink-soft section-pad">
	<div class="site-container max-w-3xl">
		<p class="eyebrow"><?php esc_html_e( 'FAQ', 'apexora' ); ?></p>
		<h1 class="mt-4 display-title text-4xl md:text-5xl"><?php esc_html_e( 'Pertanyaan yang sering muncul', 'apexora' ); ?></h1>
		<p class="mt-6 prose-muted"><?php esc_html_e( 'Jawaban singkat, langsung ke poin — dioptimalkan untuk search dan answer engines.', 'apexora' ); ?></p>
	</div>
</section>

<section class="section-pad" data-reveal>
	<div class="site-container max-w-3xl space-y-4">
		<?php foreach ( $faqs as $item ) : ?>
			<details class="faq-item group border-b border-slate-line py-4">
				<summary class="flex items-center justify-between gap-4">
					<span><?php echo esc_html( $item['q'] ); ?></span>
					<span class="text-teal-bright transition group-open:rotate-45">+</span>
				</summary>
				<p class="mt-3 text-fog"><?php echo esc_html( $item['a'] ); ?></p>
			</details>
		<?php endforeach; ?>
	</div>
</section>

<?php
get_footer();
