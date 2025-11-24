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
        'login.title': 'Inicia sesión en tu cuenta',
        'login.email': 'Dirección de correo',
        'login.password': 'Contraseña',
        'login.remember': 'Recuérdame',
        'login.forgot': '¿Olvidaste tu contraseña?',
        'login.submit': 'Iniciar sesión',
        'Reset Password': 'Restablecer Contraseña',
        'Enter your email to receive a password reset link': 'Ingresa tu correo para recibir un enlace de restablecimiento',
        'Email': 'Correo Electrónico',
        'Send Password Reset Link': 'Enviar Enlace de Restablecimiento',
        'Back to Login': 'Volver al Login',
        'reset.title': 'Restablecer Contraseña',
        'reset.email': 'Correo Electrónico',
        'reset.new_password': 'Nueva Contraseña',
        'reset.confirm_password': 'Confirmar Contraseña',
        'reset.submit': 'Restablecer Contraseña',
        'reset.back_to_login': 'Volver al Login',
        'reset.enter_new_password': 'Ingresa tu nueva contraseña'
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
        'login.title': 'Sign in to your account',
        'login.email': 'Email address',
        'login.password': 'Password',
        'login.remember': 'Remember me',
        'login.forgot': 'Forgot your password?',
        'login.submit': 'Sign in',
        'Reset Password': 'Reset Password',
        'Enter your email to receive a password reset link': 'Enter your email to receive a password reset link',
        'Email': 'Email',
        'Send Password Reset Link': 'Send Password Reset Link',
        'Back to Login': 'Back to Login',
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
    // Get current language from html tag
    const htmlLang = document.documentElement.lang;
    let currentLang = htmlLang.split('-')[0]; // 'en' or 'es'

    // Fallback if not es or en
    if (currentLang !== 'es' && currentLang !== 'en') {
        currentLang = 'es';
    }

    // Translate all elements with data-translate attribute
    function translatePage() {
        document.querySelectorAll('[data-translate]').forEach(element => {
            const key = element.getAttribute('data-translate');
            if (translations[currentLang] && translations[currentLang][key]) {
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
                } else if (data['es']) {
                    // Fallback to Spanish if current lang not found in JSON
                    element.textContent = data['es'];
                }
            } catch (e) {
                console.error('Error parsing translation JSON:', e);
            }
        });
    }

    // Initialize
    translatePage();
    console.log('Language initialized to:', currentLang);

    // Optional: Keep the toggle logic if the elements exist
    const langToggleBtn = document.getElementById('lang-toggle');
    const langEs = document.getElementById('lang-es');
    const langEn = document.getElementById('lang-en');

    if (langToggleBtn && langEs && langEn) {
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

        updateLangButton();

        // Toggle language on click
        langToggleBtn.addEventListener('click', function () {
            currentLang = currentLang === 'es' ? 'en' : 'es';
            // We don't set localStorage here because we want to rely on server-side session
            // But if this button is used for client-side only switching:
            updateLangButton();
            translatePage();
            console.log('Language switched to:', currentLang);
        });
    }
});
