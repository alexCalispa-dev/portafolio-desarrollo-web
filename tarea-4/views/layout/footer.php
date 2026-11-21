</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // SweetAlert: mensaje que dejó el controlador (guardado, actualizado, eliminado, error)
    <?php if (isset($_SESSION['alerta'])): ?>
        Swal.fire(<?= json_encode($_SESSION['alerta']) ?>);
        <?php unset($_SESSION['alerta']); ?>
    <?php endif; ?>

    // SweetAlert: confirmación antes de eliminar
    document.querySelectorAll('.btn-eliminar').forEach(function (boton) {
        boton.addEventListener('click', function (evento) {
            evento.preventDefault();
            var url = this.dataset.url;
            Swal.fire({
                title: '¿Eliminar registro?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then(function (resultado) {
                if (resultado.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });
</script>
</body>
</html>
