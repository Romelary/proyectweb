document.addEventListener('DOMContentLoaded', function() {
    const selectServicio = document.getElementById('servicio');
    const selectHora = document.getElementById('hora');
    const formulario = document.querySelector('.formulario-cita');
    const fechaInput = document.getElementById('fecha');

    // Preseleccionar servicio desde URL
    const urlParams = new URLSearchParams(window.location.search);
    const servicioSeleccionado = urlParams.get('servicio');

    if (servicioSeleccionado) {
        selectServicio.value = servicioSeleccionado;
        formulario.scrollIntoView({ behavior: 'smooth' });
    }

    // Cargar servicios si están vacíos
    const servicios = [
        { id: 'consulta-general', nombre: 'Consulta General' },
        { id: 'vacunacion', nombre: 'Vacunación' },
        { id: 'estetica', nombre: 'Estética Canina' },
        { id: 'cirugia', nombre: 'Cirugías' },
        { id: 'odontologia', nombre: 'Odontología' },
        { id: 'hospitalizacion', nombre: 'Hospitalización' },
        { id: 'emergencia', nombre: 'Emergencia' }
    ];
    if (selectServicio.children.length <= 1) {
        servicios.forEach(servicio => {
            const option = document.createElement('option');
            option.value = servicio.id;
            option.textContent = servicio.nombre;
            selectServicio.appendChild(option);
        });
    }

    // Cargar horas disponibles según la fecha seleccionada
    function cargarHorasDisponibles(fecha) {
        selectHora.innerHTML = '<option>Cargando...</option>';
        fetch(`php/horas_disponibles.php?fecha=${fecha}`)
            .then(response => response.json())
            .then(horas => {
                selectHora.innerHTML = '';
                if (horas.length > 0) {
                    const opt = document.createElement('option');
                    opt.value = '';
                    opt.textContent = 'Seleccione hora';
                    selectHora.appendChild(opt);
                    horas.forEach(hora => {
                        const option = document.createElement('option');
                        option.value = hora;
                        option.textContent = hora;
                        selectHora.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'No hay horarios disponibles';
                    selectHora.appendChild(option);
                }
            })
            .catch(error => {
                console.error('Error al cargar horas:', error);
                selectHora.innerHTML = '<option>Error al cargar horarios</option>';
            });
    }

    // Cuando cambia la fecha, actualiza horarios
    fechaInput.addEventListener('change', function() {
        const fechaSeleccionada = this.value;
        if (fechaSeleccionada) {
            cargarHorasDisponibles(fechaSeleccionada);
        }
    });

    // Validación personalizada al enviar
    formulario.addEventListener('submit', function(e) {
        let valido = true;
        const tipo = document.getElementById('tipo');
        const nombreMascota = document.getElementById('mascota-nombre');
        const nombreDueño = document.getElementById('nombre');
        const telefono = document.getElementById('telefono');
        const email = document.getElementById('email');

        if (
            selectServicio.value === '' ||
            tipo.value === '' ||
            selectHora.value === '' ||
            nombreMascota.value.trim() === '' ||
            nombreDueño.value.trim() === '' ||
            telefono.value.trim() === '' ||
            email.value.trim() === ''
        ) {
            e.preventDefault();
            valido = false;
            alert('Por favor complete todos los campos requeridos correctamente.');
        }

        // Validación del teléfono
        if (!/^[0-9]{9}$/.test(telefono.value.trim())) {
            e.preventDefault();
            valido = false;
            alert('El número de teléfono debe contener 9 dígitos numéricos.');
        }

        // Validación básica del correo
        if (!email.value.includes('@') || !email.value.includes('.')) {
            e.preventDefault();
            valido = false;
            alert('Ingrese un correo electrónico válido.');
        }

        if (!valido) return;
    });
});
