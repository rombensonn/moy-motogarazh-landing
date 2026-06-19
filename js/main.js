const utmFields = ['utm_source', 'utm_medium', 'utm_campaign'];
const params = new URLSearchParams(window.location.search);

utmFields.forEach((name) => {
    const input = document.querySelector(`input[name="${name}"]`);
    if (input && params.has(name)) {
        input.value = params.get(name) || '';
    }
});

const form = document.querySelector('.lead-form');
const serviceSelect = document.querySelector('select[name="service"]');
const formSource = document.querySelector('input[name="form_source"]');
const isStaticPagesDemo = window.location.hostname.endsWith('github.io');

document.querySelectorAll('.service-cta').forEach((link) => {
    link.addEventListener('click', () => {
        const service = link.dataset.service || '';

        if (serviceSelect) {
            const option = [...serviceSelect.options].find((item) => item.textContent === service);
            serviceSelect.value = option ? option.value : '';
        }

        if (formSource) {
            formSource.value = 'service_card';
        }
    });
});

function digitsOnly(value) {
    return value.replace(/\D+/g, '');
}

function formatPhone(value) {
    const digits = digitsOnly(value);
    if (!digits) {
        return '';
    }

    const normalized = digits.startsWith('8') ? `7${digits.slice(1)}` : digits;
    const trimmed = normalized.startsWith('7') ? normalized.slice(0, 11) : normalized.slice(0, 10);
    const local = trimmed.startsWith('7') ? trimmed.slice(1) : trimmed;
    const parts = [];

    if (trimmed.startsWith('7')) {
        parts.push('+7');
    }

    if (local.length > 0) {
        parts.push(local.slice(0, 3));
    }

    if (local.length > 3) {
        parts.push(local.slice(3, 6));
    }

    if (local.length > 6) {
        parts.push(local.slice(6, 8));
    }

    if (local.length > 8) {
        parts.push(local.slice(8, 10));
    }

    return parts.join(' ');
}

function validatePhone(input) {
    const error = document.querySelector('[data-error-for="phone"]');
    const valid = digitsOnly(input.value).length >= 10;

    if (error) {
        error.textContent = valid ? '' : 'Укажите телефон: минимум 10 цифр.';
    }

    input.setAttribute('aria-invalid', valid ? 'false' : 'true');
    return valid;
}

if (form) {
    const phoneInput = form.querySelector('input[name="phone"]');
    const status = form.querySelector('.form-status');
    const submit = form.querySelector('.form-submit');

    if (phoneInput) {
        phoneInput.addEventListener('input', () => {
            phoneInput.value = formatPhone(phoneInput.value);
        });

        phoneInput.addEventListener('blur', () => {
            validatePhone(phoneInput);
        });
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        if (phoneInput && !validatePhone(phoneInput)) {
            phoneInput.focus();
            return;
        }

        status.textContent = 'Отправляем заявку...';
        status.className = 'form-status';
        submit.disabled = true;

        try {
            if (isStaticPagesDemo) {
                status.textContent = 'Это демо на GitHub Pages. Для записи позвоните или напишите в Telegram.';
                status.classList.add('is-success');
                return;
            }

            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    Accept: 'application/json',
                },
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok || data.ok !== true) {
                throw new Error(data.error || 'Не удалось отправить заявку.');
            }

            status.textContent = 'Заявка отправлена. Мы свяжемся с вами в ближайшее рабочее время.';
            status.classList.add('is-success');
        } catch (error) {
            status.textContent = error.message || 'Не удалось отправить заявку. Позвоните или напишите в Telegram.';
            status.classList.add('is-error');
        } finally {
            submit.disabled = false;
        }
    });
}
