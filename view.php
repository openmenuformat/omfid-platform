<?php
// Get business ID from URL
$omf_id = $_GET['id'] ?? 'unknown';

// Validation
$validBusinesses = ['tonys-pizza', 'marias-spa', 'johns-coffee'];

if (!in_array($omf_id, $validBusinesses)) {
    http_response_code(404);
    echo "Business not found";
    exit;
}

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

// Get business data
$business = $businesses[$omf_id] ?? [
    'name' => ucwords(str_replace('-', ' ', $omf_id)),
    'description' => 'Welcome to our business',
    'address' => 'Bangkok, Thailand',
    'type' => '🏪 Business'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($business['name']); ?> - OMFID</title>
    
    <!-- CRITICAL: Load theme files FIRST -->
    <link rel="stylesheet" href="/css/variables.css">
    
    <!-- Favicon and App Icons -->
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    <link rel="apple-touch-icon" href="/assets/logo.jpg">
    
    <!-- Social Media Meta Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($business['name']); ?> - OMFID">
    <meta property="og:description" content="<?php echo htmlspecialchars($business['description']); ?>">
    <meta property="og:image" content="/assets/preview-business.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:url" content="https://omfid.com/<?php echo htmlspecialchars($omf_id); ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="OMFID">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@omfid">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($business['name']); ?> - OMFID">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($business['description']); ?>">
    <meta name="twitter:image" content="/assets/preview-business.jpg">
    
    <!-- Safari Specific -->
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    
    <style>
        /* Page-specific styles using CSS variables */
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
        
        /* Logo Styles with Image */
        .logo {
            display: flex !important;
            align-items: center !important;
            text-decoration: none !important;
            transition: all 0.3s ease !important;
            font-size: unset !important;
            font-weight: unset !important;
            background: unset !important;
            -webkit-background-clip: unset !important;
            -webkit-text-fill-color: unset !important;
            background-clip: unset !important;
        }

        .logo:hover {
            transform: scale(1.05) !important;
        }

        .logo-img {
            height: 35px !important;
            width: auto !important;
            border-radius: 6px !important;
            transition: all 0.3s ease !important;
            max-width: none !important;
            max-height: none !important;
            object-fit: contain !important;
        }

        /* Dark mode logo adjustments */
        [data-theme="dark"] .logo-img {
            filter: brightness(1.1) contrast(1.1) !important;
        }

        /* Mobile responsive logo */
        @media (max-width: 768px) {
            .logo-img {
                height: 28px !important;
            }
        }
        
        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        /* Theme Toggle Button */
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

        /* Action Button */
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
            background: var(--gradient);
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
        
        /* Quick Actions */
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
            background: var(--gradient);
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
            background: var(--gradient);
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
        
        .tag.veg {
            background: rgba(76, 175, 80, 0.1);
            color: #4caf50;
            border-color: rgba(76, 175, 80, 0.3);
        }
        
        /* CTA Section */
        .cta-section {
            background: var(--gradient);
            color: white;
            text-align: center;
            padding: 50px 20px;
            border-radius: 20px;
            margin-top: 50px;
        }
        
        .cta-section h2 {
            font-size: 32px;
            margin-bottom: 15px;
        }
        
        .cta-section p {
            font-size: 18px;
            opacity: 0.9;
            margin-bottom: 30px;
        }
        
        .cta-button {
            background: white;
            color: var(--accent-color);
            padding: 15px 40px;
            border-radius: 30px;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        .cta-button:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px var(--shadow-heavy);
        }

        /* Empty State */
        .empty-state {
            grid-column: 1/-1;
            text-align: center;
            padding: 60px 20px;
            background: var(--bg-tertiary);
            border-radius: 15px;
            border: 2px dashed var(--border-color);
        }

        .empty-state h3 {
            color: var(--text-secondary);
            margin-bottom: 20px;
        }

        .empty-state p {
            color: var(--text-muted);
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

            .header-actions {
                gap: 10px;
            }

            .action-btn {
                padding: 6px 12px;
                font-size: 14px;
            }

            .action-btn-hero {
                padding: 10px 20px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <!-- Header with Dark Mode & Settings -->
    <header class="header">
        <div class="header-content">
            <a href="/" class="logo">
                <img src="/assets/logo.jpg" alt="OMFID" class="logo-img" loading="eager">
            </a>
            <div class="header-actions">
                <button class="theme-toggle" id="themeToggle">
                    <span class="theme-icon">🌙</span>
                </button>
                
                <select class="language-selector" id="languageSelector" onchange="changeLanguage()">
                    <option value="en">🇬🇧 English</option>
                    <option value="th">🇹🇭 ไทย</option>
                    <option value="zh">🇨🇳 中文</option>
                    <option value="ja">🇯🇵 日本語</option>
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
                <?php if ($omf_id == 'tonys-pizza'): ?>
                    <!-- Pizza Menu Items -->
                    <div class="menu-item">
                        <div class="menu-item-header">
                            <div class="menu-item-name">Margherita Pizza</div>
                            <div class="menu-item-price">฿350</div>
                        </div>
                        <div class="menu-item-description">
                            Classic Italian pizza with San Marzano tomato sauce, fresh mozzarella, basil, and extra virgin olive oil
                        </div>
                        <div class="menu-item-tags">
                            <span class="tag veg">Vegetarian</span>
                            <span class="tag popular">Popular</span>
                        </div>
                    </div>
                    
                    <div class="menu-item">
                        <div class="menu-item-header">
                            <div class="menu-item-name">Pepperoni Pizza</div>
                            <div class="menu-item-price">฿420</div>
                        </div>
                        <div class="menu-item-description">
                            Loaded with double pepperoni, mozzarella cheese, and our signature tomato sauce
                        </div>
                        <div class="menu-item-tags">
                            <span class="tag spicy">Spicy</span>
                            <span class="tag popular">Popular</span>
                        </div>
                    </div>
                    
                    <div class="menu-item">
                        <div class="menu-item-header">
                            <div class="menu-item-name">Hawaiian Pizza</div>
                            <div class="menu-item-price">฿380</div>
                        </div>
                        <div class="menu-item-description">
                            Ham, pineapple, mozzarella cheese with tomato sauce base
                        </div>
                        <div class="menu-item-tags">
                            <span class="tag">Sweet & Savory</span>
                        </div>
                    </div>
                    
                    <div class="menu-item">
                        <div class="menu-item-header">
                            <div class="menu-item-name">Caesar Salad</div>
                            <div class="menu-item-price">฿220</div>
                        </div>
                        <div class="menu-item-description">
                            Fresh romaine lettuce, parmesan cheese, croutons, and our house-made Caesar dressing
                        </div>
                        <div class="menu-item-tags">
                            <span class="tag veg">Vegetarian</span>
                        </div>
                    </div>
                    
                    <div class="menu-item">
                        <div class="menu-item-header">
                            <div class="menu-item-name">Carbonara Pasta</div>
                            <div class="menu-item-price">฿280</div>
                        </div>
                        <div class="menu-item-description">
                            Creamy pasta with crispy bacon, egg yolk, parmesan cheese, and black pepper
                        </div>
                        <div class="menu-item-tags">
                            <span class="tag popular">Popular</span>
                        </div>
                    </div>
                    
                    <div class="menu-item">
                        <div class="menu-item-header">
                            <div class="menu-item-name">Tiramisu</div>
                            <div class="menu-item-price">฿180</div>
                        </div>
                        <div class="menu-item-description">
                            Classic Italian dessert with coffee-soaked ladyfingers, mascarpone cream, and cocoa
                        </div>
                        <div class="menu-item-tags">
                            <span class="tag">Dessert</span>
                            <span class="tag popular">Popular</span>
                        </div>
                    </div>
                    
                <?php elseif ($omf_id == 'marias-spa'): ?>
                    <!-- Spa Services -->
                    <div class="menu-item">
                        <div class="menu-item-header">
                            <div class="menu-item-name">Traditional Thai Massage</div>
                            <div class="menu-item-price">฿600/hr</div>
                        </div>
                        <div class="menu-item-description">
                            Full body traditional Thai massage focusing on pressure points and stretching
                        </div>
                        <div class="menu-item-tags">
                            <span class="tag popular">Popular</span>
                        </div>
                    </div>
                    
                    <div class="menu-item">
                        <div class="menu-item-header">
                            <div class="menu-item-name">Aromatherapy Oil Massage</div>
                            <div class="menu-item-price">฿800/hr</div>
                        </div>
                        <div class="menu-item-description">
                            Relaxing oil massage with your choice of essential oils
                        </div>
                        <div class="menu-item-tags">
                            <span class="tag">Relaxing</span>
                        </div>
                    </div>
                    
                    <div class="menu-item">
                        <div class="menu-item-header">
                            <div class="menu-item-name">Foot Reflexology</div>
                            <div class="menu-item-price">฿400/45min</div>
                        </div>
                        <div class="menu-item-description">
                            Traditional foot massage focusing on reflex points
                        </div>
                        <div class="menu-item-tags">
                            <span class="tag popular">Popular</span>
                        </div>
                    </div>
                    
                <?php elseif ($omf_id == 'johns-coffee'): ?>
                    <!-- Coffee Menu -->
                    <div class="menu-item">
                        <div class="menu-item-header">
                            <div class="menu-item-name">Cappuccino</div>
                            <div class="menu-item-price">฿120</div>
                        </div>
                        <div class="menu-item-description">
                            Double shot espresso with steamed milk and perfect foam art
                        </div>
                        <div class="menu-item-tags">
                            <span class="tag popular">Popular</span>
                        </div>
                    </div>
                    
                    <div class="menu-item">
                        <div class="menu-item-header">
                            <div class="menu-item-name">Iced Americano</div>
                            <div class="menu-item-price">฿100</div>
                        </div>
                        <div class="menu-item-description">
                            Double shot espresso over ice with cold water
                        </div>
                        <div class="menu-item-tags">
                            <span class="tag">Refreshing</span>
                        </div>
                    </div>
                    
                    <div class="menu-item">
                        <div class="menu-item-header">
                            <div class="menu-item-name">Croissant</div>
                            <div class="menu-item-price">฿90</div>
                        </div>
                        <div class="menu-item-description">
                            Freshly baked buttery French croissant
                        </div>
                        <div class="menu-item-tags">
                            <span class="tag">Fresh Daily</span>
                        </div>
                    </div>
                    
                <?php else: ?>
                    <!-- Default for unknown businesses -->
                    <div class="empty-state">
                        <h3>Menu Coming Soon!</h3>
                        <p>This business hasn't uploaded their menu yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- CTA Section -->
        <div class="cta-section">
            <h2>Is this your business?</h2>
            <p>Take control of your OMFID profile and keep your menu always up to date</p>
            <a href="https://make.openmenuformat.com" target="_blank" class="cta-button">Claim This Business - It's Free!</a>
        </div>
    </div>

    <!-- CRITICAL: Load theme script -->
    <script src="/js/theme.js"></script>
    
    <script>
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
            // In production, this would translate the content
        }
    </script>
</body>
</html>