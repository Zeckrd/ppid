document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('permohonan_files');
    if (!fileInput) return; // page doesn't have the field

    const form = fileInput.closest('form');
    const errorBox = document.getElementById('permohonan_files_error');

    const MAX_SIZE = 2 * 1024 * 1024; // 2 MB in bytes
    const ALLOWED_EXT = ['pdf', 'doc', 'docx'];

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
            // For edit form, files might be optional
            return true;
        }

        // Optional: limit to 10 files
        if (files.length > 10) {
            showError('Jumlah file maksimal 10.');
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

        if (files.length > 10) {
            showError('Jumlah file maksimal 10.');
            return false;
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
});
