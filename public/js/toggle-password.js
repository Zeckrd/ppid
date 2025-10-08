document.addEventListener('DOMContentLoaded', () => {
    // password toggle
    document.querySelectorAll('[data-toggle="password"]').forEach(button => {
        button.addEventListener('click', () => {
            const input = document.getElementById(button.dataset.target);
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    });

    // password confirmation matching
    const password = document.getElementById('password');
    const confirm = document.getElementById('password_confirmation');
    const feedback = document.getElementById('passwordMatch');

    if (password && confirm && feedback) {
        const checkMatch = () => {
            if (!confirm.value) {
                feedback.textContent = '';
                feedback.className = 'form-text';
            } else if (password.value === confirm.value) {
                feedback.textContent = '✓ Password cocok';
                feedback.className = 'form-text text-success';
            } else {
                feedback.textContent = '✗ Password tidak cocok';
                feedback.className = 'form-text text-danger';
            }
        };
        password.addEventListener('input', checkMatch);
        confirm.addEventListener('input', checkMatch);
    }

    // disable submit on send
    const form = document.getElementById('registerForm');
    const submitBtn = document.getElementById('submitBtn');

    if (form && submitBtn) {
        form.addEventListener('submit', () => {
            submitBtn.disabled = true;
            submitBtn.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Mendaftar...';

            // fallback re-enable
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML =
                    '<i class="bi bi-person-plus me-2"></i>Daftar Sekarang';
            }, 15000);
        });
    }
});
