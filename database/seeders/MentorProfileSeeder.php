<?php

namespace Database\Seeders;

use App\Models\MentorProfile;
use Illuminate\Database\Seeder;

class MentorProfileSeeder extends Seeder
{
    public function run(): void
    {
        $mentors = [
            [
                'name'       => 'Dr. Ahmad Fauzi, M.Psi.',
                'title'      => 'Psikolog Klinis & Konselor Keluarga',
                'bio'        => 'Dr. Ahmad Fauzi adalah psikolog klinis berpengalaman dengan lebih dari 15 tahun pengalaman dalam konseling keluarga dan kesehatan mental. Beliau merupakan lulusan Universitas Indonesia dan telah membantu ratusan keluarga menemukan keseimbangan dan kebahagiaan dalam kehidupan mereka.',
                'expertise'  => json_encode(['Kesehatan Mental', 'Konseling Keluarga', 'Manajemen Stres', 'Parenting']),
                'photo_path' => null,
                'is_active'  => true,
                'sort_order' => 1,
            ],
            [
                'name'       => 'Ir. Siti Rahayu, MBA.',
                'title'      => 'Konsultan Bisnis & Pengembangan UMKM',
                'bio'        => 'Ir. Siti Rahayu adalah konsultan bisnis berpengalaman yang telah membantu lebih dari 200 UMKM berkembang dan bertahan di tengah persaingan pasar. Dengan latar belakang teknik dan bisnis, beliau memberikan pendekatan yang praktis dan terukur dalam pengembangan usaha.',
                'expertise'  => json_encode(['Pengembangan UMKM', 'Strategi Bisnis', 'Pemasaran Digital', 'Manajemen Keuangan Usaha']),
                'photo_path' => null,
                'is_active'  => true,
                'sort_order' => 2,
            ],
            [
                'name'       => 'Ustadz Hasan Al-Banna, Lc.',
                'title'      => 'Konsultan Keuangan Syariah & Motivator',
                'bio'        => 'Ustadz Hasan Al-Banna adalah lulusan Universitas Al-Azhar Kairo yang kini aktif sebagai konsultan keuangan syariah dan motivator Islam. Beliau dikenal dengan pendekatannya yang hangat dan mudah dipahami dalam menjelaskan konsep keuangan Islam kepada masyarakat awam.',
                'expertise'  => json_encode(['Keuangan Syariah', 'Zakat & Wakaf', 'Perencanaan Keuangan Islam', 'Motivasi Islami']),
                'photo_path' => null,
                'is_active'  => true,
                'sort_order' => 3,
            ],
            [
                'name'       => 'dr. Dewi Kusuma Wardani, Sp.A.',
                'title'      => 'Dokter Spesialis Anak & Konsultan Tumbuh Kembang',
                'bio'        => 'dr. Dewi adalah dokter spesialis anak yang berdedikasi tinggi dalam membantu orang tua memahami tumbuh kembang anak. Beliau aktif memberikan edukasi kesehatan anak melalui berbagai platform dan telah menulis beberapa buku tentang parenting berbasis kesehatan.',
                'expertise'  => json_encode(['Kesehatan Anak', 'Tumbuh Kembang', 'Nutrisi Anak', 'Imunisasi']),
                'photo_path' => null,
                'is_active'  => true,
                'sort_order' => 4,
            ],
            [
                'name'       => 'Bapak Rizky Pratama, S.T., M.T.',
                'title'      => 'Praktisi Teknologi & Mentor Karir Digital',
                'bio'        => 'Rizky Pratama adalah praktisi teknologi dengan pengalaman 10 tahun di industri startup dan teknologi. Beliau pernah bekerja di beberapa perusahaan teknologi terkemuka dan kini berfokus pada mentoring generasi muda untuk berkarir di bidang teknologi.',
                'expertise'  => json_encode(['Pengembangan Karir IT', 'Startup', 'Product Management', 'Data Science']),
                'photo_path' => null,
                'is_active'  => true,
                'sort_order' => 5,
            ],
            [
                'name'       => 'Ibu Fatimah Azzahra, S.Pd., M.Ed.',
                'title'      => 'Pendidik & Konsultan Pendidikan Anak',
                'bio'        => 'Ibu Fatimah adalah pendidik berpengalaman dengan spesialisasi di bidang pendidikan anak usia dini dan pendidikan inklusif. Beliau telah mendedikasikan lebih dari 20 tahun hidupnya untuk dunia pendidikan dan aktif membantu orang tua dalam mendampingi proses belajar anak.',
                'expertise'  => json_encode(['Pendidikan Anak', 'PAUD', 'Pendidikan Inklusif', 'Metode Belajar Efektif']),
                'photo_path' => null,
                'is_active'  => true,
                'sort_order' => 6,
            ],
            [
                'name'       => 'Dr. Bambang Setiawan, S.H., M.H.',
                'title'      => 'Advokat & Konsultan Hukum Keluarga',
                'bio'        => 'Dr. Bambang adalah advokat senior yang berspesialisasi dalam hukum keluarga dan hukum sosial. Beliau aktif memberikan bantuan hukum gratis kepada masyarakat kurang mampu dan sering menjadi narasumber di berbagai seminar hukum.',
                'expertise'  => json_encode(['Hukum Keluarga', 'Bantuan Hukum', 'Hak Perempuan', 'Perlindungan Anak']),
                'photo_path' => null,
                'is_active'  => true,
                'sort_order' => 7,
            ],
            [
                'name'       => 'Ibu Nurul Hidayah, S.Gz., M.Kes.',
                'title'      => 'Ahli Gizi & Konsultan Nutrisi Keluarga',
                'bio'        => 'Ibu Nurul adalah ahli gizi bersertifikat yang berfokus pada nutrisi keluarga dan pencegahan stunting. Beliau aktif bekerja sama dengan pemerintah dan NGO dalam program peningkatan gizi masyarakat di daerah terpencil.',
                'expertise'  => json_encode(['Gizi Keluarga', 'Pencegahan Stunting', 'Nutrisi Ibu Hamil', 'MPASI']),
                'photo_path' => null,
                'is_active'  => false,
                'sort_order' => 8,
            ],
        ];

        foreach ($mentors as $mentor) {
            MentorProfile::create($mentor);
        }
    }
}
