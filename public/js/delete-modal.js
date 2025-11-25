/**
 * Delete Confirmation Modal Handler
 * Handles the display and interaction of delete confirmation modals
 */

class DeleteModal {
    constructor() {
        // Prevent multiple instances (singleton pattern)
        if (DeleteModal.instance) {
            // Retry initialization in case it failed previously (e.g. DOM wasn't ready)
            DeleteModal.instance.init();
            return DeleteModal.instance;
        }
        
        this.modal = null;
        this.initialized = false;
        
        DeleteModal.instance = this;
        this.init();
    }

    init() {
        // Prevent multiple initializations
        if (this.initialized) return;
        
        // Find the modal element in the DOM
        this.modal = document.getElementById('deleteModal');
        
        if (!this.modal) {
            return;
        }

        this.form = document.getElementById('deleteForm');
        this.modalTitle = document.getElementById('modalTitle');
        this.modalMessage = document.getElementById('modalMessage');
        this.cancelBtn = document.getElementById('cancelDelete');
        this.closeBtn = document.getElementById('closeModal');

        this.attachEventListeners();
        this.initialized = true;
    }

    attachEventListeners() {
        // Define handlers as bound methods so they can be removed later
        this.handleClick = (e) => {
            // Check if the clicked element or its parent is a delete button
            const deleteBtn = e.target.closest('[data-confirm-delete]');
            
            if (deleteBtn) {
                e.preventDefault();
                e.stopPropagation();
                
                const url = deleteBtn.dataset.url;
                const title = deleteBtn.dataset.title;
                const message = deleteBtn.dataset.confirmDelete;
                
                this.open(url, title, message, deleteBtn);
            }
        };

        this.handleEscape = (e) => {
            if (e.key === 'Escape' && this.modal && !this.modal.classList.contains('hidden')) {
                this.close();
            }
        };

        this.handleTab = (e) => {
            if (e.key === 'Tab' && this.modal && !this.modal.classList.contains('hidden')) {
                const focusableElements = this.modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                if (focusableElements.length === 0) return;

                const firstElement = focusableElements[0];
                const lastElement = focusableElements[focusableElements.length - 1];

                if (e.shiftKey) {
                    if (document.activeElement === firstElement) {
                        e.preventDefault();
                        lastElement.focus();
                    }
                } else {
                    if (document.activeElement === lastElement) {
                        e.preventDefault();
                        firstElement.focus();
                    }
                }
            }
        };

        this.handleClose = () => this.close();

        this.handleOutsideClick = (e) => {
            if (e.target === this.modal || e.target.hasAttribute('data-modal-overlay')) {
                this.close();
            }
        };

        // Use event delegation for delete buttons
        // We attach to document to catch clicks on any delete button, even dynamically added ones
        document.addEventListener('click', this.handleClick, true); // Use capture phase to ensure we catch the event before other handlers

        // Close modal when clicking cancel or close buttons
        if (this.cancelBtn) {
            this.cancelBtn.addEventListener('click', this.handleClose);
        }

        if (this.closeBtn) {
            this.closeBtn.addEventListener('click', this.handleClose);
        }

        // Close modal when clicking outside
        if (this.modal) {
            this.modal.addEventListener('click', this.handleOutsideClick);
        }

        // Close on escape key
        document.addEventListener('keydown', this.handleEscape);
        
        // Trap focus within modal
        document.addEventListener('keydown', this.handleTab);
    }

    open(url, title, message, triggerElement = null) {
        if (!this.modal || !this.form) {
            return;
        }

        // Update form action
        this.form.action = url;

        // Update text content
        // Use textContent instead of innerHTML to prevent XSS attacks
        if (this.modalTitle && title) {
            this.modalTitle.textContent = title;
        }
        
        if (this.modalMessage && message) {
            this.modalMessage.textContent = message;
        }

        // Show modal
        this.modal.classList.remove('hidden');
        this.modal.classList.add('flex');
        
        // Prevent body scrolling
        document.body.style.overflow = 'hidden';

        // Store trigger element to restore focus later
        this.triggerElement = triggerElement;

        // Focus management: set focus to cancel button by default
        if (this.cancelBtn) {
            this.cancelBtn.focus();
        }
    }

    close() {
        if (!this.modal) return;

        this.modal.classList.add('hidden');
        this.modal.classList.remove('flex');
        
        // Restore body scrolling
        document.body.style.overflow = '';

        // Restore focus to the element that opened the modal
        if (this.triggerElement) {
            this.triggerElement.focus();
            this.triggerElement = null;
        }
    }
}

// Initialize singleton instance
DeleteModal.instance = null;

// Initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.deleteModal = new DeleteModal();
    });
} else {
    window.deleteModal = new DeleteModal();
}
