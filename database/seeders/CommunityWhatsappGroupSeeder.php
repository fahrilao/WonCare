<?php

namespace Database\Seeders;

use App\Models\CommunityWhatsappGroup;
use Illuminate\Database\Seeder;

class CommunityWhatsappGroupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            [
                'region'        => 'DKI Jakarta',
                'name'          => 'WonCare Jakarta Pusat & Utara',
                'whatsapp_link' => 'https://chat.whatsapp.com/example-jakarta-pusat',
                'description'   => 'Grup untuk anggota WonCare di wilayah Jakarta Pusat dan Jakarta Utara. Mari saling berbagi dan mendukung satu sama lain!',
                'is_active'     => true,
                'sort_order'    => 1,
            ],
            [
                'region'        => 'DKI Jakarta',
                'name'          => 'WonCare Jakarta Selatan & Barat',
                'whatsapp_link' => 'https://chat.whatsapp.com/example-jakarta-selatan',
                'description'   => 'Grup untuk anggota WonCare di wilayah Jakarta Selatan dan Jakarta Barat. Aktif berbagi info kegiatan lokal!',
                'is_active'     => true,
                'sort_order'    => 2,
            ],
            [
                'region'        => 'DKI Jakarta',
                'name'          => 'WonCare Jakarta Timur',
                'whatsapp_link' => 'https://chat.whatsapp.com/example-jakarta-timur',
                'description'   => 'Grup untuk anggota WonCare di wilayah Jakarta Timur dan sekitarnya.',
                'is_active'     => true,
                'sort_order'    => 3,
            ],
            [
                'region'        => 'Jawa Barat',
                'name'          => 'WonCare Bandung Raya',
                'whatsapp_link' => 'https://chat.whatsapp.com/example-bandung',
                'description'   => 'Grup untuk anggota WonCare di Bandung dan sekitarnya (Cimahi, Bandung Barat, Sumedang). Hayu urang silaturahmi!',
                'is_active'     => true,
                'sort_order'    => 4,
            ],
            [
                'region'        => 'Jawa Barat',
                'name'          => 'WonCare Bekasi & Depok',
                'whatsapp_link' => 'https://chat.whatsapp.com/example-bekasi-depok',
                'description'   => 'Grup untuk anggota WonCare di Bekasi, Depok, dan Bogor. Aktif berbagi kegiatan sosial di wilayah kita!',
                'is_active'     => true,
                'sort_order'    => 5,
            ],
            [
                'region'        => 'Jawa Tengah',
                'name'          => 'WonCare Semarang & Sekitarnya',
                'whatsapp_link' => 'https://chat.whatsapp.com/example-semarang',
                'description'   => 'Grup untuk anggota WonCare di Semarang, Demak, Kendal, dan sekitarnya.',
                'is_active'     => true,
                'sort_order'    => 6,
            ],
            [
                'region'        => 'Jawa Tengah',
                'name'          => 'WonCare Solo & Yogyakarta',
                'whatsapp_link' => 'https://chat.whatsapp.com/example-solo-jogja',
                'description'   => 'Grup untuk anggota WonCare di Solo, Yogyakarta, dan sekitarnya. Ayo bareng-bareng berbuat kebaikan!',
                'is_active'     => true,
                'sort_order'    => 7,
            ],
            [
                'region'        => 'Jawa Timur',
                'name'          => 'WonCare Surabaya Raya',
                'whatsapp_link' => 'https://chat.whatsapp.com/example-surabaya',
                'description'   => 'Grup untuk anggota WonCare di Surabaya, Sidoarjo, Gresik, dan Mojokerto.',
                'is_active'     => true,
                'sort_order'    => 8,
            ],
            [
                'region'        => 'Jawa Timur',
                'name'          => 'WonCare Malang & Batu',
                'whatsapp_link' => 'https://chat.whatsapp.com/example-malang',
                'description'   => 'Grup untuk anggota WonCare di Malang Raya dan Kota Batu. Mari bersama membangun komunitas yang kuat!',
                'is_active'     => true,
                'sort_order'    => 9,
            ],
            [
                'region'        => 'Sumatera',
                'name'          => 'WonCare Medan & Sumatera Utara',
                'whatsapp_link' => 'https://chat.whatsapp.com/example-medan',
                'description'   => 'Grup untuk anggota WonCare di Medan dan seluruh Sumatera Utara.',
                'is_active'     => true,
                'sort_order'    => 10,
            ],
            [
                'region'        => 'Sumatera',
                'name'          => 'WonCare Palembang & Sumatera Selatan',
                'whatsapp_link' => 'https://chat.whatsapp.com/example-palembang',
                'description'   => 'Grup untuk anggota WonCare di Palembang dan Sumatera Selatan.',
                'is_active'     => true,
                'sort_order'    => 11,
            ],
            [
                'region'        => 'Kalimantan',
                'name'          => 'WonCare Kalimantan',
                'whatsapp_link' => 'https://chat.whatsapp.com/example-kalimantan',
                'description'   => 'Grup untuk anggota WonCare di seluruh wilayah Kalimantan (Barat, Tengah, Selatan, Timur, Utara).',
                'is_active'     => true,
                'sort_order'    => 12,
            ],
            [
                'region'        => 'Sulawesi',
                'name'          => 'WonCare Makassar & Sulawesi',
                'whatsapp_link' => 'https://chat.whatsapp.com/example-makassar',
                'description'   => 'Grup untuk anggota WonCare di Makassar dan seluruh wilayah Sulawesi.',
                'is_active'     => true,
                'sort_order'    => 13,
            ],
            [
                'region'        => 'Indonesia Timur',
                'name'          => 'WonCare Indonesia Timur',
                'whatsapp_link' => 'https://chat.whatsapp.com/example-indonesia-timur',
                'description'   => 'Grup untuk anggota WonCare di Bali, NTB, NTT, Maluku, dan Papua.',
                'is_active'     => true,
                'sort_order'    => 14,
            ],
            [
                'region'        => 'Luar Negeri',
                'name'          => 'WonCare Diaspora Indonesia',
                'whatsapp_link' => 'https://chat.whatsapp.com/example-diaspora',
                'description'   => 'Grup untuk anggota WonCare yang berada di luar negeri. Tetap terhubung dan berkontribusi dari mana saja!',
                'is_active'     => false,
                'sort_order'    => 15,
            ],
        ];

        foreach ($groups as $group) {
            CommunityWhatsappGroup::create($group);
        }
    }
}
