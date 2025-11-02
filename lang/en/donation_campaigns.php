<?php

return [
    // General
    'donation_campaigns' => 'Donation Campaigns',
    'donation_campaign' => 'Donation Campaign',
    'create_title' => 'Create Donation Campaign',
    'edit_title' => 'Edit Donation Campaign',
    'view_title' => 'Donation Campaign Details',
    'list_title' => 'Donation Campaigns',

    // Fields
    'title' => 'Title',
    'description' => 'Description',
    'goal_amount' => 'Goal Amount',
    'collected_amount' => 'Collected Amount',
    'remaining_amount' => 'Remaining Amount',
    'start_date' => 'Start Date',
    'end_date' => 'End Date',
    'status' => 'Status',
    'image' => 'Campaign Image',
    'creator' => 'Created By',
    'progress' => 'Progress',

    // Status options
    'status_draft' => 'Draft',
    'status_active' => 'Active',
    'status_completed' => 'Completed',
    'status_cancelled' => 'Cancelled',

    // Placeholders
    'title_placeholder' => 'Enter campaign title...',
    'description_placeholder' => 'Enter campaign description...',
    'goal_amount_placeholder' => '0.00',

    // Help text
    'title_help' => 'Enter a clear and compelling campaign title',
    'description_help' => 'Describe the purpose and goals of this campaign',
    'goal_amount_help' => 'Target amount to raise for this campaign',
    'start_date_help' => 'When the campaign should start accepting donations',
    'end_date_help' => 'When the campaign should end (optional)',
    'status_help' => '-- Choose One --',
    'image_help' => 'Upload an image for the campaign (optional)',

    // Validation messages
    'title_required' => 'Campaign title is required',
    'title_max' => 'Campaign title may not be greater than 255 characters',
    'goal_amount_required' => 'Goal amount is required',
    'goal_amount_numeric' => 'Goal amount must be a number',
    'goal_amount_min' => 'Goal amount must be at least 0',
    'goal_amount_max' => 'Goal amount is too large',
    'start_date_required' => 'Start date is required',
    'start_date_date' => 'Start date must be a valid date',
    'start_date_after_or_equal' => 'Start date must be today or later',
    'end_date_date' => 'End date must be a valid date',
    'end_date_after' => 'End date must be after start date',
    'status_required' => 'Status is required',
    'status_in' => 'Selected status is invalid',
    'image_image' => 'File must be an image',
    'image_mimes' => 'Image must be a file of type: jpeg, png, jpg, gif',
    'image_max' => 'Image may not be greater than 2MB',

    // Success messages
    'created_successfully' => 'Donation campaign created successfully',
    'updated_successfully' => 'Donation campaign updated successfully',
    'deleted_successfully' => 'Donation campaign deleted successfully',

    // Info messages
    'current_image' => 'Current image',
    'unlimited_duration' => 'No end date set',

    // DataTable columns
    'dt_title' => 'Title',
    'dt_goal_amount' => 'Goal',
    'dt_collected_amount' => 'Collected',
    'dt_progress' => 'Progress',
    'dt_status' => 'Status',
    'dt_creator' => 'Creator',
    'dt_created_at' => 'Created',
    'dt_actions' => 'Actions',
];
