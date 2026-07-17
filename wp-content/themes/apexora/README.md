# Apexora Softworks — Implementasi Teknis

Tema WordPress company profile untuk software house, dibangun dengan **Tailwind CSS**, plus konfigurasi **Google Analytics (via .env)**, **SEO**, **AEO**, **GEO**, dan **AIO**.

## Stack

| Layer | Teknologi |
|--------|-----------|
| CMS | WordPress (gratis) |
| Theme | `wp-content/themes/apexora` |
| CSS | Tailwind CSS v4 (`assets/css/input.css` → `app.css`) |
| Env | Root `.env` dimuat oleh `wp-content/mu-plugins/load-env.php` + `wp-config.php` |

## Halaman (SEO-ready)

Dibuat otomatis saat tema diaktifkan (`inc/pages-setup.php`):

| Slug | Halaman |
|------|---------|
| `/` | Beranda (`front-page.php`) |
| `/tentang-kami/` | Tentang Kami |
| `/produk-servis/` | Produk / Servis |
| `/kontak/` | Kontak |
| `/events/` | Events |
| `/faq/` | FAQ |
| `/member-login/` | Member Login (`noindex`) |

## Setup cepat

1. Pastikan database `companyprofilewordpress` ada (Laragon MySQL).
2. Salin `.env.example` → `.env` (sudah ada di root), isi `GA_MEASUREMENT_ID`.
3. Install WordPress lewat browser jika belum: `http://companyprofilewordpress.test/wp-admin/install.php`
4. Aktifkan tema **Apexora Softworks** di Appearance → Themes.
5. Build CSS (opsional jika `app.css` sudah ada):

```bash
cd wp-content/themes/apexora
npm install
npm run build
```

## Google Analytics (env)

**File:** `.env`

```env
GA_MEASUREMENT_ID=G-XXXXXXXXXX
GTM_CONTAINER_ID=GTM-XXXXXXX
```

**Implementasi:**

- `wp-content/mu-plugins/load-env.php` mem-parse `.env` → `define()` + `getenv()`.
- `inc/analytics.php` menyisipkan GA4 `gtag.js` dan opsional GTM di `wp_head` / `wp_body_open`.
- ID divalidasi regex; placeholder `G-XXXXXXXXXX` **tidak** di-load (aman untuk lokal).
- Admin notice mengingatkan jika GA belum diisi.

## SEO (Search Engine Optimization)

**File:** `inc/seo.php`

- Title unik per halaman (`pre_get_document_title`).
- Meta description, keywords, robots, canonical.
- Open Graph + Twitter Card.
- OG image dari `.env` `SITE_DEFAULT_OG_IMAGE` atau featured image.
- Member Login: `noindex,nofollow`.

Sitemap bawaan WordPress: `/wp-sitemap.xml`.

## AEO (Answer Engine Optimization)

**File:** `inc/aeo-geo-aio.php` + `inc/schema.php`

Tujuan: konten mudah dijawab mesin jawaban (Google AI Overview, voice, featured snippets).

- Bank jawaban singkat Q→A (`apexora_answer_bank()`).
- Halaman FAQ dengan `<details>` + teks langsung.
- JSON-LD `FAQPage` + `Organization`.
- Meta `speakable` / `answer-engine`.

## GEO (Generative Engine Optimization)

**File:** `inc/aeo-geo-aio.php`

Tujuan: generative AI (ChatGPT, Perplexity, Gemini, dll.) bisa mengutip sumber resmi.

- Endpoint teks mesin: `/llms.txt` (rewrite rule).
- Meta `ai:publisher`, `ai:citation`, `generator-engine`.
- Fakta organisasi terstruktur di `llms.txt` untuk sitasi.

## AIO (AI Optimization)

**File:** `inc/aeo-geo-aio.php`

Tujuan: sinyal intent & kebijakan untuk AI crawler/agent.

- Meta `ai:page-intent` (informational / commercial / transactional / answer).
- Meta entity type & primary topic.
- Endpoint `/ai.txt` (allow/disallow + prefer-citation).
- Member area & wp-admin di-disallow untuk AI agents.

## Struktur tema

```
apexora/
├── assets/css/input.css   # sumber Tailwind
├── assets/css/app.css     # hasil build
├── assets/js/main.js
├── assets/img/og-default.svg
├── inc/
│   ├── analytics.php
│   ├── aeo-geo-aio.php
│   ├── contact.php
│   ├── enqueue.php
│   ├── pages-setup.php
│   ├── schema.php
│   ├── seo.php
│   └── setup.php
├── front-page.php
├── page-tentang-kami.php
├── page-produk-servis.php
├── page-kontak.php
├── page-events.php
├── page-faq.php
├── page-member-login.php
├── functions.php
├── package.json
└── style.css
```

## Permalink

Gunakan **Post name** di Settings → Permalinks agar slug SEO (`/tentang-kami/`, dll.) aktif, lalu Save untuk flush rewrite (`llms.txt` / `ai.txt`).
