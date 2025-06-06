document.addEventListener('DOMContentLoaded', function() {
    
    const urlParams = new URLSearchParams(window.location.search);
    const servicioSeleccionado = urlParams.get('servicio');

        // Seleccionar automáticamente el servicio si viene en la URL
     if (servicioSeleccionado) {
        const selectServicio = document.getElementById('servicio');
        selectServicio.value = servicioSeleccionado;
        
        // Opcional: Scroll hasta el formulario
        document.querySelector('.formulario-cita').scrollIntoView({
            behavior: 'smooth'
        });
    }

    // Horarios disponibles
    const horariosDisponibles = [
        '09:00', '10:00', '11:00', '12:00', 
        '15:00', '16:00', '17:00', '18:00'
    ];
    
    // Llenar opciones de hora
    function llenarHorarios() {
        selectHora.innerHTML = '<option value="">Seleccione hora</option>';
        
        horariosDisponibles.forEach(hora => {
            const option = document.createElement('option');
            option.value = hora;
            option.textContent = hora;
            selectHora.appendChild(option);
        });
    }
    
    // Cargar servicios desde servicios.html (simulado)
    function cargarServicios() {
        const servicios = [
            { id: 'consulta-general', nombre: 'Consulta General' },
            { id: 'vacunacion', nombre: 'Vacunación' },
            { id: 'estetica', nombre: 'Estética Canina' },
            { id: 'cirugia', nombre: 'Cirugías' },
            { id: 'odontologia', nombre: 'Odontología' },
            { id: 'hospitalizacion', nombre: 'Hospitalización' },
            { id: 'emergencia', nombre: 'Emergencia' }
        ];
        
        servicios.forEach(servicio => {
            const option = document.createElement('option');
            option.value = servicio.id;
            option.textContent = servicio.nombre;
            selectServicio.appendChild(option);
        });
    }
    
    // Validar y enviar formulario
    formulario.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validación básica
        if (!this.checkValidity()) {
            alert('Por favor complete todos los campos requeridos');
            return;
        }
        
        // Obtener datos del formulario
        const formData = new FormData(this);
        const datosCita = Object.fromEntries(formData.entries());
        
        // Aquí normalmente harías una petición AJAX o fetch a tu backend
        console.log('Datos de la cita:', datosCita);
        
        // Simular envío exitoso
        alert(`Cita agendada exitosamente para ${datosCita['mascota-nombre']} el ${datosCita.fecha} a las ${datosCita.hora}`);
        this.reset();
    });
    
    // Inicializar
    llenarHorarios();
    cargarServicios();
    
    // Actualizar horarios cuando cambia la fecha
    document.getElementById('fecha').addEventListener('change', function() {
        // Aquí podrías hacer una petición al servidor para obtener horarios disponibles reales
        console.log('Fecha seleccionada:', this.value);
    });
});