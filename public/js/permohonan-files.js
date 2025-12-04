document.addEventListener('DOMContentLoaded', function () {
    const MAX_SIZE = 2 * 1024 * 1024; // 2 MB in bytes
    const ALLOWED_EXT = ['pdf', 'doc', 'docx'];
    const MAX_FILES = 10;

    function setupFileValidator(inputId, errorId) {
        const fileInput = document.getElementById(inputId);
        if (!fileInput) return; // this page doesn't have that field, skip

        const form = fileInput.closest('form');
        const errorBox = errorId ? document.getElementById(errorId) : null;

        function showError(message) {
            if (!errorBox) return;
            errorBox.textContent = message;
            errorBox.classList.remove('d-none');
        }

        function clearError() {
            if (!errorBox) return;
            errorBox.textContent = '';
            errorBox.classList.add('d-none');
        }

        function validateFiles() {
            clearError();

            const files = fileInput.files;
            if (!files || files.length === 0) {
                return true;
            }

            if (files.length > MAX_FILES) {
                showError('Jumlah file maksimal ' + MAX_FILES + '.');
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
                    showError('Ukuran tiap file maksimal 2 MB. Periksa kembali file: ' + name);
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

    // User upload (permohonan)
    setupFileValidator('permohonan_files', 'permohonan_files_error');

    // Admin upload (balasan / reply)
    setupFileValidator('reply_files', 'reply_files_error');
});
