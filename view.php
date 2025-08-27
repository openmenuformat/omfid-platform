<?php
// Get business ID from URL
$omf_id = $_GET['id'] ?? 'unknown';

// Supabase configuration
$SUPABASE_URL = "https://your-project.supabase.co"; // UPDATE THIS
$SUPABASE_ANON_KEY = "your-anon-key-here"; // UPDATE THIS

// Function to make Supabase API calls
function supabaseQuery($table, $select = '*', $filters = []) {
    global $SUPABASE_URL, $SUPABASE_ANON_KEY;
    
    $url = "$SUPABASE_URL/rest/v1/$table?select=" . urlencode($select);
    
    // Add filters
    foreach ($filters as $key => $value) {
        $url .= "&$key=" . urlencode($value);
    }
    
    $headers = [
        "apikey: $SUPABASE_ANON_KEY",
        "Authorization: Bearer $SUPABASE_ANON_KEY",
        "Content-Type: application/json"
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode !== 200) {
        return null;
    }
    
    return json_decode($response, true);
}

// Get business data from Supabase
$businessData = supabaseQuery(
    'business',
    'id_business,name_business,description_business,address_business,business_type,phone_business,email_business,hero_image_url,gallery_images',
    [
        'omf_id' => "eq.$omf_id",
        'omfid_published' => 'eq.true'
    ]
);

// Check if business exists and is published
if (!$businessData || empty($businessData)) {
    http_response_code(404);
    ?>
    <!DOCTYPE html>
    <html>
    <head><title>Business Not Found - OMFID</title></head>
    <body style="font-family: system-ui; text-align: center; padding: 100px;">
        <h1>Business Not Found</h1>
        <p>This business is not available on OMFID.</p>
        <a href="/" style="color: #667eea;">← Back to Directory</a>
    </body>
    </html>
    <?php
    exit;
}

$business = $businessData[0];

// Get featured section and products
$sectionData = supabaseQuery(
    'sections',
    'id,name,products(id_product,name_product,description_product,price_product,image_url_product)',
    [
        'business_id_section' => "eq.{$business['id_business']}",
        'featured_on_omfid' => 'eq.true',
        'limit' => '1'
    ]
);

$featuredSection = $sectionData[0] ?? null;
$menuItems = $featuredSection['products'] ?? [];

// Parse gallery images
$galleryImages = json_decode($business['gallery_images'] ?? '[]', true);

