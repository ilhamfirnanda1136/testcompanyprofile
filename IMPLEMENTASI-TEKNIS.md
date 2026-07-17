# Implementasi Teknis — Company Profile Apexora

Ringkasan cepat. Panduan lengkap ada di **[README.md](README.md)**.

## Google Analytics (env)

| Item | Lokasi |
|------|--------|
| Variabel | `.env` → `GA_MEASUREMENT_ID`, `GTM_CONTAINER_ID` |
| Loader | `wp-content/mu-plugins/load-env.php` (juga di-require dari `wp-config.php`) |
| Inject script | `wp-content/themes/apexora/inc/analytics.php` |

Isi `GA_MEASUREMENT_ID=G-XXXX` dengan Measurement ID GA4 produksi. Placeholder tidak di-render.

## SEO

| Fitur | File |
|-------|------|
| Title, description, robots, canonical, OG, Twitter | `inc/seo.php` |
| JSON-LD Organization / WebSite / Service / FAQ / Event / Article / Blog | `inc/schema.php` |
| Sitemap | WordPress core `/wp-sitemap.xml` |
| Halaman | Tentang Kami, Produk/Servis, Blog, Kontak, Events, FAQ, Member Login |

## AEO (Answer Engine Optimization)

Jawaban singkat Q→A (`apexora_answer_bank`), FAQ page, schema `FAQPage`, meta speakable — agar answer engines bisa mengutip jawaban langsung.

## GEO (Generative Engine Optimization)

`/llms.txt` berisi fakta situs + sitasi; meta `ai:publisher` / `ai:citation` agar generative engines punya sumber resmi.

## AIO (AI Optimization)

Meta `ai:page-intent`, entity type, `/ai.txt` policy (allow/disallow), Member Login di-noindex.

## Blog (CMS Posts)

| Item | Lokasi |
|------|--------|
| Listing | `/blog/` → `home.php` |
| Detail | `single.php` (`the_content()` dari Posts) |
| Setup | `inc/blog.php` |

Kelola konten lewat **Admin → Posts**.

## Tema Tailwind

```bash
cd wp-content/themes/apexora
npm install
npm run build   # atau npm run dev
```

Sumber: `assets/css/input.css` → output: `assets/css/app.css`.
