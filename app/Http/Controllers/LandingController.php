<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function home()
    {
        $stats = [
            'donors'       => 12_450,
            'participants' => 8_320,
            'activities'   => 340,
            'campaigns'    => 56,
        ];

        $testimonials = [
            [
                'name'   => 'Siti Rahayu',
                'role'   => 'Ibu Rumah Tangga',
                'avatar' => null,
                'text'   => 'WONCare membantu saya memahami keuangan keluarga dengan lebih baik. Kursus-kursusnya sangat praktis dan mudah dipahami.',
                'rating' => 5,
            ],
            [
                'name'   => 'Ahmad Fauzi',
                'role'   => 'Pengusaha Muda',
                'avatar' => null,
                'text'   => 'Berdonasi melalui WONCare sangat mudah dan transparan. Saya bisa melihat langsung dampak donasi saya untuk masyarakat.',
                'rating' => 5,
            ],
            [
                'name'   => 'Dewi Kusuma',
                'role'   => 'Mahasiswi',
                'avatar' => null,
                'text'   => 'Komunitas WONCare luar biasa! Saya mendapatkan banyak ilmu dan teman baru yang peduli terhadap sesama.',
                'rating' => 5,
            ],
        ];

        return view('landing.home', compact('stats', 'testimonials'));
    }

    public function about()
    {
        $programs = [
            [
                'key'   => 'masjid_care',
                'icon'  => 'tabler-building-mosque',
                'color' => '#10b981',
                'title' => 'Masjid Care',
                'desc'  => 'Program pemberdayaan dan renovasi masjid di daerah terpencil agar menjadi pusat kegiatan sosial dan pendidikan umat.',
            ],
            [
                'key'   => 'migrant_care',
                'icon'  => 'tabler-plane',
                'color' => '#3b82f6',
                'title' => 'Migrant Care',
                'desc'  => 'Pendampingan dan perlindungan tenaga kerja migran Indonesia di luar negeri, termasuk bantuan hukum dan pemulangan.',
            ],
            [
                'key'   => 'palestine_care',
                'icon'  => 'tabler-heart-handshake',
                'color' => '#ef4444',
                'title' => 'Palestine Care',
                'desc'  => 'Solidaritas kemanusiaan untuk saudara-saudara kita di Palestina melalui donasi, advokasi, dan kampanye kesadaran global.',
            ],
            [
                'key'   => 'nusantara_care',
                'icon'  => 'tabler-map-pin',
                'color' => '#f59e0b',
                'title' => 'Nusantara Care',
                'desc'  => 'Program pemberdayaan masyarakat di seluruh penjuru Nusantara melalui pendidikan, ekonomi, dan kesehatan.',
            ],
        ];

        $team = [
            ['name' => 'Dr. Hasan Basri', 'role' => 'Founder & CEO', 'avatar' => null],
            ['name' => 'Nur Aisyah, M.Sc', 'role' => 'Direktur Program', 'avatar' => null],
            ['name' => 'Rizky Pratama', 'role' => 'Kepala Teknologi', 'avatar' => null],
            ['name' => 'Fatimah Zahra', 'role' => 'Manajer Komunitas', 'avatar' => null],
        ];

        $partners = [
            'Kementerian Sosial RI',
            'BAZNAS',
            'Dompet Dhuafa',
            'ACT Indonesia',
            'UNHCR Indonesia',
            'Bank Syariah Indonesia',
        ];

        return view('landing.about', compact('programs', 'team', 'partners'));
    }

    public function blog()
    {
        $articles = [
            [
                'id'       => 1,
                'category' => 'Keuangan',
                'cat_color'=> 'success',
                'title'    => 'Cara Mengelola Keuangan Keluarga dengan Metode 50/30/20',
                'excerpt'  => 'Metode 50/30/20 adalah cara sederhana membagi penghasilan untuk kebutuhan, keinginan, dan tabungan. Pelajari cara menerapkannya dalam kehidupan sehari-hari.',
                'author'   => 'Tim WONCare',
                'date'     => '15 Februari 2026',
                'read_time'=> '5 menit',
                'image'    => null,
            ],
            [
                'id'       => 2,
                'category' => 'Spiritual',
                'cat_color'=> 'warning',
                'title'    => 'Keutamaan Berzakat dan Dampaknya bagi Perekonomian Umat',
                'excerpt'  => 'Zakat bukan hanya kewajiban ibadah, tetapi juga instrumen ekonomi yang powerful untuk mengurangi kesenjangan sosial dan menggerakkan roda perekonomian.',
                'author'   => 'Ustadz Ahmad',
                'date'     => '10 Februari 2026',
                'read_time'=> '7 menit',
                'image'    => null,
            ],
            [
                'id'       => 3,
                'category' => 'Sosial',
                'cat_color'=> 'info',
                'title'    => 'Update Penyaluran Donasi Palestina: Januari 2026',
                'excerpt'  => 'Laporan transparansi penyaluran donasi untuk saudara-saudara kita di Palestina selama bulan Januari 2026. Total tersalurkan Rp 2,4 Miliar.',
                'author'   => 'Tim Program',
                'date'     => '5 Februari 2026',
                'read_time'=> '4 menit',
                'image'    => null,
            ],
            [
                'id'       => 4,
                'category' => 'Keuangan',
                'cat_color'=> 'success',
                'title'    => 'Investasi Syariah untuk Pemula: Panduan Lengkap 2026',
                'excerpt'  => 'Mulai berinvestasi dengan prinsip syariah tidak harus rumit. Panduan ini akan membantu Anda memahami instrumen investasi yang halal dan menguntungkan.',
                'author'   => 'Tim WONCare',
                'date'     => '1 Februari 2026',
                'read_time'=> '8 menit',
                'image'    => null,
            ],
            [
                'id'       => 5,
                'category' => 'Kegiatan',
                'cat_color'=> 'primary',
                'title'    => 'Pelatihan Wirausaha Migrant Care: 200 Peserta Lulus',
                'excerpt'  => 'Program pelatihan wirausaha untuk mantan TKI berhasil meluluskan 200 peserta. Mereka kini siap memulai usaha mandiri di kampung halaman.',
                'author'   => 'Tim Migrant Care',
                'date'     => '28 Januari 2026',
                'read_time'=> '3 menit',
                'image'    => null,
            ],
            [
                'id'       => 6,
                'category' => 'Sosial',
                'cat_color'=> 'info',
                'title'    => 'Renovasi 12 Masjid di Pelosok NTT Selesai Dikerjakan',
                'excerpt'  => 'Program Masjid Care berhasil merenovasi 12 masjid di Nusa Tenggara Timur. Kini masjid-masjid tersebut menjadi pusat kegiatan masyarakat.',
                'author'   => 'Tim Masjid Care',
                'date'     => '20 Januari 2026',
                'read_time'=> '4 menit',
                'image'    => null,
            ],
        ];

        $categories = ['Semua', 'Keuangan', 'Spiritual', 'Sosial', 'Kegiatan'];

        return view('landing.blog', compact('articles', 'categories'));
    }

    public function blogDetail($id)
    {
        $articles = [
            1 => [
                'id'       => 1,
                'category' => 'Keuangan',
                'cat_color'=> 'success',
                'title'    => 'Cara Mengelola Keuangan Keluarga dengan Metode 50/30/20',
                'author'   => 'Tim WONCare',
                'date'     => '15 Februari 2026',
                'read_time'=> '5 menit',
                'image'    => null,
                'content'  => '<p>Metode 50/30/20 adalah salah satu pendekatan paling populer dalam pengelolaan keuangan pribadi dan keluarga. Dikembangkan oleh Senator AS Elizabeth Warren, metode ini membagi penghasilan bersih Anda menjadi tiga kategori utama.</p><h4>Apa itu Metode 50/30/20?</h4><p><strong>50% untuk Kebutuhan</strong> — Ini mencakup semua pengeluaran yang wajib dan tidak bisa dihindari: sewa/cicilan rumah, tagihan listrik dan air, makanan pokok, transportasi ke tempat kerja, dan asuransi kesehatan.</p><p><strong>30% untuk Keinginan</strong> — Kategori ini mencakup pengeluaran yang membuat hidup lebih menyenangkan namun bukan keharusan: makan di restoran, hiburan, liburan, pakaian non-esensial, dan langganan streaming.</p><p><strong>20% untuk Tabungan & Investasi</strong> — Bagian ini dialokasikan untuk dana darurat, tabungan pensiun, investasi, dan pelunasan utang lebih cepat.</p><h4>Cara Menerapkannya</h4><p>Pertama, hitung penghasilan bersih bulanan Anda. Kemudian kalikan dengan persentase masing-masing kategori. Pantau pengeluaran Anda setiap minggu menggunakan aplikasi atau buku catatan.</p>',
            ],
        ];

        $article = $articles[$id] ?? $articles[1];

        $related = [
            ['id' => 2, 'title' => 'Keutamaan Berzakat dan Dampaknya bagi Perekonomian Umat', 'category' => 'Spiritual', 'cat_color' => 'warning', 'date' => '10 Februari 2026'],
            ['id' => 4, 'title' => 'Investasi Syariah untuk Pemula: Panduan Lengkap 2026', 'category' => 'Keuangan', 'cat_color' => 'success', 'date' => '1 Februari 2026'],
        ];

        return view('landing.blog-detail', compact('article', 'related'));
    }

    public function events()
    {
        $upcoming = [
            [
                'id'       => 1,
                'type'     => 'Online',
                'type_color'=> 'info',
                'title'    => 'Webinar: Perencanaan Keuangan Syariah 2026',
                'date'     => '25 Februari 2026',
                'time'     => '19:00 - 21:00 WIB',
                'location' => 'Zoom Meeting',
                'speaker'  => 'Dr. Hasan Basri',
                'seats'    => 500,
                'registered'=> 312,
                'free'     => true,
            ],
            [
                'id'       => 2,
                'type'     => 'Offline',
                'type_color'=> 'success',
                'title'    => 'Workshop Wirausaha Mandiri untuk Mantan TKI',
                'date'     => '1 Maret 2026',
                'time'     => '08:00 - 17:00 WIB',
                'location' => 'Gedung SMESCO, Jakarta Selatan',
                'speaker'  => 'Tim Migrant Care',
                'seats'    => 100,
                'registered'=> 87,
                'free'     => true,
            ],
            [
                'id'       => 3,
                'type'     => 'Online',
                'type_color'=> 'info',
                'title'    => 'Kajian Rutin: Fiqih Muamalah Modern',
                'date'     => '7 Maret 2026',
                'time'     => '20:00 - 21:30 WIB',
                'location' => 'YouTube Live WONCare',
                'speaker'  => 'Ustadz Ahmad Fauzi',
                'seats'    => 0,
                'registered'=> 0,
                'free'     => true,
            ],
            [
                'id'       => 4,
                'type'     => 'Offline',
                'type_color'=> 'success',
                'title'    => 'Bazar Sosial & Penggalangan Dana Nusantara Care',
                'date'     => '15 Maret 2026',
                'time'     => '09:00 - 16:00 WIB',
                'location' => 'Taman Monas, Jakarta Pusat',
                'speaker'  => 'Tim Nusantara Care',
                'seats'    => 0,
                'registered'=> 0,
                'free'     => true,
            ],
        ];

        $past = [
            [
                'title'    => 'Seminar Nasional: Ekonomi Islam di Era Digital',
                'date'     => '10 Januari 2026',
                'type'     => 'Hybrid',
                'participants' => 850,
            ],
            [
                'title'    => 'Pelatihan Wirausaha Migrant Care Batch 3',
                'date'     => '5 Januari 2026',
                'type'     => 'Offline',
                'participants' => 200,
            ],
            [
                'title'    => 'Webinar Akhir Tahun: Refleksi & Resolusi Keuangan',
                'date'     => '28 Desember 2025',
                'type'     => 'Online',
                'participants' => 1200,
            ],
        ];

        return view('landing.events', compact('upcoming', 'past'));
    }

    public function contact()
    {
        $faqs = [
            [
                'q' => 'Apa itu WONCare?',
                'a' => 'WONCare adalah platform digital yang mengintegrasikan edukasi keuangan, donasi sosial, dan komunitas untuk memberdayakan masyarakat Indonesia agar berdaya dan berdampak.',
            ],
            [
                'q' => 'Bagaimana cara mendaftar di WONCare?',
                'a' => 'Klik tombol "Daftar Sekarang" di halaman utama, isi formulir pendaftaran dengan email dan password Anda, atau daftar langsung menggunakan akun Google. Proses pendaftaran hanya membutuhkan waktu kurang dari 2 menit.',
            ],
            [
                'q' => 'Apakah donasi di WONCare aman dan terpercaya?',
                'a' => 'Ya, WONCare bekerja sama dengan lembaga-lembaga terpercaya dan menggunakan payment gateway yang terenkripsi. Setiap donasi dilaporkan secara transparan dan dapat dipantau oleh donatur.',
            ],
            [
                'q' => 'Apakah kursus di WONCare gratis?',
                'a' => 'WONCare menyediakan berbagai kursus, baik yang gratis maupun berbayar. Kursus dasar keuangan dan spiritual tersedia secara gratis untuk semua member yang terdaftar.',
            ],
            [
                'q' => 'Bagaimana cara bergabung dengan komunitas WONCare?',
                'a' => 'Setelah mendaftar dan login, Anda dapat mengakses menu Komunitas untuk bergabung dengan grup WhatsApp, mengikuti event, dan berinteraksi dengan sesama member.',
            ],
            [
                'q' => 'Bagaimana cara menghubungi tim WONCare?',
                'a' => 'Anda dapat menghubungi kami melalui formulir kontak di halaman ini, WhatsApp di +62 812-3456-7890, atau email ke support@woncare.id. Tim kami siap membantu Senin–Jumat, 08:00–17:00 WIB.',
            ],
            [
                'q' => 'Apakah WONCare mendukung donasi dari luar negeri?',
                'a' => 'Ya, WONCare mendukung donasi dalam mata uang Rupiah (IDR) dan Won Korea (KRW) melalui gateway pembayaran internasional yang aman.',
            ],
        ];

        return view('landing.contact', compact('faqs'));
    }
}
