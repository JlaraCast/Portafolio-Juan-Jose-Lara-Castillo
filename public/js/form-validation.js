// Character counter and real-time validation
document.addEventListener('DOMContentLoaded', function () {
    // Add character counters to all inputs and textareas with maxlength
    const inputs = document.querySelectorAll('input[maxlength], textarea[maxlength]');
    inputs.forEach(input => {
        addCharacterCounter(input);
    });

    // Add real-time password validation
    const passwordInput = document.querySelector('input[name="password"]');
    const passwordConfirm = document.querySelector('input[name="password_confirmation"]');

    if (passwordInput) {
        addPasswordValidation(passwordInput, passwordConfirm);
    }

    // Add file upload validation
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        addFileValidation(input);
    });
});

function addCharacterCounter(input) {
    const maxLength = input.getAttribute('maxlength');
    if (!maxLength) return;

    const counter = document.createElement('div');
    counter.className = 'mt-1 text-xs text-gray-500 dark:text-gray-400';
    counter.id = `${input.id}_counter`;

    const updateCounter = () => {
        const current = input.value.length;
        const remaining = maxLength - current;
        counter.textContent = `${current} / ${maxLength} caracteres`;

        if (remaining < 20) {
            counter.classList.remove('text-gray-500', 'dark:text-gray-400');
            counter.classList.add('text-orange-600', 'dark:text-orange-400');
        } else {
            counter.classList.remove('text-orange-600', 'dark:text-orange-400');
            counter.classList.add('text-gray-500', 'dark:text-gray-400');
        }
    };

    input.addEventListener('input', updateCounter);
    input.parentElement.appendChild(counter);
    updateCounter();
}

function addPasswordValidation(passwordInput, confirmInput) {
    const validationDiv = document.createElement('div');
    validationDiv.className = 'mt-2 space-y-1';
    validationDiv.id = 'password_validation';

    const t = window.translations || {};
    const requirements = [
        { regex: /.{8,}/, text: t.minCharacters || 'Min 8 characters', id: 'length' },
        { regex: /[a-z]/, text: t.lowercase || 'One lowercase letter', id: 'lowercase' },
        { regex: /[A-Z]/, text: t.uppercase || 'One uppercase letter', id: 'uppercase' },
        { regex: /[0-9]/, text: t.number || 'One number', id: 'number' },
        { regex: /[@$!%*#?&]/, text: t.specialChar || 'One special character', id: 'special' }
    ];

    requirements.forEach(req => {
        const item = document.createElement('div');
        item.className = 'flex items-center text-xs text-gray-500 dark:text-gray-400';
        item.id = `pwd_${req.id}`;
        item.innerHTML = `
            <svg class="w-4 h-4 mr-2 requirement-icon" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>${req.text}</span>
        `;
        validationDiv.appendChild(item);
    });

    passwordInput.parentElement.appendChild(validationDiv);

    const validatePassword = () => {
        const value = passwordInput.value;

        if (value.length === 0) {
            validationDiv.style.display = 'none';
            return;
        }

        validationDiv.style.display = 'block';

        requirements.forEach(req => {
            const item = document.getElementById(`pwd_${req.id}`);
            const isValid = req.regex.test(value);

            if (isValid) {
                item.classList.remove('text-red-600', 'dark:text-red-300');
                item.classList.add('text-green-600', 'dark:text-green-300');
            } else {
                item.classList.remove('text-green-600', 'dark:text-green-300');
                item.classList.add('text-red-600', 'dark:text-red-300');
            }
        });

        // Validate password confirmation
        if (confirmInput && confirmInput.value.length > 0) {
            validatePasswordMatch();
        }
    };

    const validatePasswordMatch = () => {
        if (!confirmInput) return;

        const matchDiv = document.getElementById('password_match') || createMatchDiv();
        const matches = passwordInput.value === confirmInput.value && confirmInput.value.length > 0;

        if (confirmInput.value.length === 0) {
            matchDiv.style.display = 'none';
            return;
        }

        matchDiv.style.display = 'block';

        if (matches) {
            matchDiv.className = 'mt-1 text-xs text-green-600 dark:text-green-300 flex items-center';
            matchDiv.innerHTML = `
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                ${t.passwordsMatch || 'Passwords match'}
            `;
        } else {
            matchDiv.className = 'mt-1 text-xs text-red-600 dark:text-red-300 flex items-center';
            matchDiv.innerHTML = `
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                ${t.passwordsDontMatch || 'Passwords do not match'}
            `;
        }
    };

    function createMatchDiv() {
        const div = document.createElement('div');
        div.id = 'password_match';
        confirmInput.parentElement.appendChild(div);
        return div;
    }

    passwordInput.addEventListener('input', validatePassword);
    if (confirmInput) {
        confirmInput.addEventListener('input', validatePasswordMatch);
    }
}

function addFileValidation(input) {
    const validationDiv = document.createElement('div');
    validationDiv.id = `${input.id}_file_validation`;
    validationDiv.className = 'mt-2 text-xs';

    input.addEventListener('change', function (e) {
        const file = e.target.files[0];
        validationDiv.innerHTML = '';

        if (!file) return;

        const maxSize = 2 * 1024 * 1024; // 2MB
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

        let errors = [];
        let info = [];

        // Check file size
        if (file.size > maxSize) {
            errors.push(`Archivo muy grande: ${(file.size / 1024 / 1024).toFixed(2)}MB (máx 2MB)`);
        } else {
            info.push(`Tamaño: ${(file.size / 1024).toFixed(2)}KB`);
        }

        // Check file type
        if (!allowedTypes.includes(file.type)) {
            errors.push(`Tipo no permitido: ${file.type}`);
        } else {
            info.push(`Tipo: ${file.type.split('/')[1].toUpperCase()}`);
        }

        if (errors.length > 0) {
            validationDiv.className = 'mt-2 text-xs text-red-600 dark:text-red-400';
            validationDiv.innerHTML = errors.map(err => `
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    ${err}
                </div>
            `).join('');
        } else {
            validationDiv.className = 'mt-2 text-xs text-green-600 dark:text-green-400';
            validationDiv.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    ${info.join(' • ')}
                </div>
            `;
        }
    });

    input.parentElement.appendChild(validationDiv);
}
