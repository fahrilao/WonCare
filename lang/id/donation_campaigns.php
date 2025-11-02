<?php

return [
    // General
    'donation_campaigns' => 'Kampanye Donasi',
    'donation_campaign' => 'Kampanye Donasi',
    'create_title' => 'Buat Kampanye Donasi',
    'edit_title' => 'Edit Kampanye Donasi',
    'view_title' => 'Detail Kampanye Donasi',
    'list_title' => 'Kampanye Donasi',

    // Fields
    'title' => 'Judul',
    'description' => 'Deskripsi',
    'goal_amount' => 'Target Dana',
    'collected_amount' => 'Dana Terkumpul',
    'remaining_amount' => 'Dana Tersisa',
    'start_date' => 'Tanggal Mulai',
    'end_date' => 'Tanggal Berakhir',
    'status' => 'Status',
    'image' => 'Gambar Kampanye',
    'creator' => 'Dibuat Oleh',
    'progress' => 'Progres',

    // Status options
    'status_draft' => 'Draft',
    'status_active' => 'Aktif',
    'status_completed' => 'Selesai',
    'status_cancelled' => 'Dibatalkan',

    // Placeholders
    'title_placeholder' => 'Masukkan judul kampanye...',
    'description_placeholder' => 'Masukkan deskripsi kampanye...',
    'goal_amount_placeholder' => '0.00',

    // Help text
    'title_help' => 'Masukkan judul kampanye yang jelas dan menarik',
    'description_help' => 'Jelaskan tujuan dan sasaran kampanye ini',
    'goal_amount_help' => 'Target dana yang ingin dikumpulkan untuk kampanye ini',
    'start_date_help' => 'Kapan kampanye mulai menerima donasi',
    'end_date_help' => 'Kapan kampanye berakhir (opsional)',
    'status_help' => '-- Pilih Satu --',
    'image_help' => 'Unggah gambar untuk kampanye (opsional)',

    // Validation messages
    'title_required' => 'Judul kampanye wajib diisi',
    'title_max' => 'Judul kampanye tidak boleh lebih dari 255 karakter',
    'goal_amount_required' => 'Target dana wajib diisi',
    'goal_amount_numeric' => 'Target dana harus berupa angka',
    'goal_amount_min' => 'Target dana minimal 0',
    'goal_amount_max' => 'Target dana terlalu besar',
    'start_date_required' => 'Tanggal mulai wajib diisi',
    'start_date_date' => 'Tanggal mulai harus berupa tanggal yang valid',
    'start_date_after_or_equal' => 'Tanggal mulai harus hari ini atau setelahnya',
    'end_date_date' => 'Tanggal berakhir harus berupa tanggal yang valid',
    'end_date_after' => 'Tanggal berakhir harus setelah tanggal mulai',
    'status_required' => 'Status wajib diisi',
    'status_in' => 'Status yang dipilih tidak valid',
    'image_image' => 'File harus berupa gambar',
    'image_mimes' => 'Gambar harus berupa file dengan tipe: jpeg, png, jpg, gif',
    'image_max' => 'Gambar tidak boleh lebih dari 2MB',

    // Success messages
    'created_successfully' => 'Kampanye donasi berhasil dibuat',
    'updated_successfully' => 'Kampanye donasi berhasil diperbarui',
    'deleted_successfully' => 'Kampanye donasi berhasil dihapus',

    // Info messages
    'current_image' => 'Gambar saat ini',
    'unlimited_duration' => 'Tidak ada tanggal berakhir',

    // DataTable columns
    'dt_title' => 'Judul',
    'dt_goal_amount' => 'Target',
    'dt_collected_amount' => 'Terkumpul',
    'dt_progress' => 'Progres',
    'dt_status' => 'Status',
    'dt_creator' => 'Pembuat',
    'dt_created_at' => 'Dibuat',
    'dt_actions' => 'Aksi',
];
