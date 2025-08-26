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
    
    <!-- Load Template CSS FIRST -->
    <link rel="stylesheet" href="/templates/default1/style.css">
    
    <!-- Dark Mode Initialization Script - MUST RUN BEFORE CSS -->
    <script>
        // Initialize dark mode IMMEDIATELY to prevent flash
        (function() {
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            document.documentElement.setAttribute('data-theme', isDarkMode ? 'dark' : 'light');
        })();
    </script>
    
    <!-- Custom Colors with Dark Mode Support -->
    <style>
        :root {
            --primary-color: <?php echo $business['color_primary'] ?? '#667eea'; ?>;
            --secondary-color: <?php echo $business['color_secondary'] ?? '#764ba2'; ?>;
            --gradient: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }
        
        /* Dark mode custom colors - IMPORTANT: This overrides the defaults */
        [data-theme="dark"] {
            --primary-color: <?php echo $business['color_primary'] ?? '#6366f1'; ?>;
            --secondary-color: <?php echo $business['color_secondary'] ?? '#8b5cf6'; ?>;
            --gradient: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
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
                <button class="omfid-btn secondary theme-toggle" id="themeToggle">
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
        <!-- Menu Section - Single Section Only -->
        <section id="menu" class="menu-section fade-in-on-scroll">
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

    <!-- Load Template JavaScript -->
    <script src="/templates/default1/script.js"></script>
    
    <!-- Business Data for JavaScript -->
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
    </script>
<script>
// Force dark mode application after everything loads
document.addEventListener('DOMContentLoaded', function() {
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    console.log('Force applying theme:', isDarkMode ? 'dark' : 'light');
    document.documentElement.setAttribute('data-theme', isDarkMode ? 'dark' : 'light');
    
    // Update the theme icon
    const themeIcon = document.querySelector('.theme-icon');
    if (themeIcon) {
        themeIcon.textContent = isDarkMode ? '☀️' : '🌙';
    }
});
</script>
</body>
</html>