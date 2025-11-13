<?php

return [
    // General
    'donation_tags' => 'Tag Donasi',
    'donation_tag' => 'Tag Donasi',
    'manage_donation_tags' => 'Kelola Tag Donasi',
    
    // Actions
    'create_donation_tag' => 'Buat Tag Donasi',
    'edit_donation_tag' => 'Edit Tag Donasi',
    'view_donation_tag' => 'Lihat Tag Donasi',
    'delete_donation_tag' => 'Hapus Tag Donasi',
    'add_new_tag' => 'Tambah Tag Baru',
    
    // Fields
    'name' => 'Nama',
    'slug' => 'Slug',
    'description' => 'Deskripsi',
    'color' => 'Warna',
    'icon' => 'Ikon',
    'status' => 'Status',
    'sort_order' => 'Urutan',
    'created_by' => 'Dibuat Oleh',
    'created_at' => 'Dibuat Pada',
    'updated_at' => 'Diperbarui Pada',
    
    // Placeholders
    'enter_tag_name' => 'Masukkan nama tag',
    'enter_description' => 'Masukkan deskripsi (opsional)',
    'choose_color' => 'Pilih warna',
    'select_icon' => 'Pilih ikon (opsional)',
    'enter_sort_order' => 'Masukkan urutan',
    
    // Help text
    'name_help' => 'Nama tampilan untuk tag donasi ini',
    'slug_help' => 'Versi URL-friendly dari nama (otomatis dibuat jika kosong)',
    'description_help' => 'Deskripsi opsional untuk tag ini',
    'color_help' => 'Warna yang digunakan untuk menampilkan tag ini (format hex)',
    'icon_help' => 'Kelas ikon Tabler (contoh: ti-heart, ti-star)',
    'sort_order_help' => 'Angka lebih kecil muncul pertama dalam daftar',
    
    // Status
    'active' => 'Aktif',
    'inactive' => 'Tidak Aktif',
    'is_active' => 'Aktif',
    
    // Messages
    'created_successfully' => 'Tag donasi berhasil dibuat',
    'updated_successfully' => 'Tag donasi berhasil diperbarui',
    'deleted_successfully' => 'Tag donasi berhasil dihapus',
    'no_tags_found' => 'Tidak ada tag donasi ditemukan',
    
    // Confirmations
    'confirm_delete' => 'Apakah Anda yakin ingin menghapus tag donasi ini?',
    'delete_warning' => 'Tindakan ini tidak dapat dibatalkan.',
    
    // Table headers
    'tag_name' => 'Nama Tag',
    'icon_preview' => 'Ikon',
    'creator' => 'Pembuat',
    'actions' => 'Aksi',
    
    // Validation
    'name_required' => 'Nama tag wajib diisi',
    'name_max' => 'Nama tag tidak boleh lebih dari 255 karakter',
    'slug_unique' => 'Slug ini sudah digunakan',
    'color_format' => 'Warna harus dalam format hex (contoh: #3b82f6)',
    'sort_order_min' => 'Urutan harus minimal 0',
];
