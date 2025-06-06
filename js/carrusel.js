document.addEventListener('DOMContentLoaded', () => {
    const carrusel = document.querySelector('.carrusel-contenedor');
    const slides = document.querySelectorAll('.carrusel-slide');
    const btnIzq = document.querySelector('.carrusel-btn-izq');
    const btnDer = document.querySelector('.carrusel-btn-der');
    const indicadoresContainer = document.querySelector('.carrusel-indicadores');
    let currentIndex = 0;
    let intervalId;

    // Crear indicadores
    slides.forEach((_, index) => {
        const indicador = document.createElement('div');
        indicador.classList.add('carrusel-indicador');
        if (index === 0) indicador.classList.add('activo');
        indicador.addEventListener('click', () => goToSlide(index));
        indicadoresContainer.appendChild(indicador);
    });

    const indicadores = document.querySelectorAll('.carrusel-indicador');

    // Función para cambiar de slide
    function goToSlide(index) {
        slides[currentIndex].classList.remove('activo');
        indicadores[currentIndex].classList.remove('activo');
        
        currentIndex = (index + slides.length) % slides.length;
        
        slides[currentIndex].classList.add('activo');
        indicadores[currentIndex].classList.add('activo');
    }

    // Función para siguiente slide
    function nextSlide() {
        goToSlide(currentIndex + 1);
    }

    // Función para slide anterior
    function prevSlide() {
        goToSlide(currentIndex - 1);
    }

    // Event listeners para botones
    btnDer.addEventListener('click', () => {
        resetInterval();
        nextSlide();
    });

    btnIzq.addEventListener('click', () => {
        resetInterval();
        prevSlide();
    });

    // Auto-avance
    function startInterval() {
        intervalId = setInterval(nextSlide, 5000);
    }

    function resetInterval() {
        clearInterval(intervalId);
        startInterval();
    }

    // Iniciar carrusel
    startInterval();

    // Pausar al hacer hover
    carrusel.addEventListener('mouseenter', () => {
        clearInterval(intervalId);
    });

    carrusel.addEventListener('mouseleave', startInterval);
});