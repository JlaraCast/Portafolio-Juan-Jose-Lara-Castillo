/**
 * Period Formatter
 * Automatically formats date ranges for experiences in both Spanish and English
 */

class PeriodFormatter {
    constructor() {
        this.months_es = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        this.months_en = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
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
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const currentCheckbox = document.getElementById('is_current');

        if (!startDateInput) return; // Not on the right page

        // Listen to changes
        startDateInput?.addEventListener('change', () => this.updatePeriods());
        endDateInput?.addEventListener('change', () => this.updatePeriods());
        currentCheckbox?.addEventListener('change', () => {
            this.toggleEndDate();
            this.updatePeriods();
        });

        // Initial state
        this.toggleEndDate();
        this.updatePeriods();
    }

    toggleEndDate() {
        const endDateInput = document.getElementById('end_date');
        const currentCheckbox = document.getElementById('is_current');
        const endDateContainer = document.getElementById('end_date_container');

        if (currentCheckbox?.checked) {
            endDateInput.disabled = true;
            endDateInput.value = '';
            endDateContainer?.classList.add('opacity-50', 'pointer-events-none');
        } else {
            endDateInput.disabled = false;
            endDateContainer?.classList.remove('opacity-50', 'pointer-events-none');
        }
    }

    formatDate(dateString, language) {
        if (!dateString) return '';
        
        const [year, month] = dateString.split('-');
        const monthIndex = parseInt(month) - 1;
        
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
            periodEsInput.value = '';
            periodEnInput.value = '';
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

        periodEsInput.value = period_es;
        periodEnInput.value = period_en;
    }
}

// Initialize
new PeriodFormatter();
