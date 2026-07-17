# Apexora Softworks — Company Profile WordPress

Website company profile software house berbasis **WordPress**, tema kustom **Apexora** (Tailwind CSS), dengan konfigurasi **Google Analytics (.env)**, **SEO**, **AEO**, **GEO**, **AIO**, dan **Blog** yang terhubung ke CMS Posts.

## Stack

| Layer | Teknologi |
|--------|-----------|
| CMS | WordPress |
| Theme | `wp-content/themes/apexora` |
| CSS | Tailwind CSS v4 (`assets/css/input.css` → `app.css`) |
| Env | Root `.env` dimuat oleh `wp-content/mu-plugins/load-env.php` |

## Setup cepat

1. Pastikan database MySQL `companyprofilewordpress` sudah ada (Laragon).
2. Salin `.env.example` → `.env`, lalu isi `GA_MEASUREMENT_ID`.
3. Jalankan situs: `http://localhost/companyprofilewordpress/`
4. Aktifkan tema **Apexora Softworks** di Appearance → Themes (jika belum).
5. Settings → Permalinks → pilih **Post name** → Save.
6. (Opsional) Build CSS tema:

```bash
cd wp-content/themes/apexora
npm install
npm run build
```

---

## Halaman & fitur

| URL | Keterangan |
|-----|------------|
| `/` | Beranda |
| `/tentang-kami/` | Tentang Kami |
| `/produk-servis/` | Produk / Servis |
| `/blog/` | Blog / artikel (dari CMS Posts) |
| `/kontak/` | Kontak |
| `/events/` | Events |
| `/faq/` | FAQ |
| `/member-login/` | Member Login (`noindex`) |
| `/llms.txt` | Sumber sitasi untuk generative AI (GEO) |
| `/ai.txt` | Kebijakan akses AI agent (AIO) |
| `/wp-sitemap.xml` | Sitemap WordPress |

Halaman company profile dibuat otomatis saat tema diaktifkan (`inc/pages-setup.php`).

### Blog (CMS)

- Konten diambil dari **WordPress Admin → Posts**.
- Listing: `home.php` → `/blog/`
- Detail artikel: `single.php`
- Arsip kategori/tag: `archive.php`
- Setup & helper: `inc/blog.php`
- Tulis artikel baru di admin → langsung tampil di frontend.

---

## Google Analytics (env)

| Item | Lokasi |
|------|--------|
| Variabel | `.env` → `GA_MEASUREMENT_ID`, `GTM_CONTAINER_ID` |
| Loader | `wp-content/mu-plugins/load-env.php` (+ di-require dari `wp-config.php`) |
| Inject script | `wp-content/themes/apexora/inc/analytics.php` |

Contoh `.env`:

```env
GA_MEASUREMENT_ID=G-XXXXXXXXXX
GTM_CONTAINER_ID=
SITE_ORG_NAME=Apexora Softworks
SITE_ORG_EMAIL=hello@apexora.id
ENABLE_AEO=true
ENABLE_GEO=true
ENABLE_AIO=true
ENABLE_JSON_LD=true
```

**Alur:**

1. `load-env.php` mem-parse `.env` → `define()` / `getenv()`.
2. `inc/analytics.php` menyisipkan GA4 `gtag.js` (dan opsional GTM) di `wp_head`.
3. ID divalidasi regex; placeholder `G-XXXXXXXXXX` **tidak** di-render.
4. Admin notice muncul jika GA belum diisi.

---

## SEO (Search Engine Optimization)

| Fitur | File |
|-------|------|
| Title, description, robots, canonical, OG, Twitter | `inc/seo.php` |
| JSON-LD Organization / WebSite / Service / FAQ / Event / Article / Blog | `inc/schema.php` |
| Sitemap | `/wp-sitemap.xml` |

**Yang diimplementasikan:**

- Title & meta unik per halaman (termasuk artikel blog).
- Open Graph + Twitter Card.
- OG image dari `SITE_DEFAULT_OG_IMAGE` atau featured image.
- Member Login: `noindex,nofollow`.
- Schema `Article` untuk single post; `Blog` untuk listing `/blog/`.

---

## AEO (Answer Engine Optimization)

**Tujuan:** konten mudah dijawab mesin jawaban (AI Overview, featured snippet, voice).

**File:** `inc/aeo-geo-aio.php` + `inc/schema.php`

- Bank jawaban Q→A: `apexora_answer_bank()`
- Halaman FAQ dengan jawaban langsung
- JSON-LD `FAQPage`
- Meta `speakable` / `answer-engine` (flag `ENABLE_AEO`)

---

## GEO (Generative Engine Optimization)

**Tujuan:** generative AI (ChatGPT, Perplexity, Gemini, dll.) punya sumber resmi untuk sitasi.

**File:** `inc/aeo-geo-aio.php`

- Endpoint `/llms.txt` (fakta situs + key facts)
- Meta `ai:publisher`, `ai:citation`, `generator-engine`
- Flag `ENABLE_GEO`

---

## AIO (AI Optimization)

**Tujuan:** sinyal intent & kebijakan untuk AI crawler/agent.

**File:** `inc/aeo-geo-aio.php`

- Meta `ai:page-intent` (`informational` / `commercial` / `transactional` / `answer`)
- Meta entity type & primary topic
- Endpoint `/ai.txt` (allow/disallow + prefer-citation)
- Member Login & `wp-admin` di-disallow
- Flag `ENABLE_AIO`

---

## Alur konfigurasi

```
.env
  → load-env.php
    → analytics.php      (GA / GTM)
    → seo.php / schema.php
    → aeo-geo-aio.php    (AEO / GEO / AIO)
    → blog.php           (Posts CMS)
    → page templates
```

---

## Struktur tema

```
wp-content/themes/apexora/
├── assets/css/input.css
├── assets/css/app.css
├── assets/js/main.js
├── docs/Apexora-Implementasi-Teknis.pdf
├── inc/
│   ├── analytics.php
│   ├── aeo-geo-aio.php
│   ├── blog.php
│   ├── contact.php
│   ├── enqueue.php
│   ├── pages-setup.php
│   ├── schema.php
│   ├── seo.php
│   └── setup.php
├── template-parts/content-post-card.php
├── front-page.php
├── home.php              # listing blog
├── single.php            # detail artikel
├── archive.php
├── page-*.php
├── functions.php
└── package.json
```

## Build Tailwind

```bash
cd wp-content/themes/apexora
npm install
npm run build   # produksi
npm run dev     # watch
```

## Dokumen terkait

- Ringkasan singkat: [`IMPLEMENTASI-TEKNIS.md`](IMPLEMENTASI-TEKNIS.md)
- PDF teknis: [`wp-content/themes/apexora/docs/Apexora-Implementasi-Teknis.pdf`](wp-content/themes/apexora/docs/Apexora-Implementasi-Teknis.pdf)
- Detail tema: [`wp-content/themes/apexora/README.md`](wp-content/themes/apexora/README.md)

## Checklist verifikasi

- [ ] View Source: title, description, OG, JSON-LD, meta AEO/GEO/AIO
- [ ] `gtag` muncul hanya jika `GA_MEASUREMENT_ID` valid
- [ ] `/wp-sitemap.xml`, `/llms.txt`, `/ai.txt` bisa diakses
- [ ] `/blog/` menampilkan Posts dari CMS
- [ ] Member Login ber-meta `noindex,nofollow`
- [ ] CSS tema `app.css` ter-load
