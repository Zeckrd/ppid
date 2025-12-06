// Validation and return error
document.addEventListener('DOMContentLoaded', function () {
    const MAX_SIZE = 5 * 1024 * 1024; // 2 MB
    const ALLOWED_EXT = ['pdf', 'doc', 'docx'];

    function setupFileValidation(inputId, errorId, maxFiles = 10) {
        const fileInput = document.getElementById(inputId);
        if (!fileInput) return;

        const form = fileInput.closest('form');
        const errorBox = errorId ? document.getElementById(errorId) : null;

        function showError(message) {
            if (errorBox) {
                errorBox.textContent = message;
                errorBox.classList.remove('d-none');
            }
            fileInput.classList.add('is-invalid');
        }

        function clearError() {
            if (errorBox) {
                errorBox.textContent = '';
                errorBox.classList.add('d-none');
            }
            fileInput.classList.remove('is-invalid');
        }

        function validateFiles() {
            clearError();

            const files = fileInput.files;
            if (!files || files.length === 0) {
                return true;
            }

            if (files.length > maxFiles) {
                showError(`Jumlah file maksimal ${maxFiles}.`);
                return false;
            }

            for (const file of files) {
                const name = file.name || '';
                const ext = name.split('.').pop().toLowerCase();

                if (!ALLOWED_EXT.includes(ext)) {
                    showError('Tipe file tidak valid. Hanya PDF, DOC, dan DOCX yang diperbolehkan.');
                    return false;
                }

                if (file.size > MAX_SIZE) {
                    showError('Ukuran tiap file maksimal 5 MB. Periksa kembali file: ' + name);
                    return false;
                }
            }

            return true;
        }

        fileInput.addEventListener('change', function () {
            validateFiles();
        });

        if (form) {
            form.addEventListener('submit', function (e) {
                if (!validateFiles()) {
                    e.preventDefault();
                    fileInput.focus();
                }
            });
        }
    }

    // Attach to both ADMIN AND USER
    setupFileValidation('permohonan_files', 'permohonan_files_error', 10);
    setupFileValidation('reply_files', 'reply_files_error', 10);
});





// Files to upload preview
document.addEventListener('DOMContentLoaded', function () {
    function setupFilePreview(inputId, previewId, chipsId) {
        const input   = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const chips   = document.getElementById(chipsId);

        if (!input || !preview || !chips) return;

        input.addEventListener('change', function () {
            const files = Array.from(this.files || []);

            chips.innerHTML = '';

            if (!files.length) {
                preview.classList.add('d-none');
                return;
            }

            files.forEach(function (file, index) {
                // limit to first 10 chips, then "+N lagi"
                if (index >= 10) return;

                const sizeKb = (file.size / 1024).toFixed(1) + ' KB';

                const badge = document.createElement('span');
                badge.className = 'badge rounded-pill bg-light border text-muted text-truncate';
                badge.style.maxWidth = '220px';
                badge.title = file.name + ' (' + sizeKb + ')';
                badge.innerHTML = `
                    <i class="ri-file-line me-1"></i>
                    ${file.name} <span class="fw-normal">(${sizeKb})</span>
                `;

                chips.appendChild(badge);
            });

            if (files.length > 10) {
                const more = document.createElement('span');
                more.className = 'badge rounded-pill bg-light border text-muted';
                more.textContent = `+${files.length - 10} lagi`;
                chips.appendChild(more);
            }

            preview.classList.remove('d-none');
        });
    }

    // Admin reply files
    setupFilePreview('reply_files', 'reply_files_preview', 'reply_files_preview_chips');

    // User permohonan files
    setupFilePreview('permohonan_files', 'permohonan_files_preview', 'permohonan_files_preview_chips');
});


// FOR DELETE BUTTON (admin)
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.reply-file-item').forEach(function (row) {
        const checkbox = row.querySelector('.reply-file-delete-checkbox');
        const badge = row.querySelector('.delete-badge');
        const button = row.querySelector('.reply-file-delete-toggle');
        const icon = button ? button.querySelector('i') : null;

        if (!button || !checkbox) {
            return;
        }

        function syncVisual() {
            const marked = checkbox.checked;

            row.classList.toggle('reply-file-marked-for-deletion', marked);

            if (badge) {
                badge.style.display = marked ? 'inline-flex' : 'none';
            }

            if (icon) {
                icon.classList.toggle('ri-delete-bin-line', !marked);
                icon.classList.toggle('ri-delete-bin-fill', marked);
            }

            button.title = marked ? 'Batal tandai hapus' : 'Tandai untuk dihapus';
        }

        // when clicking trash icon
        button.addEventListener('click', function () {
            checkbox.checked = !checkbox.checked;
            syncVisual();
        });

        // initialize on page load
        if (checkbox.checked) {
            syncVisual();
        }
    });
});

// FOR DELETE BUTTON (user permohonan files)
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.user-file-item').forEach(function (row) {
        const checkbox = row.querySelector('.user-file-delete-checkbox');
        const badge = row.querySelector('.delete-badge');
        const button = row.querySelector('.user-file-delete-toggle');
        const icon = button ? button.querySelector('i') : null;

        if (!button || !checkbox) return;

        function syncVisual() {
            const marked = checkbox.checked;

            row.classList.toggle('user-file-marked-for-deletion', marked);

            if (badge) {
                badge.style.display = marked ? 'inline-flex' : 'none';
            }

            if (icon) {
                icon.classList.toggle('ri-delete-bin-line', !marked);
                icon.classList.toggle('ri-delete-bin-fill', marked);
            }

            button.title = marked ? 'Batal tandai hapus' : 'Tandai untuk dihapus';
        }

        button.addEventListener('click', function () {
            checkbox.checked = !checkbox.checked;
            syncVisual();
        });

        if (checkbox.checked) {
            syncVisual();
        }
    });
});

