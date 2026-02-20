<?php

namespace Database\Seeders;

use App\Models\CommunityPost;
use Illuminate\Database\Seeder;

class CommunityPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title'        => 'Selamat Datang di Komunitas WonCare!',
                'content'      => '<p>Halo para anggota WonCare yang luar biasa! Kami sangat senang menyambut kalian semua di komunitas yang penuh semangat ini.</p><p>Di sini kita bisa berbagi pengalaman, saling mendukung, dan bersama-sama membuat perubahan positif. Jangan ragu untuk aktif berpartisipasi dalam diskusi, mengikuti event volunteer, dan bergabung dengan grup WhatsApp regional kalian.</p><p>Bersama kita bisa lebih kuat! 💪</p>',
                'author_name'  => 'Tim WonCare',
                'status'       => 'published',
                'is_pinned'    => true,
                'published_at' => now()->subDays(30),
            ],
            [
                'title'        => 'Tips Menjaga Kesehatan Mental di Tengah Kesibukan',
                'content'      => '<p>Kesehatan mental sama pentingnya dengan kesehatan fisik. Berikut beberapa tips yang bisa kalian terapkan sehari-hari:</p><ul><li>Luangkan waktu 10 menit untuk meditasi atau pernapasan dalam</li><li>Batasi penggunaan media sosial, terutama sebelum tidur</li><li>Jaga pola tidur yang teratur (7-8 jam per malam)</li><li>Ceritakan perasaanmu kepada orang yang kamu percaya</li><li>Lakukan aktivitas fisik minimal 30 menit sehari</li></ul><p>Ingat, meminta bantuan adalah tanda kekuatan, bukan kelemahan. Komunitas WonCare selalu ada untuk kalian!</p>',
                'author_name'  => 'dr. Sari Dewi, Psikolog',
                'status'       => 'published',
                'is_pinned'    => false,
                'published_at' => now()->subDays(25),
            ],
            [
                'title'        => 'Kisah Inspiratif: Perjalanan Bunda Rahma Menjadi Relawan',
                'content'      => '<p>Bunda Rahma, 45 tahun, bergabung dengan WonCare dua tahun lalu sebagai penerima manfaat program beasiswa. Kini ia menjadi salah satu relawan paling aktif di wilayah Jawa Tengah.</p><p>"Dulu saya yang dibantu, sekarang giliran saya membantu orang lain. Rasanya luar biasa bisa melihat senyum di wajah mereka yang terbantu," cerita Bunda Rahma.</p><p>Ia kini aktif mengajar keterampilan menjahit kepada ibu-ibu di sekitar tempat tinggalnya, membantu mereka mendapatkan penghasilan tambahan.</p><p>Kisah Bunda Rahma membuktikan bahwa setiap orang memiliki potensi untuk memberi dampak positif bagi lingkungannya.</p>',
                'author_name'  => 'Redaksi WonCare',
                'status'       => 'published',
                'is_pinned'    => false,
                'published_at' => now()->subDays(20),
            ],
            [
                'title'        => 'Program Beasiswa Ramadan 2025: Pendaftaran Dibuka!',
                'content'      => '<p>Alhamdulillah, WonCare kembali membuka pendaftaran Program Beasiswa Ramadan 2025. Program ini ditujukan untuk pelajar dan mahasiswa kurang mampu yang berprestasi.</p><p><strong>Persyaratan:</strong></p><ul><li>WNI berusia 15-25 tahun</li><li>Memiliki prestasi akademik (nilai rata-rata minimal 7.5)</li><li>Berasal dari keluarga kurang mampu (dilengkapi surat keterangan)</li><li>Aktif di kegiatan sosial atau organisasi</li></ul><p><strong>Benefit:</strong></p><ul><li>Bantuan biaya pendidikan Rp 2.000.000/semester</li><li>Mentoring dari para profesional</li><li>Akses ke komunitas WonCare</li></ul><p>Daftarkan dirimu sekarang! Kuota terbatas untuk 50 penerima manfaat.</p>',
                'author_name'  => 'Tim Program WonCare',
                'status'       => 'published',
                'is_pinned'    => true,
                'published_at' => now()->subDays(15),
            ],
            [
                'title'        => 'Refleksi Akhir Tahun: Dampak Nyata Komunitas Kita',
                'content'      => '<p>Di penghujung tahun ini, mari kita bersama-sama merenungkan perjalanan luar biasa yang telah kita tempuh bersama.</p><p><strong>Pencapaian 2024:</strong></p><ul><li>1.200+ anggota aktif di seluruh Indonesia</li><li>85 kegiatan volunteer berhasil dilaksanakan</li><li>320 penerima manfaat program beasiswa</li><li>15 kota terjangkau program WonCare</li><li>Rp 2,5 Miliar dana sosial tersalurkan</li></ul><p>Semua ini tidak mungkin terwujud tanpa kontribusi kalian semua. Terima kasih telah menjadi bagian dari keluarga besar WonCare!</p><p>Mari kita sambut 2025 dengan semangat yang lebih besar untuk memberikan dampak yang lebih luas. Bersama kita bisa! 🌟</p>',
                'author_name'  => 'Direktur WonCare',
                'status'       => 'published',
                'is_pinned'    => false,
                'published_at' => now()->subDays(10),
            ],
            [
                'title'        => 'Workshop Online: Manajemen Keuangan untuk Keluarga',
                'content'      => '<p>WonCare mengadakan workshop online gratis bertema "Manajemen Keuangan Cerdas untuk Keluarga Indonesia". Workshop ini akan membahas cara mengelola keuangan keluarga dengan bijak di tengah tantangan ekonomi.</p><p><strong>Materi yang akan dibahas:</strong></p><ul><li>Membuat anggaran keluarga yang realistis</li><li>Strategi menabung dengan penghasilan terbatas</li><li>Investasi sederhana untuk masa depan</li><li>Menghindari jebakan utang konsumtif</li></ul><p><strong>Detail Acara:</strong></p><ul><li>Tanggal: Sabtu, 15 Februari 2025</li><li>Waktu: 09.00 - 12.00 WIB</li><li>Platform: Zoom (link akan dikirim via WhatsApp grup)</li></ul><p>Daftarkan dirimu sekarang, gratis untuk semua anggota WonCare!</p>',
                'author_name'  => 'Panitia Workshop WonCare',
                'status'       => 'published',
                'is_pinned'    => false,
                'published_at' => now()->subDays(5),
            ],
            [
                'title'        => 'Panduan Bergabung Grup WhatsApp Regional WonCare',
                'content'      => '<p>Untuk mempererat silaturahmi antar anggota, WonCare telah membentuk grup WhatsApp berdasarkan wilayah. Berikut cara bergabung:</p><ol><li>Pastikan kamu sudah terdaftar sebagai anggota aktif WonCare</li><li>Pilih grup sesuai wilayah domisilimu</li><li>Klik link yang tersedia di halaman Komunitas</li><li>Perkenalkan dirimu setelah bergabung</li></ol><p><strong>Aturan Grup:</strong></p><ul><li>Gunakan bahasa yang sopan dan santun</li><li>Dilarang menyebarkan hoaks atau konten negatif</li><li>Promosi dilarang tanpa izin admin</li><li>Aktif berpartisipasi dalam diskusi positif</li></ul><p>Sampai jumpa di grup! 😊</p>',
                'author_name'  => 'Admin Komunitas WonCare',
                'status'       => 'published',
                'is_pinned'    => false,
                'published_at' => now()->subDays(3),
            ],
            [
                'title'        => 'Draft: Rencana Program Komunitas Q1 2025',
                'content'      => '<p>Ini adalah draft rencana program komunitas untuk kuartal pertama 2025. Masih dalam proses finalisasi oleh tim.</p><p>Program yang direncanakan meliputi pelatihan keterampilan digital, program mentoring untuk pemuda, dan kampanye kesehatan mental.</p>',
                'author_name'  => 'Tim Program WonCare',
                'status'       => 'draft',
                'is_pinned'    => false,
                'published_at' => null,
            ],
        ];

        foreach ($posts as $post) {
            CommunityPost::create($post);
        }
    }
}
