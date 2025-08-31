<?php
// Homepage with Dynamic Business Listings
// Same Supabase config as view.php
$SUPABASE_URL = "https://au.openmenuformat.com";
$SUPABASE_ANON_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtpem5jbnBodHJmbXZmeXB3c3ZiIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzQ3MDU5MDQsImV4cCI6MjA1MDI4MTkwNH0.pjBXIE317d6cFbwaDJwBVmhNXcRU2TnwbhS9jCOhrvc";

// Same supabaseQuery function as view.php
function supabaseQuery($table, $select = '*', $filters = []) {
    global $SUPABASE_URL, $SUPABASE_ANON_KEY;
    
    $url = "$SUPABASE_URL/rest/v1/$table?select=" . urlencode($select);
    
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
        return [];
    }
    
    return json_decode($response, true) ?: [];
}

// Get trending businesses (approved only, newest first)
$trendingBusinesses = supabaseQuery(
    'business',
    'name_business,description_business,business_type,omfid_slug,created_at_business,image_business',
    [
        'moderation_status' => 'eq.approved',
        'order' => 'created_at_business.desc',
        'limit' => '6'
    ]
);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OMFID - Discover Menus Near You</title>
    
    <!-- Favicon and App Icons -->
    <link rel="icon" type="image/jpeg" href="/assets/logo.jpg">
    <link rel="apple-touch-icon" href="/assets/logo.jpg">
    
    <!-- Social Media Meta Tags -->
    <meta property="og:title" content="OMFID - Discover Menus Near You">
    <meta property="og:description" content="Browse restaurants, cafes, spas, and more. Updated menus, real prices, instant access.">
    <meta property="og:image" content="/assets/preview-business.jpg">
    <meta property="og:url" content="https://omfid.com">
    <meta name="twitter:card" content="summary_large_image">
    
    <style>
        /* CRITICAL: CSS Variables for Theme System */
        :root {
            /* Brand Colors */
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --accent-color: #667eea;
            --gradient: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            
            /* Light Mode Theme */
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #f1f5f9;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --border-color: #e2e8f0;
            --card-bg: #ffffff;
            --header-bg: rgba(255, 255, 255, 0.95);
            
            /* Shadows */
            --shadow-light: rgba(0, 0, 0, 0.05);
            --shadow-medium: rgba(0, 0, 0, 0.1);
            --shadow-heavy: rgba(0, 0, 0, 0.2);
            --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.1);
            
            /* Transitions */
            --transition: 0.3s ease;
        }

        /* Dark Mode Theme */
        [data-theme="dark"] {
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-tertiary: #334155;
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --border-color: #334155;
            --card-bg: #1e293b;
            --header-bg: rgba(30, 41, 59, 0.95);
            
            /* Adjusted shadows for dark mode */
            --shadow-light: rgba(0, 0, 0, 0.3);
            --shadow-medium: rgba(0, 0, 0, 0.4);
            --shadow-heavy: rgba(0, 0, 0, 0.6);
            --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.4);
        }

        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: background-color var(--transition), color var(--transition), border-color var(--transition);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background: var(--bg-secondary);
            transition: all var(--transition);
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: var(--header-bg);
            backdrop-filter: blur(20px);
            box-shadow: 0 2px 20px var(--shadow-light);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--border-color);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Logo Styles */
        .logo {
            text-decoration: none;
            flex-shrink: 0;
            transition: all var(--transition);
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo-img {
            height: 40px;
            width: 40px;
            object-fit: contain;
            border-radius: 8px;
            transition: all var(--transition);
            display: block;
        }

        [data-theme="dark"] .logo-img {
            filter: brightness(1.1) contrast(1.1);
        }

        /* Search Bar */
        .search-bar {
            flex: 1;
            display: flex;
            max-width: 600px;
        }

        .search-input {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid var(--border-color);
            border-radius: 12px 0 0 12px;
            font-size: 16px;
            outline: none;
            transition: border-color var(--transition);
            background: var(--card-bg);
            color: var(--text-primary);
        }

        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-btn {
            padding: 12px 16px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0 12px 12px 0;
            cursor: pointer;
            font-size: 16px;
            transition: all var(--transition);
        }

        .search-btn:hover {
            background: var(--secondary-color);
        }

        .header-actions {
            display: flex;
            gap: 12px;
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
            transition: all var(--transition);
            font-size: 18px;
            color: var(--text-primary);
        }

        .theme-toggle:hover {
            border-color: var(--primary-color);
            transform: scale(1.05);
        }

        .btn {
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all var(--transition);
            white-space: nowrap;
            border: 2px solid transparent;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--bg-tertiary);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        .btn-secondary:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            text-align: center;
            padding: 4rem 1rem;
            background: var(--gradient);
            color: white;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
            text-shadow: 0 2px 20px rgba(0,0,0,0.3);
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .location-picker {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 2px solid rgba(255,255,255,0.3);
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 16px;
            cursor: pointer;
            backdrop-filter: blur(15px);
            transition: all var(--transition);
        }

        .location-picker:hover {
            background: rgba(255,255,255,0.3);
            border-color: rgba(255,255,255,0.5);
        }

        /* Categories */
        .categories {
            background: var(--card-bg);
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 80px;
            z-index: 90;
        }

        .categories-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            gap: 12px;
            overflow-x: auto;
        }

        .category-pill {
            background: var(--bg-tertiary);
            border: 2px solid var(--border-color);
            padding: 10px 16px;
            border-radius: 20px;
            white-space: nowrap;
            cursor: pointer;
            transition: all var(--transition);
            color: var(--text-primary);
        }

        .category-pill.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .category-pill:hover:not(.active) {
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .see-all {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all var(--transition);
        }

        .see-all:hover {
            color: var(--secondary-color);
        }

        /* Featured Carousel */
        .featured-carousel {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .featured-card {
            background: var(--gradient);
            color: white;
            padding: 2rem;
            border-radius: 16px;
            text-decoration: none;
            transition: transform var(--transition);
        }

        .featured-card:hover {
            transform: translateY(-4px);
            color: white;
        }

        .featured-tag {
            background: rgba(255,255,255,0.2);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .featured-title {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .featured-desc {
            opacity: 0.9;
            margin-bottom: 1rem;
        }

        .featured-cta {
            font-weight: 600;
        }

        /* Business Grid */
        .business-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .business-card {
            background: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            box-shadow: var(--shadow-medium);
            transition: transform var(--transition);
            border: 1px solid var(--border-color);
        }

        .business-card:hover {
            transform: translateY(-4px);
            color: inherit;
            box-shadow: var(--shadow-xl);
        }

        .business-image {
            height: 200px;
            background: linear-gradient(135deg, var(--bg-tertiary) 0%, var(--bg-secondary) 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
        }

        .business-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: #10b981;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .business-badge.new {
            background: #f59e0b;
        }

        .business-content {
            padding: 1.5rem;
        }

        .business-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .business-type {
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .business-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .distance {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        /* Stats Bar */
        .stats-bar {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 2rem;
            margin: 3rem 0;
            box-shadow: var(--shadow-medium);
            border: 1px solid var(--border-color);
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        /* Footer */
        .footer {
            background: var(--bg-primary);
            color: var(--text-secondary);
            padding: 3rem 1rem 1rem;
            margin-top: 4rem;
            border-top: 1px solid var(--border-color);
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .footer-section h3 {
            margin-bottom: 1rem;
            color: var(--text-primary);
            text-align: center;
        }

        .footer-section a {
            color: var(--text-secondary);
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: all var(--transition);
        }

        .footer-section a:hover {
            color: var(--primary-color);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .footer-bottom a {
            color: var(--primary-color);
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .header-content {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .search-bar {
                order: 3;
                width: 100%;
                margin-top: 1rem;
            }

            .header-actions {
                gap: 8px;
            }

            .btn {
                padding: 8px 12px;
                font-size: 14px;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .main-content {
                padding: 1rem 0.5rem;
            }

            .featured-carousel {
                grid-template-columns: 1fr;
            }

            .business-grid {
                grid-template-columns: 1fr;
            }

            .logo-img {
                height: 32px;
                width: 32px;
            }
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
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="Search restaurants, cafes, spas..." id="searchInput">
                <button class="search-btn" onclick="handleSearch()">🔍</button>
            </div>
            <div class="header-actions">
                <button class="theme-toggle" id="themeToggle" title="Toggle dark mode">
                    <span class="theme-icon">🌙</span>
                </button>
                <a href="#map" class="btn btn-secondary">🗺️ Map View</a>
                <a href="https://make.openmenuformat.com" target="_blank" class="btn btn-primary">+ Add Business</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Discover Menus & Services Near You</h1>
        <p>Browse restaurants, cafes, spas, and more. Updated menus, real prices, instant access.</p>
        <button class="location-picker" onclick="pickLocation()">
            📍 Bangkok, Thailand ▼
        </button>
    </section>

    <!-- Category Pills -->
    <div class="categories">
        <div class="categories-container">
            <button class="category-pill active" onclick="filterCategory('all')">🔥 All</button>
            <button class="category-pill" onclick="filterCategory('restaurant')">🍕 Restaurants</button>
            <button class="category-pill" onclick="filterCategory('cafe')">☕ Cafes</button>
            <button class="category-pill" onclick="filterCategory('spa')">💆 Spa & Massage</button>
            <button class="category-pill" onclick="filterCategory('salon')">💅 Beauty</button>
            <button class="category-pill" onclick="filterCategory('bakery')">🥐 Bakery</button>
            <button class="category-pill" onclick="filterCategory('bar')">🍺 Bars</button>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main-content">
      
        <!-- Stats Bar -->
       <?php
// Get real counts
$totalBusinesses = count(supabaseQuery('business', 'id_business', ['moderation_status' => 'eq.approved']));
$totalProducts = count(supabaseQuery('products', 'id_product', []));
?>

<div class="stats-container">
    <div class="stat-item">
        <div class="stat-number"><?php echo number_format($totalBusinesses); ?></div>
        <div class="stat-label">Active Businesses</div>
    </div>
    <div class="stat-item">
        <div class="stat-number"><?php echo number_format($totalProducts ?: 193); ?></div>
        <div class="stat-label">Menu Items</div>
    </div>
    <div class="stat-item">
        <div class="stat-number">2</div>
        <div class="stat-label">Cities</div>
    </div>
    <div class="stat-item">
        <div class="stat-number">24/7</div>
        <div class="stat-label">Always Updated</div>
    </div>
</div>

        <!-- Trending Now -->
        <section>
            <div class="section-header">
                <h2 class="section-title">🔥 Trending Now</h2>
                <a href="#trending" class="see-all">See all →</a>
            </div>
           

<div class="business-grid">
    <?php foreach ($trendingBusinesses as $index => $business): ?>
    <a href="/<?php echo htmlspecialchars($business['omfid_slug']); ?>" class="business-card">
       <div class="business-image">
    <span class="business-badge <?php echo $index < 2 ? 'new' : ''; ?>">
        <?php echo $index < 2 ? 'NEW' : 'OPEN NOW'; ?>
    </span>
    <?php if (!empty($business['image_business'])): ?>
        <img src="<?php echo htmlspecialchars($business['image_business']); ?>" 
             alt="<?php echo htmlspecialchars($business['name_business']); ?>"
             style="width: 100%; height: 100%; object-fit: cover;">
    <?php else: ?>
        <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: var(--text-muted);">
            📸 Business Image<br><small>(1000x1000px recommended)</small>
        </div>
    <?php endif; ?>
</div>
        <div class="business-content">
            <h3 class="business-name"><?php echo htmlspecialchars($business['name_business']); ?></h3>
            <p class="business-type">
                <?php 
                $icons = ['restaurant' => '🍕', 'cafe' => '☕', 'spa' => '💆', 'snack' => '🍿'];
                $type = strtolower($business['business_type'] ?? 'restaurant');
                $icon = $icons[$type] ?? '🏪';
                echo $icon . ' ' . htmlspecialchars($business['business_type'] ?? 'Business');
                ?>
            </p>
            <div class="business-meta">
                <div class="rating">
                    <span class="stars">⭐⭐⭐⭐⭐</span>
                    <span><?php echo $index < 2 ? 'New' : '4.8 (324)'; ?></span>
                </div>
                <div class="distance"><?php echo rand(5, 25) / 10; ?> km</div>
            </div>
        </div>
    </a>
    <?php endforeach; ?>
</div>



        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>For Businesses</h3>
                <a href="https://make.openmenuformat.com" target="_blank">Add Your Business</a>
                <a href="https://openmenuformat.com">Pricing</a>
                <a href="https://openmenuformat.com">Features</a>
            </div>
            <div class="footer-section">
                <h3>Discover</h3>
                <a href="#restaurants">Restaurants</a>
                <a href="#cafes">Cafes</a>
                <a href="#spas">Spas & Massage</a>
            </div>
            <div class="footer-section">
                <h3>Company</h3>
                <a href="https://openmenuformat.com" target="_blank">About OMF</a>
                <a href="#">Blog</a>
                <a href="#">Contact</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 OMFID - Part of the <a href="https://openmenuformat.com" target="_blank">Open Menu Format</a> ecosystem</p>
            <p>Made with ❤️ in Burbank and Bangkok</p>
        </div>
    </footer>

    <script>
        // Theme Manager with proper localStorage key
        const ThemeManager = {
            init() {
                const savedTheme = localStorage.getItem('darkMode') === 'true' ? 'dark' : 'light';
                this.setTheme(savedTheme);
                this.setupToggle();
            },

            setTheme(theme) {
                document.documentElement.setAttribute('data-theme', theme);
                localStorage.setItem('darkMode', theme === 'dark');
                this.updateIcon(theme);
            },

            toggle() {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                this.setTheme(newTheme);
            },

            updateIcon(theme) {
                const themeIcon = document.querySelector('.theme-icon');
                if (themeIcon) {
                    themeIcon.textContent = theme === 'dark' ? '☀️' : '🌙';
                }
            },

            setupToggle() {
                const toggle = document.getElementById('themeToggle');
                if (toggle) {
                    toggle.addEventListener('click', () => this.toggle());
                }
            }
        };

        // Search functionality
        function handleSearch() {
            const query = document.getElementById('searchInput').value;
            if (query) {
                console.log(`Searching for: ${query}`);
                // In production, this would search the database
            }
        }

        // Category filtering
        function filterCategory(category) {
            document.querySelectorAll('.category-pill').forEach(pill => {
                pill.classList.remove('active');
            });
            event.target.classList.add('active');
            console.log('Filtering by:', category);
        }

        // Location picker
        function pickLocation() {
            console.log('Location picker clicked');
            // In production, this would open location selection
        }

        // Enter key search
        document.getElementById('searchInput')?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                handleSearch();
            }
        });

        // Initialize on DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => ThemeManager.init());
        } else {
            ThemeManager.init();
        }
    </script>
</body>
</html>