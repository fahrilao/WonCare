<?php

return [
    // General
    'payment_gateways' => 'Gateway Pembayaran',
    'payment_gateway' => 'Gateway Pembayaran',
    'create_title' => 'Buat Gateway Pembayaran',
    'edit_title' => 'Edit Gateway Pembayaran',
    'view_title' => 'Detail Gateway Pembayaran',
    'list_title' => 'Gateway Pembayaran',

    // Fields
    'name' => 'Nama Gateway',
    'provider' => 'Penyedia',
    'api_key' => 'API Key',
    'secret_key' => 'Secret Key',
    'webhook_secret' => 'Webhook Secret',
    'additional_config' => 'Konfigurasi Tambahan',
    'is_active' => 'Status',
    'is_sandbox' => 'Mode',
    'description' => 'Deskripsi',
    'creator' => 'Dibuat Oleh',

    // Provider options
    'provider_midtrans' => 'Midtrans',
    'provider_stripe' => 'Stripe',
    'provider_toss' => 'Toss Payments',

    // Status options
    'sandbox' => 'Sandbox',
    'production' => 'Produksi',
    'configured' => 'Terkonfigurasi',
    'not_configured' => 'Belum Dikonfigurasi',

    // Placeholders
    'name_placeholder' => 'Masukkan nama gateway...',
    'api_key_placeholder' => 'Masukkan API key...',
    'secret_key_placeholder' => 'Masukkan secret key...',
    'webhook_secret_placeholder' => 'Masukkan webhook secret...',
    'description_placeholder' => 'Masukkan deskripsi gateway...',

    // Help text
    'name_help' => 'Masukkan nama deskriptif untuk gateway pembayaran ini',
    'provider_help' => '-- Pilih Penyedia --',
    'api_key_help' => 'API key dari penyedia gateway pembayaran Anda',
    'secret_key_help' => 'Secret key dari penyedia gateway pembayaran Anda',
    'webhook_secret_help' => 'Webhook secret untuk komunikasi yang aman',
    'is_active_help' => 'Aktifkan atau nonaktifkan gateway pembayaran ini',
    'is_sandbox_help' => 'Gunakan mode sandbox untuk pengujian',
    'description_help' => 'Deskripsi opsional untuk konfigurasi gateway ini',
    'additional_config_help' => 'Konfigurasi tambahan dalam format JSON',

    // Validation messages
    'name_required' => 'Nama gateway wajib diisi',
    'name_max' => 'Nama gateway tidak boleh lebih dari 255 karakter',
    'provider_required' => 'Penyedia wajib diisi',
    'provider_invalid' => 'Penyedia yang dipilih tidak valid',
    'api_key_max' => 'API key tidak boleh lebih dari 1000 karakter',
    'secret_key_max' => 'Secret key tidak boleh lebih dari 1000 karakter',
    'webhook_secret_max' => 'Webhook secret tidak boleh lebih dari 1000 karakter',
    'additional_config_array' => 'Konfigurasi tambahan harus berupa JSON yang valid',
    'is_active_boolean' => 'Status harus berupa true atau false',
    'is_sandbox_boolean' => 'Mode harus berupa true atau false',
    'description_max' => 'Deskripsi tidak boleh lebih dari 1000 karakter',

    // Success messages
    'created_successfully' => 'Gateway pembayaran berhasil dibuat',
    'updated_successfully' => 'Gateway pembayaran berhasil diperbarui',
    'deleted_successfully' => 'Gateway pembayaran berhasil dihapus',

    // Info messages
    'not_set' => 'Belum Diatur',
    'connection_successful' => 'Tes koneksi berhasil',
    'connection_failed' => 'Tes koneksi gagal',

    // DataTable columns
    'dt_name' => 'Nama',
    'dt_provider' => 'Penyedia',
    'dt_status' => 'Status',
    'dt_mode' => 'Mode',
    'dt_configured' => 'Konfigurasi',
    'dt_creator' => 'Pembuat',
    'dt_created_at' => 'Dibuat',
    'dt_actions' => 'Aksi',

    // Security
    'masked_key' => 'Key dienkripsi dan disembunyikan untuk keamanan',
    'test_connection' => 'Tes Koneksi',
];