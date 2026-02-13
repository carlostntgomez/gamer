<x-layouts.app>
    @php
        // Data is passed from CheckoutController
    @endphp

    <!-- breadcrumb start -->
    <section class="breadcrumb-area">
        <div class="container">
            <div class="col">
                <div class="row">
                    <div class="breadcrumb-index">
                        <ul class="breadcrumb-ul">
                            <li class="breadcrumb-li"><a class="breadcrumb-link" href="{{ route('home') }}">Inicio</a></li>
                            <li class="breadcrumb-li"><span class="breadcrumb-text">Checkout</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end -->

    <!-- checkout-area start -->
    <section class="section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="checkout-area">
                        <form method="POST" action="{{ route('checkout.store') }}" id="checkout-form">
                            @csrf
                            <input type="hidden" name="submit_type" id="submit_type" value="">
                            <input type="hidden" name="country" value="Colombia">
                        </form>

                        <!-- Wizard Navigation -->
                        <div class="wizard-nav">
                            <div class="wizard-step active" data-step="1">
                                <div class="step-icon">1</div>
                                <div class="step-label">Envío</div>
                            </div>
                            <div class="wizard-step" data-step="2">
                                <div class="step-icon">2</div>
                                <div class="step-label">Pago</div>
                            </div>
                            <div class="wizard-step" data-step="3">
                                <div class="step-icon">3</div>
                                <div class="step-label">Confirmar</div>
                            </div>
                        </div>

                        <div id="validation-errors" class="alert alert-danger d-none mt-3"></div>
                        
                        <!-- Wizard Content -->
                        <div class="wizard-content">
                            <!-- Step 1: Billing and Shipping Details -->
                            <div class="wizard-pane active" data-step="1">
                                <div class="billing-area">
                                    <form onsubmit="return false;">
                                        <h2 data-animate="animate__fadeInUp">Detalles de facturación</h2>
                                        <p class="mb-3">Los campos marcados con * son obligatorios.</p>
                                        <div class="billing-form">
                                            <ul class="input-2" data-animate="animate__fadeInUp">
                                                <li class="billing-li"><label>Nombres *</label><input form="checkout-form" type="text" name="first_name" placeholder="Tus nombres" value="{{ old('first_name', auth()->user()->name ?? '') }}" required></li>
                                                <li class="billing-li"><label>Apellidos *</label><input form="checkout-form" type="text" name="last_name" placeholder="Tus apellidos" value="{{ old('last_name', auth()->user()->last_name ?? '') }}" required></li>
                                            </ul>
                                            <ul class="billing-ul">
                                                <li class="billing-li" data-animate="animate__fadeInUp"><label>Departamento *</label><input form="checkout-form" type="text" name="state" placeholder="Ej: Antioquia" value="{{ old('state') }}" required></li>
                                                <li class="billing-li" data-animate="animate__fadeInUp">
                                                    <label>Ciudad / Municipio *</label>
                                                    <select form="checkout-form" name="city" id="city" required>
                                                        <option value="">Seleccione un municipio</option>
                                                        @foreach($municipalities as $municipality)
                                                            <option value="{{ $municipality->municipality }}" {{ old('city') == $municipality->municipality ? 'selected' : '' }}>{{ $municipality->municipality }}</option>
                                                        @endforeach
                                                    </select>
                                                </li>
                                                <li class="billing-li" data-animate="animate__fadeInUp">
                                                    <label>Barrio *</label>
                                                    <select form="checkout-form" name="neighborhood" id="neighborhood" required>
                                                        <option value="">Seleccione un barrio</option>
                                                    </select>
                                                </li>
                                                <li class="billing-li" data-animate="animate__fadeInUp"><label>Dirección *</label><input form="checkout-form" type="text" name="address" placeholder="Ej: Calle 10 #43A-25" value="{{ old('address') }}" required></li>
                                                <li class="billing-li" data-animate="animate__fadeInUp"><label>Interior, Apto, etc. (Opcional)</label><input form="checkout-form" type="text" name="apartment" placeholder="Ej: Apto 502" value="{{ old('apartment') }}"></li>
                                            </ul>
                                            <ul class="input-2" data-animate="animate__fadeInUp">
                                                <li class="billing-li"><label>Email *</label><input form="checkout-form" type="email" name="email" placeholder="tu@correo.com" value="{{ old('email', auth()->user()->email ?? '') }}" required></li>
                                                <li class="billing-li"><label>Celular / WhatsApp *</label><input form="checkout-form" type="text" name="phone" placeholder="Ej: 3001234567" value="{{ old('phone') }}" required></li>
                                            </ul>
                                        </div>
                                    </form>
                                    <div class="billing-details mt-4">
                                        <form onsubmit="return false;">
                                            <h2 data-animate="animate__fadeInUp">Detalles de envío</h2>
                                            <ul class="shipping-form pro-submit">
                                                <li class="check-box label-info">
                                                    <label class="box-area" data-animate="animate__fadeInUp">
                                                        <span class="text">¿Enviar a una dirección diferente?</span>
                                                        <input form="checkout-form" type="checkbox" name="ship_to_different_address" id="ship-to-different-address" value="1" {{ old('ship_to_different_address') ? 'checked' : '' }} class="cust-checkbox">
                                                        <span class="cust-check"></span>
                                                    </label>
                                                </li>
                                                <div id="shipping-address-form" class="billing-form {{ old('ship_to_different_address') ? '' : 'd-none' }}" data-animate="animate__fadeInUp">
                                                    <ul class="input-2 mt-3">
                                                        <li class="billing-li"><label>Nombres de quien recibe *</label><input form="checkout-form" type="text" name="shipping_first_name" value="{{ old('shipping_first_name') }}" placeholder="Nombres de quien recibe"></li>
                                                        <li class="billing-li"><label>Apellidos de quien recibe *</label><input form="checkout-form" type="text" name="shipping_last_name" value="{{ old('shipping_last_name') }}" placeholder="Apellidos de quien recibe"></li>
                                                    </ul>
                                                    <ul class="billing-ul mt-3">
                                                        <li class="billing-li"><label>Departamento *</label><input form="checkout-form" type="text" name="shipping_state" value="{{ old('shipping_state') }}" placeholder="Departamento"></li>
                                                        <li class="billing-li">
                                                            <label>Ciudad / Municipio *</label>
                                                            <select form="checkout-form" name="shipping_city" id="shipping_city">
                                                                <option value="">Seleccione un municipio</option>
                                                                @foreach($municipalities as $municipality)
                                                                    <option value="{{ $municipality->municipality }}" {{ old('shipping_city') == $municipality->municipality ? 'selected' : '' }}>{{ $municipality->municipality }}</option>
                                                                @endforeach
                                                            </select>
                                                        </li>
                                                        <li class="billing-li">
                                                            <label>Barrio *</label>
                                                            <select form="checkout-form" name="shipping_neighborhood" id="shipping_neighborhood">
                                                                <option value="">Seleccione un barrio</option>
                                                            </select>
                                                        </li>
                                                        <li class="billing-li"><label>Dirección *</label><input form="checkout-form" type="text" name="shipping_address" value="{{ old('shipping_address') }}" placeholder="Dirección de entrega"></li>
                                                    </ul>
                                                </div>
                                            </ul>
                                        </form>
                                    </div>
                                </div>
                                <div class="wizard-footer">
                                    <button type="button" class="btn-style2 wizard-next">Siguiente</button>
                                </div>
                            </div>

                            <!-- Step 2: Order and Payment -->
                            <div class="wizard-pane" data-step="2">
                                <div class="order-area">
                                    <h2 data-animate="animate__fadeInUp">Tu pedido</h2>
                                    <ul class="order-history">
                                        <li class="order-details" data-animate="animate__fadeInUp"><span>Subtotal</span><span id="summary-subtotal">${{ number_format($subtotal, 0, ',', '.') }}</span></li>
                                        <li class="order-details" data-animate="animate__fadeInUp"><span>Envío</span><span id="summary-shipping">Selecciona una dirección</span></li>
                                        <li class="order-details" data-animate="animate__fadeInUp"><span>Total</span><span id="summary-total">${{ number_format($total, 0, ',', '.') }}</span></li>
                                    </ul>
                                    <form onsubmit="return false;">
                                        <ul class="order-form pro-submit">
                                            <li class="label-info" data-animate="animate__fadeInUp"><label class="box-area"><span class="text">Transferencia Bancaria (Bancolombia, Nequi)</span><input form="checkout-form" type="radio" name="payment_method" value="bank_transfer" checked="checked" class="cust-checkbox"><span class="cust-check"></span></label></li>
                                            <li class="label-info" data-animate="animate__fadeInUp"><label class="box-area"><span class="text">Pago Contra Entrega</span><input form="checkout-form" type="radio" name="payment_method" value="cash_on_delivery" class="cust-checkbox"><span class="cust-check"></span></label></li>
                                        </ul>
                                        <ul class="order-form pro-submit">
                                            <li class="check-box label-info" data-animate="animate__fadeInUp"><label class="box-area"><span class="text">He leído y acepto los <a href="{{ route('terms-condition.index') }}" target="_blank">términos y condiciones</a> *</span><input form="checkout-form" type="checkbox" name="terms_and_conditions" id="terms_and_conditions" class="cust-checkbox" required><span class="cust-check"></span></label></li>
                                        </ul>
                                    </form>
                                </div>
                                <div class="wizard-footer">
                                    <button type="button" class="btn-style2-white wizard-prev">Anterior</button>
                                    <button type="button" class="btn-style2 wizard-next">Siguiente</button>
                                </div>
                            </div>

                            <!-- Step 3: Confirmation -->
                            <div class="wizard-pane" data-step="3">
                                <div class="order-area">
                                    <div class="check-pro" data-animate="animate__fadeInUp">
                                        <h2>En tu carrito ({{ $cartCount }})</h2>
                                        <ul class="check-ul">
                                            @foreach($cart as $id => $details)
                                                @php
                                                    $imageUrl = isset($details['image']) && $details['image'] ? Storage::url($details['image']) : url('/images/placeholder-product.png');
                                                @endphp
                                                <li>
                                                    <div class="check-pro-img">
                                                        <a href="#"><img src="{{ $imageUrl }}" class="img-fluid" alt="{{ $details['name'] }}"></a>
                                                    </div>
                                                    <div class="check-content"><a href="#">{{ $details['name'] }}</a><div class="check-qty-pric"><span class="check-qty">{{ $details['quantity'] }} X</span><span class="check-price">${{ number_format($details['price'], 0, ',', '.') }}</span></div></div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <h2 data-animate="animate__fadeInUp">Resumen Final</h2>
                                    <ul class="order-history">
                                        <li class="order-details"><span>Subtotal:</span><span id="confirm-subtotal">${{ number_format($subtotal, 0, ',', '.') }}</span></li>
                                        <li class="order-details"><span>Envío:</span><span id="confirm-shipping"></span></li>
                                        <li class="order-details"><span>Total:</span><span id="confirm-total"></span></li>
                                        <li class="order-details"><span>Método de pago:</span><span id="confirm-payment"></span></li>
                                    </ul>
                                </div>
                                <div class="checkout-btn" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 20px;">
                                    <button type="button" id="direct-checkout-btn" class="btn-style2 checkout" data-animate="animate__fadeInUp">Finalizar Compra</button>
                                    <button type="button" id="whatsapp-checkout-btn" class="btn-style2 checkout" style="background-color: #25D366; border-color: #25D366;" data-animate="animate__fadeInUp">Terminar por WhatsApp</button>
                                </div>
                                <div class="wizard-footer mt-3">
                                    <button type="button" class="btn-style2-white wizard-prev">Anterior</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- checkout-area end -->

    <!-- Modals -->
    <div class="modal fade" id="whatsappModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">¡Pedido Registrado!</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><p>Tu pedido ha sido guardado. Haz clic abajo para confirmar y finalizar por WhatsApp.</p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button><a href="#" id="whatsapp-confirm-link" target="_blank" class="btn btn-success">Confirmar por WhatsApp</a></div></div></div></div>
    <div class="modal fade" id="completeModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">¡Gracias por tu compra!</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><p>Tu pedido ha sido procesado con éxito.</p></div><div class="modal-footer"><a href="{{ route('home') }}" class="btn btn-secondary">Seguir Comprando</a><a href="#" id="order-complete-link" class="btn btn-primary">Ver mi Pedido</a></div></div></div></div>
    <div id="loading-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; display: none; justify-content: center; align-items: center;"><div class="spinner-border text-light" role="status"><span class="visually-hidden">Loading...</span></div></div>

    @push('styles')
    <style>
        .wizard-nav { display: flex; justify-content: space-between; margin-bottom: 20px; border-bottom: 2px solid #eee; }
        .wizard-step { display: flex; align-items: center; padding: 10px 15px; color: #aaa; flex-grow: 1; justify-content: center; }
        .wizard-step .step-icon { width: 30px; height: 30px; border-radius: 50%; background-color: #aaa; color: white; display: flex; align-items: center; justify-content: center; margin-right: 10px; }
        .wizard-step .step-label { font-weight: 500; }
        .wizard-step.active { color: var(--font-color); border-bottom: 2px solid var(--theme-color); }
        .wizard-step.active .step-icon { background-color: var(--theme-color); }
        .wizard-pane { display: none; }
        .wizard-pane.active { display: block; animation: fadeInUp 0.5s; }
        .wizard-footer { display: flex; justify-content: space-between; margin-top: 20px; }
    </style>
    @endpush

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- WIZARD ELEMENTS ---
        const wizardSteps = document.querySelectorAll('.wizard-step');
        const wizardPanes = document.querySelectorAll('.wizard-pane');
        const nextButtons = document.querySelectorAll('.wizard-next');
        const prevButtons = document.querySelectorAll('.wizard-prev');
        let currentStep = 1;

        // --- FORM ELEMENTS ---
        const checkoutForm = document.getElementById('checkout-form');
        const termsCheckbox = document.getElementById('terms_and_conditions');
        const validationErrorsDiv = document.getElementById('validation-errors');
        const submitTypeInput = document.getElementById('submit_type');
        const directCheckoutBtn = document.getElementById('direct-checkout-btn');
        const whatsappCheckoutBtn = document.getElementById('whatsapp-checkout-btn');
        const loadingOverlay = document.getElementById('loading-overlay');
        const whatsappModal = new bootstrap.Modal(document.getElementById('whatsappModal'));
        const completeModal = new bootstrap.Modal(document.getElementById('completeModal'));

        const subtotal = {{ $subtotal ?? 0 }};
        const shippingZones = @json($shippingZones ?? []);
        const oldBillingNeighborhood = "{{ old('neighborhood') }}";
        const oldShippingNeighborhood = "{{ old('shipping_neighborhood') }}";
        
        const summaryShippingEl = document.getElementById('summary-shipping');
        const summaryTotalEl = document.getElementById('summary-total');
        const shipCheckbox = document.getElementById('ship-to-different-address');
        const shippingForm = document.getElementById('shipping-address-form');
        const billingCitySelect = document.getElementById('city');
        const billingNeighborhoodSelect = document.getElementById('neighborhood');
        const shippingCitySelect = document.getElementById('shipping_city');
        const shippingNeighborhoodSelect = document.getElementById('shipping_neighborhood');

        // --- HELPER FUNCTIONS ---
        const formatCurrency = (value) => `$${parseInt(value).toLocaleString('es-CO', { minimumFractionDigits: 0, maximumFractionDigits: 0 })}`;

        function updateNeighborhoods(citySelect, neighborhoodSelect, oldNeighborhoodValue) {
            const selectedCity = citySelect.value;
            neighborhoodSelect.innerHTML = '<option value="">Seleccione un barrio</option>';
            updateShippingCost();

            if (selectedCity) {
                const neighborhoods = shippingZones.filter(zone => zone.municipality === selectedCity).map(zone => zone.neighborhood);
                [...new Set(neighborhoods)].sort().forEach(neighborhood => {
                    const option = document.createElement('option');
                    option.value = neighborhood;
                    option.textContent = neighborhood;
                    if (neighborhood === oldNeighborhoodValue) option.selected = true;
                    neighborhoodSelect.appendChild(option);
                });
            }
             if (oldNeighborhoodValue) updateShippingCost();
        }

        function updateShippingCost() {
            const useShippingAddress = shipCheckbox.checked;
            const city = useShippingAddress ? shippingCitySelect.value : billingCitySelect.value;
            const neighborhood = useShippingAddress ? shippingNeighborhoodSelect.value : billingNeighborhoodSelect.value;
            
            if (!city || !neighborhood) {
                summaryShippingEl.textContent = 'Selecciona una dirección';
                summaryTotalEl.textContent = formatCurrency(subtotal);
                return;
            }

            const zone = shippingZones.find(z => z.municipality === city && z.neighborhood === neighborhood);
            const shippingCost = zone ? parseFloat(zone.price) : 0;
            const total = subtotal + shippingCost;

            summaryShippingEl.textContent = formatCurrency(shippingCost);
            summaryTotalEl.textContent = formatCurrency(total);
        }

        // --- WIZARD LOGIC ---
        function goToStep(step) {
            currentStep = step;
            wizardSteps.forEach(s => s.classList.toggle('active', parseInt(s.dataset.step) === step));
            wizardPanes.forEach(p => p.classList.toggle('active', parseInt(p.dataset.step) === step));
            window.scrollTo(0, 0);
        }
        
        function validateStep(step) {
            let isValid = true;
            const inputsToValidate = wizardPanes.querySelector(`[data-step="${step}"]`).querySelectorAll('[form="checkout-form"][required]');
            inputsToValidate.forEach(input => {
                if (!input.checkValidity()) {
                    isValid = false;
                    input.reportValidity(); // Show browser's validation message
                }
            });
            return isValid;
        }

        nextButtons.forEach(button => {
            button.addEventListener('click', () => {
                //if (validateStep(currentStep)) {
                    if (currentStep < 3) {
                        if(currentStep === 2) { // Update confirmation screen
                            document.getElementById('confirm-subtotal').textContent = formatCurrency(subtotal);
                            document.getElementById('confirm-shipping').textContent = summaryShippingEl.textContent;
                            document.getElementById('confirm-total').textContent = summaryTotalEl.textContent;
                            const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
                            document.getElementById('confirm-payment').textContent = selectedPayment ? selectedPayment.closest('.label-info').querySelector('.text').textContent : 'No seleccionado';
                        }
                        goToStep(currentStep + 1);
                    }
                //}
            });
        });

        prevButtons.forEach(button => {
            button.addEventListener('click', () => {
                if (currentStep > 1) {
                    goToStep(currentStep - 1);
                }
            });
        });


        async function handleFormSubmit() {
            validationErrorsDiv.classList.add('d-none');
            validationErrorsDiv.innerHTML = '';

            if (!termsCheckbox.checked) {
                validationErrorsDiv.innerHTML = '<ul><li>Debes aceptar los términos y condiciones para continuar.</li></ul>';
                validationErrorsDiv.classList.remove('d-none');
                goToStep(2); // Go to payment step where checkbox is
                return;
            }

            // Validate all form fields before submitting
            let isFormFullyValid = true;
            const allInputs = checkoutForm.querySelectorAll('[required]');
            for(const input of allInputs) {
                if(!input.checkValidity()) {
                    isFormFullyValid = false;
                    // Find which step the invalid input is on and go to it
                    const pane = input.closest('.wizard-pane');
                    if(pane) {
                        goToStep(parseInt(pane.dataset.step));
                        input.reportValidity();
                    }
                    break; 
                }
            }
            if(!isFormFullyValid) return;


            loadingOverlay.style.display = 'flex';
            const formData = new FormData(checkoutForm);
            
            try {
                const response = await fetch('{{ route("checkout.store") }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }, body: formData });
                const result = await response.json();
                loadingOverlay.style.display = 'none';

                if (!response.ok) {
                    let errorHtml = '<ul>';
                    if (response.status === 422) {
                        for (const field in result.errors) { result.errors[field].forEach(error => { errorHtml += `<li>${error}</li>`; }); }
                    } else {
                        errorHtml += `<li>Error del servidor: ${result.message || 'Ocurrió un error inesperado.'}</li>`;
                    }
                    errorHtml += '</ul>';
                    validationErrorsDiv.innerHTML = errorHtml;
                    validationErrorsDiv.classList.remove('d-none');
                    window.scrollTo(0, 0);
                    return;
                }
                
                if (result.status === 'success') {
                    if (result.type === 'whatsapp') {
                        document.getElementById('whatsapp-confirm-link').href = result.whatsapp_url;
                        whatsappModal.show();
                    } else if (result.type === 'direct') {
                        document.getElementById('order-complete-link').href = result.redirect_url;
                        completeModal.show();
                    }
                }
            } catch (error) {
                loadingOverlay.style.display = 'none';
                validationErrorsDiv.innerHTML = '<p>No se pudo conectar con el servidor. Revisa tu conexión.</p>';
                validationErrorsDiv.classList.remove('d-none');
                window.scrollTo(0, 0);
            }
        }

        // --- EVENT LISTENERS ---
        directCheckoutBtn.addEventListener('click', () => { submitTypeInput.value = 'direct'; handleFormSubmit(); });
        whatsappCheckoutBtn.addEventListener('click', () => { submitTypeInput.value = 'whatsapp'; handleFormSubmit(); });

        shipCheckbox.addEventListener('change', () => {
            shippingForm.classList.toggle('d-none', !shipCheckbox.checked);
            updateShippingCost();
        });
        
        billingCitySelect.addEventListener('change', () => updateNeighborhoods(billingCitySelect, billingNeighborhoodSelect, oldBillingNeighborhood));
        billingNeighborhoodSelect.addEventListener('change', updateShippingCost);
        shippingCitySelect.addEventListener('change', () => updateNeighborhoods(shippingCitySelect, shippingNeighborhoodSelect, oldShippingNeighborhood));
        shippingNeighborhoodSelect.addEventListener('change', updateShippingCost);

        // --- INITIALIZATION ---
        if (billingCitySelect.value) updateNeighborhoods(billingCitySelect, billingNeighborhoodSelect, oldBillingNeighborhood);
        if (shippingCitySelect.value) updateNeighborhoods(shippingCitySelect, shippingNeighborhoodSelect, oldShippingNeighborhood);
        
    });
    </script>
    @endpush
</x-layouts.app>
