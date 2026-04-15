/**
 * Global Live Validation System
 * Monitors input/blur events to provide immediate feedback based on HTML5 validity.
 */
document.addEventListener('DOMContentLoaded', () => {
    // Attach to all relevant inputs
    const inputs = document.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        // Trigger on input (as user types) and blur (when leaving)
        input.addEventListener('input', () => validateField(input));
        input.addEventListener('blur', () => validateField(input));
    });

    function validateField(input) {
        // Find or create error message container
        let errorMsg = input.parentElement.querySelector('.live-error-msg') || 
                       input.closest('.form-group')?.querySelector('.live-error-msg') ||
                       input.closest('div')?.querySelector('.live-error-msg');
        
        // If not found, try to find the standard .error-msg I created earlier
        if (!errorMsg) {
            errorMsg = input.parentElement.querySelector('.error-msg') || 
                       input.closest('.form-group')?.querySelector('.error-msg');
            if (errorMsg) errorMsg.classList.add('live-error-msg');
        }

        if (input.required && !input.value.trim()) {
            showError(input, errorMsg, 'This field is required.');
        } else if (input.pattern && !new RegExp('^' + input.pattern + '$').test(input.value)) {
            showError(input, errorMsg, input.title || 'Please match the requested format.');
        } else if (!input.checkValidity()) {
            showError(input, errorMsg, input.validationMessage);
        } else {
            clearError(input, errorMsg);
        }
    }

    function showError(input, errorMsg, message) {
        input.style.borderColor = '#ff4d4d';
        input.style.boxShadow = '0 0 0 2px rgba(255, 77, 77, 0.1)';
        
        if (errorMsg) {
            errorMsg.textContent = message;
            errorMsg.style.display = 'block';
            errorMsg.style.color = '#ff4d4d';
            errorMsg.style.fontSize = '10px';
            errorMsg.style.marginTop = '4px';
            errorMsg.style.fontWeight = 'bold';
            errorMsg.style.textTransform = 'uppercase';
        }
    }

    function clearError(input, errorMsg) {
        input.style.borderColor = '';
        input.style.boxShadow = '';
        if (errorMsg) {
            errorMsg.style.display = 'none';
        }
    }
});
