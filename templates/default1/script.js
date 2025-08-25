// Default1 Template JavaScript - templates/default1/script.js

document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize dark mode - SAME KEY AS HOMEPAGE
    initializeDarkMode();
    
    // Smooth scrolling for menu link
    const menuLink = document.querySelector('a[href="#menu"]');
    if (menuLink) {
        menuLink.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('#menu').scrollIntoView({ behavior: 'smooth' });
        });

    // Upload zone interactions (for future image upload feature)
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
    });

    // Header scroll effect - Updated for dark mode
    let lastScrollY = window.scrollY;
    window.addEventListener('scroll', () => {
        const header = document.querySelector('.omfid-header');
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
    });

    // Dark mode toggle - EXACTLY SAME AS HOMEPAGE
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = themeToggle.querySelector('.theme-icon');

    themeToggle.addEventListener('click', () => {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('darkMode', newTheme === 'dark');
        updateThemeIcon(newTheme);
    });

    function updateThemeIcon(theme) {
        themeIcon.textContent = theme === 'dark' ? '☀️' : '🌙';
    }

    function initializeDarkMode() {
        // Load saved theme - SAME KEY AS HOMEPAGE
        const isDark = localStorage.getItem('darkMode') === 'true';
        document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
        updateThemeIcon(isDark ? 'dark' : 'light');
    }
    document.querySelectorAll('[data-upload-zone]').forEach(zone => {
        zone.addEventListener('click', function() {
            const zoneType = this.dataset.uploadZone;
            console.log(`Image upload for zone: ${zoneType}`);
            // Future: Open image upload modal
            showImageUploadModal(zoneType);
        });
    });

    // Remove old theme functions since we have new ones above
});

// Future function for image upload modal
function showImageUploadModal(zoneType) {
    // This will be implemented when we add the image upload system
    alert(`Image upload for ${zoneType} - Coming soon!\n\nThis will open an upload modal with size guidance.`);
}

// Business-specific functions (use window.businessData from PHP)
function getDirections() {
    if (window.businessData && window.businessData.address) {
        const address = encodeURIComponent(window.businessData.name + ' ' + window.businessData.address);
        window.open(`https://maps.google.com/?q=${address}`, '_blank');
    }
}

// Share business function
function shareBusiness() {
    if (navigator.share && window.businessData) {
        navigator.share({
            title: window.businessData.name,
            text: `Check out ${window.businessData.name} on OMFID!`,
            url: window.location.href
        });
    } else {
        navigator.clipboard.writeText(window.location.href);
        // Show toast notification
        showToast('Link copied to clipboard!');
    }
}

// Simple toast notification
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