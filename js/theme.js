// Universal Theme Manager for OMFID Platform
// Works across homepage (index.html) and business pages (view.php)

const ThemeManager = {
    // Initialize theme system
    init() {
        // Load saved theme preference
        const savedTheme = localStorage.getItem('darkMode') === 'true' ? 'dark' : 'light';
        this.setTheme(savedTheme);
        this.updateIcon(savedTheme);
        
        // Set up theme toggle listener
        this.setupToggle();
        
        // Listen for system theme changes
        this.setupSystemThemeListener();
    },

    // Set the theme
    setTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('darkMode', theme === 'dark');
        
        // Update meta theme-color for mobile browsers
        this.updateMetaThemeColor(theme);
        
        // Dispatch custom event for other components
        document.dispatchEvent(new CustomEvent('themechange', { 
            detail: { theme } 
        }));
    },

    // Toggle between light and dark themes
    toggle() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        this.setTheme(newTheme);
        this.updateIcon(newTheme);
        
        // Add a subtle animation effect
        document.body.style.transition = 'background-color 0.3s ease, color 0.3s ease';
        setTimeout(() => {
            document.body.style.transition = '';
        }, 300);
    },

    // Update theme toggle icon
    updateIcon(theme) {
        const themeIcons = document.querySelectorAll('.theme-icon');
        themeIcons.forEach(icon => {
            icon.textContent = theme === 'dark' ? '☀️' : '🌙';
            
            // Add rotation animation
            icon.style.transform = 'rotate(180deg)';
            setTimeout(() => {
                icon.style.transform = '';
            }, 200);
        });
    },

    // Set up toggle button listeners
    setupToggle() {
        const themeToggles = document.querySelectorAll('.theme-toggle, [data-theme-toggle]');
        themeToggles.forEach(toggle => {
            toggle.addEventListener('click', () => this.toggle());
            
            // Add hover effect
            toggle.addEventListener('mouseenter', () => {
                toggle.style.transform = 'scale(1.05)';
            });
            
            toggle.addEventListener('mouseleave', () => {
                toggle.style.transform = '';
            });
        });
    },

    // Listen for system theme changes
    setupSystemThemeListener() {
        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            
            // Only auto-switch if user hasn't manually set a preference
            if (!localStorage.getItem('darkMode')) {
                this.setTheme(mediaQuery.matches ? 'dark' : 'light');
                this.updateIcon(mediaQuery.matches ? 'dark' : 'light');
            }
            
            // Listen for changes (but respect manual preference)
            mediaQuery.addEventListener('change', (e) => {
                if (!localStorage.getItem('darkMode')) {
                    this.setTheme(e.matches ? 'dark' : 'light');
                    this.updateIcon(e.matches ? 'dark' : 'light');
                }
            });
        }
    },

    // Update meta theme-color for mobile browsers
    updateMetaThemeColor(theme) {
        let metaThemeColor = document.querySelector('meta[name="theme-color"]');
        
        if (!metaThemeColor) {
            metaThemeColor = document.createElement('meta');
            metaThemeColor.name = 'theme-color';
            document.head.appendChild(metaThemeColor);
        }
        
        // Set appropriate theme colors
        const colors = {
            light: '#f8fafc',
            dark: '#1e293b'
        };
        
        metaThemeColor.content = colors[theme];
    },

    // Get current theme
    getCurrentTheme() {
        return document.documentElement.getAttribute('data-theme') || 'light';
    },

    // Check if dark mode is active
    isDarkMode() {
        return this.getCurrentTheme() === 'dark';
    },

    // Force a specific theme (useful for testing)
    forceTheme(theme) {
        this.setTheme(theme);
        this.updateIcon(theme);
    },

    // Reset to system preference
    resetToSystem() {
        localStorage.removeItem('darkMode');
        
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            this.setTheme('dark');
            this.updateIcon('dark');
        } else {
            this.setTheme('light');
            this.updateIcon('light');
        }
    }
};

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => ThemeManager.init());
} else {
    ThemeManager.init();
}

// Export for global access
window.ThemeManager = ThemeManager;

// Legacy support for existing code
window.toggleTheme = () => ThemeManager.toggle();
window.updateThemeIcon = (theme) => ThemeManager.updateIcon(theme);

// Add keyboard shortcut (Ctrl/Cmd + Shift + D)
document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'D') {
        e.preventDefault();
        ThemeManager.toggle();
        
        // Show a subtle notification
        if (document.body) {
            const notification = document.createElement('div');
            notification.textContent = `Switched to ${ThemeManager.isDarkMode() ? 'dark' : 'light'} mode`;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: var(--card-bg);
                color: var(--text-primary);
                padding: 12px 20px;
                border-radius: 8px;
                box-shadow: var(--shadow-xl);
                border: 1px solid var(--border-color);
                z-index: 1000;
                font-size: 14px;
                opacity: 0;
                transform: translateY(-20px);
                transition: all 0.3s ease;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.style.opacity = '1';
                notification.style.transform = 'translateY(0)';
            }, 10);
            
            // Animate out and remove
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateY(-20px)';
                setTimeout(() => notification.remove(), 300);
            }, 2000);
        }
    }
});

// Add smooth color transitions for theme changes
const style = document.createElement('style');
style.textContent = `
    /* Smooth theme transition */
    * {
        transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease !important;
    }
    
    /* Override for elements that shouldn't transition */
    .no-theme-transition,
    .no-theme-transition * {
        transition: none !important;
    }
`;
document.head.appendChild(style);