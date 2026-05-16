document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('categoriaForm');
    const methodInput = document.getElementById('categoria_method');

    const nombreInput = document.getElementById('categoria_nombre');
    const iconoInput = document.getElementById('icono');
    const colorInput = document.getElementById('color_hex');

    const previewIconBox = document.getElementById('previewCategoriaIcono');
    const previewIcon = previewIconBox?.querySelector('i');
    const previewNombre = document.getElementById('previewCategoriaNombre');

    const formTitle = document.getElementById('categoriaFormTitle');
    const submitBtn = document.getElementById('categoriaSubmitBtn');
    const cancelBtn = document.getElementById('cancelarEdicionCategoria');

    if (
        !form ||
        !methodInput ||
        !nombreInput ||
        !iconoInput ||
        !colorInput ||
        !previewIconBox ||
        !previewNombre ||
        !formTitle ||
        !submitBtn
    ) {
        return;
    }

    const textoPlaceholder = 'Vista previa de categoría';

    function actualizarPreview() {
        previewNombre.textContent = nombreInput.value || textoPlaceholder;

        if (previewIcon) {
            previewIcon.className = `bi ${iconoInput.value}`;
        }

        previewIconBox.style.backgroundColor = colorInput.value;
        previewIconBox.style.boxShadow = `0 0 18px ${colorInput.value}`;
    }

    function marcarIconoActivo(icono) {
        document.querySelectorAll('.category-icon-option').forEach((button) => {
            button.classList.toggle('active', button.dataset.icon === icono);
        });
    }

    function marcarColorActivo(color) {
        document.querySelectorAll('.category-color-option').forEach((button) => {
            button.classList.toggle('active', button.dataset.color === color);
        });
    }

    function modoCrear() {
        form.action = form.dataset.storeUrl;

        methodInput.disabled = true;
        methodInput.value = 'POST';

        nombreInput.value = '';
        iconoInput.value = 'bi-tag';
        colorInput.value = '#72f59a';

        formTitle.textContent = 'Crear nueva categoría';
        submitBtn.textContent = 'Guardar categoría';

        if (cancelBtn) {
            cancelBtn.classList.add('hidden');
        }

        marcarIconoActivo(iconoInput.value);
        marcarColorActivo(colorInput.value);
        actualizarPreview();
    }

    function modoEditar(button) {
        form.action = button.dataset.updateUrl;

        methodInput.disabled = false;
        methodInput.value = 'PUT';

        nombreInput.value = button.dataset.nombre || '';
        iconoInput.value = button.dataset.icono || 'bi-tag';
        colorInput.value = button.dataset.color || '#72f59a';

        formTitle.textContent = 'Editar categoría';
        submitBtn.textContent = 'Actualizar categoría';

        if (cancelBtn) {
            cancelBtn.classList.remove('hidden');
        }

        marcarIconoActivo(iconoInput.value);
        marcarColorActivo(colorInput.value);
        actualizarPreview();

        form.scrollIntoView({
            behavior: 'smooth',
            block: 'center',
        });
    }

    document.querySelectorAll('.category-icon-option').forEach((button) => {
        button.addEventListener('click', () => {
            iconoInput.value = button.dataset.icon;

            marcarIconoActivo(iconoInput.value);
            actualizarPreview();
        });
    });

    document.querySelectorAll('.category-color-option').forEach((button) => {
        button.addEventListener('click', () => {
            colorInput.value = button.dataset.color;

            marcarColorActivo(colorInput.value);
            actualizarPreview();
        });
    });

    document.querySelectorAll('.categoria-edit-btn').forEach((button) => {
        button.addEventListener('click', () => {
            modoEditar(button);
        });
    });

    if (cancelBtn) {
        cancelBtn.addEventListener('click', () => {
            modoCrear();
        });
    }

    nombreInput.addEventListener('input', actualizarPreview);

    marcarIconoActivo(iconoInput.value);
    marcarColorActivo(colorInput.value);
    actualizarPreview();
});