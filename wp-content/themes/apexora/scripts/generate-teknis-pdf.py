#!/usr/bin/env python3
"""Generate simple black-and-white technical PDF for Apexora theme."""

from pathlib import Path

from fpdf import FPDF

OUT = Path(__file__).resolve().parents[1] / "docs" / "Apexora-Implementasi-Teknis.pdf"
ROOT_COPY = Path(__file__).resolve().parents[4] / "docs" / "Apexora-Implementasi-Teknis.pdf"
FONT_DIR = Path(r"C:\Windows\Fonts")


class DocPDF(FPDF):
    def __init__(self):
        super().__init__(orientation="P", unit="mm", format="A4")
        self.add_font("Body", "", str(FONT_DIR / "arial.ttf"))
        self.add_font("Body", "B", str(FONT_DIR / "arialbd.ttf"))
        self.add_font("Body", "I", str(FONT_DIR / "ariali.ttf"))
        self.add_font("Mono", "", str(FONT_DIR / "cour.ttf"))

    def header(self):
        if self.page_no() == 1:
            return
        self.set_font("Body", "", 9)
        self.set_text_color(0, 0, 0)
        self.cell(0, 6, "Apexora Softworks - Implementasi Teknis", align="L")
        self.ln(2)
        self.set_draw_color(0, 0, 0)
        self.set_line_width(0.2)
        self.line(self.l_margin, self.get_y(), self.w - self.r_margin, self.get_y())
        self.ln(5)

    def footer(self):
        self.set_y(-15)
        self.set_font("Body", "", 8)
        self.set_text_color(0, 0, 0)
        self.cell(0, 10, f"Halaman {self.page_no()}/{{nb}}", align="C")

    def h1(self, text: str):
        self.ln(2)
        self.set_x(self.l_margin)
        self.set_font("Body", "B", 13)
        self.set_text_color(0, 0, 0)
        self.multi_cell(0, 7, text, new_x="LMARGIN", new_y="NEXT")
        self.ln(1)

    def h2(self, text: str):
        self.ln(2)
        self.set_x(self.l_margin)
        self.set_font("Body", "B", 11)
        self.set_text_color(0, 0, 0)
        self.multi_cell(0, 6, text, new_x="LMARGIN", new_y="NEXT")
        self.ln(1)

    def body(self, text: str):
        self.set_x(self.l_margin)
        self.set_font("Body", "", 10)
        self.set_text_color(0, 0, 0)
        self.multi_cell(0, 5.2, text, new_x="LMARGIN", new_y="NEXT")
        self.ln(1)

    def bullet(self, text: str):
        self.set_x(self.l_margin)
        self.set_font("Body", "", 10)
        self.set_text_color(0, 0, 0)
        self.cell(5, 5.2, "-")
        self.multi_cell(self.epw - 5, 5.2, text, new_x="LMARGIN", new_y="NEXT")

    def code(self, text: str):
        self.set_x(self.l_margin)
        self.set_font("Mono", "", 8.5)
        self.set_text_color(0, 0, 0)
        self.multi_cell(0, 4.5, text, new_x="LMARGIN", new_y="NEXT")
        self.ln(2)

    def line_item(self, label: str, value: str):
        self.set_x(self.l_margin)
        self.set_font("Body", "B", 10)
        self.cell(45, 5.2, label)
        self.set_font("Body", "", 10)
        self.multi_cell(self.epw - 45, 5.2, value, new_x="LMARGIN", new_y="NEXT")


