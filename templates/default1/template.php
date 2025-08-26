<?php
// Default1 Template - templates/default1/template.php
// Dynamic template that uses $business data from view.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($business['name']); ?> - OMF:ID</title>
    
    <!-- Favicon and Meta Tags -->
    <link rel="icon" type="image/x-icon" href="https://omfid.com/assets/favicon.ico">
    <meta property="og:title" content="<?php echo htmlspecialchars($business['name']); ?> - OMF:ID">
    <meta property="og:description" content="<?php echo htmlspecialchars($business['description']); ?>">
    <meta property="og:image" content="https://omfid.com/assets/preview-business.jpg">
    <meta property="og:url" content="https://omfid.com/<?php echo htmlspecialchars($omf_id); ?>">
    
    <!-- Shared CSS Variables (same as homepage) -->
    <link rel="stylesheet" href="/css/variables.css">
    
    <!-- Template-specific styles -->
    <style>
        /* Business page specific styles */
        .omfid-header {
            background: var(--bg-primary);
            backdrop-filter: blur(20px);
            box-shadow: 0 2px 20px var(--shadow-light);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            transition: all 0.3s ease;
            border-bottom: 1px solid var(--border-color);
        }

        .omfid-nav {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .omfid-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .omfid-logo:hover {
            transform: scale(1.05);
        }

        .omfid-logo-img {
            height: 40px;
            width: 40px;
            border-radius: 8px;
            transition: all 0.3s ease;
            object-fit: contain;
            display: block;
        }

        .omfid-actions {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .omfid-btn {
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .omfid-btn.primary {
            background: var(--gradient);
            color: white;
        }

        .omfid-btn.secondary {
            background: var(--bg-tertiary);
            color: var(--text-secondary);
            border: 2px solid var(--border-color);
        }

        .omfid-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--shadow-medium);
        }

        .theme-toggle {
            background: var(--bg-tertiary);
            border: 2px solid var(--border-color);
            color: var(--text-primary);
            font-size: 18px;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            border-color: var(--primary);
            transform: scale(1.05);
        }

        /* Hero Section */
        .hero {
            position: relative;
            height: 75vh;
            min-height: 500px;
            background: var(--gradient);
            display: flex;
            align-items: center;
            color: white;
            position: relative;
        }

        .hero-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .business-type {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 15px;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .hero-text h1 {
            font-size: clamp(3rem, 6vw, 5rem);
            font-weight: 900;
            margin-bottom: 25px;
            text-shadow: 0 4px 30px rgba(0,0,0,0.3);
            letter-spacing: -2px;
            line-height: 1.1;
        }

        .description {
            font-size: 1.2rem;
            opacity: 0.95;
            margin-bottom: 40px;
            max-width: 500px;
            line-height: 1.8;
            font-weight: 300;
        }

        .hero-meta {
            display: flex;
            gap: 35px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
            opacity: 0.95;
            font-weight: 500;
        }

        .hero-actions {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .hero-btn {
            padding: 18px 35px;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .hero-btn.primary {
            background: white;
            color: var(--primary);
        }

        .hero-btn.secondary {
            background: rgba(255,255,255,0.15);
            color: white;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .hero-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }

        .hero-image-placeholder {
            width: 100%;
            height: 400px;
            background: rgba(255,255,255,0.1);
            border-radius: 25px;
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

        /* Main Content */
        .main-content {
            max-width: 1400px;
            margin: -60px auto 0;
            padding: 0 30px;
            position: relative;
            z-index: 10;
        }

        .menu-section {
            background: var(--bg-primary);
            border-radius: 30px;
            padding: 60px 50px;
            margin-bottom: 80px;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--border-color);
        }

        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title {
            font-size: 3rem;
            font-weight: 900;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
            letter-spacing: -1px;
        }

        .section-subtitle {
            color: var(--text-secondary);
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
            gap: 30px;
        }

        .menu-item {
            background: var(--bg-tertiary);
            border-radius: 20px;
            padding: 30px;
            transition: all 0.4s ease;
            border: 1px solid var(--border-color);
            cursor: pointer;
        }

        .menu-item:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 25px 50px var(--shadow-medium);
            border-color: var(--primary);
        }

        .menu-item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .menu-item-name {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-primary);
            flex: 1;
        }

        .menu-item-price {
            font-size: 1.5rem;
            font-weight: 900;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-left: 20px;
        }

        .menu-item-description {
            color: var(--text-secondary);
            font-size: 1rem;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .menu-item-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .tag {
            padding: 6px 16px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 600;
        }

        .tag.popular {
            background: rgba(255, 152, 0, 0.2);
            color: #ff9800;
            border-color: rgba(255, 152, 0, 0.3);
        }

        .tag.veg {
            background: rgba(76, 175, 80, 0.2);
            color: #4caf50;
            border-color: rgba(76, 175, 80, 0.3);
        }

        .tag.spicy {
            background: rgba(255, 68, 68, 0.2);
            color: #f44336;
            border-color: rgba(255, 68, 68, 0.3);
        }

        .gallery-flow {
            margin: 100px 0;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-template-rows: repeat(8, 80px);
            gap: 20px;
        }

        .gallery-item {
            background: var(--bg-tertiary);
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 2px dashed var(--border-color);
            color: var(--text-muted);
            font-size: 16px;
            font-weight: 600;
            transition: all 0.5s ease;
            cursor: pointer;
            text-align: center;
        }

        .gallery-item:hover {
            border-color: var(--primary);
            transform: scale(1.05);
            box-shadow: 0 20px 40px var(--shadow-medium);
        }

        .footer {
            text-align: center;
            padding: 50px 30px 30px;
            color: var(--text-secondary);
            background: var(--bg-primary);
            margin-top: 100px;
            border-top: 1px solid var(--border-color);
        }

        .footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        /* Mobile Responsive */
        @media (max-width: 1024px) {
            .hero-content {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
            }

            .menu-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .omfid-nav {
                padding: 0 20px;
            }

            .main-content {
                padding: 0 20px;
            }

            .hero-text h1 {
                font-size: 2.5rem;
            }

            .menu-section {
                padding: 40px 25px;
                margin-bottom: 50px;
            }
        }

        /* Custom business colors override */
        :root {
            --primary: <?php echo $business['color_primary'] ?? '#667eea'; ?>;
            --secondary: <?php echo $business['color_secondary'] ?? '#764ba2'; ?>;
            --gradient: linear-gradient(135deg, var(--primary), var(--secondary));
        }
    </style>
</head>
<body>
    <!-- OMF:ID Header -->
    <header class="omfid-header">
        <nav class="omfid-nav">
            <a href="/" class="omfid-logo">
                <img src="/assets/logo.jpg" alt="OMF:ID" class="omfid-logo-img">
            </a>
            <div class="omfid-actions">
                <button class="theme-toggle" onclick="ThemeManager.toggle()">
                    <span class="theme-icon">🌙</span>
                </button>
                <a href="tel:<?php echo $business['phone']; ?>" class="omfid-btn secondary">📞 Call</a>
                <a href="https://make.openmenuformat.com" target="_blank" class="omfid-btn primary">+ Create Menu</a>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <div class="business-type"><?php echo $business['type']; ?></div>
                <h1><?php echo htmlspecialchars($business['name']); ?></h1>
                <p class="description"><?php echo htmlspecialchars($business['description']); ?></p>
                <div class="hero-meta">
                    <div class="meta-item">📍 <?php echo htmlspecialchars($business['address']); ?></div>
                    <div class="meta-item">🕐 <?php echo htmlspecialchars($business['hours'] ?? 'Check hours'); ?></div>
                </div>
                <div class="hero-actions">
                    <a href="tel:<?php echo $business['phone']; ?>" class="hero-btn primary">📞 Call Now</a>
                    <a href="#menu" class="hero-btn secondary">📖 View Menu</a>
                    <a href="#" class="hero-btn secondary" onclick="getDirections()">📍 Directions</a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-image-placeholder" data-upload-zone="hero">
                    📸 Hero Image<br>
                    <small style="margin-top: 10px; opacity: 0.8;">(1200x600px recommended)</small>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Menu Section -->
        <section id="menu" class="menu-section">
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
                        <?php
                        $tagClass = '';
                        if (in_array(strtolower($tag), ['popular', 'bestseller'])) $tagClass = 'popular';
                        elseif (in_array(strtolower($tag), ['vegetarian', 'vegan', 'veg'])) $tagClass = 'veg';
                        elseif (in_array(strtolower($tag), ['spicy', 'hot'])) $tagClass = 'spicy';
                        ?>
                        <span class="tag <?php echo $tagClass; ?>"><?php echo htmlspecialchars($tag); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Gallery Flow -->
        <section class="gallery-flow">
            <div class="gallery-grid">
                <?php
                $galleryItems = $business['gallery'] ?? [];
                $index = 1;
                foreach ($galleryItems as $title => $orientation):
                ?>
                <div class="gallery-item" data-upload-zone="gallery-<?php echo $index; ?>">
                    📸 <?php echo htmlspecialchars($title); ?><br>
                    <small style="opacity: 0.7; margin-top: 5px;"><?php echo htmlspecialchars($orientation); ?></small>
                </div>
                <?php
                $index++;
                endforeach;
                ?>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>Powered by <a href="https://openmenuformat.com" target="_blank">Open Menu Format</a> •
         Made with the <strong>Default1</strong> template</p>
    </footer>

    <!-- Shared Theme Manager (same as homepage) -->
    <script src="/js/theme.js"></script>
    
    <!-- Business Data -->
    <script>
        window.businessData = {
            name: <?php echo json_encode($business['name']); ?>,
            address: <?php echo json_encode($business['address']); ?>,
            phone: <?php echo json_encode($business['phone']); ?>,
            omfId: <?php echo json_encode($omf_id); ?>
        };
        
        function getDirections() {
            const address = encodeURIComponent(window.businessData.name + ' ' + window.businessData.address);
            window.open(`https://maps.google.com/?q=${address}`, '_blank');
        }

        // Initialize theme on page load
        document.addEventListener('DOMContentLoaded', () => {
            ThemeManager.init();
        });
    </script>
</body>
</html>