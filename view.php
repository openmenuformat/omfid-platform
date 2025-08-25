<?php
// OMFID view.php - Template Router
// Loads business data and renders with selected template

// Get business ID from URL
$omf_id = $_GET['id'] ?? 'unknown';

// Validate business exists
$validBusinesses = ['tonys-pizza', 'marias-spa', 'johns-coffee'];
if (!in_array($omf_id, $validBusinesses)) {
    include 'not-found.php';
    exit;
}

// Business data (in future: fetch from Supabase)
// Add this to your $businesses array in view.php
$businesses = [
    'tonys-pizza' => [
        'name' => "Tony's Pizza Bangkok",
        'description' => 'Authentic Italian pizza and pasta in the heart of Bangkok',
        'address' => 'Sukhumvit Soi 24, Bangkok 10110',
        'type' => '🍕 Italian Restaurant',
        'template' => 'default1',
        'color_primary' => '#667eea',
        'color_secondary' => '#764ba2',
        // ADD THESE DARK MODE COLORS
        'color_primary_dark' => '#6366f1',
        'color_secondary_dark' => '#8b5cf6',
        'hours' => 'Open until 11 PM',
        'phone' => '+6621234567',
        'menu_section' => [
            // ... your existing menu data
        ]
    ],
    'marias-spa' => [
        'name' => "Maria's Thai Massage & Spa",
        'description' => 'Traditional Thai massage and relaxation spa',
        'address' => 'Silom Road, Bangkok 10500',
        'type' => '💆 Spa & Wellness',
        'template' => 'default1',
        'color_primary' => '#48bb78',
        'color_secondary' => '#38a169',
        // ADD THESE DARK MODE COLORS
        'color_primary_dark' => '#48bb78',
        'color_secondary_dark' => '#2f855a',
        'hours' => 'Open until 10 PM',
        'phone' => '+6621234568',
        'menu_section' => [
            // ... your existing menu data
        ]
    ],
    'johns-coffee' => [
        'name' => "John's Coffee House",
        'description' => 'Specialty coffee and fresh pastries',
        'address' => 'Thonglor Soi 13, Bangkok 10110',
        'type' => '☕ Specialty Coffee',
        'template' => 'default1',
        'color_primary' => '#d69e2e',
        'color_secondary' => '#b7791f',
        // ADD THESE DARK MODE COLORS
        'color_primary_dark' => '#ed8936',
        'color_secondary_dark' => '#c05621',
        'hours' => 'Open until 8 PM',
        'phone' => '+6621234569',
        'menu_section' => [
            // ... your existing menu data
        ]
    ]
];

// Get business data or show 404
$business = $businesses[$omf_id] ?? null;
if (!$business) {
    include 'not-found.php';
    exit;
}

// Load the selected template
$template = $business['template'] ?? 'default1';
$templatePath = "templates/{$template}/template.php";

if (file_exists($templatePath)) {
    include $templatePath;
} else {
    // Fallback to default template
    include 'templates/default1/template.php';
}
?>