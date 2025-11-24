/**
 * Form loading state handler
 * Adds loading spinners and disables buttons during form submission
 */
document.addEventListener('DOMContentLoaded', function() {
    // Handle all forms with the class 'loading-form'
    const forms = document.querySelectorAll('form.loading-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitButton = form.querySelector('button[type="submit"]');
            
            if (submitButton && !submitButton.disabled) {
                // Store original button text
                const originalText = submitButton.innerHTML;
                
                // Disable button
                submitButton.disabled = true;
                
                // Add loading spinner
                submitButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    ${window.translations?.loading || 'Processing...'}
                `;
                
                // Re-enable after a timeout in case submission fails
                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                }, 10000); // 10 seconds timeout
            }
        });
    });
    
    // Handle delete forms separately (they usually have confirmation)
    const deleteForms = document.querySelectorAll('form[method="POST"][action*="delete"], form button[onclick*="confirm"]');
    
    deleteForms.forEach(element => {
        const form = element.tagName === 'FORM' ? element : element.closest('form');
        
        if (form) {
            form.addEventListener('submit', function(e) {
                const submitButton = form.querySelector('button[type="submit"]');
                
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                }
            });
        }
    });
});
