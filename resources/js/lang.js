const translations = {
    es: {
        'hero.title': 'Hola, soy',
        'hero.contact': 'Contáctame',
        'hero.work': 'Ver Experiencia',
        'skills.title': 'Habilidades Técnicas',
        'projects.title': 'Experiencia',
        'contact.title': '¿Listo para colaborar?',
        'contact.subtitle': 'Actualmente trabajo part-time como desarrollador backend en el equipo de I+D de la Universidad de Costa Rica.',
        'contact.button': 'Hablemos',
        'footer': 'Todos los derechos reservados',
        // login page keys
        'login.title': 'Inicia sesión en tu cuenta',
        'login.email': 'Dirección de correo',
        'login.password': 'Contraseña',
        'login.remember': 'Recuérdame',
        'login.forgot': '¿Olvidaste tu contraseña?',
        'login.submit': 'Iniciar sesión',
        // reset password keys
        'reset.title': 'Restablecer contraseña',
        'reset.email': 'Correo electrónico',
        'reset.new_password': 'Nueva contraseña',
        'reset.confirm_password': 'Confirmar contraseña',
        'reset.submit': 'Restablecer contraseña',
        'reset.back_to_login': 'Volver al inicio de sesión',
        'reset.enter_new_password': 'Introduce tu nueva contraseña'
    },
    en: {
        'hero.title': "Hi, I'm",
        'hero.contact': 'Contact Me',
        'hero.work': 'View Experience',
        'skills.title': 'Technical Skills',
        'projects.title': 'Experience',
        'contact.title': 'Ready to collaborate?',
        'contact.subtitle': 'Currently working part-time as a backend developer on the I+D team at the University of Costa Rica.',
        'contact.button': "Let's Talk",
        'footer': 'All rights reserved',
        // login page keys
        'login.title': 'Sign in to your account',
        'login.email': 'Email address',
        'login.password': 'Password',
        'login.remember': 'Remember me',
        'login.forgot': 'Forgot your password?',
        'login.submit': 'Sign in',
        // reset password keys
        'reset.title': 'Reset Password',
        'reset.email': 'Email',
        'reset.new_password': 'New Password',
        'reset.confirm_password': 'Confirm Password',
        'reset.submit': 'Reset Password',
        'reset.back_to_login': 'Back to Login',
        'reset.enter_new_password': 'Enter your new password'
    }
};

document.addEventListener('DOMContentLoaded', function () {
    const langToggleBtn = document.getElementById('lang-toggle');
    const langEs = document.getElementById('lang-es');
    const langEn = document.getElementById('lang-en');

    if (!langToggleBtn || !langEs || !langEn) {
        return;
    }

    // Get current language from localStorage or default to Spanish
    let currentLang = localStorage.getItem('language') || 'es';

    // Update button display
    function updateLangButton() {
        if (currentLang === 'es') {
            langEs.classList.remove('hidden');
            langEn.classList.add('hidden');
        } else {
            langEs.classList.add('hidden');
            langEn.classList.remove('hidden');
        }
    }

    // Translate all elements with data-translate attribute
    function translatePage() {
        document.querySelectorAll('[data-translate]').forEach(element => {
            const key = element.getAttribute('data-translate');
            if (translations[currentLang][key]) {
                element.textContent = translations[currentLang][key];
            }
        });

        // Translate JSON based elements
        document.querySelectorAll('[data-translate-json]').forEach(element => {
            const jsonData = element.getAttribute('data-translate-json');
            try {
                const data = JSON.parse(jsonData);
                if (data[currentLang]) {
                    element.textContent = data[currentLang];
                }
            } catch (e) {
                console.error('Error parsing translation JSON:', e);
            }
        });
    }

    // Initialize
    updateLangButton();
    translatePage();

    // Toggle language on click
    langToggleBtn.addEventListener('click', function () {
        currentLang = currentLang === 'es' ? 'en' : 'es';
        localStorage.setItem('language', currentLang);
        updateLangButton();
        translatePage();
        console.log('Language switched to:', currentLang);
    });
});
