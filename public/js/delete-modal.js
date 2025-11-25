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
        // Use event delegation for delete buttons
        // We attach to document to catch clicks on any delete button, even dynamically added ones
        document.addEventListener('click', (e) => {
            // Check if the clicked element or its parent is a delete button
            const deleteBtn = e.target.closest('[data-confirm-delete]');
            
            if (deleteBtn) {
                e.preventDefault();
                e.stopPropagation();
                
                const id = deleteBtn.dataset.id;
                const url = deleteBtn.dataset.url;
                const title = deleteBtn.dataset.title;
                const message = deleteBtn.dataset.message || deleteBtn.dataset.confirmDelete;
                
                this.open(id, url, title, message);
            }
        }, true); // Use capture phase to ensure we catch the event before other handlers

        // Close modal when clicking cancel or close buttons
        if (this.cancelBtn) {
            this.cancelBtn.addEventListener('click', () => this.close());
        }
        
        if (this.closeBtn) {
            this.closeBtn.addEventListener('click', () => this.close());
        }

        // Close modal when clicking outside
        if (this.modal) {
            this.modal.addEventListener('click', (e) => {
                if (e.target === this.modal) {
                    this.close();
                }
            });
        }

        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal && !this.modal.classList.contains('hidden')) {
                this.close();
            }
        });
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

    open(id, url, title, message) {
        if (!this.modal || !this.form) {
            return;
        }

        // Update form action
        this.form.action = url;

        // Update text content
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
    }

    close() {
        if (!this.modal) return;

        this.modal.classList.add('hidden');
        this.modal.classList.remove('flex');
        
        // Restore body scrolling
        document.body.style.overflow = '';
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
