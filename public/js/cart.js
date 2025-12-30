// Lógica para abrir y cerrar el cajón del carrito
$(document).ready(function() {
    $(".cart-wrapper a.js-cart-drawer,  .bottom-menu-wrapper a.bottom-menu-cart, a.add-to-cart, .bottom-menu-cart").on("click", function() {
        $("#cart-drawer").addClass('active');
        $(".bg-screen").addClass('active');
        $("body").addClass('hidden');
    });
    $(".drawer-close button.drawer-close-btn").on("click", function() {
        $("#cart-drawer").removeClass('active');
        $(".bg-screen").removeClass('active');
        $("body").removeClass('hidden');
    });

    // Lógica para cerrar el cajón del carrito y otros elementos cuando se hace clic en el fondo
    $(".bg-screen").on("click", function() {
        $(this).removeClass('active');
        $(".main-menu-area").removeClass('active');
        $("#cart-drawer").removeClass('active');
        $("body").removeClass('hidden');
    });
});

// Funcionalidad AJAX para añadir productos al carrito
$(document).on('click', '.add-to-cart-ajax', function(e) {
    e.preventDefault(); // Evitar el comportamiento predeterminado del enlace/botón

    var $this = $(this);
    var productId = $this.data('product-id');
    var quantity = $this.closest('.product-details, .single-product-wrap').find('input[name="quantity"]').val();
    quantity = quantity ? parseInt(quantity) : 1; // Por defecto 1 si el input de cantidad no se encuentra o está vacío

    if (!productId) {
        console.error('ID de producto no encontrado para añadir al carrito.');
        alert('Error: El ID del producto no está disponible.');
        return;
    }

    $.ajax({
        url: '/cart/add', // Ruta de Laravel para añadir al carrito
        method: 'POST',
        data: {
            product_id: productId,
            quantity: quantity,
            _token: $('meta[name="csrf-token"]').attr('content') // Token CSRF para Laravel
        },
        success: function(response) {
            if (response.success) {
                // Actualizar el HTML del cajón del carrito
                $('#cart-drawer').html(response.cart_drawer_html);
                // Actualizar el contador del carrito en la interfaz
                $('.bigcounter, .cart-counter').text(response.cart_count); // Asumiendo que ambas clases se usan para mostrar el contador

                // Mostrar el cajón del carrito si no estaba visible
                $("#cart-drawer").addClass('active');
                $(".bg-screen").addClass('active');
                $("body").addClass('hidden');

                alert(response.message); // Mostrar mensaje de éxito al usuario
            } else {
                alert('Error al añadir el producto al carrito: ' + (response.message || 'Error desconocido.'));
            }
        },
        error: function(xhr) {
            console.error('Error AJAX al añadir al carrito:', xhr.responseText);
            alert('Hubo un error al añadir el producto al carrito. Por favor, inténtalo de nuevo.');
            }
        });
    });