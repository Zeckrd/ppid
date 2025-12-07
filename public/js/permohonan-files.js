document.addEventListener('DOMContentLoaded', function () {
    // ==========================
    // VALIDATION
    // ==========================
    const MAX_SIZE = 5 * 1024 * 1024; // 5 MB
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

        fileInput.addEventListener('change', validateFiles);

        if (form) {
            form.addEventListener('submit', function (e) {
                if (!validateFiles()) {
                    e.preventDefault();
                    fileInput.focus();
                }
            });
        }
    }

    setupFileValidation('permohonan_files', 'permohonan_files_error', 10);           // user permohonan
    setupFileValidation('reply_files', 'reply_files_error', 10);                     // admin permohonan balasan
    setupFileValidation('keberatan_reply_files', 'keberatan_reply_files_error', 10); // admin keberatan balasan



    // ==========================
    // PREVIEW CHIPS
    // ==========================
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

    setupFilePreview('reply_files', 'reply_files_preview', 'reply_files_preview_chips');                       // admin permohonan
    setupFilePreview('permohonan_files', 'permohonan_files_preview', 'permohonan_files_preview_chips');       // user permohonan
    setupFilePreview('keberatan_reply_files', 'keberatan_reply_files_preview', 'keberatan_reply_files_preview_chips'); // admin keberatan



    // ==========================
    // DELETE TOGGLE
    // ==========================
    /**
     * General helper for any "trash icon -> mark for deletion" pattern.
     *
     * @param {Object} opts
     * @param {string} opts.rowSelector        - selector for each row (li)
     * @param {string} opts.checkboxSelector   - selector for hidden checkbox inside row
     * @param {string} opts.buttonSelector     - selector for trash button inside row
     * @param {string} [opts.badgeSelector]    - selector for "Akan dihapus" badge
     * @param {string} [opts.markedClass]      - class added to row when marked
     */
    function setupDeleteToggle(opts) {
        const {
            rowSelector,
            checkboxSelector,
            buttonSelector,
            badgeSelector,
            markedClass
        } = opts;

        document.querySelectorAll(rowSelector).forEach(function (row) {
            const checkbox = row.querySelector(checkboxSelector);
            const button   = row.querySelector(buttonSelector);
            const badge    = badgeSelector ? row.querySelector(badgeSelector) : null;
            const icon     = button ? button.querySelector('i') : null;

            if (!button || !checkbox) return;

            function syncVisual() {
                const marked = checkbox.checked;

                if (markedClass) {
                    row.classList.toggle(markedClass, marked);
                }

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

            // Initialize on page load
            if (checkbox.checked) {
                syncVisual();
            }
        });
    }

    // Admin permohonan reply files
    setupDeleteToggle({
        rowSelector:      '.reply-file-item',
        checkboxSelector: '.reply-file-delete-checkbox',
        buttonSelector:   '.reply-file-delete-toggle',
        badgeSelector:    '.delete-badge',
        markedClass:      'reply-file-marked-for-deletion'
    });

    // User permohonan files
    setupDeleteToggle({
        rowSelector:      '.user-file-item',
        checkboxSelector: '.user-file-delete-checkbox',
        buttonSelector:   '.user-file-delete-toggle',
        badgeSelector:    '.delete-badge',
        markedClass:      'user-file-marked-for-deletion'
    });

    // Admin keberatan reply files
    setupDeleteToggle({
        rowSelector:      '.kb-reply-file-item',
        checkboxSelector: '.kb-reply-file-delete-checkbox',
        buttonSelector:   '.kb-reply-file-delete-toggle',
        badgeSelector:    '.kb-delete-badge',
        markedClass:      'kb-reply-file-marked-for-deletion'
    });
});
