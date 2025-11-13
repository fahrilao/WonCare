<?php

return [
  // Page titles
  'donation_reports' => 'Donation Reports',
  'manage_donation_reports' => 'Manage Donation Reports',
  'create_donation_report' => 'Create Donation Report',
  'edit_donation_report' => 'Edit Donation Report',
  'view_donation_report' => 'View Donation Report',
  'donation_report_details' => 'Donation Report Details',

  // Form fields
  'campaign' => 'Campaign',
  'select_campaign' => 'Select Campaign',
  'report_title' => 'Report',
  'institution_name' => 'Institution Name',
  'contact_person' => 'Contact Person',
  'contact_email' => 'Contact Email',
  'contact_phone' => 'Contact Phone',
  'distributed_amount' => 'Distributed Amount',
  'distribution_date' => 'Distribution Date',
  'description' => 'Description',
  'beneficiaries' => 'Beneficiaries',
  'status' => 'Status',
  'evidence_file' => 'Evidence File',
  'current_evidence_file' => 'Current Evidence File',
  'replace_evidence_file' => 'Replace Evidence File',
  'notes' => 'Notes',
  'created_by' => 'Created By',
  'verified_by' => 'Verified By',
  'verified_at' => 'Verified At',
  'report_id' => 'Report ID',

  // Help texts
  'institution_name_help' => 'Name of the institution that distributed the donations',
  'distributed_amount_help' => 'Amount of money distributed to beneficiaries',
  'distribution_date_help' => 'Date when the distribution took place (cannot be future date)',
  'description_help' => 'Detailed description of the distribution activity',
  'beneficiaries_help' => 'Information about who received the donations',
  'evidence_file_help' => 'Upload supporting documents (PDF, DOC, DOCX, JPG, PNG - Max 5MB)',
  'notes_help' => 'Additional notes or comments about this report',

  // Actions
  'add_new_report' => 'Add New Report',
  'create_report' => 'Create Report',
  'update_report' => 'Update Report',
  'verify' => 'Verify',
  'reject' => 'Reject',
  'verified' => 'Verified',
  'rejected' => 'Rejected',

  // Status messages
  'created_successfully' => 'Donation report created successfully',
  'updated_successfully' => 'Donation report updated successfully',
  'deleted_successfully' => 'Donation report deleted successfully',
  'verified_successfully' => 'Donation report verified successfully',
  'rejected_successfully' => 'Donation report rejected successfully',

  // Confirmations
  'confirm_delete_text' => 'Are you sure you want to delete this donation report',
  'confirm_verify' => 'Verify Report',
  'confirm_verify_text' => 'Are you sure you want to verify this donation report?',
  'confirm_reject' => 'Reject Report',
  'confirm_reject_text' => 'Are you sure you want to reject this donation report?',
  'rejection_notes' => 'Rejection Notes',
  'rejection_notes_placeholder' => 'Please provide reason for rejection...',
  'rejection_notes_required' => 'Rejection notes are required',

  // Error messages
  'cannot_edit_verified' => 'Cannot edit verified or rejected reports',
  'cannot_verify' => 'Cannot verify this report',
  'cannot_reject' => 'Cannot reject this report',

  // Validation messages
  'campaign_required' => 'Campaign is required',
  'campaign_exists' => 'Selected campaign does not exist',
  'institution_name_required' => 'Institution name is required',
  'institution_name_max' => 'Institution name cannot exceed 255 characters',
  'contact_email_email' => 'Contact email must be a valid email address',
  'distributed_amount_required' => 'Distributed amount is required',
  'distributed_amount_numeric' => 'Distributed amount must be a number',
  'distributed_amount_min' => 'Distributed amount must be at least 0',
  'distributed_amount_max' => 'Distributed amount is too large',
  'distribution_date_required' => 'Distribution date is required',
  'distribution_date_date' => 'Distribution date must be a valid date',
  'distribution_date_before_or_equal' => 'Distribution date cannot be in the future',
  'evidence_file_file' => 'Evidence file must be a valid file',
  'evidence_file_mimes' => 'Evidence file must be PDF, DOC, DOCX, JPG, JPEG, or PNG',
  'evidence_file_max' => 'Evidence file cannot exceed 5MB',

  // Information sections
  'campaign_information' => 'Campaign Information',
  'institution_information' => 'Institution Information',
  'distribution_information' => 'Distribution Information',
  'verification_information' => 'Verification Information',

  // File handling
  'click_to_view' => 'Click to view file',
  'click_to_download' => 'Click to download file',

  // Campaign show view
  'no_reports' => 'No Reports Yet',
  'no_reports_description' => 'No donation reports have been submitted for this campaign yet.',
  'add_first_report' => 'Add First Report',

  'not_found' => 'Reports Not Found',

  // Image management
  'images' => 'Images',
  'report_details' => 'Report Details',
  'details_tab_description' => 'View detailed information about this donation report.',
  'current_images' => 'Current Images',
  'no_images' => 'No Images',
  'add_new_images' => 'Add New Images',
  'select_images' => 'Select Images',
  'images_help' => 'Upload images (JPG, PNG, GIF - Max 5MB each, up to 10 images)',
  'upload_images' => 'Upload Images',
  'primary_image' => 'Primary',
  'set_as_primary' => 'Set as Primary',
  'no_alt_text' => 'No description',
  'images_uploaded_successfully' => 'Images uploaded successfully',
  'image_deleted_successfully' => 'Image deleted successfully',
  'primary_image_set_successfully' => 'Primary image set successfully',
  'confirm_delete_image' => 'Are you sure you want to delete this image?',
];
