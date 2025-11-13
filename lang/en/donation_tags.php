<?php

return [
    // General
    'donation_tags' => 'Donation Tags',
    'donation_tag' => 'Donation Tag',
    'manage_donation_tags' => 'Manage Donation Tags',
    
    // Actions
    'create_donation_tag' => 'Create Donation Tag',
    'edit_donation_tag' => 'Edit Donation Tag',
    'view_donation_tag' => 'View Donation Tag',
    'delete_donation_tag' => 'Delete Donation Tag',
    'add_new_tag' => 'Add New Tag',
    
    // Fields
    'name' => 'Name',
    'slug' => 'Slug',
    'description' => 'Description',
    'color' => 'Color',
    'icon' => 'Icon',
    'status' => 'Status',
    'sort_order' => 'Sort Order',
    'created_by' => 'Created By',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
    
    // Placeholders
    'enter_tag_name' => 'Enter tag name',
    'enter_description' => 'Enter description (optional)',
    'choose_color' => 'Choose color',
    'select_icon' => 'Select icon (optional)',
    'enter_sort_order' => 'Enter sort order',
    
    // Help text
    'name_help' => 'The display name for this donation tag',
    'slug_help' => 'URL-friendly version of the name (auto-generated if empty)',
    'description_help' => 'Optional description for this tag',
    'color_help' => 'Color used to display this tag (hex format)',
    'icon_help' => 'Tabler icon class (e.g., ti-heart, ti-star)',
    'sort_order_help' => 'Lower numbers appear first in lists',
    
    // Status
    'active' => 'Active',
    'inactive' => 'Inactive',
    'is_active' => 'Is Active',
    
    // Messages
    'created_successfully' => 'Donation tag created successfully',
    'updated_successfully' => 'Donation tag updated successfully',
    'deleted_successfully' => 'Donation tag deleted successfully',
    'no_tags_found' => 'No donation tags found',
    
    // Confirmations
    'confirm_delete' => 'Are you sure you want to delete this donation tag?',
    'delete_warning' => 'This action cannot be undone.',
    
    // Table headers
    'tag_name' => 'Tag Name',
    'icon_preview' => 'Icon',
    'creator' => 'Creator',
    'actions' => 'Actions',
    
    // Validation
    'name_required' => 'Tag name is required',
    'name_max' => 'Tag name cannot exceed 255 characters',
    'slug_unique' => 'This slug is already taken',
    'color_format' => 'Color must be in hex format (e.g., #3b82f6)',
    'sort_order_min' => 'Sort order must be at least 0',
];