def build():
    OUT.parent.mkdir(parents=True, exist_ok=True)
    ROOT_COPY.parent.mkdir(parents=True, exist_ok=True)

    pdf = DocPDF()
    pdf.alias_nb_pages()
    pdf.set_auto_page_break(auto=True, margin=18)
    pdf.set_margins(20, 18, 20)
    pdf.set_text_color(0, 0, 0)

    # Title page (simple)
    pdf.add_page()
    pdf.set_font("Body", "B", 16)
    pdf.multi_cell(0, 8, "Implementasi Teknis", new_x="LMARGIN", new_y="NEXT")
    pdf.set_font("Body", "B", 14)
    pdf.multi_cell(0, 7, "Website & Theme Apexora Softworks", new_x="LMARGIN", new_y="NEXT")
    pdf.ln(4)
    pdf.set_font("Body", "", 10)
    pdf.multi_cell(
        0,
        5.2,
        "Dokumen ini menjelaskan implementasi teknis company profile software house "
        "berbasis WordPress dengan tema Apexora (Tailwind CSS), termasuk Google Analytics, "
        "SEO, AEO, GEO, dan AIO.",
        new_x="LMARGIN",
        new_y="NEXT",
    )
    pdf.ln(4)
    pdf.line_item("Tema", "wp-content/themes/apexora")
    pdf.line_item("CMS", "WordPress")
    pdf.line_item("Versi", "1.0.0")
    pdf.line_item("Tanggal", "15 Juli 2026")

    # 1
    pdf.h1("1. Ringkasan")
    pdf.body(
        "Website dibangun dengan WordPress. Tema kustom Apexora Softworks memakai Tailwind CSS v4. "
        "Konfigurasi sensitif (GA, data organisasi, feature flags) disimpan di file .env pada root "
        "WordPress dan dimuat oleh wp-content/mu-plugins/load-env.php."
    )
    pdf.body("File inti:")
    pdf.bullet("inc/analytics.php - Google Analytics / GTM")
    pdf.bullet("inc/seo.php - meta SEO, OG, Twitter")
    pdf.bullet("inc/schema.php - JSON-LD Schema.org")
    pdf.bullet("inc/aeo-geo-aio.php - AEO, GEO, AIO")
    pdf.bullet("inc/pages-setup.php - auto-create halaman & menu")

    pdf.body("Halaman:")
    pdf.bullet("/ - Beranda (front-page.php)")
    pdf.bullet("/tentang-kami/ - Tentang Kami")
    pdf.bullet("/produk-servis/ - Produk / Servis")
    pdf.bullet("/kontak/ - Kontak")
    pdf.bullet("/events/ - Events")
    pdf.bullet("/faq/ - FAQ")
    pdf.bullet("/member-login/ - Member Login (noindex)")

    # 2 GA
    pdf.h1("2. Google Analytics (via .env)")
    pdf.body(
        "Measurement ID GA4 dan GTM tidak di-hardcode. Nilai diambil dari .env agar mudah "
        "diganti antar environment."
    )
    pdf.h2("2.1 Contoh .env")
    pdf.code(
        "GA_MEASUREMENT_ID=G-XXXXXXXXXX\n"
        "GTM_CONTAINER_ID=\n"
        "SITE_ORG_NAME=Apexora Softworks\n"
        "SITE_ORG_EMAIL=hello@apexora.id\n"
        "ENABLE_AEO=true\n"
        "ENABLE_GEO=true\n"
        "ENABLE_AIO=true\n"
        "ENABLE_JSON_LD=true"
    )
    pdf.h2("2.2 Alur")
    pdf.bullet("wp-config.php me-require load-env.php")
    pdf.bullet("load-env.php parse KEY=VALUE lalu define()/getenv()")
    pdf.bullet("Tema membaca nilai lewat apexora_env() / apexora_flag()")
    pdf.bullet("inc/analytics.php inject gtag.js / GTM di wp_head")
    pdf.bullet("GTM noscript di wp_body_open")
    pdf.bullet("ID divalidasi regex; placeholder G-XXXXXXXXXX tidak di-render")
    pdf.bullet("gtag memakai anonymize_ip: true")

    pdf.h2("2.3 Aktifkan di produksi")
    pdf.body(
        "Isi GA_MEASUREMENT_ID di .env dengan ID GA4 asli (G-...). Opsional isi GTM_CONTAINER_ID. "
        "Lalu cek View Source halaman depan apakah script gtag muncul."
    )

    # 3 SEO
    pdf.h1("3. SEO (Search Engine Optimization)")
    pdf.body(
        "SEO diimplementasikan native di tema (tanpa plugin berbayar) lewat inc/seo.php dan "
        "inc/schema.php."
    )
    pdf.h2("3.1 Fitur")
    pdf.bullet("Title unik per halaman (filter pre_get_document_title)")
    pdf.bullet("Meta description, keywords, robots, canonical")
    pdf.bullet("Open Graph dan Twitter Card")
    pdf.bullet("OG image dari SITE_DEFAULT_OG_IMAGE atau featured image")
    pdf.bullet("Member Login: noindex,nofollow")
    pdf.bullet("Sitemap WordPress: /wp-sitemap.xml")
    pdf.bullet("Permalink: /%postname%/")

    pdf.h2("3.2 Schema JSON-LD")
    pdf.bullet("Organization")
    pdf.bullet("WebSite")
    pdf.bullet("Service (halaman produk/beranda)")
    pdf.bullet("FAQPage (FAQ/beranda)")
    pdf.bullet("Event (halaman events)")
    pdf.body("Bisa dimatikan dengan ENABLE_JSON_LD=false di .env.")

    # 4 AEO
    pdf.add_page()
    pdf.h1("4. AEO (Answer Engine Optimization)")
    pdf.body(
        "AEO membuat konten mudah diambil mesin jawaban (AI Overview, featured snippet, voice). "
        "Fokus: jawaban singkat, jelas, dan terstruktur."
    )
    pdf.h2("4.1 Implementasi")
    pdf.bullet("apexora_answer_bank() di inc/aeo-geo-aio.php menyimpan Q&A kanonik")
    pdf.bullet("page-faq.php menampilkan Q&A dengan details/summary")
    pdf.bullet("Cuplikan jawaban juga ada di beranda")
    pdf.bullet("JSON-LD FAQPage di inc/schema.php")
    pdf.bullet("Meta speakable dan answer-engine (jika ENABLE_AEO=true)")

    pdf.h2("4.2 Praktik")
    pdf.bullet("Satu pertanyaan = satu jawaban singkat (2-4 kalimat)")
    pdf.bullet("Samakan fakta di FAQ, llms.txt, schema, dan About")

    # 5 GEO
    pdf.h1("5. GEO (Generative Engine Optimization)")
    pdf.body(
        "GEO menyiapkan sumber resmi agar generative AI (ChatGPT, Perplexity, Gemini, dll.) "
        "bisa meringkas dan mengutip situs dengan atribusi benar."
    )
    pdf.h2("5.1 Implementasi")
    pdf.bullet("Endpoint /llms.txt (rewrite rule)")
    pdf.bullet("apexora_render_llms_txt() mengeluarkan fakta situs + Q&A")
    pdf.bullet("Meta ai:publisher, ai:citation, generator-engine")
    pdf.bullet("Link alternate ke /llms.txt")
    pdf.bullet("Dikontrol ENABLE_GEO di .env")

    pdf.h2("5.2 Verifikasi")
    pdf.body(
        "Buka /llms.txt di browser. Pastikan permalink Post name sudah disimpan agar rewrite aktif."
    )

    # 6 AIO
    pdf.h1("6. AIO (AI Optimization)")
    pdf.body(
        "AIO memberi sinyal ke AI crawler/agent: intent halaman, tipe entitas, topik, bahasa, "
        "dan kebijakan akses lewat /ai.txt."
    )
    pdf.h2("6.1 Meta")
    pdf.bullet("ai:page-intent = informational / commercial / transactional / answer")
    pdf.bullet("ai:entity-type = Organization, SoftwareApplication, Service")
    pdf.bullet("ai:content-language = id")
    pdf.bullet("ai:primary-topic = software house, custom software development")

    pdf.h2("6.2 Mapping intent")
    pdf.bullet("Default / About / Events = informational")
    pdf.bullet("Kontak & Produk/Servis = commercial")
    pdf.bullet("Member Login = transactional")
    pdf.bullet("FAQ = answer")

    pdf.h2("6.3 /ai.txt")
    pdf.code(
        "User-Agent: *\n"
        "Allow: /\n"
        "Disallow: /member-login/\n"
        "Disallow: /wp-admin/\n"
        "Prefer-Citation: <home_url>\n"
        "Contact: hello@apexora.id\n"
        "Content-Language: id"
    )
    pdf.body("Dikontrol ENABLE_AIO di .env.")

    # 7
    pdf.h1("7. Hubungan antar fitur")
    pdf.bullet("SEO: peringkat search engine klasik")
    pdf.bullet("AEO: cuplikan jawaban / answer engines")
    pdf.bullet("GEO: sitasi generative AI (/llms.txt)")
    pdf.bullet("AIO: sinyal intent & policy untuk AI agent (/ai.txt)")
    pdf.bullet("Analytics: mengukur traffic dari semua kanal")
    pdf.ln(1)
    pdf.code(
        ".env\n"
        " -> load-env.php\n"
        "   -> analytics.php\n"
        "   -> seo.php / schema.php\n"
        "   -> aeo-geo-aio.php\n"
        "   -> page templates"
    )

    # 8
    pdf.h1("8. Checklist verifikasi")
    pdf.bullet("View Source: title, description, OG, JSON-LD, meta AEO/GEO/AIO")
    pdf.bullet("gtag hanya muncul jika GA_MEASUREMENT_ID valid")
    pdf.bullet("/wp-sitemap.xml bisa dibuka")
    pdf.bullet("/llms.txt dan /ai.txt mengembalikan text/plain")
    pdf.bullet("Member Login ber-meta noindex,nofollow")
    pdf.bullet("Halaman utama 200 OK dan load app.css tema Apexora")

    # 9
    pdf.h1("9. Build Tailwind")
    pdf.code(
        "cd wp-content/themes/apexora\n"
        "npm install\n"
        "npm run build\n"
        "npm run dev"
    )
    pdf.body(
        "Sumber: assets/css/input.css. Output yang dipakai WordPress: assets/css/app.css."
    )

    # 10
    pdf.h1("10. Kesimpulan")
    pdf.body(
        "Tema Apexora menyediakan company profile software house yang siap untuk search engine "
        "dan AI engines, dengan Google Analytics dikonfigurasi lewat .env. Logika utama ada di "
        "wp-content/themes/apexora/inc."
    )

    pdf.output(str(OUT))
    ROOT_COPY.write_bytes(OUT.read_bytes())
    print(f"PDF written: {OUT}")
    print(f"Also copied: {ROOT_COPY}")
    print(f"Size bytes: {OUT.stat().st_size}")


if __name__ == "__main__":
    build()
