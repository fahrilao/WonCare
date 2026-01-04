<?php

return [
  'title' => 'Events & Activities',
  'subtitle' => 'Event calendar & activity management',
  'create_title' => 'Create Event',
  'edit_title' => 'Edit Event',
  'detail_title' => 'Event Details',
  'rsvp_title' => 'Event Attendees (RSVP)',

  'fields' => [
    'title' => 'Event Title',
    'description' => 'Description',
    'type' => 'Event Type',
    'location' => 'Location',
    'meeting_link' => 'Meeting Link (Zoom/Online)',
    'start_datetime' => 'Start Date & Time',
    'end_datetime' => 'End Date & Time',
    'max_participants' => 'Max Participants',
    'status' => 'Status',
    'banner_image' => 'Banner Image',
    'require_rsvp' => 'Require RSVP',
    'send_reminder' => 'Send Reminder',
    'reminder_hours_before' => 'Reminder Hours Before Event',
    'notes' => 'Notes',
    'participants' => 'Participants',
    'date_range' => 'Date & Time',
  ],

  'types' => [
    'offline' => 'Offline (Kopdar Berdaya & Berdampak)',
    'online' => 'Online (Zoom Meeting)',
  ],

  'statuses' => [
    'draft' => 'Draft',
    'published' => 'Published',
    'cancelled' => 'Cancelled',
    'completed' => 'Completed',
  ],

  'rsvp' => [
    'name' => 'Name',
    'email' => 'Email',
    'phone' => 'Phone',
    'status' => 'Status',
    'notes' => 'Notes',
    'registered_at' => 'Registered At',
    'attended_at' => 'Attended At',
    'reminder_sent' => 'Reminder Sent',
    'mark_attended' => 'Mark as Attended',
    'statuses' => [
      'pending' => 'Pending',
      'confirmed' => 'Confirmed',
      'cancelled' => 'Cancelled',
      'attended' => 'Attended',
    ],
  ],

  'documentation' => [
    'title' => 'Event Documentation',
    'upload' => 'Upload Photo/Video',
    'type' => 'Type',
    'file' => 'File',
    'photo' => 'Photo',
    'video' => 'Video',
    'description' => 'Description',
  ],

  'reminders' => [
    'send_all' => 'Send Reminders to All',
    'send_success' => 'Reminders sent successfully to :count attendees',
    'email_sent' => 'Email reminder sent',
    'whatsapp_sent' => 'WhatsApp reminder sent',
  ],

  'info' => [
    'upcoming' => 'Upcoming',
    'ongoing' => 'Ongoing',
    'past' => 'Past',
    'full' => 'Full',
    'available_slots' => ':count slots available',
    'unlimited_slots' => 'Unlimited slots',
  ],

  'created_successfully' => 'Event created successfully.',
  'updated_successfully' => 'Event updated successfully.',
  'deleted_successfully' => 'Event deleted successfully.',
  'delete_title' => 'Delete Event',
  'rsvp_updated_successfully' => 'RSVP status updated successfully.',
  'reminders_sent_successfully' => 'Reminders sent to :count attendees.',
  'documentation_uploaded_successfully' => 'Documentation uploaded successfully.',
  'documentation_deleted_successfully' => 'Documentation deleted successfully.',
];
