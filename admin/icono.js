
document.querySelectorAll('.icon-option').forEach(function(el) {
  el.addEventListener('click', function() {
    // Desmarcar todos
    document.querySelectorAll('.icon-option').forEach(opt => opt.classList.remove('selected'));

    // Marcar seleccionado
    el.classList.add('selected');

    // Guardar en input oculto
    const iconClass = el.getAttribute('data-icono');
    document.getElementById('cat-icono').value = iconClass;

    // Mostrar ícono seleccionado
    document.getElementById('icono-preview').innerHTML = 'Ícono seleccionado: <i class="fas ' + iconClass + '"></i>';
  });
});


// Cierra el modal al hacer clic fuera del contenido
window.addEventListener('click', function(event) {
  const modal = document.getElementById('modal-categoria');
  const modalContent = modal.querySelector('.modal-content');
  
  if (event.target === modal) {
    modal.style.display = 'none';
  }
});