// Default gallery placeholders if no images uploaded
$defaultGallery = [
    ['label' => 'Fresh Ingredients', 'size' => 'large'],
    ['label' => 'Interior View', 'size' => 'medium'], 
    ['label' => 'Signature Dish', 'size' => 'small'],
    ['label' => 'Kitchen Action', 'size' => 'medium'],
    ['label' => 'Team Photo', 'size' => 'small'],
    ['label' => 'Happy Customers', 'size' => 'large']
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($business['name_business']); ?> - OMFID</title>
    
    <!-- CRITICAL: Load theme files FIRST -->
    <link rel="stylesheet" href="/css/variables.css">
    
    <!-- Favicon and App Icons -->
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    <link rel="apple-touch-icon" href="/assets/logo.jpg">
    
    <!-- Social Media Meta Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($business['name_business']); ?> - OMFID">
    <meta property="og:description" content="<?php echo htmlspecialchars($business['description_business']); ?>">
    <meta property="og:image" content="<?php echo $business['hero_image_url'] ?: '/assets/preview-business.jpg'; ?>">
    <meta property="og:url" content="https://omfid.com/<?php echo htmlspecialchars($omf_id); ?>">
    <meta property="og:type" content="website">
    
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
        
        /* Logo Styles */
        .logo {
            display: flex !important;
            align-items: center !important;
            text-decoration: none !important;
            transition: all 0.3s ease !important;
        }

        .logo:hover {
            transform: scale(1.05) !important;
        }

        .logo-img {
            height: 35px !important;
            width: auto !important;
            border-radius: 6px !important;
            transition: all 0.3s ease !important;
            object-fit: contain !important;
        }

        [data-theme="dark"] .logo-img {
            filter: brightness(1.1) contrast(1.1) !important;
        }

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
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
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

        .business-type {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
            margin-bottom: 10px;
        }
        
        .business-info h1 {
            font-size: 48px;
            margin-bottom: 15px;
            font-weight: 900;
            line-height: 1.1;
        }

        .business-description {
            font-size: 18px;
            opacity: 0.9;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .business-meta {
            display: flex;
            gap: 30px;
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 30px;
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
            font-weight: 600;
        }
        
        .action-btn-hero.primary {
            background: white;
            color: var(--accent-color);
        }
        
        .action-btn-hero.secondary {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
        }
        
        .action-btn-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }

        /* Hero Image */
        .hero-visual {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-image {
            width: 100%;
            max-width: 400px;
            height: 400px;
            border-radius: 20px;
            object-fit: cover;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        }

        .hero-image-placeholder {
            width: 100%;
            max-width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.1);
            border-radius: 20px;
            backdrop-filter: blur(20px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 2px dashed rgba(255,255,255,0.3);
            color: white;
            font-size: 18px;
            text-align: center;
            transition: all 0.4s ease;
        }

        .hero-image-placeholder:hover {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.6);
            transform: scale(1.02);
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
            padding: 40px;
            box-shadow: 0 10px 40px var(--shadow-medium);
            margin-bottom: 50px;
            border: 1px solid var(--border-color);
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .section-title {
            font-size: 36px;
            font-weight: 900;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
        }

        .section-subtitle {
            color: var(--text-secondary);
            font-size: 18px;
            max-width: 600px;
            margin: 0 auto;
        }
        
        /* Menu Grid */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
        }
        
        .menu-item {
            background: var(--bg-tertiary);
            border-radius: 15px;
            padding: 25px;
            transition: all 0.3s;
            cursor: pointer;
            border: 1px solid var(--border-color);
        }
        
        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px var(--shadow-medium);
            border-color: var(--accent-color);
        }
        
        .menu-item-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 12px;
        }
        
        .menu-item-name {
            font-size: 20px;
            font-weight: bold;
            color: var(--text-primary);
            flex: 1;
        }
        
        .menu-item-price {
            font-size: 20px;
            font-weight: bold;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-left: 15px;
        }
        
        .menu-item-description {
            color: var(--text-secondary);
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        
        .menu-item-tags {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .tag {
            padding: 4px 12px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            font-size: 12px;
            color: var(--text-secondary);
            font-weight: 600;
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

        /* Gallery Section */
        .gallery-section {
            margin: 60px 0;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-template-rows: repeat(8, 80px);
            gap: 20px;
        }

        .gallery-item {
            background: var(--bg-tertiary);
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 2px dashed var(--border-color);
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 600;
            transition: all 0.4s ease;
            cursor: pointer;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* Different gallery item sizes */
        .gallery-item.large {
            grid-column: span 5;
            grid-row: span 3;
        }

        .gallery-item.medium {
            grid-column: span 4; 
            grid-row: span 2;
        }

        .gallery-item.small {
            grid-column: span 3;
            grid-row: span 2;
        }

        /* Specific positioning for artistic layout */
        .gallery-item:nth-child(1) {
            grid-column: 1 / 6;
            grid-row: 1 / 4;
        }

        .gallery-item:nth-child(2) {
            grid-column: 6 / 10;
            grid-row: 1 / 3;
        }

        .gallery-item:nth-child(3) {
            grid-column: 10 / 13;
            grid-row: 1 / 3;
        }

        .gallery-item:nth-child(4) {
            grid-column: 1 / 5;
            grid-row: 4 / 7;
        }

        .gallery-item:nth-child(5) {
            grid-column: 5 / 8;
            grid-row: 3 / 6;
        }

        .gallery-item:nth-child(6) {
            grid-column: 8 / 13;
            grid-row: 3 / 6;
        }

        .gallery-item:hover {
            border-color: var(--accent-color);
            transform: scale(1.05);
            box-shadow: 0 15px 35px var(--shadow-medium);
            background: var(--card-bg);
        }

        /* Gallery image display */
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 13px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: var(--bg-tertiary);
            border-radius: 15px;
            border: 2px dashed var(--border-color);
            grid-column: 1/-1;
        }

        .empty-state h3 {
            color: var(--text-secondary);
            margin-bottom: 15px;
            font-size: 24px;
        }

        .empty-state p {
            color: var(--text-muted);
            font-size: 16px;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .business-hero-content {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
            }

            .business-info h1 {
                font-size: 32px;
            }
            
            .menu-grid {
                grid-template-columns: 1fr;
            }
            
            .business-meta {
                flex-direction: column;
                gap: 15px;
                align-items: center;
            }
            
            .quick-actions {
                justify-content: center;
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

            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                grid-template-rows: repeat(8, 100px);
                gap: 15px;
            }

            .gallery-item:nth-child(1) { grid-column: 1 / 3; grid-row: 1 / 3; }
            .gallery-item:nth-child(2) { grid-column: 1 / 2; grid-row: 3 / 5; }
            .gallery-item:nth-child(3) { grid-column: 2 / 3; grid-row: 3 / 5; }
            .gallery-item:nth-child(4) { grid-column: 1 / 3; grid-row: 5 / 7; }
            .gallery-item:nth-child(5) { grid-column: 1 / 2; grid-row: 7 / 9; }
            .gallery-item:nth-child(6) { grid-column: 2 / 3; grid-row: 7 / 9; }
        }
    </style>
</head>
<body>
    <!-- Header -->
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
            <div class="business-info">
                <a href="/" class="back-button">← Back to Directory</a>
                <div class="business-type"><?php echo htmlspecialchars($business['business_type']); ?></div>
                <h1><?php echo htmlspecialchars($business['name_business']); ?></h1>
                <p class="business-description"><?php echo htmlspecialchars($business['description_business']); ?></p>
                <div class="business-meta">
                    <div class="meta-item">📍 <?php echo htmlspecialchars($business['address_business']); ?></div>
                    <div class="meta-item">⭐ 4.8 (324 reviews)</div>
                    <div class="meta-item">🕒 Open until 11 PM</div>
                </div>
                <div class="quick-actions">
                    <a href="tel:<?php echo htmlspecialchars($business['phone_business'] ?? '+66212345678'); ?>" class="action-btn-hero primary">📞 Call Now</a>
                    <button class="action-btn-hero secondary" onclick="scrollToMenu()">📋 View Menu</button>
                    <button class="action-btn-hero secondary" onclick="handleDirections()">📍 Directions</button>
                </div>
            </div>
            
            <div class="hero-visual">
                <?php if ($business['hero_image_url']): ?>
                    <img src="<?php echo htmlspecialchars($business['hero_image_url']); ?>" 
                         alt="<?php echo htmlspecialchars($business['name_business']); ?>" 
                         class="hero-image" loading="lazy">
                <?php else: ?>
                    <div class="hero-image-placeholder">
                        📸 Hero Image<br>
                        <small style="margin-top: 10px; opacity: 0.8;">(1200x600px recommended)</small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Menu Container -->
    <div class="container">
        <!-- Menu Section -->
        <div class="menu-section" id="menu">
            <div class="section-header">
                <h2 class="section-title">
                    <?php echo htmlspecialchars($featuredSection['name'] ?? 'Our Menu'); ?>
                </h2>
                <p class="section-subtitle">
                    Handcrafted with love using the finest ingredients and our signature recipes.
                </p>
            </div>
            
            <div class="menu-grid">
                <?php if (!empty($menuItems)): ?>
                    <?php foreach ($menuItems as $item): ?>
                    <div class="menu-item">
                        <div class="menu-item-header">
                            <div class="menu-item-name"><?php echo htmlspecialchars($item['name_product']); ?></div>
                            <div class="menu-item-price">₿<?php echo htmlspecialchars($item['price_product']); ?></div>
                        </div>
                        <div class="menu-item-description">
                            <?php echo htmlspecialchars($item['description_product']); ?>
                        </div>
                        <div class="menu-item-tags">
                            <!-- You can add dynamic tags here based on product properties -->
                            <span class="tag popular">Popular</span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Fallback content when no menu items -->
                    <div class="empty-state">
                        <h3>Menu Coming Soon!</h3>
                        <p>This business is setting up their delicious menu. Check back soon!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Gallery Section -->
        <div class="gallery-section">
            <div class="gallery-grid">
                <?php if (!empty($galleryImages)): ?>
                    <?php foreach ($galleryImages as $index => $image): ?>
                    <div class="gallery-item">
                        <img src="<?php echo htmlspecialchars($image['url']); ?>" 
                             alt="<?php echo htmlspecialchars($image['alt'] ?? 'Gallery image'); ?>"
                             loading="lazy">
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Default gallery placeholders -->
                    <?php foreach ($defaultGallery as $item): ?>
                    <div class="gallery-item <?php echo $item['size']; ?>">
                        📸 <?php echo $item['label']; ?><br>
                        <small style="opacity: 0.7; margin-top: 5px;">Upload image</small>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- CRITICAL: Load theme script -->
    <script src="/js/theme.js"></script>
    
    <script>
        // Business Actions
        function scrollToMenu() {
            document.getElementById('menu').scrollIntoView({ behavior: 'smooth' });
        }
        
        function handleDirections() {
            const businessName = <?php echo json_encode($business['name_business']); ?>;
            const address = <?php echo json_encode($business['address_business']); ?>;
            window.open(`https://maps.google.com/?q=${encodeURIComponent(businessName + ' ' + address)}`, '_blank');
        }
        
        function handleShare() {
            if (navigator.share) {
                navigator.share({
                    title: <?php echo json_encode($business['name_business']); ?>,
                    text: `Check out ${<?php echo json_encode($business['name_business']); ?>} on OMFID!`,
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

        // Initialize theme on page load
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize theme using existing theme.js
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = themeToggle.querySelector('.theme-icon');

            // Load saved theme - SAME KEY AS HOMEPAGE
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
        });
    </script>
</body>
</html>