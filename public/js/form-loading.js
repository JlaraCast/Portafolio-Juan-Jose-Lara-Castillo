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
                // Store original button content
                const originalNodes = Array.from(submitButton.childNodes);

                // Disable button
                submitButton.disabled = true;

                // Add loading spinner
                submitButton.replaceChildren(
                    domIcons.spinnerIcon('animate-spin -ml-1 mr-3 h-5 w-5 text-white inline'),
                    document.createTextNode(window.translations?.loading || 'Processing...')
                );

                // Re-enable after a timeout in case submission fails
                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.replaceChildren(...originalNodes);
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
