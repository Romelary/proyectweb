// boton-menu.js mejorado
document.addEventListener('DOMContentLoaded', () => {
    const botonMenu = document.querySelector('.boton-menu');
    const menuMovil = document.querySelector('.mobile-nav');
    const overlay = document.createElement('div');
    
    overlay.classList.add('overlay');
    document.body.appendChild(overlay);

    function toggleMenu() {
        menuMovil.classList.toggle('activo');
        overlay.classList.toggle('activo');
        document.body.style.overflow = menuMovil.classList.contains('activo') ? 'hidden' : '';
    }

    botonMenu.addEventListener('click', toggleMenu);
    
    overlay.addEventListener('click', toggleMenu);

    // Cerrar menú al hacer clic en un enlace
    const enlacesMenu = menuMovil.querySelectorAll('a');
    enlacesMenu.forEach(enlace => {
        enlace.addEventListener('click', toggleMenu);
    });
});