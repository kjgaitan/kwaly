document.addEventListener('DOMContentLoaded', () => {

    const nombreInput = document.getElementById('categoria_nombre');
    const iconoInput = document.getElementById('icono');
    const colorInput = document.getElementById('color_hex');

    const previewIconBox = document.getElementById('previewCategoriaIcono');
    const previewNombre = document.getElementById('previewCategoriaNombre');

    const previewIcon = previewIconBox?.querySelector('i');

    if (
        !nombreInput ||
        !iconoInput ||
        !colorInput ||
        !previewIconBox ||
        !previewNombre
    ) {
        return;
    }


    document.querySelectorAll('.category-icon-option')
        .forEach(button => {

            button.addEventListener('click', () => {

                document.querySelectorAll('.category-icon-option')
                    .forEach(btn => btn.classList.remove('active'));

                button.classList.add('active');

                const icono = button.dataset.icon;

                iconoInput.value = icono;

                if (previewIcon) {
                    previewIcon.className = `bi ${icono}`;
                }

            });

        });


    document.querySelectorAll('.category-color-option')
        .forEach(button => {

            button.addEventListener('click', () => {

                document.querySelectorAll('.category-color-option')
                    .forEach(btn => btn.classList.remove('active'));

                button.classList.add('active');

                const color = button.dataset.color;

                colorInput.value = color;

                previewIconBox.style.backgroundColor = color;
                previewIconBox.style.boxShadow = `0 0 18px ${color}`;

            });

        });


    previewNombre.textContent =
        nombreInput.value || 'Vista previa de categoría';


    nombreInput.addEventListener('input', () => {

        previewNombre.textContent =
            nombreInput.value || 'Vista previa de categoría';

    });


    previewIconBox.style.backgroundColor =
        colorInput.value;

    previewIconBox.style.boxShadow =
        `0 0 18px ${colorInput.value}`;

});