// Dashboard animations and interactions

document.addEventListener('DOMContentLoaded', function() {
    
    // Animate cards on load
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Update current time
    function updateTime() {
        const now = new Date();
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        const timeString = now.toLocaleDateString('id-ID', options);
        
        const timeElement = document.getElementById('current-time');
        if (timeElement) {
            timeElement.textContent = timeString;
        }
    }
    
    // Add time element if not exists
    if (!document.getElementById('current-time')) {
        const header = document.querySelector('.content .header');
        if (header) {
            const timeElement = document.createElement('div');
            timeElement.id = 'current-time';
            timeElement.style.cssText = 'color: var(--gray); font-size: 14px; margin-top: 5px;';
            header.appendChild(timeElement);
            updateTime();
            setInterval(updateTime, 1000);
        }
    }
    
    // Add hover effects to tables
    const tableRows = document.querySelectorAll('table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.3s ease';
        });
    });
    
    // Form validation styling
    const formInputs = document.querySelectorAll('input[required], select[required], textarea[required]');
    formInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.style.borderColor = 'var(--danger)';
                this.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';
            } else {
                this.style.borderColor = 'var(--success)';
                this.style.boxShadow = '0 0 0 3px rgba(16, 185, 129, 0.1)';
            }
        });
        
        input.addEventListener('input', function() {
            if (this.value) {
                this.style.borderColor = 'var(--primary)';
                this.style.boxShadow = '0 0 0 3px rgba(59, 130, 246, 0.1)';
            }
        });
    });
    
    // Smooth scroll for sidebar
    document.querySelectorAll('.sidebar a').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href.startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
    
    // Add loading animation to buttons
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', function() {
            if (this.type === 'submit' || this.href) {
                this.innerHTML = `<i class="fas fa-spinner fa-spin"></i> ${this.textContent}`;
                setTimeout(() => {
                    this.innerHTML = this.getAttribute('data-original') || this.innerHTML;
                }, 2000);
            }
        });
    });
    
    // Dark mode toggle (optional)
    const darkModeToggle = document.createElement('button');
    darkModeToggle.innerHTML = '<i class="fas fa-moon"></i>';
    darkModeToggle.style.cssText = 'position: fixed; bottom: 20px; right: 20px; width: 50px; height: 50px; border-radius: 50%; background: var(--primary); color: white; border: none; cursor: pointer; z-index: 1000; box-shadow: var(--shadow-lg);';
    document.body.appendChild(darkModeToggle);
    
    darkModeToggle.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
        this.innerHTML = document.body.classList.contains('dark-mode') ? 
            '<i class="fas fa-sun"></i>' : 
            '<i class="fas fa-moon"></i>';
    });
    
    // Add dark mode styles
    const darkModeStyles = document.createElement('style');
    darkModeStyles.textContent = `
        .dark-mode {
            background: #0f172a !important;
            color: #e2e8f0 !important;
        }
        
        .dark-mode .card {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #e2e8f0 !important;
        }
        
        .dark-mode input,
        .dark-mode select,
        .dark-mode textarea {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #e2e8f0 !important;
        }
        
        .dark-mode table {
            background: #1e293b !important;
            color: #e2e8f0 !important;
        }
        
        .dark-mode table th {
            background: #334155 !important;
        }
        
        .dark-mode table td {
            border-color: #334155 !important;
        }
        
        .dark-mode .sidebar {
            background: #111827 !important;
        }
    `;
    document.head.appendChild(darkModeStyles);
    
    // Auto-refresh dashboard data every 30 seconds
    if (window.location.pathname.includes('dashboard')) {
        setInterval(() => {
            const event = new CustomEvent('dashboardRefresh');
            window.dispatchEvent(event);
        }, 30000);
        
        window.addEventListener('dashboardRefresh', function() {
            // Simulate data refresh (in real implementation, this would be an AJAX call)
            console.log('Refreshing dashboard data...');
        });
    }
});