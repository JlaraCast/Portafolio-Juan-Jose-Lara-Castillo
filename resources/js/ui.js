/**
 * UI behaviours wired up through `data-*` attributes.
 *
 * Replaces the inline `onclick`/`onchange` attributes, which a strict CSP
 * (no `unsafe-inline`) blocks.
 */

function activateDeferredStylesheets() {
    // Sheets marked media="print" do not block rendering; once loaded we flip
    // them to "all" so they apply.
    document.querySelectorAll('link[data-deferred-style]').forEach((link) => {
        link.media = 'all';
    });
}

function initContactModal() {
    const modal = document.getElementById('contact-modal');

    if (!modal) {
        return;
    }

    let lastFocused = null;

    const open = (trigger) => {
        lastFocused = trigger;
        modal.classList.remove('hidden');
        modal.removeAttribute('aria-hidden');
        modal.querySelector('a, button')?.focus();
    };

    const close = () => {
        modal.classList.add('hidden');
        modal.setAttribute('aria-hidden', 'true');
        lastFocused?.focus();
        lastFocused = null;
    };

    document.querySelectorAll('[data-modal-open="contact-modal"]').forEach((trigger) => {
        trigger.addEventListener('click', () => open(trigger));
    });

    modal.querySelectorAll('[data-modal-close]').forEach((trigger) => {
        trigger.addEventListener('click', close);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            close();
        }
    });
}

function initSkillFilter() {
    const cards = document.querySelectorAll('.skill-card');

    if (!cards.length) {
        return;
    }

    const badges = document.querySelectorAll('.skill-badge');
    const filterables = document.querySelectorAll('.project-card, .experience-card');
    const activeSkillIds = new Set();

    const CARD_ACTIVE = ['ring-2', 'ring-emerald-500', 'dark:ring-indigo-500', 'bg-emerald-50', 'dark:bg-indigo-900/20'];
    const BADGE_IDLE = ['bg-emerald-50', 'dark:bg-indigo-900/30', 'text-emerald-700', 'dark:text-indigo-300', 'border-emerald-100', 'dark:border-indigo-800'];
    const BADGE_ACTIVE = ['bg-emerald-600', 'dark:bg-indigo-600', 'text-white', 'border-transparent'];

    const render = () => {
        badges.forEach((badge) => {
            const isActive = activeSkillIds.has(Number(badge.dataset.skillId));
            badge.classList.remove(...(isActive ? BADGE_IDLE : BADGE_ACTIVE));
            badge.classList.add(...(isActive ? BADGE_ACTIVE : BADGE_IDLE));
        });

        filterables.forEach((element) => {
            const ids = (element.dataset.skillIds || '').split(',').map(Number);
            const matches = [...activeSkillIds].every((id) => ids.includes(id));

            element.style.display = matches ? '' : 'none';
        });
    };

    cards.forEach((card) => {
        card.addEventListener('click', () => {
            const skillId = Number(card.dataset.skillId);
            const isActive = !activeSkillIds.has(skillId);

            if (isActive) {
                activeSkillIds.add(skillId);
            } else {
                activeSkillIds.delete(skillId);
            }

            CARD_ACTIVE.forEach((className) => card.classList.toggle(className, isActive));
            card.setAttribute('aria-pressed', String(isActive));

            render();
        });
    });
}

function initFileInputLabels() {
    document.querySelectorAll('input[type="file"][data-filename-target]').forEach((input) => {
        const output = document.getElementById(input.dataset.filenameTarget);

        if (!output) {
            return;
        }

        const placeholder = output.textContent;

        input.addEventListener('change', () => {
            output.textContent = input.files[0] ? input.files[0].name : placeholder;
        });
    });
}

function initFieldFillers() {
    document.querySelectorAll('[data-fill-target]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const field = document.getElementById(trigger.dataset.fillTarget);

            if (field) {
                field.value = trigger.dataset.fillValue || '';
                field.dispatchEvent(new Event('input', { bubbles: true }));
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    activateDeferredStylesheets();
    initContactModal();
    initSkillFilter();
    initFileInputLabels();
    initFieldFillers();
});
