window.ThemeManager = {
  init() {
    const isDark = localStorage.getItem('darkMode') === 'true';
    document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
    this.updateIcon();
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