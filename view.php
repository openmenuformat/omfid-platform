<?php
// Get business ID from URL
$omf_id = $_GET['id'] ?? 'unknown';

// Business data
$businesses = [
    'tonys-pizza' => [
        'name' => "Tony's Pizza Bangkok",
        'description' => 'Authentic Italian pizza and pasta in the heart of Bangkok',
        'subtitle' => 'Fresh ingredients, traditional recipes, modern atmosphere.',
        'address' => 'Sukhumvit Soi 24',
        'hours' => 'Open until 11 PM',
        'type' => '🍕 ITALIAN RESTAURANT',
        'color_primary' => '#667eea',
        'color_secondary' => '#764ba2',
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
                    'description' => 'Spicy salami, mozzarella, fresh chilies, and our fiery tomato sauce. Perfect for those who love it hot with freshly cracked black pepper.',
                    'tags' => ['Spicy']
                ],
                [
                    'name' => 'Carbonara Pizza',
                    'price' => '450',
                    'description' => 'Our signature fusion creation combining the best of both worlds with cream sauce, crispy pancetta, farm-fresh egg yolk, and pecorino romano.',
                    'tags' => ['Chef\'s Special', 'Popular']
                ]
            ]
        ],
        'gallery' => [
            'Wood Fire Oven' => 'Landscape',
            'Fresh Ingredients' => 'Square',
            'Restaurant Interior' => 'Portrait',
            'Signature Pizza' => 'Square',
            'Chef at Work' => 'Wide',
            'Happy Customers' => 'Landscape'
        ]
    ],
    'marias-spa' => [
        'name' => "Maria's Thai Massage & Spa",
        'description' => 'Traditional Thai massage and relaxation spa',
        'subtitle' => 'Ancient healing techniques in modern comfort.',
        'address' => 'Silom Road',
        'hours' => 'Open until 10 PM',
        'type' => '💆 SPA & WELLNESS',
        'color_primary' => '#48bb78',
        'color_secondary' => '#38a169',
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
                ]
            ]
        ]
    ]
];

