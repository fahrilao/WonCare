<?php

return [
  'title' => 'Event & Kegiatan',
  'subtitle' => 'Kalender kegiatan & manajemen event',
  'create_title' => 'Buat Event',
  'edit_title' => 'Ubah Event',
  'detail_title' => 'Detail Event',
  'rsvp_title' => 'Peserta Event (RSVP)',

  'fields' => [
    'title' => 'Judul Event',
    'description' => 'Deskripsi',
    'type' => 'Tipe Event',
    'location' => 'Lokasi',
    'meeting_link' => 'Link Meeting (Zoom/Online)',
    'start_datetime' => 'Tanggal & Waktu Mulai',
    'end_datetime' => 'Tanggal & Waktu Selesai',
    'max_participants' => 'Maksimal Peserta',
    'status' => 'Status',
    'banner_image' => 'Gambar Banner',
    'require_rsvp' => 'Butuh RSVP',
    'send_reminder' => 'Kirim Pengingat',
    'reminder_hours_before' => 'Jam Pengingat Sebelum Event',
    'notes' => 'Catatan',
    'participants' => 'Peserta',
    'date_range' => 'Tanggal & Waktu',
  ],

  'types' => [
    'offline' => 'Offline (Kopdar Berdaya & Berdampak)',
    'online' => 'Online (Zoom Meeting)',
  ],

  'statuses' => [
    'draft' => 'Draft',
    'published' => 'Dipublikasi',
    'cancelled' => 'Dibatalkan',
    'completed' => 'Selesai',
  ],

  'rsvp' => [
    'name' => 'Nama',
    'email' => 'Email',
    'phone' => 'Telepon',
    'status' => 'Status',
    'notes' => 'Catatan',
    'registered_at' => 'Terdaftar Pada',
    'attended_at' => 'Hadir Pada',
    'reminder_sent' => 'Pengingat Terkirim',
    'mark_attended' => 'Tandai Hadir',
    'statuses' => [
      'pending' => 'Menunggu',
      'confirmed' => 'Dikonfirmasi',
      'cancelled' => 'Dibatalkan',
      'attended' => 'Hadir',
    ],
  ],

  'documentation' => [
    'title' => 'Dokumentasi Event',
    'upload' => 'Upload Foto/Video',
    'type' => 'Tipe',
    'file' => 'File',
    'photo' => 'Foto',
    'video' => 'Video',
    'description' => 'Deskripsi',
  ],

  'reminders' => [
    'send_all' => 'Kirim Pengingat ke Semua',
    'send_success' => 'Pengingat berhasil dikirim ke :count peserta',
    'email_sent' => 'Pengingat email terkirim',
    'whatsapp_sent' => 'Pengingat WhatsApp terkirim',
  ],

  'info' => [
    'upcoming' => 'Akan Datang',
    'ongoing' => 'Sedang Berlangsung',
    'past' => 'Sudah Lewat',
    'full' => 'Penuh',
    'available_slots' => ':count slot tersedia',
    'unlimited_slots' => 'Slot tidak terbatas',
  ],

  'created_successfully' => 'Event berhasil dibuat.',
  'updated_successfully' => 'Event berhasil diperbarui.',
  'deleted_successfully' => 'Event berhasil dihapus.',
  'delete_title' => 'Hapus Event',
  'rsvp_updated_successfully' => 'Status RSVP berhasil diperbarui.',
  'reminders_sent_successfully' => 'Pengingat terkirim ke :count peserta.',
  'documentation_uploaded_successfully' => 'Dokumentasi berhasil diupload.',
  'documentation_deleted_successfully' => 'Dokumentasi berhasil dihapus.',
];
