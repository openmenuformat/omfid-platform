/* Reset and Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    background: #f8f9fa;
    color: #333;
    line-height: 1.6;
}

a {
    text-decoration: none;
    color: inherit;
}

/* Header Styles */
.header {
    background: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    position: sticky;
    top: 0;
    z-index: 100;
}

.header-content {
    max-width: 1400px;
    margin: 0 auto;
    padding: 15px 20px;
    display: flex;
    align-items: center;
    gap: 30px;
}

.logo {
    font-size: 28px;
    font-weight: bold;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.search-bar {
    flex: 1;
    max-width: 500px;
    display: flex;
    background: #f1f3f5;
    border-radius: 50px;
    overflow: hidden;
}

.search-input {
    flex: 1;
    padding: 12px 20px;
    border: none;
    background: transparent;
    font-size: 15px;
    outline: none;
}

.search-btn {
    padding: 0 20px;
    border: none;
    background: transparent;
    cursor: pointer;
    font-size: 18px;
}

.header-actions {
    display: flex;
    gap: 15px;
}

.btn {
    padding: 10px 20px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s;
    cursor: pointer;
    border: none;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
}

.btn-secondary {
    background: white;
    border: 2px solid #e9ecef;
    color: #495057;
}

.btn-secondary:hover {
    background: #f8f9fa;
}

/* Hero Section */
.hero {
    text-align: center;
    padding: 80px 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.hero h1 {
    font-size: 48px;
    margin-bottom: 20px;
    font-weight: 700;
}

.hero p {
    font-size: 20px;
    opacity: 0.9;
    margin-bottom: 40px;
}

.location-picker {
    background: white;
    color: #333;
    padding: 15px 30px;
    border-radius: 50px;
    border: none;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
}

.location-picker:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

/* Categories */
.categories {
    background: white;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    position: sticky;
    top: 70px;
    z-index: 90;
}

.categories-container {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    gap: 15px;
    overflow-x: auto;
    scrollbar-width: none;
}

.categories-container::-webkit-scrollbar {
    display: none;
}

.category-pill {
    padding: 10px 20px;
    border-radius: 25px;
    border: 2px solid #e9ecef;
    background: white;
    white-space: nowrap;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 14px;
    font-weight: 500;
}

.category-pill:hover {
    background: #f8f9fa;
}

.category-pill.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: transparent;
}

/* Main Content */
.main-content {
    max-width: 1400px;
    margin: 0 auto;
    padding: 40px 20px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.section-title {
    font-size: 28px;
    font-weight: 700;
}

.see-all {
    color: #667eea;
    font-weight: 500;
}

.see-all:hover {
    text-decoration: underline;
}

/* Featured Carousel */
.featured-carousel {
    display: flex;
    gap: 20px;
    overflow-x: auto;
    scrollbar-width: none;
    margin-bottom: 60px;
}

.featured-carousel::-webkit-scrollbar {
    display: none;
}

.featured-card {
    min-width: 400px;
    height: 200px;
    border-radius: 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 30px;
    display: flex;
    align-items: flex-end;
    position: relative;
    overflow: hidden;
    transition: transform 0.3s;
}

.featured-card:hover {
    transform: scale(1.02);
}

.featured-content {
    color: white;
    z-index: 1;
}

.featured-tag {
    display: inline-block;
    padding: 5px 12px;
    background: rgba(255,255,255,0.2);
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 10px;
}

.featured-title {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 5px;
}

.featured-desc {
    opacity: 0.9;
    margin-bottom: 10px;
}

.featured-cta {
    font-weight: 600;
}

/* Stats Bar */
.stats-bar {
    background: white;
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 60px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 30px;
    text-align: center;
}

.stat-number {
    font-size: 32px;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.stat-label {
    color: #6c757d;
    font-size: 14px;
}

/* Business Grid */
.business-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 25px;
    margin-bottom: 60px;
}

.business-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.business-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.business-image {
    height: 200px;
    background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    position: relative;
}

.business-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    padding: 5px 12px;
    background: #28a745;
    color: white;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.business-badge.new {
    background: #ff6b6b;
}

.business-content {
    padding: 20px;
}

.business-name {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 5px;
}

.business-type {
    color: #6c757d;
    font-size: 14px;
    margin-bottom: 15px;
}

.business-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
}

.rating {
    display: flex;
    align-items: center;
    gap: 5px;
}

.stars {
    color: #ffc107;
}

.distance {
    color: #6c757d;
}

/* Footer */
.footer {
    background: #212529;
    color: white;
    padding: 60px 20px 30px;
    margin-top: 100px;
}

.footer-content {
    max-width: 1400px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 40px;
    margin-bottom: 40px;
}

.footer-section h3 {
    margin-bottom: 20px;
    font-size: 18px;
}

.footer-section a {
    display: block;
    color: #adb5bd;
    margin-bottom: 10px;
    transition: color 0.3s;
}

.footer-section a:hover {
    color: white;
}

.footer-bottom {
    text-align: center;
    padding-top: 30px;
    border-top: 1px solid #495057;
    color: #adb5bd;
}

.footer-bottom p {
    margin-bottom: 10px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        gap: 15px;
    }
    
    .search-bar {
        width: 100%;
    }
    
    .header-actions {
        width: 100%;
        justify-content: space-between;
    }
    
    .hero h1 {
        font-size: 32px;
    }
    
    .hero p {
        font-size: 16px;
    }
    
    .business-grid {
        grid-template-columns: 1fr;
    }
    
    .featured-card {
        min-width: 300px;
    }
}