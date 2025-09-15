<?php

function isCurrentUserAdmin() {
    return isset($_GET['admin_key']) && $_GET['admin_key'] === 'admin123';
}
// OMFID Business Viewer - Production Ready
// Clean version with no sample data, Supabase only

// Get business ID from URL
$omf_id = $_GET['id'] ?? 'unknown';

// Supabase configuration - UPDATE THESE WITH YOUR ACTUAL VALUES
$SUPABASE_URL = "https://au.openmenuformat.com";
$SUPABASE_ANON_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtpem5jbnBodHJmbXZmeXB3c3ZiIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzQ3MDU5MDQsImV4cCI6MjA1MDI4MTkwNH0.pjBXIE317d6cFbwaDJwBVmhNXcRU2TnwbhS9jCOhrvc";

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
        error_log("Supabase API Error: HTTP $httpCode for $url");
        return null;
    }
    
    return json_decode($response, true);
}
// Admin preview override
$isAdminPreview = isset($_GET['admin_preview']) && isCurrentUserAdmin();
if ($isAdminPreview) {
    // Admin can see any business - skip normal checks
} elseif (!$business['omfid_published'] || $business['moderation_status'] !== 'approved') {
    // Normal users: only show if published AND approved
    header("Location: /");
    exit;
}
// Get business data from Supabase
$businessData = supabaseQuery(
    'business',
    'id_business,name_business,description_business,address_business,business_type,omfid_slug,image_business,hours_business',
    [
        'omfid_slug' => "eq.$omf_id",
        'moderation_status' => "eq.approved"
    ]
);

// Check if business exists
if (!$businessData || empty($businessData)) {


// DEBUG: Add this temporarily
echo "<script>console.log('DEBUG: Looking for omfid_slug = $omf_id');</script>";
echo "<script>console.log('DEBUG: businessData = " . json_encode($businessData) . "');</script>";

// Also check if Supabase is working at all
$testQuery = supabaseQuery('business', 'omfid_slug', ['limit' => '5']);
echo "<script>console.log('DEBUG: All slugs in database = " . json_encode($testQuery) . "');</script>";


    // Business not found - show 404
    http_response_code(404);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Business Not Found - OMFID</title>
        <style>
            :root {
                --primary-color: #667eea;
                --bg-primary: #ffffff;
                --bg-secondary: #f8fafc;
                --text-primary: #1e293b;
                --text-secondary: #64748b;
                --border-color: #e2e8f0;
                --transition: 0.3s ease;
            }

            [data-theme="dark"] {
                --bg-primary: #0f172a;
                --bg-secondary: #1e293b;
                --text-primary: #f8fafc;
                --text-secondary: #cbd5e1;
                --border-color: #334155;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                transition: background-color var(--transition), color var(--transition);
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                background: var(--bg-secondary);
                color: var(--text-primary);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem;
            }

            .error-container {
                text-align: center;
                max-width: 500px;
                background: var(--bg-primary);
                padding: 3rem;
                border-radius: 20px;
                border: 1px solid var(--border-color);
                box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            }

            .error-code {
                font-size: 4rem;
                font-weight: 900;
                color: var(--primary-color);
                margin-bottom: 1rem;
            }

            .error-title {
                font-size: 1.5rem;
                font-weight: 700;
                margin-bottom: 1rem;
            }

            .error-message {
                color: var(--text-secondary);
                margin-bottom: 2rem;
                line-height: 1.6;
            }

            .back-btn {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 12px 24px;
                background: var(--primary-color);
                color: white;
                text-decoration: none;
                border-radius: 12px;
                font-weight: 600;
                transition: all var(--transition);
            }

            .back-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            }

            .theme-toggle {
                position: fixed;
                top: 2rem;
                right: 2rem;
                background: var(--bg-primary);
                border: 2px solid var(--border-color);
                border-radius: 50%;
                width: 50px;
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                font-size: 20px;
                transition: all var(--transition);
            }

            .theme-toggle:hover {
                border-color: var(--primary-color);
                transform: scale(1.05);
            }
        </style>
    </head>
    <body>
        <button class="theme-toggle" id="themeToggle">
            <span class="theme-icon">🌙</span>
        </button>

        <div class="error-container">
            <div class="error-code">404</div>
            <h1 class="error-title">Business Not Found</h1>
            <p class="error-message">
                Sorry, we couldn't find a business with the ID "<strong><?php echo htmlspecialchars($omf_id); ?></strong>". 
                It may have been moved or doesn't exist yet.
            </p>
            <a href="/" class="back-btn">
                ← Back to Directory
            </a>
        </div>

        <script>
            // Theme system - same as main site
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

            ThemeManager.init();
        </script>
    </body>
    </html>
    <?php
    exit;
}

$business = $businessData[0];

