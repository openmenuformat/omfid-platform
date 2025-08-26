// Universal Theme Manager - js/theme.js
window.ThemeManager = {
    init() {
        const isDark = localStorage.getItem('darkMode') === 'true';
        document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
        this.updateIcon();
        
        // Set up event listener for theme toggle if it exists
        const themeToggle = document.getElementById('themeToggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', () => this.toggle());
        }
    },
    
    toggle() {
        const current = document.documentElement.getAttribute('data-theme');
        const newTheme = current === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('darkMode', newTheme === 'dark');
        this.updateIcon();
    },
    
    updateIcon() {
        const icon = document.querySelector('.theme-icon');
        if (icon) {
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            icon.textContent = isDark ? '☀️' : '🌙';
        }
    }
};

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => window.ThemeManager.init());
} else {
    window.ThemeManager.init();
}