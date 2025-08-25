<?php
// templates/default1/template.php
// This file uses the $business data from view.php - RESTORED ORIGINAL LAYOUT
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
    
    <!-- Load the template CSS file -->
    <link rel="stylesheet" href="/templates/default1/style.css">
    
    <!-- 🎨 BUSINESS COLOR CUSTOMIZATION WITH DARK MODE FIX -->
    <style>
        :root {
            --primary-color: <?php echo $business['color_primary'] ?? '#667eea'; ?>;
            --secondary-color: <?php echo $business['color_secondary'] ?? '#764ba2'; ?>;
            --gradient: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        /* Dark mode color overrides - CRITICAL FIX */
        [data-theme="dark"] {
            --primary-color: <?php echo $business['color_primary_dark'] ?? '#6366f1'; ?>;
            --secondary-color: <?php echo $business['color_secondary_dark'] ?? '#8b5cf6'; ?>;
            
            /* Ensure dark mode background colors aren't overridden */
            --bg-primary: #0f172a !important;
            --bg-secondary: #1e293b !important;
            --bg-tertiary: #334155 !important;
            --text-primary: #f8fafc !important;
            --text-secondary: #cbd5e1 !important;
            --border-color: #334155 !important;
            --card-bg: #1e293b !important;
            --header-bg: #1e293b !important;
        }
    </style>
</head>
<body>
    <!-- Header with Dark Mode Toggle -->
    <header class="header">
        <div class="header-content">
            <a href="/" class="logo">
                <img src="https://omfid.com/assets/logo.jpg" alt="OMFID" class="logo-img" loading="eager">
            </a>
            <div class="header-actions">
                <button class="theme-toggle" id="themeToggle">
                    <span class="theme-icon">🌙</span>
                </button>
                
                <div class="settings-dropdown">
                    <button class="settings-btn" id="settingsBtn">
                        ⚙️ Settings
                    </button>
                    <div class="settings-menu" id="settingsMenu">
                        <div class="settings-item" onclick="shareApp()">
                            📤 Share App
                        </div>
                        <div class="settings-item" onclick="reportIssue()">
                            🐛 Report Issue
                        </div>
                        <div class="settings-item" onclick="showAbout()">
                            ℹ️ About OMFID
                        </div>
                        <div class="settings-item" onclick="window.open('https://make.openmenuformat.com', '_blank')">
                            🏪 Create Business
                        </div>
                    </div>
                </div>
                
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
                    <div class="meta-item">🕒 <?php echo htmlspecialchars($business['hours'] ?? 'Open today'); ?></div>
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
                <div class="section-info">
                    <h2 class="section-title"><?php echo htmlspecialchars($business['menu_section']['title']); ?></h2>
                    <?php if (isset($business['menu_section']['subtitle'])): ?>
                        <p class="section-subtitle"><?php echo htmlspecialchars($business['menu_section']['subtitle']); ?></p>
                    <?php endif; ?>
                </div>
                <div class="view-toggle">
                    <button class="toggle-btn active" onclick="switchView('grid')">Grid View</button>
                    <button class="toggle-btn" onclick="switchView('list')">List View</button>
                </div>
            </div>
            
            <div class="menu-grid" id="menuGrid">
                <?php if (!empty($business['menu_section']['items'])): ?>
                    <?php foreach ($business['menu_section']['items'] as $item): ?>
                        <div class="menu-item">
                            <div class="menu-item-header">
                                <div class="menu-item-name"><?php echo htmlspecialchars($item['name']); ?></div>
                                <div class="menu-item-price">฿<?php echo htmlspecialchars($item['price']); ?></div>
                            </div>
                            <div class="menu-item-description">
                                <?php echo htmlspecialchars($item['description']); ?>
                            </div>
                            <?php if (!empty($item['tags'])): ?>
                                <div class="menu-item-tags">
                                    <?php foreach ($item['tags'] as $tag): ?>
                                        <span class="tag <?php echo strtolower(str_replace([' ', "'"], ['-', ''], $tag)); ?>">
                                            <?php echo htmlspecialchars($tag); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <h3>Menu Coming Soon!</h3>
                        <p>This business hasn't uploaded their menu yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Gallery Section (Future Enhancement) -->
        <?php if (!empty($business['gallery'])): ?>
            <div class="gallery-section">
                <div class="section-header">
                    <h2 class="section-title">📸 Gallery</h2>
                </div>
                <div class="gallery-grid">
                    <?php foreach ($business['gallery'] as $title => $layout): ?>
                        <div class="gallery-item <?php echo strtolower($layout); ?>" data-upload-zone="business-gallery">
                            <div class="gallery-placeholder">
                                <div class="upload-icon">📷</div>
                                <div class="upload-text"><?php echo htmlspecialchars($title); ?></div>
                                <div class="upload-hint"><?php echo $layout; ?> Image</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- CTA Section -->
        <div class="cta-section">
            <h2>Is this your business?</h2>
            <p>Take control of your OMFID profile and keep your menu always up to date</p>
            <a href="https://make.openmenuformat.com" target="_blank" class="cta-button">Claim This Business - It's Free!</a>
        </div>
    </div>

    <!-- Load JavaScript -->
    <script src="/templates/default1/script.js"></script>
    
    <!-- Business-specific JavaScript -->
    <script>
        // Business Actions with actual data
        function handleCall() {
            window.location.href = 'tel:<?php echo htmlspecialchars($business['phone'] ?? '+6621234567'); ?>';
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
    </script>
</body>
</html>