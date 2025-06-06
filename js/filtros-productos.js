document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const filtros = document.querySelectorAll('.boton-filtro');
    const productos = document.querySelectorAll('.producto');
    const listaProductos = document.querySelector('.lista-productos');
    const botonesFavorito = document.querySelectorAll('.boton-favorito');

    // Filtrado de productos
    filtros.forEach(filtro => {
        filtro.addEventListener('click', function() {
            // Remover clase activa de todos los filtros
            filtros.forEach(f => f.classList.remove('activo'));
            // Añadir clase activa al filtro seleccionado
            this.classList.add('activo');
            
            const categoria = this.dataset.categoria;
            
            // Filtrar productos
            productos.forEach(producto => {
                if (categoria === 'todos' || producto.dataset.categoria === categoria) {
                    producto.style.display = 'block';
                } else {
                    producto.style.display = 'none';
                }
            });
        });
    });

    // Botones de favorito
    botonesFavorito.forEach(boton => {
        boton.addEventListener('click', function() {
            this.classList.toggle('activo');
            this.innerHTML = this.classList.contains('activo') ? 
                '<i class="fas fa-heart"></i>' : 
                '<i class="far fa-heart"></i>';
            
            // Aquí puedes añadir lógica para guardar favoritos en localStorage o backend
        });
    });

    // Animación al cargar productos
    function animarProductos() {
        const tiempoBase = 100;
        
        productos.forEach((producto, index) => {
            setTimeout(() => {
                producto.style.opacity = '1';
                producto.style.transform = 'translateY(0)';
            }, tiempoBase * index);
        });
    }

    // Inicializar animación
    productos.forEach(producto => {
        producto.style.opacity = '0';
        producto.style.transform = 'translateY(20px)';
        producto.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    });

    setTimeout(animarProductos, 300);
});