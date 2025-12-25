/**
 * TRENCH CITY - GLOBAL JAVASCRIPT
 * Dark Luxury Theme - Global Pack 04 Specifications
 * Features: Bar Regeneration, AJAX Helpers, Notifications, Form Validation
 */

(function() {
    'use strict';

    // ============================================================================
    // GLOBAL CONFIGURATION
    // ============================================================================

    const TC = {
        config: {
            barUpdateInterval: 1000, // Update bars every second
            toastDuration: 5000, // Toast notifications disappear after 5 seconds
            ajaxTimeout: 30000, // AJAX requests timeout after 30 seconds
        },
        timers: {},
        initialized: false
    };

    // Make TC globally accessible
    window.TC = TC;

    // ============================================================================
    // INITIALIZATION
    // ============================================================================

    /**
     * Initialize Trench City frontend system
     */
    TC.init = function() {
        if (TC.initialized) return;

        console.log('[TC] Initializing Trench City Frontend System...');

        // Initialize components
        TC.initSidebar();
        TC.initBarRegeneration();
        TC.initSmoothScroll();
        TC.initFormValidation();
        TC.initTooltips();

        TC.initialized = true;
        console.log('[TC] Initialization complete.');
    };

    // ============================================================================
    // SIDEBAR & NAVIGATION
    // ============================================================================

    /**
     * Initialize sidebar toggle for mobile + collapsed desktop state
     */
    TC.initSidebar = function() {
        const body = document.body;
        const sidebar = document.querySelector('[data-sidebar]');
        const toggle = document.querySelector('.tc-sidebar-toggle');
        const overlay = document.querySelector('.tc-sidebar-overlay');
        const collapseBtn = document.querySelector('.tc-sidebar-collapse');

        if (!sidebar) return;

        const collapsedKey = 'tcSidebarCollapsed';
        const applyCollapsedState = (collapsed) => {
            body.classList.toggle('tc-sidebar-collapsed', collapsed);
        };

        try {
            const saved = localStorage.getItem(collapsedKey);
            if (saved === '1') {
                applyCollapsedState(true);
            }
        } catch (err) {
            console.warn('[TC] Unable to read sidebar state', err);
        }

        if (collapseBtn) {
            collapseBtn.addEventListener('click', () => {
                const collapsed = body.classList.toggle('tc-sidebar-collapsed');
                try {
                    localStorage.setItem(collapsedKey, collapsed ? '1' : '0');
                } catch (err) {
                    console.warn('[TC] Unable to persist sidebar state', err);
                }
            });
        }

        const closeMobileSidebar = () => {
            body.classList.remove('tc-sidebar-open');
        };

        if (toggle) {
            toggle.addEventListener('click', () => {
                body.classList.toggle('tc-sidebar-open');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', closeMobileSidebar);
        }

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeMobileSidebar();
            }
        });

        window.addEventListener('resize', TC.debounce(() => {
            if (window.innerWidth > 1024) {
                closeMobileSidebar();
            }
        }, 150));
    };

    // ============================================================================
    // BAR REGENERATION SYSTEM
    // ============================================================================

    /**
     * Initialize bar regeneration timers
     */
    TC.initBarRegeneration = function() {
        const bars = document.querySelectorAll('[data-bar-regen]');

        bars.forEach(bar => {
            const barType = bar.dataset.barType;
            const regenRate = parseFloat(bar.dataset.barRegen) || 1; // Points per interval
            const regenInterval = parseInt(bar.dataset.barInterval) || 60; // Seconds
            const maxValue = parseFloat(bar.dataset.barMax) || 100;
            const currentValue = parseFloat(bar.dataset.barCurrent) || 0;

            if (currentValue < maxValue) {
                TC.startBarRegeneration(bar, barType, currentValue, maxValue, regenRate, regenInterval);
            }
        });
    };

    /**
     * Start regeneration for a specific bar
     */
    TC.startBarRegeneration = function(barElement, barType, current, max, rate, interval) {
        const timerId = `bar-${barType}`;

        // Clear existing timer if any
        if (TC.timers[timerId]) {
            clearInterval(TC.timers[timerId]);
        }

        let currentValue = current;
        let secondsUntilNext = interval;

        // Update display immediately
        TC.updateBarDisplay(barElement, currentValue, max, secondsUntilNext);

        // Set up timer
        TC.timers[timerId] = setInterval(() => {
            secondsUntilNext--;

            if (secondsUntilNext <= 0) {
                // Regenerate
                currentValue = Math.min(currentValue + rate, max);
                secondsUntilNext = interval;

                // Update data attribute
                barElement.dataset.barCurrent = currentValue;

                // Stop timer if full
                if (currentValue >= max) {
                    clearInterval(TC.timers[timerId]);
                    delete TC.timers[timerId];
                }
            }

            TC.updateBarDisplay(barElement, currentValue, max, secondsUntilNext);
        }, 1000);
    };

    /**
     * Update bar display (visual and timer)
     */
    TC.updateBarDisplay = function(barElement, current, max, secondsUntilNext) {
        const percentage = (current / max) * 100;

        // Update progress bar fill
        const fill = barElement.querySelector('.bar-fill');
        if (fill) {
            fill.style.width = percentage + '%';
        }

        // Update value text
        const valueElement = barElement.querySelector('.bar-value');
        if (valueElement) {
            valueElement.textContent = `${TC.formatNumber(current, 0)} / ${TC.formatNumber(max, 0)}`;
        }

        // Update percentage text
        const textElement = barElement.querySelector('.bar-text');
        if (textElement) {
            textElement.textContent = `${Math.round(percentage)}%`;
        }

        // Update timer
        const timerElement = barElement.querySelector('.bar-timer');
        if (timerElement) {
            if (current >= max) {
                timerElement.innerHTML = '<span class="bar-timer-full">FULL</span>';
            } else {
                const timeString = TC.formatTime(secondsUntilNext);
                timerElement.textContent = `Next: ${timeString}`;
            }
        }
    };

    /**
     * Manually update a bar (e.g., after AJAX action)
     */
    TC.updateBar = function(barType, newValue) {
        const bar = document.querySelector(`[data-bar-type="${barType}"]`);
        if (!bar) return;

        const maxValue = parseFloat(bar.dataset.barMax) || 100;
        const regenRate = parseFloat(bar.dataset.barRegen) || 1;
        const regenInterval = parseInt(bar.dataset.barInterval) || 60;

        bar.dataset.barCurrent = newValue;

        // Restart regeneration if not full
        if (newValue < maxValue) {
            TC.startBarRegeneration(bar, barType, newValue, maxValue, regenRate, regenInterval);
        } else {
            // Stop regeneration if full
            const timerId = `bar-${barType}`;
            if (TC.timers[timerId]) {
                clearInterval(TC.timers[timerId]);
                delete TC.timers[timerId];
            }
            TC.updateBarDisplay(bar, newValue, maxValue, 0);
        }
    };

    // ============================================================================
    // AJAX HELPERS
    // ============================================================================

    /**
     * Make an AJAX request with built-in error handling and loading states
     */
    TC.ajax = function(options) {
        const defaults = {
            method: 'POST',
            url: '',
            data: {},
            timeout: TC.config.ajaxTimeout,
            onSuccess: null,
            onError: null,
            onComplete: null,
            showLoading: true,
            loadingTarget: null,
            showNotification: true
        };

        const settings = Object.assign({}, defaults, options);

        // Show loading overlay if target specified
        let loadingOverlay = null;
        if (settings.showLoading && settings.loadingTarget) {
            loadingOverlay = TC.showLoading(settings.loadingTarget);
        }

        // Prepare request
        const xhr = new XMLHttpRequest();
        xhr.open(settings.method, settings.url, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.timeout = settings.timeout;

        // Handle response
        xhr.onload = function() {
            if (loadingOverlay) loadingOverlay.remove();

            let response;
            try {
                response = JSON.parse(xhr.responseText);
            } catch (e) {
                response = { success: false, message: 'Invalid response from server' };
            }

            if (xhr.status >= 200 && xhr.status < 300) {
                if (response.success) {
                    if (settings.showNotification && response.message) {
                        TC.toast(response.message, 'success');
                    }
                    if (settings.onSuccess) settings.onSuccess(response);
                } else {
                    if (settings.showNotification && response.message) {
                        TC.toast(response.message, 'danger');
                    }
                    if (settings.onError) settings.onError(response);
                }
            } else {
                const errorMsg = response.message || 'An error occurred';
                if (settings.showNotification) {
                    TC.toast(errorMsg, 'danger');
                }
                if (settings.onError) settings.onError(response);
            }

            if (settings.onComplete) settings.onComplete(response);
        };

        // Handle errors
        xhr.onerror = function() {
            if (loadingOverlay) loadingOverlay.remove();
            if (settings.showNotification) {
                TC.toast('Network error. Please check your connection.', 'danger');
            }
            if (settings.onError) settings.onError({ success: false, message: 'Network error' });
            if (settings.onComplete) settings.onComplete({ success: false });
        };

        xhr.ontimeout = function() {
            if (loadingOverlay) loadingOverlay.remove();
            if (settings.showNotification) {
                TC.toast('Request timed out. Please try again.', 'warning');
            }
            if (settings.onError) settings.onError({ success: false, message: 'Timeout' });
            if (settings.onComplete) settings.onComplete({ success: false });
        };

        // Send request
        const payload = settings.method === 'GET' ? null : JSON.stringify(settings.data);
        xhr.send(payload);

        return xhr;
    };

    /**
     * Submit a form via AJAX
     */
    TC.submitForm = function(form, options) {
        const defaults = {
            onSuccess: null,
            onError: null,
            showNotification: true
        };

        const settings = Object.assign({}, defaults, options);

        // Validate form first
        if (!TC.validateForm(form)) {
            TC.toast('Please fix the errors in the form', 'warning');
            return false;
        }

        // Gather form data
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

        // Disable submit button
        const submitBtn = form.querySelector('[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.dataset.originalText = submitBtn.textContent;
            submitBtn.innerHTML = '<span class="spinner"></span> Processing...';
        }

        // Make AJAX request
        TC.ajax({
            method: form.method || 'POST',
            url: form.action,
            data: data,
            showLoading: true,
            loadingTarget: form,
            showNotification: settings.showNotification,
            onSuccess: function(response) {
                if (settings.onSuccess) settings.onSuccess(response);
            },
            onError: function(response) {
                if (settings.onError) settings.onError(response);
            },
            onComplete: function() {
                // Re-enable submit button
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = submitBtn.dataset.originalText;
                }
            }
        });

        return false;
    };

    // ============================================================================
    // NOTIFICATIONS & TOASTS
    // ============================================================================

    /**
     * Show a toast notification
     */
    TC.toast = function(message, type = 'info', duration = TC.config.toastDuration) {
        // Create container if it doesn't exist
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            document.body.appendChild(container);
        }

        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;

        // Icon based on type
        const icons = {
            success: '',
            danger: '',
            warning: '�',
            info: '9'
        };

        toast.innerHTML = `
            <div class="toast-icon">${icons[type] || icons.info}</div>
            <div class="toast-content">
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close" onclick="this.parentElement.remove()">�</button>
        `;

        container.appendChild(toast);

        // Auto-remove after duration
        if (duration > 0) {
            setTimeout(() => {
                toast.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, duration);
        }

        return toast;
    };

    /**
     * Show an alert banner
     */
    TC.alert = function(message, type = 'info', container = null) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;

        const icons = {
            success: '',
            danger: '',
            warning: '�',
            info: '9'
        };

        alert.innerHTML = `
            <div class="alert-icon">${icons[type] || icons.info}</div>
            <div class="alert-content">
                <div class="alert-message">${message}</div>
            </div>
        `;

        if (container) {
            if (typeof container === 'string') {
                container = document.querySelector(container);
            }
            container.insertBefore(alert, container.firstChild);
        } else {
            const contentWrapper = document.querySelector('.content-wrapper');
            if (contentWrapper) {
                contentWrapper.insertBefore(alert, contentWrapper.firstChild);
            }
        }

        return alert;
    };

    // ============================================================================
    // LOADING STATES
    // ============================================================================

    /**
     * Show loading overlay on an element
     */
    TC.showLoading = function(target) {
        if (typeof target === 'string') {
            target = document.querySelector(target);
        }

        if (!target) return null;

        // Make target position relative if not already positioned
        const position = window.getComputedStyle(target).position;
        if (position === 'static') {
            target.style.position = 'relative';
        }

        const overlay = document.createElement('div');
        overlay.className = 'loading-overlay';
        overlay.innerHTML = '<div class="spinner spinner-lg"></div>';
        target.appendChild(overlay);

        return overlay;
    };

    /**
     * Hide loading overlay
     */
    TC.hideLoading = function(target) {
        if (typeof target === 'string') {
            target = document.querySelector(target);
        }

        if (!target) return;

        const overlay = target.querySelector('.loading-overlay');
        if (overlay) overlay.remove();
    };

    // ============================================================================
    // FORM VALIDATION
    // ============================================================================

    /**
     * Initialize form validation on all forms with data-validate
     */
    TC.initFormValidation = function() {
        const forms = document.querySelectorAll('form[data-validate]');

        forms.forEach(form => {
            // Validate on submit
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (TC.validateForm(form)) {
                    // Check if form has AJAX submission
                    if (form.dataset.ajax) {
                        TC.submitForm(form);
                    } else {
                        form.submit();
                    }
                } else {
                    TC.toast('Please fix the errors in the form', 'warning');
                }
            });

            // Real-time validation on blur
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    TC.validateField(input);
                });
            });
        });
    };

    /**
     * Validate entire form
     */
    TC.validateForm = function(form) {
        let isValid = true;
        const inputs = form.querySelectorAll('input, textarea, select');

        inputs.forEach(input => {
            if (!TC.validateField(input)) {
                isValid = false;
            }
        });

        return isValid;
    };

    /**
     * Validate a single field
     */
    TC.validateField = function(field) {
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';

        // Clear previous errors
        TC.clearFieldError(field);

        // Check if required
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'This field is required';
        }

        // Check min length
        if (isValid && field.hasAttribute('minlength')) {
            const minLength = parseInt(field.getAttribute('minlength'));
            if (value.length < minLength) {
                isValid = false;
                errorMessage = `Minimum length is ${minLength} characters`;
            }
        }

        // Check max length
        if (isValid && field.hasAttribute('maxlength')) {
            const maxLength = parseInt(field.getAttribute('maxlength'));
            if (value.length > maxLength) {
                isValid = false;
                errorMessage = `Maximum length is ${maxLength} characters`;
            }
        }

        // Check email format
        if (isValid && field.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Please enter a valid email address';
            }
        }

        // Check number range
        if (isValid && field.type === 'number' && value) {
            const numValue = parseFloat(value);

            if (field.hasAttribute('min')) {
                const min = parseFloat(field.getAttribute('min'));
                if (numValue < min) {
                    isValid = false;
                    errorMessage = `Value must be at least ${min}`;
                }
            }

            if (field.hasAttribute('max')) {
                const max = parseFloat(field.getAttribute('max'));
                if (numValue > max) {
                    isValid = false;
                    errorMessage = `Value must be at most ${max}`;
                }
            }
        }

        // Check custom pattern
        if (isValid && field.hasAttribute('pattern') && value) {
            const pattern = new RegExp(field.getAttribute('pattern'));
            if (!pattern.test(value)) {
                isValid = false;
                errorMessage = field.getAttribute('data-error-message') || 'Invalid format';
            }
        }

        // Update field state
        if (isValid) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        } else {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
            TC.showFieldError(field, errorMessage);
        }

        return isValid;
    };

    /**
     * Show error message for a field
     */
    TC.showFieldError = function(field, message) {
        let errorElement = field.parentElement.querySelector('.form-error');

        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.className = 'form-error';
            field.parentElement.appendChild(errorElement);
        }

        errorElement.textContent = message;
    };

    /**
     * Clear error message for a field
     */
    TC.clearFieldError = function(field) {
        const errorElement = field.parentElement.querySelector('.form-error');
        if (errorElement) {
            errorElement.remove();
        }
    };

    // ============================================================================
    // UTILITY FUNCTIONS
    // ============================================================================

    /**
     * Format number with commas and decimals
     */
    TC.formatNumber = function(number, decimals = 0) {
        if (typeof number !== 'number') {
            number = parseFloat(number) || 0;
        }

        return number.toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    };

    /**
     * Format cash value
     */
    TC.formatCash = function(amount, symbol = '$') {
        const formatted = TC.formatNumber(amount, 0);
        return symbol + formatted;
    };

    /**
     * Format time in MM:SS format
     */
    TC.formatTime = function(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${mins}:${secs.toString().padStart(2, '0')}`;
    };

    /**
     * Format time in human-readable format
     */
    TC.formatTimeHuman = function(seconds) {
        if (seconds < 60) {
            return `${seconds}s`;
        } else if (seconds < 3600) {
            const mins = Math.floor(seconds / 60);
            return `${mins}m`;
        } else if (seconds < 86400) {
            const hours = Math.floor(seconds / 3600);
            return `${hours}h`;
        } else {
            const days = Math.floor(seconds / 86400);
            return `${days}d`;
        }
    };

    /**
     * Smooth scroll to element
     */
    TC.scrollTo = function(target, offset = 80) {
        if (typeof target === 'string') {
            target = document.querySelector(target);
        }

        if (!target) return;

        const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;

        window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
        });
    };

    /**
     * Initialize smooth scrolling for anchor links
     */
    TC.initSmoothScroll = function() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#') return;

                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    TC.scrollTo(target);
                }
            });
        });
    };

    /**
     * Initialize tooltips (if tooltip library is available)
     */
    TC.initTooltips = function() {
        // Placeholder for tooltip initialization
        // Can be integrated with a tooltip library like Tippy.js
    };

    /**
     * Debounce function for performance optimization
     */
    TC.debounce = function(func, wait = 300) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    };

    /**
     * Throttle function for performance optimization
     */
    TC.throttle = function(func, limit = 300) {
        let inThrottle;
        return function(...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    };

    /**
     * Check if element is in viewport
     */
    TC.isInViewport = function(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    };

    /**
     * Copy text to clipboard
     */
    TC.copyToClipboard = function(text) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(() => {
                TC.toast('Copied to clipboard!', 'success', 2000);
            }).catch(() => {
                TC.toast('Failed to copy', 'danger');
            });
        } else {
            // Fallback for older browsers
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            try {
                document.execCommand('copy');
                TC.toast('Copied to clipboard!', 'success', 2000);
            } catch (err) {
                TC.toast('Failed to copy', 'danger');
            }
            document.body.removeChild(textarea);
        }
    };

    /**
     * Get URL parameter
     */
    TC.getUrlParameter = function(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    };

    /**
     * Update URL parameter without reload
     */
    TC.updateUrlParameter = function(name, value) {
        const url = new URL(window.location);
        url.searchParams.set(name, value);
        window.history.pushState({}, '', url);
    };

    // ============================================================================
    // MODAL HELPERS
    // ============================================================================

    /**
     * Open modal
     */
    TC.openModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        const overlay = modal.closest('.modal-overlay');
        if (overlay) {
            overlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    };

    /**
     * Close modal
     */
    TC.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        const overlay = modal.closest('.modal-overlay');
        if (overlay) {
            overlay.style.display = 'none';
            document.body.style.overflow = '';
        }
    };

    // ============================================================================
    // AUTO-INITIALIZATION
    // ============================================================================

    // ============================================================================
    // THEME SYSTEM
    // ============================================================================

    /**
     * Initialize theme toggle functionality
     */
    TC.initThemeToggle = function() {
        const toggleInputs = document.querySelectorAll('[data-theme-toggle]');

        if (toggleInputs.length === 0) return;

        // Get current theme
        const getCurrentTheme = () => {
            try {
                return localStorage.getItem('tcTheme') || 'dark';
            } catch (err) {
                return 'dark';
            }
        };

        // Set theme
        const setTheme = (theme) => {
            document.documentElement.setAttribute('data-theme', theme);
            try {
                localStorage.setItem('tcTheme', theme);
            } catch (err) {
                console.warn('[TC] Unable to save theme preference', err);
            }

            // Update all toggle switches
            toggleInputs.forEach(input => {
                input.checked = (theme === 'light');
            });

            // Update theme-aware logos
            const logos = document.querySelectorAll('[data-theme-logo]');
            logos.forEach(logo => {
                const darkSrc = logo.getAttribute('data-dark-logo');
                const lightSrc = logo.getAttribute('data-light-logo');
                if (theme === 'light' && lightSrc) {
                    logo.src = lightSrc;
                } else if (theme === 'dark' && darkSrc) {
                    logo.src = darkSrc;
                }
            });
        };

        // Initialize toggle state based on current theme
        const currentTheme = getCurrentTheme();
        toggleInputs.forEach(input => {
            input.checked = (currentTheme === 'light');
        });

        // Add event listeners to all toggle switches
        toggleInputs.forEach(input => {
            input.addEventListener('change', function() {
                const newTheme = this.checked ? 'light' : 'dark';
                setTheme(newTheme);
            });
        });

        console.log('[TC] Theme toggle initialized. Current theme:', currentTheme);
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            TC.init();
            TC.initThemeToggle();
        });
    } else {
        TC.init();
        TC.initThemeToggle();
    }

    console.log('[TC] Trench City Global JS loaded.');

})();

