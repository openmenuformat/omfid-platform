<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Not Available - OMFID</title>
    
    <!-- Favicon and App Icons -->
    <link rel="icon" type="image/x-icon" href="https://omfid.com/assets/favicon.ico">
    <link rel="apple-touch-icon" href="https://omfid.com/assets/icon-180.png">
    
    <!-- Meta Tags -->
    <meta name="description" content="This menu is not available or hasn't been published yet. Create your own menu with OMFID.">
    <meta property="og:title" content="Menu Not Available - OMFID">
    <meta property="og:description" content="This menu is not available or hasn't been published yet.">
    <meta property="og:image" content="https://omfid.com/assets/preview-404.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:type" content="website">
    
    <!-- Safari Specific -->
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    
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
            --error-color: #ef4444;
            --warning-color: #f59e0b;
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
            --error-color: #ef4444;
            --warning-color: #f59e0b;
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            width: 100%;
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: 0 20px 60px var(--shadow-medium);
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .header {
            background: var(--hero-gradient);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .error-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            display: block;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        .header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .content {
            padding: 40px 30px;
            text-align: center;
        }

        .reasons {
            background: var(--bg-tertiary);
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            text-align: left;
            border: 1px solid var(--border-color);
        }

        .reasons h3 {
            color: var(--text-primary);
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .reasons ul {
            list-style: none;
            padding: 0;
        }

        .reasons li {
            padding: 8px 0;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .reasons li::before {
            content: "•";
            color: var(--accent-color);
            font-weight: bold;
            font-size: 1.2rem;
        }

        .actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: var(--hero-gradient);
            color: white;
        }

        .btn-secondary {
            background: var(--bg-tertiary);
            color: var(--text-primary);
            border: 2px solid var(--border-color);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--shadow-medium);
        }

        .btn-primary:hover {
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .footer {
            background: var(--bg-tertiary);
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid var(--border-color);
        }

        .footer p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .footer a {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 500;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .logo-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 600;
            margin-top: 10px;
        }

        .logo-link:hover {
            opacity: 0.8;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .container {
                margin: 10px;
                border-radius: 15px;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .header h1 {
                font-size: 1.5rem;
            }
            
            .content {
                padding: 30px 20px;
            }
            
            .actions {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 280px;
                justify-content: center;
            }
            
            .footer {
                padding: 15px 20px;
            }
        }

        /* Theme Toggle Button */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 20px;
            color: var(--text-primary);
            box-shadow: 0 4px 12px var(--shadow-medium);
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            transform: scale(1.1);
            border-color: var(--accent-color);
        }

        /* Back Button */
        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 25px;
            padding: 8px 16px;
            text-decoration: none;
            color: var(--text-primary);
            font-weight: 500;
            box-shadow: 0 4px 12px var(--shadow-medium);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .back-button:hover {
            transform: translateY(-2px);
            border-color: var(--accent-color);
        }

        @media (max-width: 768px) {
            .theme-toggle, .back-button {
                position: static;
                margin: 10px;
            }
            
            .mobile-controls {
                position: fixed;
                top: 10px;
                left: 50%;
                transform: translateX(-50%);
                display: flex;
                gap: 10px;
                z-index: 1000;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Controls -->
    <div class="mobile-controls">
        <a href="/" class="back-button">← Back</a>
        <button class="theme-toggle" id="themeToggle">
            <span class="theme-icon">🌙</span>
        </button>
    </div>

    <!-- Desktop Controls -->
    <a href="/" class="back-button" style="display: none;">← Back to OMFID</a>
    <button class="theme-toggle" id="themeToggleDesktop" style="display: none;">
        <span class="theme-icon">🌙</span>
    </button>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <span class="error-icon">📄</span>
            <h1>Menu Not Available</h1>
            <p>This menu is currently not accessible</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p style="color: var(--text-secondary); font-size: 1.1rem; line-height: 1.6; margin-bottom: 20px;">
                We couldn't find or display this menu right now. Here are some possible reasons:
            </p>

            <div class="reasons">
                <h3>🤔 Why isn't this menu showing?</h3>
                <ul>
                    <li>The business hasn't published their menu yet</li>
                    <li>The menu is currently under review for approval</li>
                    <li>This menu URL doesn't exist or was removed</li>
                    <li>The business has temporarily disabled their menu</li>
                </ul>
            </div>

            <p style="color: var(--text-secondary); margin-bottom: 30px;">
                If you're the business owner, make sure to toggle <strong>"Publish to OMFID"</strong> in your OMF Maker app and wait for approval.
            </p>

            <!-- Action Buttons -->
            <div class="actions">
                <a href="https://make.openmenuformat.com" target="_blank" class="btn btn-primary">
                    🏪 Create Your Menu
                </a>
                <a href="/" class="btn btn-secondary">
                    🏠 Browse Directory
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Looking for something else?</p>
            <p>
                Explore other businesses on <a href="/">OMFID</a> or learn more about 
                <a href="https://openmenuformat.com" target="_blank">Open Menu Format</a>
            </p>
            
            <a href="https://openmenuformat.com" target="_blank" class="logo-link">
                🔗 Powered by Open Menu Format
            </a>
        </div>
    </div>

    <script>
        // Dark Mode Toggle (Same localStorage key as homepage)
        function initTheme() {
            const savedTheme = localStorage.getItem('darkMode') === 'true' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            updateThemeIcons(savedTheme);
        }

        function updateThemeIcons(theme) {
            const icons = document.querySelectorAll('.theme-icon');
            icons.forEach(icon => {
                icon.textContent = theme === 'dark' ? '☀️' : '🌙';
            });
        }

        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('darkMode', newTheme === 'dark');
            updateThemeIcons(newTheme);
        }

        // Initialize theme on page load
        initTheme();

        // Add event listeners to both theme toggles
        document.getElementById('themeToggle').addEventListener('click', toggleTheme);
        document.getElementById('themeToggleDesktop').addEventListener('click', toggleTheme);

        // Show appropriate controls based on screen size
        function updateControlsVisibility() {
            const isMobile = window.innerWidth <= 768;
            const mobileControls = document.querySelector('.mobile-controls');
            const desktopBack = document.querySelector('.back-button[style*="display: none"]');
            const desktopTheme = document.getElementById('themeToggleDesktop');
            
            if (isMobile) {
                mobileControls.style.display = 'flex';
                desktopBack.style.display = 'none';
                desktopTheme.style.display = 'none';
            } else {
                mobileControls.style.display = 'none';
                desktopBack.style.display = 'inline-flex';
                desktopTheme.style.display = 'flex';
            }
        }

        // Update visibility on load and resize
        updateControlsVisibility();
        window.addEventListener('resize', updateControlsVisibility);

        // Optional: Track 404 visits for analytics
        if (typeof gtag !== 'undefined') {
            gtag('event', 'page_view', {
                page_title: 'Menu Not Found',
                page_location: window.location.href
            });
        }

        // Optional: Auto-redirect after certain time (disabled by default)
        // setTimeout(() => {
        //     window.location.href = '/';
        // }, 10000); // Redirect to homepage after 10 seconds
    </script>
</body>
</html>