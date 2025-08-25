// OMFID Default1 Template JavaScript
// Fixed version to handle missing elements gracefully

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 OMFID Template script loading...');
    
    initializeDarkMode();
    setupThemeToggle();
    setupSettingsDropdown();
    setupMenuAnimations();
    
    console.log('✅ OMFID Template script loaded successfully');
});

// Dark Mode System - CRITICAL: Uses same key as homepage
function initializeDarkMode() {
    try {
        const savedTheme = localStorage.getItem('darkMode') === 'true';
        const theme = savedTheme ? 'dark' : 'light';
        
        document.documentElement.setAttribute('data-theme', theme);
        updateThemeIcon(theme);
        
        console.log('🌙 Dark mode initialized:', theme);
    } catch (error) {
        console.error('Error initializing dark mode:', error);
    }
}

function setupThemeToggle() {
    const themeToggle = document.getElementById('themeToggle');
    
    if (!themeToggle) {
        console.warn('Theme toggle button not found');
        return;
    }
    
    themeToggle.addEventListener('click', () => {
        try {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            // Update DOM immediately
            document.documentElement.setAttribute('data-theme', newTheme);
            
            // Save to localStorage (SAME key as homepage)
            localStorage.setItem('darkMode', newTheme === 'dark');
            
            // Update icon
            updateThemeIcon(newTheme);
            
            console.log('🌙 Theme switched to:', newTheme);
        } catch (error) {
            console.error('Error toggling theme:', error);
        }
    });
}

function updateThemeIcon(theme) {
    const themeIcon = document.querySelector('.theme-icon');
    if (themeIcon) {
        themeIcon.textContent = theme === 'dark' ? '☀️' : '🌙';
    }
}

// Settings Dropdown
function setupSettingsDropdown() {
    const settingsBtn = document.getElementById('settingsBtn');
    const settingsMenu = document.getElementById('settingsMenu');

    if (!settingsBtn || !settingsMenu) {
        console.warn('Settings dropdown elements not found');
        return;
    }

    settingsBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        settingsMenu.classList.toggle('active');
    });

    // Close settings menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!settingsBtn.contains(e.target) && !settingsMenu.contains(e.target)) {
            settingsMenu.classList.remove('active');
        }
    });
}

// Menu Animations and Interactions
function setupMenuAnimations() {
    // Animate menu items on scroll (if they exist)
    const menuItems = document.querySelectorAll('.menu-item');
    
    if (menuItems.length === 0) {
        console.log('No menu items found for animation');
        return;
    }

    // Simple fade-in animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '50px'
    });

    menuItems.forEach((item, index) => {
        // Initial state
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        item.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        
        observer.observe(item);
    });
}

// View Toggle Functionality
function switchView(viewType) {
    const buttons = document.querySelectorAll('.toggle-btn');
    const menuGrid = document.getElementById('menuGrid');
    
    if (!menuGrid) {
        console.warn('Menu grid not found');
        return;
    }
    
    // Update button states
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Update grid layout
    if (viewType === 'list') {
        menuGrid.style.gridTemplateColumns = '1fr';
    } else {
        menuGrid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(350px, 1fr))';
    }
    
    console.log('View switched to:', viewType);
}

// Settings Functions (same as homepage)
function shareApp() {
    settingsMenu = document.getElementById('settingsMenu');
    
    if (navigator.share) {
        navigator.share({
            title: 'OMFID - Open Menu Format Directory',
            text: 'Discover amazing local businesses on OMFID!',
            url: window.location.href
        }).catch(err => console.log('Error sharing:', err));
    } else {
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Link copied to clipboard!');
        }).catch(err => {
            console.error('Failed to copy link:', err);
        });
    }
    
    if (settingsMenu) {
        settingsMenu.classList.remove('active');
    }
}

function reportIssue() {
    const settingsMenu = document.getElementById('settingsMenu');
    const subject = encodeURIComponent('Issue Report - ' + window.location.href);
    const body = encodeURIComponent('Please describe the issue you encountered:');
    
    window.open(`mailto:support@omfid.com?subject=${subject}&body=${body}`, '_blank');
    
    if (settingsMenu) {
        settingsMenu.classList.remove('active');
    }
}

function showAbout() {
    const settingsMenu = document.getElementById('settingsMenu');
    
    alert('OMFID v1.0\n\nOpen Menu Format Directory\nDiscover. Connect. Explore.\n\nPowered by Open Menu Format\n\nBuilt with ❤️ in Bangkok');
    
    if (settingsMenu) {
        settingsMenu.classList.remove('active');
    }
}

function changeLanguage() {
    const languageSelector = document.getElementById('languageSelector');
    if (languageSelector) {
        const lang = languageSelector.value;
        console.log('Language changed to:', lang);
        // In production, this would translate the content
    }
}

// Smooth scrolling for anchor links
document.addEventListener('DOMContentLoaded', function() {
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    
    anchorLinks.forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const target = document.getElementById(targetId);
            
            if (target) {
                target.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Error handling wrapper
window.addEventListener('error', function(e) {
    console.error('JavaScript error in OMFID template:', e.error);
});

// Make functions globally available
window.switchView = switchView;
window.shareApp = shareApp;
window.reportIssue = reportIssue;
window.showAbout = showAbout;
window.changeLanguage = changeLanguage;