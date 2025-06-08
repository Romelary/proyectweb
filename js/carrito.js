// carrito.js
document.addEventListener('DOMContentLoaded', function () {
    // Añadir al carrito
    document.querySelectorAll('.boton-producto').forEach(btn => {
        btn.addEventListener('click', () => {
            const productoId = btn.dataset.productoId;
            agregarAlCarrito(productoId);
        });
    });

    // Aumentar/disminuir cantidad
    document.querySelectorAll('.btn-cantidad').forEach(btn => {
        btn.addEventListener('click', () => {
            const productoId = btn.dataset.productoId;
            const accion = btn.dataset.accion; // "incrementar" o "decrementar"
            actualizarCantidad(productoId, accion);
        });
    });

    // Eliminar del carrito
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', () => {
            const productoId = btn.dataset.productoId;
            eliminarDelCarrito(productoId);
        });
    });

    // Vaciar carrito
    const btnVaciar = document.getElementById('vaciar-carrito') || document.querySelector('.boton-cancelar');
    if (btnVaciar) {
        btnVaciar.addEventListener('click', vaciarCarrito);
    }

    // Actualizar contador al cargar
    actualizarContadorCarrito();
});

// Función: agregar al carrito
function agregarAlCarrito(productoId) {
    fetch('php/agregar_carrito.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ producto_id: productoId, cantidad: 1 })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            actualizarContadorCarrito();
            mostrarNotificacion('Producto añadido al carrito');
        } else {
            mostrarError(data.message || 'Error al añadir al carrito');
        }
    })
    .catch(() => mostrarError('Error de conexión'));
}

// Función: actualizar cantidad
function actualizarCantidad(productoId, accion) {
    fetch('php/actualizar_carrito.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ producto_id: productoId, accion })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            mostrarError(data.message || 'Error al actualizar cantidad');
        }
    })
    .catch(() => mostrarError('Error de conexión'));
}

// Función: eliminar producto
function eliminarDelCarrito(productoId) {
    fetch('php/eliminar_carrito.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ producto_id: productoId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            mostrarError(data.message || 'Error al eliminar producto');
        }
    })
    .catch(() => mostrarError('Error de conexión'));
}

// Función: vaciar carrito
function vaciarCarrito() {
    if (confirm('¿Estás seguro de que quieres vaciar tu carrito?')) {
        fetch('php/vaciar_carrito.php', { method: 'POST' })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                mostrarError(data.message || 'Error al vaciar carrito');
            }
        })
        .catch(() => mostrarError('Error de conexión'));
    }
}

// Función: mostrar notificación
function mostrarNotificacion(mensaje) {
    alert(mensaje); // Puedes reemplazar con SweetAlert o Toastify para una mejor UX
}

// Función: mostrar error
function mostrarError(mensaje) {
    alert('Error: ' + mensaje);
}

// Función: actualizar contador del carrito
function actualizarContadorCarrito() {
    fetch('php/obtener_carrito_count.php')
    .then(res => res.json())
    .then(data => {
        const total = data.totalItems ?? 0;
        const contador = document.getElementById('contador-carrito');
        const contadorMobile = document.getElementById('contador-carrito-mobile');

        if (contador) {
            contador.textContent = total;
            contador.style.display = total > 0 ? 'inline-block' : 'none';
        }

        if (contadorMobile) {
            contadorMobile.textContent = total;
            contadorMobile.style.display = total > 0 ? 'inline-block' : 'none';
        }
    })
    .catch(() => console.error('Error al actualizar contador del carrito'));
}
