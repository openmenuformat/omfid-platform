<?php
// Get business ID from URL
$omf_id = $_GET['id'] ?? 'unknown';

// Test data for businesses
$businesses = [
    'tonys-pizza' => [
        'name' => "Tony's Pizza Bangkok",
        'description' => 'Authentic Italian pizza and pasta in the heart of Bangkok',
        'address' => 'Sukhumvit Soi 24, Bangkok 10110',
        'type' => '🍕 Italian Restaurant'
    ],
    'marias-spa' => [
        'name' => "Maria's Thai Massage & Spa",
        'description' => 'Traditional Thai massage and relaxation spa',
        'address' => 'Silom Road, Bangkok 10500',
        'type' => '💆 Spa & Wellness'
    ],
    'johns-coffee' => [
        'name' => "John's Coffee House",
        'description' => 'Specialty coffee and fresh pastries',
        'address' => 'Thonglor Soi 13, Bangkok 10110',
        'type' => '☕ Specialty Coffee'
    ]
];

// Get business data or use default
$business = $businesses[$omf_id] ?? [
    'name' => ucwords(str_replace('-', ' ', $omf_id)),
    'description' => 'Welcome to our business',
    'address' => 'Bangkok, Thailand',
    'type' => '🏪 Business'
];

// Sample menu items for each business
if ($omf_id == 'tonys-pizza') {
    $menuItems = [
        [
            'name' => 'Margherita Pizza',
            'price' => '350',
            'description' => 'Classic Italian pizza with San Marzano tomato sauce, fresh mozzarella, basil, and extra virgin olive oil',
            'tags' => ['Vegetarian', 'Popular']
        ],
        [
            'name' => 'Pepperoni Pizza',
            'price' => '420',
            'description' => 'Loaded with double pepperoni, mozzarella cheese, and our signature tomato sauce',
            'tags' => ['Spicy', 'Popular']
        ],
        [
            'name' => 'Hawaiian Pizza',
            'price' => '380',
            'description' => 'Ham, pineapple, mozzarella cheese with tomato sauce base',
            'tags' => ['Sweet & Savory']
        ],
        [
            'name' => 'Caesar Salad',
            'price' => '220',
            'description' => 'Fresh romaine lettuce, parmesan cheese, croutons, and our house-made Caesar dressing',
            'tags' => ['Vegetarian']
        ],
        [
            'name' => 'Carbonara Pasta',
            'price' => '280',
            'description' => 'Creamy pasta with crispy bacon, egg yolk, parmesan cheese, and black pepper',
            'tags' => ['Popular']
        ],
        [
            'name' => 'Tiramisu',
            'price' => '180',
            'description' => 'Classic Italian dessert with coffee-soaked ladyfingers, mascarpone cream, and cocoa',
            'tags' => ['Dessert', 'Popular']
        ]
    ];
} elseif ($omf_id == 'marias-spa') {
    $menuItems = [
        [
            'name' => 'Traditional Thai Massage',
            'price' => '600/hr',
            'description' => 'Full body traditional Thai massage focusing on pressure points and stretching',
            'tags' => ['Popular']
        ],
        [
            'name' => 'Aromatherapy Oil Massage',
            'price' => '800/hr',
            'description' => 'Relaxing oil massage with your choice of essential oils',
            'tags' => ['Relaxing']
        ],
        [
            'name' => 'Foot Reflexology',
            'price' => '400/45min',
            'description' => 'Traditional foot massage focusing on reflex points',
            'tags' => ['Popular']
        ]
    ];
} elseif ($omf_id == 'johns-coffee') {
    $menuItems = [
        [
            'name' => 'Cappuccino',
            'price' => '120',
            'description' => 'Double shot espresso with steamed milk and perfect foam art',
            'tags' => ['Popular']
        ],
        [
            'name' => 'Iced Americano',
            'price' => '100',
            'description' => 'Double shot espresso over ice with cold water',
            'tags' => ['Refreshing']
        ],
        [
            'name' => 'Croissant',
            'price' => '90',
            'description' => 'Freshly baked buttery French croissant',
            'tags' => ['Fresh Daily']
        ]
    ];
} else {
    $menuItems = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($business['name']); ?> - OMFID</title>
    
    <!-- Favicon and App Icons -->
    <link rel="icon" type="image/x-icon" href="https://omfid.com/assets/favicon.ico">
    <link rel="apple-touch-icon" href="https://omfid.com/assets/favicon.ico">
    
    <!-- Social Media Meta Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($business['name']); ?> - OMFID">
    <meta property="og:description" content="<?php echo htmlspecialchars($business['description']); ?>">
    <meta property="og:image" content="https://omfid.com/assets/preview-business.jpg">
    <meta property="og:url" content="https://omfid.com/<?php echo htmlspecialchars($omf_id); ?>">
    
    <style>
        /* Modern CSS Variables with Dark Mode Support */
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #f1f5f9;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --border-color: #e2e8f0;
            --card-bg: #ffffff;
            --header-bg: #ffffff;
            --hero-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --accent-color: #667eea;
            --shadow-light: rgba(0, 0, 0, 0.05);
            --shadow-medium: rgba(0, 0, 0, 0.1);
            --shadow-heavy: rgba(0, 0, 0, 0.2);
        }

        [data-theme="dark"] {
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-tertiary: #334155;
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --border-color: #334155;
            --card-bg: #1e293b;
            --header-bg: #1e293b;
            --hero-gradient: linear-gradient(135deg, #4338ca 0%, #7c3aed 100%);
            --accent-color: #6366f1;
            --shadow-light: rgba(0, 0, 0, 0.3);
            --shadow-medium: rgba(0, 0, 0, 0.4);
            --shadow-heavy: rgba(0, 0, 0, 0.6);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: var(--bg-secondary);
            color: var(--text-primary);
            transition: all 0.3s ease;
            min-height: 100vh;
        }
        
        /* Header Styles */
        .header {
            background: var(--header-bg);
            box-shadow: 0 2px 10px var(--shadow-light);
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo-img {
            height: 35px;
            width: auto;
            border-radius: 6px;
            transition: all 0.3s ease;
            object-fit: contain;
        }
        
        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .theme-toggle {
            background: var(--bg-tertiary);
            border: 2px solid var(--border-color);
            border-radius: 50%;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 18px;
            color: var(--text-primary);
        }

        .theme-toggle:hover {
            border-color: var(--accent-color);
            transform: scale(1.05);
            box-shadow: 0 4px 12px var(--shadow-medium);
        }
        
        .language-selector {
            padding: 8px 15px;
            border: 2px solid var(--border-color);
            border-radius: 25px;
            background: var(--card-bg);
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .language-selector:hover {
            border-color: var(--accent-color);
            transform: translateY(-2px);
        }

        .action-btn {
            padding: 8px 16px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .action-btn.secondary {
            background: var(--bg-tertiary);
            color: var(--text-primary);
            border: 2px solid var(--border-color);
        }

        .action-btn.secondary:hover {
            border-color: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px var(--shadow-medium);
        }
        
        /* Business Hero Section */
        .business-hero {
            background: var(--hero-gradient);
            color: white;
            padding: 60px 20px;
            position: relative;
        }
        
        .business-hero-content {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .back-button {
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 20px;
            opacity: 0.9;
            transition: all 0.3s;
        }
        
        .back-button:hover {
            opacity: 1;
            transform: translateX(-5px);
        }
        
        .business-info h1 {
            font-size: 48px;
            margin-bottom: 10px;
        }
        
        .business-meta {
            display: flex;
            gap: 30px;
            font-size: 18px;
            opacity: 0.9;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .quick-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .action-btn-hero {
            padding: 12px 24px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        
        .action-btn-hero.primary {
            background: white;
            color: var(--accent-color);
        }
        
        .action-btn-hero.secondary {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        
        .action-btn-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px var(--shadow-heavy);
        }
        
        /* Menu Container */
        .container {
            max-width: 1200px;
            margin: -30px auto 50px;
            padding: 0 20px;
            position: relative;
            z-index: 10;
        }
        
        /* Menu Sections */
        .menu-section {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px var(--shadow-medium);
            margin-bottom: 30px;
            border: 1px solid var(--border-color);
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--border-color);
        }
        
        .section-title {
            font-size: 28px;
            font-weight: bold;
            color: var(--text-primary);
        }
        
        .view-toggle {
            display: flex;
            gap: 10px;
        }
        
        .toggle-btn {
            padding: 8px 16px;
            border: 2px solid var(--border-color);
            background: var(--card-bg);
            color: var(--text-primary);
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .toggle-btn.active {
            background: var(--hero-gradient);
            color: white;
            border-color: transparent;
        }
        
        .toggle-btn:hover:not(.active) {
            border-color: var(--accent-color);
        }
        
        /* Menu Grid */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }
        
        .menu-item {
            background: var(--bg-tertiary);
            border-radius: 15px;
            padding: 20px;
            transition: all 0.3s;
            cursor: pointer;
            border: 1px solid var(--border-color);
        }
        
        .menu-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px var(--shadow-medium);
            border-color: var(--accent-color);
        }
        
        .menu-item-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 10px;
        }
        
        .menu-item-name {
            font-size: 20px;
            font-weight: bold;
            color: var(--text-primary);
        }
        
        .menu-item-price {
            font-size: 20px;
            font-weight: bold;
            background: var(--hero-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .menu-item-description {
            color: var(--text-secondary);
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 10px;
        }
        
        .menu-item-tags {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .tag {
            padding: 4px 10px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            font-size: 12px;
            color: var(--text-secondary);
        }
        
        .tag.spicy {
            background: rgba(255, 68, 68, 0.1);
            color: #ff4444;
            border-color: rgba(255, 68, 68, 0.3);
        }
        
        .tag.popular {
            background: rgba(255, 152, 0, 0.1);
            color: #ff9800;
            border-color: rgba(255, 152, 0, 0.3);
        }
        
        .tag.vegetarian {
            background: rgba(76, 175, 80, 0.1);
            color: #4caf50;
            border-color: rgba(76, 175, 80, 0.3);
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .business-info h1 {
                font-size: 32px;
            }
            
            .menu-grid {
                grid-template-columns: 1fr;
            }
            
            .business-meta {
                flex-direction: column;
                gap: 10px;
            }
            
            .quick-actions {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <a href="/" class="logo">
                <img src="https://omfid.com/assets/logo.jpg" alt="OMFID" class="logo-img" loading="eager">
            </a>
            <div class="header-actions">
                <button class="theme-toggle" id="themeToggle">
                    <span class="theme-icon">🌙</span>
                </button>
                
                <select class="language-selector" id="languageSelector" onchange="changeLanguage()">
                    <option value="en">🇬🇧 English</option>
                    <option value="th">🇹🇭 ไทย</option>
                </select>

                <a href="https://make.openmenuformat.com" target="_blank" class="action-btn secondary">📱 Create Menu</a>
            </div>
        </div>
    </header>

    <!-- Business Hero -->
    <div class="business-hero">
        <div class="business-hero-content">
            <a href="/" class="back-button">← Back to Directory</a>
            <div class="business-info">
                <h1><?php echo htmlspecialchars($business['name']); ?></h1>
                <p style="font-size: 20px; opacity: 0.9;"><?php echo htmlspecialchars($business['description']); ?></p>
                <div class="business-meta">
                    <div class="meta-item">📍 <?php echo htmlspecialchars($business['address']); ?></div>
                    <div class="meta-item">⭐ 4.8 (324 reviews)</div>
                    <div class="meta-item"><?php echo $business['type']; ?></div>
                </div>
                <div class="quick-actions">
                    <button class="action-btn-hero primary" onclick="handleCall()">📞 Call Now</button>
                    <button class="action-btn-hero secondary" onclick="handleDirections()">🗺️ Get Directions</button>
                    <button class="action-btn-hero secondary" onclick="handleShare()">📤 Share</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Container -->
    <div class="container">
        <!-- Menu Section -->
        <div class="menu-section">
            <div class="section-header">
                <h2 class="section-title">Menu</h2>
                <div class="view-toggle">
                    <button class="toggle-btn active" onclick="switchView('grid')">Grid View</button>
                    <button class="toggle-btn" onclick="switchView('list')">List View</button>
                </div>
            </div>
            
            <div class="menu-grid" id="menuGrid">
                <?php if (!empty($menuItems)): ?>
                    <?php foreach ($menuItems as $item): ?>
                        <div class="menu-item">
                            <div class="menu-item-header">
                                <div class="menu-item-name"><?php echo htmlspecialchars($item['name']); ?></div>
                                <div class="menu-item-price">฿<?php echo htmlspecialchars($item['price']); ?></div>
                            </div>
                            <div class="menu-item-description">
                                <?php echo htmlspecialchars($item['description']); ?>
                            </div>
                            <div class="menu-item-tags">
                                <?php foreach ($item['tags'] as $tag): ?>
                                    <span class="tag <?php echo strtolower(str_replace(' ', '-', $tag)); ?>">
                                        <?php echo htmlspecialchars($tag); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Dark Mode Toggle
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = themeToggle.querySelector('.theme-icon');

        // Load saved theme
        const savedTheme = localStorage.getItem('darkMode') === 'true' ? 'dark' : 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        updateThemeIcon(savedTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('darkMode', newTheme === 'dark');
            updateThemeIcon(newTheme);
        });

        function updateThemeIcon(theme) {
            themeIcon.textContent = theme === 'dark' ? '☀️' : '🌙';
        }

        // View Toggle
        function switchView(viewType) {
            const buttons = document.querySelectorAll('.toggle-btn');
            const menuGrid = document.getElementById('menuGrid');
            
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            if (viewType === 'list') {
                menuGrid.style.gridTemplateColumns = '1fr';
            } else {
                menuGrid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(350px, 1fr))';
            }
        }

        // Business Actions
        function handleCall() {
            window.location.href = 'tel:+6621234567';
        }
        
        function handleDirections() {
            window.open('https://maps.google.com/?q=<?php echo urlencode($business['name'] . ' ' . $business['address']); ?>', '_blank');
        }
        
        function handleShare() {
            if (navigator.share) {
                navigator.share({
                    title: '<?php echo addslashes($business['name']); ?>',
                    text: 'Check out <?php echo addslashes($business['name']); ?> on OMFID!',
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href);
                alert('Link copied to clipboard!');
            }
        }
        
        function changeLanguage() {
            const lang = document.getElementById('languageSelector').value;
            console.log('Language changed to:', lang);
        }
    </script>
</body>
</html>