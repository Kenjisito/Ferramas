$(document).ready(function() {
    // Lógica para el formulario de inicio de sesión
    $('#loginForm').on('submit', function(event) {
        event.preventDefault();
        
        const usuario = $(this).find('input[type="text"]').val();
        const contrasena = $(this).find('input[type="password"]').val();

        // Simulación de autenticación
        if (usuario === "admin" && contrasena === "1234") {
            window.location.href = 'home.html'; // Redirige al home después del login
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Usuario o contraseña incorrectos.',
            });
        }
    });

    // Lógica para añadir productos al carrito
    $('.btn-primary.agregar-carrito').on('click', function() {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        const precio = parseFloat($(this).data('precio'));

        let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

        // Buscar si el producto ya está en el carrito
        const productoExistente = carrito.find(p => p.id === id);

        if (productoExistente) {
            productoExistente.cantidad += 1;
        } else {
            carrito.push({ id, nombre, precio, cantidad: 1 });
        }

        // Guardar carrito en localStorage
        localStorage.setItem('carrito', JSON.stringify(carrito));

        Swal.fire({
            icon: 'success',
            title: 'Producto añadido',
            text: `${nombre} se ha añadido al carrito.`,
        });
    });

    // Función para mostrar productos en el carrito (carrito.html)
    if (window.location.pathname.includes('carrito.html')) {
        const carritoContainer = $('#carritoContainer');
        let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

        carrito.forEach(producto => {
            carritoContainer.append(`
                <div class="alert alert-info">
                    <strong>${producto.nombre}</strong> - Precio: $${producto.precio} x ${producto.cantidad}
                </div>
            `);
        });
    }
});
