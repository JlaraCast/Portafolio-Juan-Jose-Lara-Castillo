/**
 * Period Formatter
 * Automatically formats date ranges for experiences in both Spanish and English
 */

class PeriodFormatter {
    constructor() {
        this.months_es = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        this.months_en = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        this.months_es_abbr = ['ene.', 'feb.', 'mar.', 'abr.', 'may.', 'jun.', 'jul.', 'ago.', 'sep.', 'oct.', 'nov.', 'dic.'];
        this.months_en_abbr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        this.initialized = false;
        this.boundHandlers = {
            updatePeriods: null,
            toggleAndUpdate: null
        };
        this.init();
    }

    init() {
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setupListeners());
        } else {
            this.setupListeners();
        }
    }

    setupListeners() {
        // Prevent multiple initializations
        if (this.initialized) return;
        
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const currentCheckbox = document.getElementById('is_current');

        if (!startDateInput) return; // Not on the right page

        // Parse existing period data if available (for edit form)
        if (window.existingPeriodData) {
            this.parseExistingPeriod(window.existingPeriodData);
        }

        // Create bound handlers for potential cleanup
        this.boundHandlers.updatePeriods = () => this.updatePeriods();
        this.boundHandlers.toggleAndUpdate = () => {
            this.toggleEndDate();
            this.updatePeriods();
        };

        // Listen to changes
        startDateInput?.addEventListener('change', this.boundHandlers.updatePeriods);
        endDateInput?.addEventListener('change', this.boundHandlers.updatePeriods);
        currentCheckbox?.addEventListener('change', this.boundHandlers.toggleAndUpdate);

        // Initial state
        this.toggleEndDate();
        this.updatePeriods();
        
        // Mark as initialized
        this.initialized = true;
    }

    toggleEndDate() {
        const endDateInput = document.getElementById('end_date');
        const currentCheckbox = document.getElementById('is_current');
        const endDateContainer = document.getElementById('end_date_container');

        if (currentCheckbox?.checked) {
            if (endDateInput) {
                endDateInput.disabled = true;
                endDateInput.value = '';
            }
            endDateContainer?.classList.add('opacity-50', 'pointer-events-none');
        } else {
            if (endDateInput) {
                endDateInput.disabled = false;
            }
            endDateContainer?.classList.remove('opacity-50', 'pointer-events-none');
        }
    }

    formatDate(dateString, language) {
        if (!dateString) return '';
        
        const [year, month] = dateString.split('-');
        const monthIndex = parseInt(month) - 1;
        
        // Validate month index is within bounds (0-11)
        if (isNaN(monthIndex) || monthIndex < 0 || monthIndex > 11) {
            return '';
        }
        
        if (language === 'es') {
            return `${this.months_es[monthIndex]} ${year}`;
        } else {
            return `${this.months_en[monthIndex]} ${year}`;
        }
    }

    updatePeriods() {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const currentCheckbox = document.getElementById('is_current');
        const periodEsInput = document.getElementById('period_es');
        const periodEnInput = document.getElementById('period_en');

        if (!startDateInput?.value) {
            if (periodEsInput) periodEsInput.value = '';
            if (periodEnInput) periodEnInput.value = '';
            return;
        }

        const startDate_es = this.formatDate(startDateInput.value, 'es');
        const startDate_en = this.formatDate(startDateInput.value, 'en');

        let period_es = '';
        let period_en = '';

        if (currentCheckbox?.checked) {
            // Current position
            period_es = `${startDate_es} - ${window.translations?.present || 'Presente'}`;
            period_en = `${startDate_en} - ${window.translations?.present_en || 'Present'}`;
        } else if (endDateInput?.value) {
            // Has end date
            const endDate_es = this.formatDate(endDateInput.value, 'es');
            const endDate_en = this.formatDate(endDateInput.value, 'en');
            period_es = `${startDate_es} - ${endDate_es}`;
            period_en = `${startDate_en} - ${endDate_en}`;
        } else {
            // Only start date
            period_es = startDate_es;
            period_en = startDate_en;
        }

        if (periodEsInput) periodEsInput.value = period_es;
        if (periodEnInput) periodEnInput.value = period_en;
    }

    /**
     * Parse existing period data and populate the form fields
     * @param {Object} periodData - Object containing period_es and period_en
     */
    parseExistingPeriod(periodData) {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const currentCheckbox = document.getElementById('is_current');

        if (!periodData.period_es || !periodData.period_en) return;

        // Try to parse the Spanish period first
        const parsed = this.parsePeriodString(periodData.period_es, 'es');
        
        if (parsed) {
            if (startDateInput) {
                startDateInput.value = parsed.startDate;
            }
            
            if (parsed.isCurrent) {
                if (currentCheckbox) {
                    currentCheckbox.checked = true;
                }
            } else if (parsed.endDate) {
                if (endDateInput) {
                    endDateInput.value = parsed.endDate;
                }
            }
        }
    }

    /**
     * Parse a period string and extract start date, end date, and current status
     * @param {string} periodString - The period string to parse (e.g., "ago. 2025 - actualidad")
     * @param {string} language - The language of the period string ('es' or 'en')
     * @returns {Object|null} - Object with startDate, endDate, and isCurrent, or null if parsing fails
     */
    parsePeriodString(periodString, language) {
        if (!periodString) return null;

        const months = language === 'es' ? this.months_es_abbr : this.months_en_abbr;
        const presentKeywords = language === 'es' ? ['actualidad', 'presente'] : ['present', 'current'];

        // Split by dash to get start and end parts
        const parts = periodString.split('-').map(p => p.trim().toLowerCase());
        
        if (parts.length === 0) return null;

        // Parse start date
        const startDate = this.parseDateFromString(parts[0], months);
        
        if (!startDate) return null;

        let endDate = null;
        let isCurrent = false;

        // Check if there's an end part
        if (parts.length > 1) {
            // Check if it's a "present" keyword
            const endPart = parts[1].toLowerCase();
            if (presentKeywords.some(keyword => endPart.includes(keyword))) {
                isCurrent = true;
            } else {
                // Try to parse as end date
                endDate = this.parseDateFromString(parts[1], months);
            }
        }

        return { startDate, endDate, isCurrent };
    }

    /**
     * Parse a date string like "ago. 2025" or "jan 2022" into YYYY-MM format
     * @param {string} dateString - The date string to parse
     * @param {Array} months - Array of month names/abbreviations
     * @returns {string|null} - Date in YYYY-MM format, or null if parsing fails
     */
    parseDateFromString(dateString, months) {
        if (!dateString) return null;

        // Match pattern: month year
        const parts = dateString.trim().split(/\s+/);
        
        if (parts.length < 2) return null;

        const monthPart = parts[0].toLowerCase().replace('.', '').trim();
        const yearPart = parts[parts.length - 1];

        // Find month index with exact match (after normalizing)
        let monthIndex = -1;
        
        for (let i = 0; i < months.length; i++) {
            const normalizedMonth = months[i].toLowerCase().replace('.', '').trim();
            if (monthPart === normalizedMonth) {
                monthIndex = i;
                break;
            }
        }

        if (monthIndex === -1) return null;

        // Parse year
        const year = parseInt(yearPart);
        if (isNaN(year)) return null;

        // Format as YYYY-MM
        const month = String(monthIndex + 1).padStart(2, '0');
        return `${year}-${month}`;
    }

    /**
     * Remove event listeners to prevent memory leaks
     */
    destroy() {
        if (!this.initialized) return;

        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const currentCheckbox = document.getElementById('is_current');

        if (this.boundHandlers.updatePeriods) {
            startDateInput?.removeEventListener('change', this.boundHandlers.updatePeriods);
            endDateInput?.removeEventListener('change', this.boundHandlers.updatePeriods);
        }

        if (this.boundHandlers.toggleAndUpdate) {
            currentCheckbox?.removeEventListener('change', this.boundHandlers.toggleAndUpdate);
        }

        this.boundHandlers.updatePeriods = null;
        this.boundHandlers.toggleAndUpdate = null;
        this.initialized = false;
    }
}

// Initialize
new PeriodFormatter();