// Get menu data from sections and products - PUBLIC DISPLAY ONLY
$sectionsData = supabaseQuery(
    'sections',
    'id_section,name_section,description_section',
    [
        'id_business' => "eq.{$business['id_business']}",
        'is_public_display' => 'eq.true',  // Only sections marked for public display
        'limit' => '1'
    ]
);

// DEBUG: Check what sections are marked public
echo "<script>console.log('Public sections found: " . json_encode($sectionsData) . "');</script>";

// FALLBACK: If no public sections, try first section (temporary)
if (!$sectionsData || empty($sectionsData)) {
    $sectionsData = supabaseQuery(
        'sections',
        'id_section,name_section,description_section',
        [
            'id_business' => "eq.{$business['id_business']}",
            'order' => 'created_at_section.asc',
            'limit' => '1'
        ]
    );
    echo "<script>console.log('Fallback sections found: " . json_encode($sectionsData) . "');</script>";
}

// DEBUG: Add these lines right here
echo "<script>console.log('Business ID: {$business['id_business']}');</script>";
echo "<script>console.log('Sections found: " . json_encode($sectionsData) . "');</script>";

$menuData = [
    'section_name' => 'Our Services',
    'items' => []
];

// If we have sections, get products for the first section
if ($sectionsData && !empty($sectionsData)) {
    $firstSection = $sectionsData[0];
    $menuData['section_name'] = $firstSection['name_section'];
    
    $productsData = supabaseQuery(
        'products',
        'name_product,description_product,price_product',
        [
            'id_section' => "eq.{$firstSection['id_section']}",
            'order' => 'created_at_product.asc'
        ]
    );

$productsData = supabaseQuery(
        'products',
        'name_product,description_product,price_product',
        [
            'id_section' => "eq.{$firstSection['id_section']}",
            'order' => 'created_at_product.asc'
        ]
    );
    
    // DEBUG: Add this line right here
    echo "<script>console.log('Products found: " . json_encode($productsData) . "');</script>";

    
    if ($productsData && !empty($productsData)) {
        $menuData['items'] = $productsData;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($business['name_business']); ?> - OMFID</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="/assets/logo.jpg">
    
    <!-- Social Media Meta Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($business['name_business']); ?> - OMFID">
    <meta property="og:description" content="<?php echo htmlspecialchars($business['description_business']); ?>">
    <meta property="og:url" content="https://omfid.com/<?php echo htmlspecialchars($omf_id); ?>">
    
    <style>
        /* CRITICAL: Same CSS variables as homepage */

/* Footer */

..footer-section {
    text-align: center;
}

.footer-section h3 {
    text-align: center;
    margin-bottom: 1rem;
    color: var(--text-primary);
}


.footer-section a {
    color: var(--text-secondary);
    text-decoration: none;
    display: block;
    margin-bottom: 0.5rem;
    transition: all var(--transition);
    text-align: center;
}

.footer-bottom {
    text-align: center;
    padding-top: 2rem;
    margin-top: 2rem;
    border-top: 1px solid var(--border-color);
    color: var(--text-secondary);
}

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


        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --accent-color: #667eea;
            --gradient: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #f1f5f9;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --border-color: #e2e8f0;
            --card-bg: #ffffff;
            --header-bg: rgba(255, 255, 255, 0.95);
            
            --shadow-light: rgba(0, 0, 0, 0.05);
            --shadow-medium: rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.1);
            --transition: 0.3s ease;
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
            --header-bg: rgba(30, 41, 59, 0.95);
            
            --shadow-light: rgba(0, 0, 0, 0.3);
            --shadow-medium: rgba(0, 0, 0, 0.4);
            --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.4);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: background-color var(--transition), color var(--transition), border-color var(--transition);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            background: var(--bg-secondary);
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
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex !important;
            align-items: center !important;
            text-decoration: none !important;
            transition: all var(--transition) !important;
        }

        .logo:hover {
            transform: scale(1.05) !important;
        }

        .logo-img {
            height: 35px !important;
            width: auto !important;
            border-radius: 6px !important;
            object-fit: contain !important;
        }

        [data-theme="dark"] .logo-img {
            filter: brightness(1.1) contrast(1.1) !important;
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
            transition: all var(--transition);
            font-size: 18px;
            color: var(--text-primary);
        }

        .theme-toggle:hover {
            border-color: var(--accent-color);
            transform: scale(1.05);
        }

        .action-btn {
            padding: 8px 16px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 2px solid transparent;
        }

        .action-btn.secondary {
            background: var(--bg-tertiary);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        .action-btn.secondary:hover {
            border-color: var(--accent-color);
            transform: translateY(-2px);
        }

        /* Hero Section */
        .business-hero {
            background: var(--gradient);
            color: white;
            padding: 60px 20px;
            position: relative;
        }

        .hero-content {
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
            transition: all var(--transition);
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
            text-shadow: 0 2px 20px rgba(0,0,0,0.3);
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
            transition: all var(--transition);
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

        .action-btn-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }

        /* Hero Image Placeholder */
        .hero-visual {
            display: flex;
            justify-content: center;
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
            overflow: hidden;
        }

        .hero-image-placeholder:hover {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.6);
            transform: scale(1.02);
        }

        /* Main Content */
        .container {
            max-width: 1200px;
            margin: -30px auto 50px;
            padding: 0 20px;
            position: relative;
            z-index: 10;
        }

        .menu-section {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow-xl);
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
            line-height: 1.6;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
        }

        .menu-item {
            background: var(--bg-tertiary);
            border-radius: 15px;
            padding: 25px;
            transition: all var(--transition);
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

        /* Empty State */
        .coming-soon {
            text-align: center;
            padding: 60px 20px;
            background: var(--bg-tertiary);
            border-radius: 15px;
            border: 2px dashed var(--border-color);
        }

        .coming-soon h3 {
            color: var(--text-secondary);
            margin-bottom: 15px;
            font-size: 24px;
        }

        .coming-soon p {
            color: var(--text-muted);
            font-size: 16px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .hero-content {
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

            .logo-img {
                height: 28px !important;
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
            <div class="header-actions">
                <button class="theme-toggle" id="themeToggle">
                    <span class="theme-icon">🌙</span>
                </button>
                <a href="https://make.openmenuformat.com" target="_blank" class="action-btn secondary">📱 Create Menu</a>
            </div>
        </div>
    </header>

    <!-- Business Hero -->
    <div class="business-hero">
        <div class="hero-content">
            <div class="business-info">
                <a href="/" class="back-button">← Back to Directory</a>
                <div class="business-type"><?php echo htmlspecialchars($business['business_type']); ?></div>
                <h1><?php echo htmlspecialchars($business['name_business']); ?></h1>
                <p class="business-description"><?php echo htmlspecialchars($business['description_business']); ?></p>
                
                <div class="business-meta">
                    <div class="meta-item">📍 <?php echo htmlspecialchars($business['address_business']); ?></div>
                    <?php if (!empty($business['hours_business'])): ?>
                    <div class="meta-item">⏰ <?php echo htmlspecialchars($business['hours_business']); ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="quick-actions">
                    <button class="action-btn-hero primary" onclick="handleDirections()">🧭 Directions</button>
                </div>
            </div>
            
            <div class="hero-visual">
                <div class="hero-image-placeholder">
                    <?php if (!empty($business['image_business'])): ?>
                        <img src="<?php echo htmlspecialchars($business['image_business']); ?>" 
                             alt="<?php echo htmlspecialchars($business['name_business']); ?>"
                             style="width: 100%; height: 100%; object-fit: cover; border-radius: 20px;">
                    <?php else: ?>
                        📸 Hero Image<br>
                        <small style="margin-top: 10px; opacity: 0.8;">(1000x1000px recommended)</small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Container -->
    <div class="container">
        <div class="menu-section" id="services">
            <div class="section-header">
                <h2 class="section-title">Our Services</h2>
                <p class="section-subtitle"><?php echo htmlspecialchars($business['description_business']); ?></p>
            </div>
            
            <?php if (!empty($menuData['items'])): ?>
                <div class="menu-grid">
                    <?php foreach ($menuData['items'] as $item): ?>
                    <div class="menu-item">
                        <div class="menu-item-header">
                            <div class="menu-item-name"><?php echo htmlspecialchars($item['name_product']); ?></div>
                            <div class="menu-item-price">฿<?php echo htmlspecialchars($item['price_product']); ?></div>
                        </div>
                        <div class="menu-item-description">
                            <?php echo htmlspecialchars($item['description_product']); ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="coming-soon">
                    <h3>Menu Coming Soon!</h3>
                    <p>This business is setting up their OMF menu. Check back soon!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Theme Manager - EXACTLY same as homepage
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

        // Business Actions
        function handleDirections() {
            const businessName = <?php echo json_encode($business['name_business']); ?>;
            const address = <?php echo json_encode($business['address_business']); ?>;
            const query = encodeURIComponent(businessName + ' ' + address);
            window.open(`https://maps.google.com/?q=${query}`, '_blank');
        }

        // Initialize theme on page load
        ThemeManager.init();
    </script>


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
            <p>&copy; 2025 OMFID - Part of the <a href="https://openmenuformat.com" target="_blank">Open Menu Format</a> ecosystem</p>
            <p>Made with ❤️ in Burbank and Bangkok</p>
        </div>
    </footer>

    <script>


</body>
</html>