// Get business data
$business = $businesses[$omf_id] ?? $businesses['tonys-pizza'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($business['name']); ?> - OMFID</title>
    
    <!-- Social Media Meta Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($business['name']); ?> - OMFID">
    <meta property="og:description" content="<?php echo htmlspecialchars($business['description']); ?>">
    <meta property="og:image" content="https://omfid.com/assets/preview.jpg">
    <meta property="og:url" content="https://omfid.com/<?php echo htmlspecialchars($omf_id); ?>">
    
    <style>
        /* CSS Variables */
        :root {
            --primary-color: <?php echo $business['color_primary']; ?>;
            --secondary-color: <?php echo $business['color_secondary']; ?>;
            --gradient: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            --text-white: #ffffff;
            --text-dark: #1a202c;
            --text-gray: #4a5568;
            --text-light-gray: #718096;
            --bg-white: #ffffff;
            --bg-light: #f7fafc;
            --border-light: #e2e8f0;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        /* Dark mode variables */
        [data-theme="dark"] {
            --text-white: #f7fafc;
            --text-dark: #f7fafc;
            --text-gray: #cbd5e1;
            --text-light-gray: #94a3b8;
            --bg-white: #1a202c;
            --bg-light: #2d3748;
            --border-light: #4a5568;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.4);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* Header */
        .header {
            background: var(--bg-white);
            padding: 20px 0;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .logo img {
            width: 40px;
            height: 40px;
            margin-right: 12px;
            border-radius: 8px;
            object-fit: contain;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .theme-toggle {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            background: var(--bg-light);
        }

        .btn {
            padding: 12px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-call {
            background: var(--bg-light);
            color: var(--text-gray);
            border: 2px solid var(--border-light);
        }

        .btn-call:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .btn-primary {
            background: var(--gradient);
            color: var(--text-white);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* Hero Section */
        .hero {
            background: var(--gradient);
            color: var(--text-white);
            padding: 60px 20px;
            position: relative;
        }

        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 60px;
            align-items: center;
        }

        .hero-text h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 16px;
            line-height: 1.1;
        }

        .hero-subtitle {
            font-size: 18px;
            opacity: 0.9;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .business-type {
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            display: inline-block;
            margin-bottom: 20px;
        }

        .hero-meta {
            display: flex;
            gap: 30px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            opacity: 0.9;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .hero-btn {
            padding: 14px 28px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .hero-btn.primary {
            background: var(--text-white);
            color: var(--primary-color);
        }

        .hero-btn.secondary {
            background: rgba(255, 255, 255, 0.2);
            color: var(--text-white);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .hero-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        /* Hero Image Placeholder */
        .hero-image {
            background: rgba(255, 255, 255, 0.1);
            border: 2px dashed rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            aspect-ratio: 4/3;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-white);
            font-size: 18px;
            font-weight: 600;
        }

        .hero-image small {
            margin-top: 8px;
            opacity: 0.7;
            font-size: 14px;
        }

        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: -40px auto 60px;
            padding: 0 20px;
            position: relative;
            z-index: 10;
        }

        /* Menu Section */
        .menu-section {
            background: var(--bg-white);
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow);
            margin-bottom: 40px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 36px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 16px;
        }

        .section-subtitle {
            font-size: 18px;
            color: var(--text-gray);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Menu Grid */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }

        .menu-item {
            background: var(--bg-light);
            border-radius: 16px;
            padding: 24px;
            transition: all 0.3s ease;
            border: 1px solid var(--border-light);
        }

        .menu-item:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
        }

        .menu-item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            gap: 16px;
        }

        .menu-item-name {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
            line-height: 1.3;
        }

        .menu-item-price {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
            white-space: nowrap;
        }

        .menu-item-description {
            color: var(--text-gray);
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 16px;
        }

        .menu-item-tags {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .tag {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            border: 1px solid;
        }

        .tag.vegetarian {
            background: rgba(72, 187, 120, 0.1);
            color: #38a169;
            border-color: rgba(72, 187, 120, 0.3);
        }

        .tag.popular {
            background: rgba(237, 137, 54, 0.1);
            color: #dd6b20;
            border-color: rgba(237, 137, 54, 0.3);
        }

        .tag.spicy {
            background: rgba(245, 101, 101, 0.1);
            color: #e53e3e;
            border-color: rgba(245, 101, 101, 0.3);
        }

        .tag.premium {
            background: rgba(159, 122, 234, 0.1);
            color: #805ad5;
            border-color: rgba(159, 122, 234, 0.3);
        }

        .tag.signature {
            background: rgba(56, 178, 172, 0.1);
            color: #319795;
            border-color: rgba(56, 178, 172, 0.3);
        }

        /* Gallery Section */
        .gallery-section {
            background: var(--bg-white);
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow);
            margin-bottom: 40px;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .gallery-item {
            background: var(--bg-light);
            border: 2px dashed var(--border-light);
            border-radius: 12px;
            aspect-ratio: 16/9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-light-gray);
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .gallery-item:hover {
            border-color: var(--primary-color);
            background: var(--bg-white);
            transform: translateY(-2px);
        }

        .gallery-item.square { aspect-ratio: 1/1; }
        .gallery-item.portrait { aspect-ratio: 3/4; }
        .gallery-item.wide { aspect-ratio: 21/9; }

        /* Footer */
        .footer {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-light-gray);
            font-size: 14px;
        }

        .footer a {
            color: var(--primary-color);
            text-decoration: none;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 20px;
            }

            .hero-content {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
            }

            .hero-text h1 {
                font-size: 32px;
            }

            .hero-meta {
                justify-content: center;
            }

            .menu-grid {
                grid-template-columns: 1fr;
            }

            .section-title {
                font-size: 28px;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <a href="/" class="logo">
                <img src="/assets/logo.jpg" alt="OMFID Logo">
                OMF:ID
            </a>
            <div class="header-actions">
                <button class="theme-toggle" id="themeToggle">
                    <span class="theme-icon">🌙</span>
                </button>
                <a href="tel:+6621234567" class="btn btn-call">📞 Call</a>
                <a href="https://make.openmenuformat.com" target="_blank" class="btn btn-primary">+ Create Menu</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <div class="business-type"><?php echo $business['type']; ?></div>
                <h1><?php echo htmlspecialchars($business['name']); ?></h1>
                <p class="hero-subtitle"><?php echo htmlspecialchars($business['subtitle']); ?></p>
                
                <div class="hero-meta">
                    <div class="meta-item">📍 <?php echo htmlspecialchars($business['address']); ?></div>
                    <div class="meta-item">🕐 <?php echo htmlspecialchars($business['hours']); ?></div>
                </div>
                
                <div class="hero-actions">
                    <button class="hero-btn primary" onclick="handleCall()">📞 Call Now</button>
                    <button class="hero-btn secondary" onclick="document.querySelector('.menu-section').scrollIntoView({behavior:'smooth'})">📖 View Menu</button>
                    <button class="hero-btn secondary" onclick="handleDirections()">📍 Directions</button>
                </div>
            </div>
            
            <div class="hero-image">
                📸 Hero Image
                <small>(1200x600px recommended)</small>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Menu Section -->
        <section class="menu-section">
            <div class="section-header">
                <h2 class="section-title"><?php echo htmlspecialchars($business['menu_section']['title']); ?></h2>
                <p class="section-subtitle"><?php echo htmlspecialchars($business['menu_section']['subtitle']); ?></p>
            </div>
            
            <div class="menu-grid">
                <?php foreach ($business['menu_section']['items'] as $item): ?>
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
                                <span class="tag <?php echo strtolower(str_replace([' ', "'"], ['-', ''], $tag)); ?>">
                                    <?php echo htmlspecialchars($tag); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Gallery Section -->
        <?php if (!empty($business['gallery'])): ?>
            <section class="gallery-section">
                <div class="section-header">
                    <h2 class="section-title">📸 Gallery</h2>
                </div>
                <div class="gallery-grid">
                    <?php foreach ($business['gallery'] as $title => $layout): ?>
                        <div class="gallery-item <?php echo strtolower($layout); ?>">
                            📸 <?php echo htmlspecialchars($title); ?>
                            <small><?php echo $layout; ?></small>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>Powered by <a href="https://openmenuformat.com" target="_blank">Open Menu Format</a> • Made with the <strong>Snack House</strong> template</p>
    </footer>

    <script>
        // Dark Mode Toggle - SAME TOKEN AS HOMEPAGE
        function initializeDarkMode() {
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = themeToggle.querySelector('.theme-icon');

            // Use EXACT SAME localStorage key as homepage
            const savedTheme = localStorage.getItem('darkMode') === 'true';
            const theme = savedTheme ? 'dark' : 'light';
            
            document.documentElement.setAttribute('data-theme', theme);
            updateThemeIcon(theme);

            themeToggle.addEventListener('click', () => {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                // Update DOM immediately
                document.documentElement.setAttribute('data-theme', newTheme);
                
                // Save using EXACT SAME key as homepage
                localStorage.setItem('darkMode', newTheme === 'dark');
                
                updateThemeIcon(newTheme);
                
                console.log('🌙 Theme synced:', newTheme, 'darkMode:', newTheme === 'dark');
            });

            function updateThemeIcon(theme) {
                themeIcon.textContent = theme === 'dark' ? '☀️' : '🌙';
            }
        }

        // Initialize dark mode when page loads
        document.addEventListener('DOMContentLoaded', initializeDarkMode);

        // Business Actions
        function handleCall() {
            window.location.href = 'tel:+6621234567';
        }
        
        function handleDirections() {
            const address = encodeURIComponent('<?php echo $business["name"] . " " . $business["address"]; ?>');
            window.open(`https://maps.google.com/?q=${address}`, '_blank');
        }
    </script>
</body>
</html>