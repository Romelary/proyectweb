document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("modal-producto");
  const btnNuevo = document.getElementById("btn-nuevo-producto");
  const form = document.getElementById("form-producto");
  const closeBtn = document.querySelector(".close-modal");

  const idField = document.getElementById("producto-id");
  const nombre = document.getElementById("nombre");
  const categoria = document.getElementById("categoria_id");
  const descripcion = document.getElementById("descripcion");
  const precio = document.getElementById("precio");
  const precioAnterior = document.getElementById("precio_anterior");
  const stock = document.getElementById("stock");
  const destacado = document.getElementById("destacado");
  const imagen = document.getElementById("imagen");
  const preview = document.getElementById("preview-imagen");

  // Mostrar modal para nuevo producto
  btnNuevo.addEventListener("click", () => {
    limpiarFormulario();
    document.getElementById("modal-titulo").textContent = "Nuevo Producto";
    modal.style.display = "block";
  });

  // Cerrar modal
  closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
  });

  window.addEventListener("click", (e) => {
    if (e.target === modal) modal.style.display = "none";
  });

  // Vista previa de imagen
  imagen.addEventListener("change", (e) => {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = () => {
        preview.innerHTML = `<img src="${reader.result}" style="max-width: 100px;">`;
      };
      reader.readAsDataURL(file);
    } else {
      preview.innerHTML = "";
    }
  });

  // Enviar formulario (crear o actualizar)
  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const formData = new FormData(form);
    const url = idField.value ? "../php/actualizar_producto.php" : "../php/crear_producto.php";

    fetch(url, {
      method: "POST",
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          alert("Producto guardado correctamente.");
          location.reload();
        } else {
          alert("Error: " + (data.error || "No se pudo guardar el producto."));
        }
      })
      .catch(err => {
        console.error("Error de red:", err);
        alert("Error de red al guardar el producto.");
      });
  });

  // Botones editar
  document.querySelectorAll(".btn-editar").forEach(btn => {
  btn.addEventListener("click", () => {
    const id = btn.dataset.id;

    fetch(`../php/obtener_producto.php?id=${id}`)
      .then(res => res.json())
      .then(producto => {
        if (producto && producto.id) {
          idField.value = producto.id;
          nombre.value = producto.nombre;
          categoria.value = producto.categoria_id;
          descripcion.value = producto.descripcion;
          precio.value = producto.precio;
          precioAnterior.value = producto.precio_anterior;
          stock.value = producto.stock;
          destacado.value = producto.destacado;
          preview.innerHTML = producto.imagen
            ? `<img src="../${producto.imagen}" style="max-width: 100px;">`
            : "";

          document.getElementById("modal-titulo").textContent = "Editar Producto";
          modal.style.display = "block";
        } else {
          alert("Error al obtener producto.");
        }
      })
      .catch(error => {
        console.error("Error de conexión o formato:", error);
        alert("Error al obtener producto.");
      });
  });
});


  // Botones eliminar
  document.querySelectorAll(".btn-eliminar").forEach(btn => {
    btn.addEventListener("click", () => {
      if (confirm("¿Estás seguro de eliminar este producto?")) {
        const id = btn.dataset.id;
        fetch("../php/eliminar_producto.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `id=${id}`
        })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              alert("Producto eliminado.");
              location.reload();
            } else {
              alert("Error al eliminar: " + (data.error || ""));
            }
          });
      }
    });
  });

  function limpiarFormulario() {
    idField.value = "";
    nombre.value = "";
    categoria.value = "";
    descripcion.value = "";
    precio.value = "";
    precioAnterior.value = "";
    stock.value = "";
    destacado.value = "0";
    imagen.value = "";
    preview.innerHTML = "";
  }
});
