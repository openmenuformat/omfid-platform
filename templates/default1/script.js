// Default1 Template JavaScript - templates/default1/script.js

// Dark mode functions - MUST BE DEFINED FIRST
function initializeDarkMode() {
    // Load saved theme - SAME KEY AS HOMEPAGE
    const isDark = localStorage.getItem('darkMode') === 'true';
    console.log('🌙 Initializing dark mode - isDark:', isDark, 'localStorage value:', localStorage.getItem('darkMode'));
    
    // FORCE set the data-theme attribute
    document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
    console.log('🌙 Set data-theme to:', document.documentElement.getAttribute('data-theme'));
    
    updateThemeIcon(isDark ? 'dark' : 'light');
}

function updateThemeIcon(theme) {
    const themeIcon = document.querySelector('.theme-icon');
    if (themeIcon) {
        themeIcon.textContent = theme === 'dark' ? '☀️' : '🌙';
        console.log('🌙 Updated icon to:', themeIcon.textContent);
    } else {
        console.log('🌙 Theme icon not found');
    }
}

// Business-specific functions (use window.businessData from PHP)
function getDirections() {
    if (window.businessData && window.businessData.address) {
        const address = encodeURIComponent(window.businessData.name + ' ' + window.businessData.address);
        window.open(`https://maps.google.com/?q=${address}`, '_blank');
    } else {
        showToast('Address not available');
    }
}

function shareBusiness() {
    const businessName = window.businessData ? window.businessData.name : 'this business';
    
    if (navigator.share) {
        navigator.share({
            title: businessName,
            text: `Check out ${businessName} on OMF:ID!`,
            url: window.location.href
        });
    } else {
        navigator.clipboard.writeText(window.location.href);
        showToast('Link copied to clipboard!');
    }
}

function changeLanguage() {
    const lang = document.getElementById('languageSelector').value;
    console.log('Language changed to:', lang);
    showToast(`Language switched to ${lang}`);
}

function showImageUploadModal(zoneType) {
    alert(`Image upload for ${zoneType} - Coming soon!\n\nThis will open an upload modal with size guidance.`);
}

function showToast(message) {
    const toast = document.createElement('div');
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: var(--gray-800);
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        z-index: 1000;
        font-size: 14px;
        animation: slideInUp 0.3s ease;
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOutDown 0.3s ease forwards';
        setTimeout(() => toast.remove(), 300);
    }, 2000);
}

// DOM Content Loaded - Main initialization
document.addEventListener('DOMContentLoaded', function() {
    
    console.log('🌙 DOM loaded, initializing...');
    
    // Initialize dark mode - SAME KEY AS HOMEPAGE
    initializeDarkMode();
    
    // Dark mode toggle - EXACTLY SAME AS HOMEPAGE
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        console.log('🌙 Theme toggle found, adding listener');
        themeToggle.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            console.log('🌙 Toggle clicked - current:', currentTheme, 'new:', newTheme);
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('darkMode', newTheme === 'dark');
            updateThemeIcon(newTheme);
            
            console.log('🌙 Theme updated - localStorage:', localStorage.getItem('darkMode'));
        });
    } else {
        console.log('🌙 Theme toggle NOT found!');
    }
    
    // Smooth scrolling for menu link
    const menuLink = document.querySelector('a[href="#menu"]');
    if (menuLink) {
        menuLink.addEventListener('click', function(e) {
            e.preventDefault();
            const menuSection = document.querySelector('#menu');
            if (menuSection) {
                menuSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }

    // Enhanced hover effects for menu items
    document.querySelectorAll('.menu-item').forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
        
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-15px) scale(1.05)';
            this.style.zIndex = '10';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(-10px) scale(1.03)';
            this.style.zIndex = '1';
        });
    });

    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.fade-in-on-scroll').forEach(el => {
        observer.observe(el);
    });

    // Gallery items individual animation triggers
    const galleryObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.animation = `slideInGallery 0.8s ease-out forwards`;
                }, index * 100);
            }
        });
    }, { threshold: 0.2 });

    document.querySelectorAll('.gallery-item').forEach(item => {
        item.style.opacity = '0';
        galleryObserver.observe(item);
    });

    // Header scroll effect - Updated for dark mode
    let lastScrollY = window.scrollY;
    window.addEventListener('scroll', () => {
        const header = document.querySelector('.omfid-header');
        if (header) {
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            
            if (window.scrollY > 100) {
                header.style.background = isDark 
                    ? 'rgba(30, 41, 59, 0.98)' 
                    : 'rgba(255,255,255,0.98)';
                header.style.boxShadow = '0 4px 30px rgba(0,0,0,0.12)';
            } else {
                header.style.background = isDark 
                    ? 'rgba(30, 41, 59, 0.95)' 
                    : 'rgba(255,255,255,0.95)';
                header.style.boxShadow = '0 2px 20px rgba(0,0,0,0.08)';
            }
        }
    });

    // Upload zone interactions (for future image upload feature)
    document.querySelectorAll('[data-upload-zone]').forEach(zone => {
        zone.addEventListener('click', function() {
            const zoneType = this.dataset.uploadZone;
            console.log(`Image upload for zone: ${zoneType}`);
            showImageUploadModal(zoneType);
        });
    });
    
    console.log('🌙 All initialization complete');
});

// Add toast animations to document
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInUp {
        from { transform: translateY(100%); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    @keyframes slideOutDown {
        from { transform: translateY(0); opacity: 1; }
        to { transform: translateY(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);