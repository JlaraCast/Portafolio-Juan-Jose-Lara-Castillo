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
        const t = window.translations || {};
        counter.textContent = `${current} / ${maxLength} ${t.characters || 'caracteres'}`;

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
        item.appendChild(domIcons.statusIcon('check', 'w-4 h-4 mr-2 requirement-icon'));

        const label = document.createElement('span');
        label.textContent = req.text;
        item.appendChild(label);

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
            matchDiv.replaceChildren(
                domIcons.statusIcon('check', 'w-4 h-4 mr-1'),
                document.createTextNode(t.passwordsMatch || 'Passwords match')
            );
        } else {
            matchDiv.className = 'mt-1 text-xs text-red-600 dark:text-red-300 flex items-center';
            matchDiv.replaceChildren(
                domIcons.statusIcon('cross', 'w-4 h-4 mr-1'),
                document.createTextNode(t.passwordsDontMatch || 'Passwords do not match')
            );
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
        validationDiv.replaceChildren();

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
            validationDiv.replaceChildren(...errors.map(err => domIcons.iconRow('cross', err)));
        } else {
            validationDiv.className = 'mt-2 text-xs text-green-600 dark:text-green-400';
            validationDiv.replaceChildren(domIcons.iconRow('check', info.join(' • ')));
        }
    });

    input.parentElement.appendChild(validationDiv);
}
