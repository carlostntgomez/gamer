<x-layouts.app>
    {{-- Título de la página --}}
    <x-slot name="title">
        Política de Envíos | TecnnyGames
    </x-slot>

    <!-- Breadcrumb -->
    <section class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-index">
                        <ul class="breadcrumb-ul">
                            <li class="breadcrumb-li">
                                <a class="breadcrumb-link" href="{{ route('home') }}">Inicio</a>
                            </li>
                            <li class="breadcrumb-li">
                                <span class="breadcrumb-text">Política de Envíos</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin del Breadcrumb -->

    <!-- Página de Política de Envíos -->
    <section class="shipping-page section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-capture">
                        <div class="section-title">
                            <h2 data-animate="animate__fadeInUp"><span>Política de Envíos</span></h2>
                        </div>
                    </div>
                    <div class="shipping" data-animate="animate__fadeInUp">
                        <span>P.1</span>
                        <h6 class="shipping-title">¿Cuáles son los costos de envío?</h6>
                        <div class="shipping-content">
                            <p>El costo de envío varía según el producto y la ubicación de entrega. Ofrecemos tarifas competitivas para Lima Metropolitana y envíos a nivel nacional.</p>
                            <p>En algunos productos seleccionados o durante promociones especiales, ¡el envío podría ser gratuito! El costo final del envío se calculará automáticamente en el checkout, antes de finalizar tu compra.</p>
                        </div>
                    </div>
                    <div class="shipping" data-animate="animate__fadeInUp">
                        <span>P.2</span>
                        <h6 class="shipping-title">¿Cuál es el tiempo de entrega estimado?</h6>
                        <div class="shipping-content">
                            <p>El tiempo de entrega estimado es de <strong>1 a 3 días hábiles para Lima Metropolitana</strong> y de <strong>3 a 7 días hábiles para provincias</strong>. Todos los pedidos se despachan desde nuestro almacén en un plazo máximo de 48 horas hábiles después de confirmado el pago.</p>
                        </div>
                    </div>
                    <div class="shipping" data-animate="animate__fadeInUp">
                        <span>P.3</span>
                        <h6 class="shipping-title">¿Cómo se realiza la entrega?</h6>
                        <div class="shipping-content">
                            <p>Trabajamos con las empresas de mensajería más confiables del país para garantizar que tu pedido llegue seguro y a tiempo. Una vez despachado, te enviaremos un correo con el número de seguimiento.</p>
                            <p>Si no hay un servicio de mensajería disponible en tu área, nos pondremos en contacto contigo para coordinar una alternativa de entrega conveniente.</p>
                        </div>
                    </div>
                    <div class="shipping" data-animate="animate__fadeInUp">
                        <span>P.4</span>
                        <h6 class="shipping-title">¿Cómo se empaquetan los artículos?</h6>
                        <div class="shipping-content">
                            <p>En TecnnyGames, la seguridad de tu compra es nuestra prioridad. Todos los artículos se empaquetan cuidadosamente en cajas resistentes y con material de protección para evitar cualquier tipo de daño durante el transporte.</p>
                        </div>
                    </div>
                    <div class="shipping" data-animate="animate__fadeInUp">
                        <span>P.5</span>
                        <h6 class="shipping-title">¿Puedo rastrear mi pedido?</h6>
                        <div class="shipping-content">
                            <p>¡Por supuesto! Tan pronto como tu pedido sea despachado, recibirás un correo electrónico de confirmación de envío que incluirá un número de seguimiento y un enlace a la página del transportista para que puedas ver el estado de tu entrega en tiempo real.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin de la Página de Política de Envíos -->

</x-layouts.app>
