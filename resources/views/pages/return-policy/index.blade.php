<x-layouts.app>
    @props([
        'settings' => \App\Models\Setting::all()->keyBy('key'),
    ])
    {{-- Título de la página --}}
    <x-slot name="title">
        Política de Devoluciones | {{ $settings['company_name']->value ?? 'TecnnyGames' }}
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
                                <span class="breadcrumb-text">Política de Devoluciones</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin del Breadcrumb -->

    <!-- Página de Política de Devoluciones -->
    <section class="shipping-page section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-capture">
                        <div class="section-title">
                            <h2 data-animate="animate__fadeInUp"><span>Política de Devoluciones</span></h2>
                        </div>
                    </div>
                    @if(!empty($settings['return_policy_content']->value))
                        <div class="t-condition-block">
                            <ul class="condition-ul">
                                <li data-animate="animate__fadeInUp">
                                    <p>{!! nl2br(e($settings['return_policy_content']->value)) !!}</p>
                                </li>
                            </ul>
                        </div>
                    @else
                        <div class="shipping" data-animate="animate__fadeInUp">
                            <span>P.1</span>
                            <h6 class="shipping-title">¿Cuál es la política de devoluciones de {{ $settings['company_name']->value ?? 'TecnnyGames' }}?</h6>
                            <div class="shipping-content">
                                <p>Nuestro programa de protección al comprador 100% permite devoluciones fáciles para productos que no coincidan con la descripción/foto en el sitio web, o productos que recibiste en condición dañada, defectuosa o rota.</p>
                                <p>Para que la devolución sea válida, todos los productos deben ser retornados en su condición original, sellados, sin uso, y junto con sus boletas, facturas y etiquetas correspondientes.</p>
                            </div>
                        </div>
                        <div class="shipping" data-animate="animate__fadeInUp">
                            <span>P.2</span>
                            <h6 class="shipping-title">¿Cómo inicio un proceso de devolución?</h6>
                            <div class="shipping-content">
                                <p>Puedes iniciar una solicitud de devolución dentro de los 7 días calendario posteriores a la entrega. Para ello, contáctanos enviando un correo a <strong>{{ $settings['email']->value ?? 'soporte@tecnnygames.com' }}</strong> con imágenes del producto dañado/defectuoso, mencionando tu número de pedido.</p>
                                <p>No se aceptarán solicitudes de devolución de productos después de 7 días desde la fecha de entrega.</p>
                            </div>
                        </div>
                        <div class="shipping" data-animate="animate__fadeInUp">
                            <span>P.3</span>
                            <h6 class="shipping-title">¿Cuándo recibiré mi reembolso?</h6>
                            <div class="shipping-content">
                                <p>Para los pedidos con recojo a domicilio, iniciaremos el reembolso una vez que el artículo sea recogido por nuestro socio logístico y verificado en nuestro almacén.</p>
                                <p>Si tú mismo envías el producto, realizaremos el reembolso cuando lo recibamos y validemos su estado. El monto del reembolso se acreditará en un plazo de 5 a 10 días hábiles a tu método de pago original o como crédito en la tienda.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Fin de la Página de Política de Devoluciones -->

</x-layouts.app>
