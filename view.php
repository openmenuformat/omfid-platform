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
$businesses = [
    'tonys-pizza' => [
        'name' => "Tony's Pizza Bangkok",
        'description' => 'Authentic Italian pizza and pasta in the heart of Bangkok',
        'address' => 'Sukhumvit Soi 24, Bangkok 10110',
        'type' => '🍕 Italian Restaurant',
        'template' => 'default1',
        'color_primary' => '#667eea',
        'color_secondary' => '#764ba2',
        'color_primary_dark' => '#6366f1',
        'color_secondary_dark' => '#8b5cf6',
        'hours' => 'Open until 11 PM',
        'phone' => '+6621234567',
        'menu_section' => [
            'title' => 'Our Signature Pizzas',
            'subtitle' => 'Handcrafted with love using the finest imported Italian ingredients and our signature wood-fired oven.',
            'items' => [
                [
                    'name' => 'Margherita Pizza',
                    'price' => '350',
                    'description' => 'Classic Italian pizza with San Marzano tomato sauce, fresh mozzarella di bufala, organic basil, and extra virgin olive oil on our signature wood-fired crust.',
                    'tags' => ['Vegetarian', 'Popular']
                ],
                [
                    'name' => 'Pepperoni Supreme', 
                    'price' => '420',
                    'description' => 'Loaded with double pepperoni, premium mozzarella cheese, bell peppers, red onions, and our signature spicy tomato sauce. A crowd favorite!',
                    'tags' => ['Spicy', 'Popular']
                ],
                [
                    'name' => 'Quattro Stagioni',
                    'price' => '480', 
                    'description' => 'Four seasons pizza featuring artichokes, mushrooms, ham, and olives on different quarters. A true Italian masterpiece representing the four seasons.',
                    'tags' => ['Signature']
                ],
                [
                    'name' => 'Truffle & Arugula',
                    'price' => '680',
                    'description' => 'Premium white pizza with truffle oil, fresh arugula, parmesan shavings, and mozzarella. Finished with a drizzle of aged balsamic reduction.',
                    'tags' => ['Vegetarian', 'Premium']
                ],
                [
                    'name' => 'Diavola',
                    'price' => '390',
                    'description' => 'Spicy salami, mozzarella, fresh chilies, and our fiery tomato sauce. Perfect for those who love it hot and authentic.',
                    'tags' => ['Spicy']
                ],
                [
                    'name' => 'Carbonara Pizza',
                    'price' => '450',
                    'description' => 'Our signature fusion: white pizza with cream sauce, crispy pancetta, egg yolk, pecorino romano, and freshly cracked black pepper.',
                    'tags' => ['Chef\'s Special', 'Popular']
                ]
            ]
        ],
        'gallery' => [
            'Wood Fire Oven' => 'Landscape',
            'Fresh Ingredients' => 'Square', 
            'Restaurant Interior' => 'Portrait',
            'Chef at Work' => 'Wide',
            'Signature Pizza' => 'Square',
            'Happy Customers' => 'Landscape'
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
        'color_primary_dark' => '#48bb78',
        'color_secondary_dark' => '#2f855a',
        'hours' => 'Open until 10 PM',
        'phone' => '+6621234568',
        'menu_section' => [
            'title' => 'Signature Treatments',
            'subtitle' => 'Traditional Thai healing techniques combined with modern spa luxury for ultimate relaxation.',
            'items' => [
                [
                    'name' => 'Traditional Thai Massage',
                    'price' => '600/hr',
                    'description' => 'Full body traditional Thai massage focusing on pressure points and stretching techniques passed down through generations.',
                    'tags' => ['Popular', 'Traditional']
                ],
                [
                    'name' => 'Aromatherapy Oil Massage',
                    'price' => '800/hr', 
                    'description' => 'Relaxing oil massage with your choice of essential oils including lavender, eucalyptus, and lemongrass.',
                    'tags' => ['Relaxing', 'Premium']
                ],
                [
                    'name' => 'Foot Reflexology',
                    'price' => '400/45min',
                    'description' => 'Traditional foot massage focusing on reflex points that correspond to different organs and systems.',
                    'tags' => ['Popular']
                ],
                [
                    'name' => 'Hot Stone Massage',
                    'price' => '900/90min',
                    'description' => 'Therapeutic massage using heated volcanic stones to relax muscles and improve circulation.',
                    'tags' => ['Premium', 'Relaxing']
                ],
                [
                    'name' => 'Thai Herbal Compress',
                    'price' => '700/hr',
                    'description' => 'Traditional massage combined with heated herbal compress balls containing lemongrass, ginger, and turmeric.',
                    'tags' => ['Traditional', 'Healing']
                ]
            ]
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
        'color_primary_dark' => '#ed8936',
        'color_secondary_dark' => '#c05621',
        'hours' => 'Open until 8 PM',
        'phone' => '+6621234569',
        'menu_section' => [
            'title' => 'Coffee & Pastries',
            'subtitle' => 'Freshly roasted beans from the mountains of Northern Thailand, expertly brewed to perfection.',
            'items' => [
                [
                    'name' => 'Cappuccino',
                    'price' => '120',
                    'description' => 'Double shot espresso with perfectly steamed milk and beautiful latte art by our skilled baristas.',
                    'tags' => ['Popular']
                ],
                [
                    'name' => 'Iced Americano', 
                    'price' => '100',
                    'description' => 'Double shot espresso over ice with cold filtered water. Clean, bold, refreshing.',
                    'tags' => ['Refreshing']
                ],
                [
                    'name' => 'Fresh Croissant',
                    'price' => '90',
                    'description' => 'Buttery French croissant baked fresh daily with imported French butter and flour.',
                    'tags' => ['Fresh Daily']
                ],
                [
                    'name' => 'Flat White',
                    'price' => '130',
                    'description' => 'Velvety microfoam milk combined with a double shot of our signature blend espresso.',
                    'tags' => ['Signature']
                ],
                [
                    'name' => 'Thai Iced Coffee',
                    'price' => '110',
                    'description' => 'Traditional Thai-style coffee with condensed milk served over ice. Sweet and strong.',
                    'tags' => ['Local Favorite', 'Sweet']
                ],
                [
                    'name' => 'Banana Bread',
                    'price' => '85',
                    'description' => 'Homemade banana bread with walnuts, baked fresh daily. Perfect with coffee.',
                    'tags' => ['Homemade', 'Fresh Daily']
                ]
            ]
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