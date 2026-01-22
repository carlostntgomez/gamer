<x-layouts.app>
    {{-- Título de la página --}}
    <x-slot name="title">
        Políticas de Pago | TecnnyGames
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
                                <span class="breadcrumb-text">Políticas de Pago</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin del Breadcrumb -->

    <!-- Página de Políticas de Pago -->
    <section class="shipping-page section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-capture">
                        <div class="section-title">
                            <h2 data-animate="animate__fadeInUp"><span>Políticas de Pago</span></h2>
                        </div>
                    </div>
                    <div class="shipping" data-animate="animate__fadeInUp">
                        <span>P.1</span>
                        <h6 class="shipping-title">¿Cómo puedo pagar mi compra en TecnnyGames?</h6>
                        <div class="shipping-content">
                            <p>En TecnnyGames, te ofrecemos múltiples métodos de pago para tu comodidad. Puedes estar seguro de que nuestros socios de pasarela de pago utilizan tecnología de encriptación segura para mantener la confidencialidad de los detalles de tu transacción en todo momento.</p>
                            <p>Aceptamos tarjetas de crédito/débito (Visa, MasterCard, American Express), PayPal, y transferencias bancarias directas.</p>
                        </div>
                    </div>
                    <div class="shipping" data-animate="animate__fadeInUp">
                        <span>P.2</span>
                        <h6 class="shipping-title">¿Puedo realizar un pago con tarjeta de crédito/débito o banca por internet a través de mi celular?</h6>
                        <div class="shipping-content">
                            <p>¡Claro que sí! Puedes realizar pagos con tarjeta de crédito de forma segura a través del sitio móvil de TecnnyGames. Utilizamos tecnología de encriptación de 256 bits para proteger la información de tu tarjeta mientras se transmite de forma segura a nuestras pasarelas de pago de confianza, administradas por bancos líderes.</p>
                        </div>
                    </div>
                    <div class="shipping" data-animate="animate__fadeInUp">
                        <span>P.3</span>
                        <h6 class="shipping-title">¿Es seguro usar mi tarjeta de crédito/débito en TecnnyGames?</h6>
                        <div class="shipping-content">
                            <p>Tu seguridad es nuestra prioridad. Todos los detalles de las tarjetas de crédito/débito permanecen confidenciales y privados. TecnnyGames y nuestras pasarelas de pago de confianza utilizan tecnología de encriptación SSL para proteger la información de tu tarjeta durante toda la transacción.</p>
                        </div>
                    </div>
                    <div class="shipping" data-animate="animate__fadeInUp">
                        <span>P.4</span>
                        <h6 class="shipping-title">¿TecnnyGames almacena la información de mi tarjeta de crédito?</h6>
                        <div class="shipping-content">
                            <p>No. TecnnyGames no recopila ni almacena la información de tu cuenta en absoluto. Tu transacción es autorizada en múltiples puntos, primero por nuestras pasarelas de pago (como Culqi, MercadoPago) y posteriormente por la seguridad de Visa/MasterCard/AMEX directamente, sin que ninguna información pase a través de nuestros servidores.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin de la Página de Políticas de Pago -->

</x-layouts.app>
