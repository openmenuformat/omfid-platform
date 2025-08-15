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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($business['name']); ?> - OMFID</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: #f8f9fa;
        }
        
        /* Header */
        .header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
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
            font-size: 24px;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }
        
        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .language-selector {
            padding: 8px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .language-selector:hover {
            border-color: #667eea;
            transform: translateY(-2px);
        }
        
        /* Business Hero */
        .business-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        }
        
        .action-btn {
            padding: 12px 24px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .action-btn.primary {
            background: white;
            color: #667eea;
        }
        
        .action-btn.secondary {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
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
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .section-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }
        
        .view-toggle {
            display: flex;
            gap: 10px;
        }
        
        .toggle-btn {
            padding: 8px 16px;
            border: 2px solid #e0e0e0;
            background: white;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .toggle-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
        }
        
        /* Menu Grid */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }
        
        .menu-item {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .menu-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
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
            color: #333;
        }
        
        .menu-item-price {
            font-size: 20px;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .menu-item-description {
            color: #666;
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
            background: white;
            border-radius: 12px;
            font-size: 12px;
            color: #666;
        }
        
        .tag.spicy {
            background: #ffe5e5;
            color: #ff4444;
        }
        
        .tag.popular {
            background: #fff3cd;
            color: #ff9800;
        }
        
        .tag.veg {
            background: #e8f5e9;
            color: #4caf50;
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            color: #667eea;
            padding: 15px 40px;
            border-radius: 30px;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        .cta-button:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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
            <a href="/" class="logo">OMFID</a>
            <div class="header-actions">
                <select class="language-selector" id="languageSelector" onchange="changeLanguage()">
                    <option value="en">🇬🇧 English</option>
                    <option value="th">🇹🇭 ไทย</option>
                    <option value="zh">🇨🇳 中文</option>
                    <option value="ja">🇯🇵 日本語</option>
                </select>
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
                    <button class="action-btn primary" onclick="handleCall()">📞 Call Now</button>
                    <button class="action-btn secondary" onclick="handleDirections()">🗺️ Get Directions</button>
                    <button class="action-btn secondary" onclick="handleShare()">📤 Share</button>
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
                    <button class="toggle-btn active">Grid View</button>
                    <button class="toggle-btn">List View</button>
                </div>
            </div>
            
            <div class="menu-grid">
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
                    <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                        <h3 style="color: #666; margin-bottom: 20px;">Menu Coming Soon!</h3>
                        <p style="color: #999;">This business hasn't uploaded their menu yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- CTA Section -->
        <div class="cta-section">
            <h2>Is this your business?</h2>
            <p>Take control of your OMFID profile and keep your menu always up to date</p>
            <a href="https://omf.gg/maker" class="cta-button">Claim This Business - It's Free!</a>
        </div>
    </div>

    <script>
        function handleCall() {
            window.location.href = 'tel:+6621234567';
        }
        
        function handleDirections() {
            window.open('https://maps.google.com/?q=<?php echo urlencode($business['name'] . ' ' . $business['address']); ?>', '_blank');
        }
        
        function handleShare() {
            if (navigator.share) {
                navigator.share({
                    title: '<?php echo $business['name']; ?>',
                    text: 'Check out <?php echo $business['name']; ?> on OMFID!',
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
