/**
 * Delete Confirmation Modal Handler
 * Handles the display and interaction of delete confirmation modals
 */

class DeleteModal {
    constructor() {
        // Prevent multiple instances (singleton pattern)
        if (DeleteModal.instance) {
            return DeleteModal.instance;
        }
        
        this.modal = null;
        this.currentForm = null;
        this.initialized = false;
        this.defaultMessage = '';
        
        DeleteModal.instance = this;
        this.init();
    }

    init() {
        // Prevent multiple initializations
        if (this.initialized) return;
        
        this.modal = document.getElementById('deleteModal');
        if (this.modal) {
            // Store default message for resetting later
            const messageEl = document.getElementById('modalMessage');
            if (messageEl) {
                this.defaultMessage = messageEl.textContent.trim();
            }

            this.attachEventListeners();
            this.initialized = true;
            console.log('DeleteModal: Initialized successfully with existing DOM element');
        } else {
            console.error('DeleteModal: Modal element #deleteModal not found in DOM');
        }
    }

    attachEventListeners() {
        // Use delegation on document for better reliability
        this.handleClick = (e) => {
            // Check if the clicked element or its parent has the data attribute
            // Check matches first for direct clicks, then closest for nested elements
            // Also handle cases where e.target might not support matches/closest (e.g. text nodes)
            let deleteBtn = null;
            
            if (e.target.matches && e.target.matches('[data-confirm-delete]')) {
                deleteBtn = e.target;
            } else if (e.target.closest) {
                deleteBtn = e.target.closest('[data-confirm-delete]');
            }
            
            if (deleteBtn) {
                console.log('DeleteModal: Delete button clicked', deleteBtn);
                e.preventDefault();
                e.stopPropagation();
                
                const form = deleteBtn.closest('form');
                console.log('DeleteModal: Found form', form);
                
                if (!form) {
                    console.error('DeleteModal: No form found for delete button');
                    return;
                }
                
                const message = deleteBtn.getAttribute('data-confirm-delete');
                console.log('DeleteModal: Message', message);
                this.show(form, message);
            }
        };
        
        // Attach click handler to document for better event delegation
        document.addEventListener('click', this.handleClick, true); // Use capture phase
        console.log('DeleteModal: Click handler attached to document');

        // Cancel button
        const cancelBtn = document.getElementById('cancelDelete');
        if (cancelBtn) {
            cancelBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.hide();
            });
        }

        // Backdrop click
        const backdrop = document.getElementById('modalBackdrop');
        if (backdrop) {
            backdrop.addEventListener('click', (e) => {
                e.preventDefault();
                this.hide();
            });
        }

        // Confirm button
        const confirmBtn = document.getElementById('confirmDelete');
        if (confirmBtn) {
            confirmBtn.addEventListener('click', (e) => {
                e.preventDefault();
                console.log('DeleteModal: Confirm clicked, submitting form', this.currentForm);
                if (this.currentForm) {
                    this.currentForm.submit();
                }
                this.hide();
            });
        }

        // ESC key to close
        this.handleEscape = (e) => {
            if (e.key === 'Escape' && this.modal && !this.modal.classList.contains('hidden')) {
                this.hide();
            }
        };
        document.addEventListener('keydown', this.handleEscape);
    }

    destroy() {
        // Cleanup event listeners
        if (this.handleClick) {
            document.removeEventListener('click', this.handleClick, true); // Match the capture phase
        }
        if (this.handleEscape) {
            document.removeEventListener('keydown', this.handleEscape);
        }
        
        // Clear singleton instance
        DeleteModal.instance = null;
        this.initialized = false;
    }

    show(form, message = null) {
        if (!this.modal) return;
        
        this.currentForm = form;
        
        // Update message if provided
        if (message) {
            const modalMessage = document.getElementById('modalMessage');
            if (modalMessage) {
                modalMessage.textContent = message;
            }
        }

        // Show modal
        this.modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Focus on cancel button for accessibility
        setTimeout(() => {
            const cancelBtn = document.getElementById('cancelDelete');
            if (cancelBtn) cancelBtn.focus();
        }, 100);
    }

    hide() {
        if (!this.modal) return;
        
        this.modal.classList.add('hidden');
        this.currentForm = null;
        document.body.style.overflow = '';
        
        // Reset message to default
        const modalMessage = document.getElementById('modalMessage');
        if (modalMessage && this.defaultMessage) {
            modalMessage.textContent = this.defaultMessage;
        }
    }
}

// Initialize singleton instance
DeleteModal.instance = null;

// Initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        console.log('DeleteModal: Initializing on DOMContentLoaded');
        window.deleteModal = new DeleteModal();
    });
} else {
    console.log('DeleteModal: Initializing immediately (DOM already loaded)');
    window.deleteModal = new DeleteModal();
}
