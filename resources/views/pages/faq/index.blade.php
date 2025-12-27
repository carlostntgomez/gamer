<x-layouts.app>
    {{-- Título de la página --}}
    <x-slot name="title">
        Preguntas Frecuentes (FAQ) | TecnnyGames
    </x-slot>

    <!-- Breadcrumb -->
    <section class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-index">
                        <ul class="breadcrumb-ul">
                            <li class="breadcrumb-li">
                                <a class="breadcrumb-link" href="{{ route('''home''') }}">Inicio</a>
                            </li>
                            <li class="breadcrumb-li">
                                <span class="breadcrumb-text">Preguntas Frecuentes</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin del Breadcrumb -->

    <!-- Página de FAQ -->
    <section class="faq-page section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-capture">
                        <div class="section-title">
                            <h2 data-animate="animate__fadeInUp"><span>Preguntas Frecuentes</span></h2>
                        </div>
                    </div>
                    <div class="content-qa-banner">
                        <div class="banner-image banner-hover" data-animate="animate__fadeInUp">
                            <img src="{{ asset('''img/other-pages/faq.jpg''') }}" class="img-fluid" alt="FAQ TecnnyGames">
                        </div>
                        <div class="que-ans">
                            <ul class="accordian-ul">
                                <li class="accordian-li" data-animate="animate__fadeInUp">
                                    <a href="#faq-1" class="accordian" data-bs-toggle="collapse" aria-expanded="true">
                                        <h6 class="acco-text">¿Cuáles son los métodos de pago aceptados?</h6>
                                        <span class="acco-arrow"><i class="bi bi-chevron-down"></i></span>
                                    </a>
                                    <div class="ans-accordian show" id="faq-1">
                                        <p>Aceptamos una amplia variedad de métodos de pago, incluyendo tarjetas de crédito y débito (Visa, MasterCard, American Express), PayPal, y transferencias bancarias. ¡Tus datos están 100% seguros con nosotros!</p>
                                    </div>
                                </li>
                                <li class="accordian-li" data-animate="animate__fadeInUp">
                                    <a href="#faq-2" class="accordian" data-bs-toggle="collapse">
                                        <h6 class="acco-text">¿Cuánto tiempo tarda en llegar mi pedido?</h6>
                                        <span class="acco-arrow"><i class="bi bi-chevron-down"></i></span>
                                    </a>
                                    <div class="ans-accordian collapse" id="faq-2">
                                        <p>El tiempo de entrega varía según tu ubicación. Para Lima Metropolitana, el envío estándar es de 24 a 48 horas hábiles. Para otras provincias, puede tomar de 3 a 7 días hábiles. Ofrecemos también un servicio de envío express con costo adicional.</p>
                                    </div>
                                </li>
                                <li class="accordian-li" data-animate="animate__fadeInUp">
                                    <a href="#faq-3" class="accordian" data-bs-toggle="collapse">
                                        <h6 class="acco-text">¿Puedo devolver un producto?</h6>
                                        <span class="acco-arrow"><i class="bi bi-chevron-down"></i></span>
                                    </a>
                                    <div class="ans-accordian collapse" id="faq-3">
                                        <p>¡Sí! Tienes 7 días calendario desde que recibes tu producto para solicitar una devolución. El producto debe estar sellado, sin uso y con todos sus empaques originales. Los costos de envío de la devolución corren por cuenta del cliente, a menos que se trate de un error nuestro.</p>
                                    </div>
                                </li>
                                <li class="accordian-li" data-animate="animate__fadeInUp">
                                    <a href="#faq-4" class="accordian" data-bs-toggle="collapse">
                                        <h6 class="acco-text">¿Cómo hago válida la garantía de un producto?</h6>
                                        <span class="acco-arrow"><i class="bi bi-chevron-down"></i></span>
                                    </a>
                                    <div class="ans-accordian collapse" id="faq-4">
                                        <p>Todos nuestros productos nuevos cuentan con garantía del fabricante. Si tu producto presenta un defecto de fábrica, contáctanos a través de nuestro formulario de soporte adjuntando tu boleta o factura de compra. Nosotros te guiaremos en el proceso para hacer válida la garantía con la marca correspondiente.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin de la página de FAQ -->

</x-layouts.app>
