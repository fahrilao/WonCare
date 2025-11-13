<?php

return [
    // Page titles
    'donation_reports' => 'Laporan Donasi',
    'manage_donation_reports' => 'Kelola Laporan Donasi',
    'create_donation_report' => 'Buat Laporan Donasi',
    'edit_donation_report' => 'Edit Laporan Donasi',
    'view_donation_report' => 'Lihat Laporan Donasi',
    'donation_report_details' => 'Detail Laporan Donasi',

    // Form fields
    'campaign' => 'Kampanye',
    'select_campaign' => 'Pilih Kampanye',
    'institution_name' => 'Nama Lembaga',
    'contact_person' => 'Narahubung',
    'contact_email' => 'Email Kontak',
    'contact_phone' => 'Telepon Kontak',
    'distributed_amount' => 'Jumlah Disalurkan',
    'distribution_date' => 'Tanggal Penyaluran',
    'description' => 'Deskripsi',
    'beneficiaries' => 'Penerima Manfaat',
    'status' => 'Status',
    'evidence_file' => 'File Bukti',
    'current_evidence_file' => 'File Bukti Saat Ini',
    'replace_evidence_file' => 'Ganti File Bukti',
    'notes' => 'Catatan',
    'created_by' => 'Dibuat Oleh',
    'verified_by' => 'Diverifikasi Oleh',
    'verified_at' => 'Diverifikasi Pada',
    'report_id' => 'ID Laporan',

    // Help texts
    'institution_name_help' => 'Nama lembaga yang menyalurkan donasi',
    'distributed_amount_help' => 'Jumlah uang yang disalurkan kepada penerima manfaat',
    'distribution_date_help' => 'Tanggal ketika penyaluran dilakukan (tidak boleh tanggal masa depan)',
    'description_help' => 'Deskripsi detail tentang kegiatan penyaluran',
    'beneficiaries_help' => 'Informasi tentang siapa yang menerima donasi',
    'evidence_file_help' => 'Unggah dokumen pendukung (PDF, DOC, DOCX, JPG, PNG - Maks 5MB)',
    'notes_help' => 'Catatan atau komentar tambahan tentang laporan ini',

    // Actions
    'add_new_report' => 'Tambah Laporan Baru',
    'create_report' => 'Buat Laporan',
    'update_report' => 'Perbarui Laporan',
    'verify' => 'Verifikasi',
    'reject' => 'Tolak',
    'verified' => 'Terverifikasi',
    'rejected' => 'Ditolak',

    // Status messages
    'created_successfully' => 'Laporan donasi berhasil dibuat',
    'updated_successfully' => 'Laporan donasi berhasil diperbarui',
    'deleted_successfully' => 'Laporan donasi berhasil dihapus',
    'verified_successfully' => 'Laporan donasi berhasil diverifikasi',
    'rejected_successfully' => 'Laporan donasi berhasil ditolak',

    // Confirmations
    'confirm_delete_text' => 'Apakah Anda yakin ingin menghapus laporan donasi ini',
    'confirm_verify' => 'Verifikasi Laporan',
    'confirm_verify_text' => 'Apakah Anda yakin ingin memverifikasi laporan donasi ini?',
    'confirm_reject' => 'Tolak Laporan',
    'confirm_reject_text' => 'Apakah Anda yakin ingin menolak laporan donasi ini?',
    'rejection_notes' => 'Catatan Penolakan',
    'rejection_notes_placeholder' => 'Silakan berikan alasan penolakan...',
    'rejection_notes_required' => 'Catatan penolakan diperlukan',

    // Error messages
    'cannot_edit_verified' => 'Tidak dapat mengedit laporan yang sudah diverifikasi atau ditolak',
    'cannot_verify' => 'Tidak dapat memverifikasi laporan ini',
    'cannot_reject' => 'Tidak dapat menolak laporan ini',

    // Validation messages
    'campaign_required' => 'Kampanye wajib dipilih',
    'campaign_exists' => 'Kampanye yang dipilih tidak ada',
    'institution_name_required' => 'Nama lembaga wajib diisi',
    'institution_name_max' => 'Nama lembaga tidak boleh lebih dari 255 karakter',
    'contact_email_email' => 'Email kontak harus berupa alamat email yang valid',
    'distributed_amount_required' => 'Jumlah disalurkan wajib diisi',
    'distributed_amount_numeric' => 'Jumlah disalurkan harus berupa angka',
    'distributed_amount_min' => 'Jumlah disalurkan minimal 0',
    'distributed_amount_max' => 'Jumlah disalurkan terlalu besar',
    'distribution_date_required' => 'Tanggal penyaluran wajib diisi',
    'distribution_date_date' => 'Tanggal penyaluran harus berupa tanggal yang valid',
    'distribution_date_before_or_equal' => 'Tanggal penyaluran tidak boleh di masa depan',
    'evidence_file_file' => 'File bukti harus berupa file yang valid',
    'evidence_file_mimes' => 'File bukti harus berformat PDF, DOC, DOCX, JPG, JPEG, atau PNG',
    'evidence_file_max' => 'File bukti tidak boleh lebih dari 5MB',

    // Information sections
    'campaign_information' => 'Informasi Kampanye',
    'institution_information' => 'Informasi Lembaga',
    'distribution_information' => 'Informasi Penyaluran',
    'verification_information' => 'Informasi Verifikasi',

    // File handling
    'click_to_view' => 'Klik untuk melihat file',
    'click_to_download' => 'Klik untuk mengunduh file',

    // Campaign show view
    'no_reports' => 'Belum Ada Laporan',
    'no_reports_description' => 'Belum ada laporan donasi yang disubmit untuk kampanye ini.',
    'add_first_report' => 'Tambah Laporan Pertama',

    'not_found' => 'Laporan Tidak Ditemukan',

    // Image management
    'images' => 'Gambar',
    'report_details' => 'Detail Laporan',
    'details_tab_description' => 'Lihat informasi detail tentang laporan donasi ini.',
    'current_images' => 'Gambar Saat Ini',
    'no_images' => 'Tidak Ada Gambar',
    'add_new_images' => 'Tambah Gambar Baru',
    'select_images' => 'Pilih Gambar',
    'images_help' => 'Unggah gambar (JPG, PNG, GIF - Maksimal 5MB per gambar, hingga 10 gambar)',
    'upload_images' => 'Unggah Gambar',
    'primary_image' => 'Utama',
    'set_as_primary' => 'Jadikan Utama',
    'no_alt_text' => 'Tidak ada deskripsi',
    'images_uploaded_successfully' => 'Gambar berhasil diunggah',
    'image_deleted_successfully' => 'Gambar berhasil dihapus',
    'primary_image_set_successfully' => 'Gambar utama berhasil ditetapkan',
    'confirm_delete_image' => 'Apakah Anda yakin ingin menghapus gambar ini?',
];
