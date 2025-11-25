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
        
        DeleteModal.instance = this;
        this.init();
    }

    init() {
        // Prevent multiple initializations
        if (this.initialized) return;
        
        // Create modal element if it doesn't exist
        if (!document.getElementById('deleteModal')) {
            this.createModal();
        }
        this.modal = document.getElementById('deleteModal');
        if (this.modal) {
            this.attachEventListeners();
            this.initialized = true;
        }
    }

    createModal() {
        const t = window.translations || {};
        const modalHTML = `
            <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Background overlay -->
                    <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-80 transition-opacity" aria-hidden="true" id="modalBackdrop"></div>

                    <!-- Center modal -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <!-- Modal panel -->
                    <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl px-4 pt-5 pb-4 text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6 border border-gray-100 dark:border-gray-700">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-xl bg-red-100 dark:bg-red-900/30 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white" id="modal-title">
                                    ${t.confirmDelete || 'Confirm Delete'}
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400" id="modalMessage">
                                        ${t.confirmDeleteMessage || 'Are you sure you want to delete this item? This action cannot be undone.'}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse gap-3">
                            <button type="button" id="confirmDelete" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-lg shadow-red-500/30 px-4 py-2.5 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-all hover:scale-105">
                                ${t.delete || 'Delete'}
                            </button>
                            <button type="button" id="cancelDelete" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2.5 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                                ${t.cancel || 'Cancel'}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }

    attachEventListeners() {
        // Use delegation on document for better reliability
        this.handleClick = (e) => {
            // Check if the clicked element or its parent has the data attribute
            const deleteBtn = e.target.closest('[data-confirm-delete]');
            
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
        
        // Remove modal from DOM
        if (this.modal && this.modal.parentNode) {
            this.modal.parentNode.removeChild(this.modal);
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
        const t = window.translations || {};
        if (modalMessage) {
            modalMessage.textContent = t.confirmDeleteMessage || 'Are you sure you want to delete this item? This action cannot be undone.';
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
        console.log('DeleteModal: Initialized successfully');
    });
} else {
    console.log('DeleteModal: Initializing immediately (DOM already loaded)');
    window.deleteModal = new DeleteModal();
    console.log('DeleteModal: Initialized successfully');
}
