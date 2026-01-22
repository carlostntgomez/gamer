$(document).ready(function() {

    // =================================================================================
    // 1. FUNCIONES AUXILIARES PARA EL PANEL LATERAL DEL CARRITO (DRAWER)
    // =================================================================================

    // Se adjuntan a 'window' para que sean accesibles globalmente desde otros scripts.

    window.openCartDrawer = () => {
        $("#cart-drawer").addClass('active');
        $(".bg-screen").addClass('active');
        $("body").addClass('hidden');
    };

    window.closeCartDrawer = () => {
        $("#cart-drawer").removeClass('active');
        $(".bg-screen").removeClass('active');
        $("body").removeClass('hidden');
    };

    window.refreshCartDrawer = (callback) => {
        $.ajax({
            url: '/cart/drawer?_t=' + new Date().getTime(), // Cache-busting
            method: 'GET',
            success: function(responseHtml) {
                const $existingDrawer = $('#cart-drawer');
                if ($existingDrawer.length) {
                    $existingDrawer.replaceWith(responseHtml);
                } else {
                    $('body').append(responseHtml);
                }
                initializeCartDrawerEvents();
                if (callback && typeof callback === 'function') {
                    callback(); // Ejecuta el callback si existe (ej. openCartDrawer)
                }
            },
            error: (xhr) => console.error('Error al refrescar el cajón del carrito:', xhr.responseText)
        });
    };

    const initializeCartDrawerEvents = () => {
        $(document).off('click', '.js-qty-adjust').on('click', '.js-qty-adjust', function() {
            const $this = $(this);
            const rowId = $this.data('id');
            const action = $this.data('action');
            const $input = $this.closest('.js-qty-wrap').find('.js-qty-num');
            const currentQuantity = parseInt($input.val());
            let newQuantity = action === 'increase' ? currentQuantity + 1 : currentQuantity - 1;

            if (rowId && newQuantity > 0) {
                sendCartModificationRequest(`/cart/${rowId}`, 'PUT', { quantity: newQuantity });
            } else if (rowId) {
                sendCartModificationRequest(`/cart/${rowId}`, 'DELETE', {});
            }
        });

        $(document).off('click', '.cart-remove').on('click', '.cart-remove', function(e) {
            e.preventDefault();
            const rowId = $(this).data('id');
            if (rowId) {
                sendCartModificationRequest(`/cart/${rowId}`, 'DELETE', {});
            }
        });
    };
    
    const sendCartModificationRequest = (url, method, data) => {
        $.ajax({
            url: url,
            method: method,
            data: { ...data, _token: $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                if(response.success) {
                    // Única responsabilidad: refrescar el panel y actualizar el contador.
                    window.refreshCartDrawer(); 
                    $('.cart-count').text(response.cart_count);
                } else {
                    alert(response.message || 'Hubo un error');
                }
            },
            error: (xhr) => {
                console.error('Error en la modificación del carrito:', xhr.responseText);
                alert('No se pudo comunicar con el servidor.');
            }
        });
    };


    // =================================================================================
    // 2. LÓGICA DE "AÑADIR AL CARRITO" DESDE LA PÁGINA DE PRODUCTO
    // =================================================================================

    $(document).on('submit', 'form.add-to-cart-form', function(e) {
        e.preventDefault();
        const $form = $(this);
        const $button = $form.find('button[type="submit"]');
        
        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            beforeSend: () => $button.addClass('loading').prop('disabled', true),
            success: function(response) {
                if (response.success) {
                    $('.cart-count').text(response.cart_count);
                    // Refresca y abre el panel del carrito.
                    window.refreshCartDrawer(window.openCartDrawer);
                } else {
                    alert(response.message || 'No se pudo añadir el producto.');
                }
            },
            error: (xhr) => {
                console.error('Error al añadir al carrito:', xhr.responseText);
                alert('Error de comunicación con el servidor.');
            },
            complete: () => $button.removeClass('loading').prop('disabled', false)
        });
    });


    // =================================================================================
    // 3. MANEJADORES DE EVENTOS GENERALES
    // =================================================================================

    $(document).on("click", ".js-cart-drawer", window.openCartDrawer);
    $(document).on("click", ".drawer-close-btn, .bg-screen", window.closeCartDrawer);

    // =================================================================================
    // 4. INICIALIZACIÓN AL CARGAR LA PÁGINA
    // =================================================================================

    initializeCartDrawerEvents();

});
