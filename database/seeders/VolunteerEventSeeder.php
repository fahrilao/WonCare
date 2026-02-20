<?php

namespace Database\Seeders;

use App\Models\VolunteerEvent;
use Illuminate\Database\Seeder;

class VolunteerEventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title'             => 'Bakti Sosial Kesehatan Gratis - Jakarta Utara',
                'description'       => 'Kegiatan bakti sosial berupa pemeriksaan kesehatan gratis untuk warga kurang mampu di wilayah Jakarta Utara. Kami membutuhkan relawan medis (dokter, perawat, bidan) dan relawan umum untuk membantu administrasi dan logistik.',
                'start_at'          => now()->addDays(14)->setTime(7, 0),
                'end_at'            => now()->addDays(14)->setTime(15, 0),
                'region'            => 'DKI Jakarta',
                'location'          => 'Lapangan RW 05, Kelurahan Penjaringan, Jakarta Utara',
                'is_online'         => false,
                'registration_link' => 'https://forms.google.com/example-baksos-jakarta',
                'is_active'         => true,
            ],
            [
                'title'             => 'Workshop Digital Marketing untuk UMKM - Online',
                'description'       => 'Workshop online gratis untuk membantu pelaku UMKM memahami dan memanfaatkan digital marketing. Relawan yang dibutuhkan adalah mereka yang memiliki keahlian di bidang digital marketing, social media, atau e-commerce.',
                'start_at'          => now()->addDays(7)->setTime(9, 0),
                'end_at'            => now()->addDays(7)->setTime(12, 0),
                'region'            => 'Nasional',
                'location'          => 'Zoom Meeting',
                'is_online'         => true,
                'registration_link' => 'https://forms.google.com/example-workshop-umkm',
                'is_active'         => true,
            ],
            [
                'title'             => 'Pelatihan Keterampilan Menjahit - Bandung',
                'description'       => 'Program pelatihan menjahit selama 3 hari untuk ibu-ibu rumah tangga di Bandung. Kami mencari relawan instruktur menjahit dan relawan pendamping untuk membantu peserta selama pelatihan.',
                'start_at'          => now()->addDays(21)->setTime(8, 0),
                'end_at'            => now()->addDays(23)->setTime(16, 0),
                'region'            => 'Jawa Barat',
                'location'          => 'Balai Warga Kelurahan Cicendo, Bandung',
                'is_online'         => false,
                'registration_link' => 'https://forms.google.com/example-menjahit-bandung',
                'is_active'         => true,
            ],
            [
                'title'             => 'Mengajar di Sekolah Terpencil - Garut',
                'description'       => 'Program mengajar sukarela selama 2 minggu di sekolah dasar terpencil di Kabupaten Garut. Kami membutuhkan relawan pengajar untuk mata pelajaran Matematika, Bahasa Indonesia, dan IPA.',
                'start_at'          => now()->addDays(30)->setTime(7, 30),
                'end_at'            => now()->addDays(44)->setTime(14, 0),
                'region'            => 'Jawa Barat',
                'location'          => 'SDN Cikajang 3, Kecamatan Cikajang, Garut',
                'is_online'         => false,
                'registration_link' => 'https://forms.google.com/example-mengajar-garut',
                'is_active'         => true,
            ],
            [
                'title'             => 'Kampanye Kesehatan Mental - Surabaya',
                'description'       => 'Kampanye kesehatan mental berupa seminar dan konseling gratis untuk remaja di Surabaya. Kami membutuhkan relawan psikolog, konselor, dan relawan umum untuk membantu pelaksanaan acara.',
                'start_at'          => now()->addDays(10)->setTime(9, 0),
                'end_at'            => now()->addDays(10)->setTime(17, 0),
                'region'            => 'Jawa Timur',
                'location'          => 'Aula Universitas Airlangga, Surabaya',
                'is_online'         => false,
                'registration_link' => 'https://forms.google.com/example-mental-health-sby',
                'is_active'         => true,
            ],
            [
                'title'             => 'Distribusi Sembako untuk Lansia - Semarang',
                'description'       => 'Kegiatan distribusi paket sembako untuk lansia kurang mampu di Semarang. Kami membutuhkan relawan untuk membantu packing, distribusi, dan pendataan penerima manfaat.',
                'start_at'          => now()->addDays(5)->setTime(8, 0),
                'end_at'            => now()->addDays(5)->setTime(13, 0),
                'region'            => 'Jawa Tengah',
                'location'          => 'Masjid Al-Ikhlas, Kelurahan Banyumanik, Semarang',
                'is_online'         => false,
                'registration_link' => 'https://forms.google.com/example-sembako-semarang',
                'is_active'         => true,
            ],
            [
                'title'             => 'Webinar: Parenting Islami di Era Digital',
                'description'       => 'Webinar gratis untuk orang tua tentang cara mendidik anak dengan nilai-nilai Islami di era digital. Kami membutuhkan relawan moderator dan tim teknis untuk membantu pelaksanaan webinar.',
                'start_at'          => now()->addDays(3)->setTime(19, 30),
                'end_at'            => now()->addDays(3)->setTime(21, 30),
                'region'            => 'Nasional',
                'location'          => 'YouTube Live & Zoom',
                'is_online'         => true,
                'registration_link' => 'https://forms.google.com/example-webinar-parenting',
                'is_active'         => true,
            ],
            [
                'title'             => 'Bersih-Bersih Pantai - Makassar',
                'description'       => 'Kegiatan bersih-bersih pantai bersama komunitas peduli lingkungan di Makassar. Terbuka untuk semua anggota WonCare dan masyarakat umum yang ingin berkontribusi menjaga kebersihan lingkungan.',
                'start_at'          => now()->subDays(10)->setTime(6, 0),
                'end_at'            => now()->subDays(10)->setTime(10, 0),
                'region'            => 'Sulawesi',
                'location'          => 'Pantai Losari, Makassar',
                'is_online'         => false,
                'registration_link' => null,
                'is_active'         => false,
            ],
            [
                'title'             => 'Pelatihan Pertolongan Pertama (P3K) - Medan',
                'description'       => 'Pelatihan pertolongan pertama pada kecelakaan (P3K) untuk relawan WonCare di Medan. Peserta akan mendapatkan sertifikat setelah menyelesaikan pelatihan.',
                'start_at'          => now()->subDays(20)->setTime(8, 0),
                'end_at'            => now()->subDays(20)->setTime(17, 0),
                'region'            => 'Sumatera',
                'location'          => 'Gedung PMI Kota Medan',
                'is_online'         => false,
                'registration_link' => null,
                'is_active'         => false,
            ],
            [
                'title'             => 'Kelas Bahasa Inggris Gratis - Online',
                'description'       => 'Program kelas bahasa Inggris gratis untuk anggota WonCare yang ingin meningkatkan kemampuan berbahasa Inggris mereka. Kelas diadakan setiap Sabtu selama 2 bulan.',
                'start_at'          => now()->addDays(60)->setTime(10, 0),
                'end_at'            => now()->addDays(60)->setTime(12, 0),
                'region'            => 'Nasional',
                'location'          => 'Google Meet',
                'is_online'         => true,
                'registration_link' => 'https://forms.google.com/example-english-class',
                'is_active'         => true,
            ],
        ];

        foreach ($events as $event) {
            VolunteerEvent::create($event);
        }
    }
}
