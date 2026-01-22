<x-layouts.app>
    @props([
        'settings' => \App\Models\Setting::all()->keyBy('key'),
    ])
    {{-- Título de la página --}}
    <x-slot name="title">
        Política de Privacidad | {{ $settings['company_name']->value ?? 'TecnnyGames' }}
    </x-slot>

    <!-- Breadcrumb -->
    <section class="breadcrumb-area">
        <div class="container">
            <div class="col">
                <div class="row">
                    <div class="breadcrumb-index">
                        <ul class="breadcrumb-ul">
                            <li class="breadcrumb-li">
                                <a class="breadcrumb-link" href="{{ route('home') }}">Inicio</a>
                            </li>
                            <li class="breadcrumb-li">
                                <span class="breadcrumb-text">Política de Privacidad</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin del Breadcrumb -->

    @if(!empty($settings['privacy_policy_content']->value))
        <!-- Política de Privacidad -->
        <section class="privacy-policy section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="section-capture">
                            <div class="section-title">
                                <h2 data-animate="animate__fadeInUp"><span>Política de Privacidad</span></h2>
                            </div>
                        </div>
                        <div class="t-condition-block">
                            <ul class="condition-ul">
                                <li data-animate="animate__fadeInUp">
                                    <p>{!! nl2br(e($settings['privacy_policy_content']->value)) !!}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <!-- Política de Privacidad (Fallback) -->
        <section class="privacy-policy section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="section-capture">
                            <div class="section-title">
                                <h2 data-animate="animate__fadeInUp"><span>Política de Privacidad</span></h2>
                            </div>
                        </div>
                        <div class="terms-banner-rules">
                            <div class="banner-wrap">
                                <div class="banner-bgimg" style="background-image: url('{{ asset('img/policy/Privacy-policy.jpg') }}');"></div>
                                <div class="banner-img" data-animate="animate__fadeInUp">
                                    <img src="{{ asset('img/policy/Privacy-policy.jpg') }}" class="img-fluid" alt="Política de Privacidad">
                                </div>
                            </div>
                            <div class="rules-wrap">
                                <h4 class="rules-title" data-animate="animate__fadeInUp">Tu privacidad es importante para nosotros</h4>
                                <ul class="terms-ul">
                                    <li class="terms-li" data-animate="animate__fadeInUp"><p>Recolectamos solo la información necesaria para procesar tus pedidos y mejorar tu experiencia.</p></li>
                                    <li class="terms-li" data-animate="animate__fadeInUp"><p>No compartimos tus datos personales con terceros para fines de marketing sin tu consentimiento explícito.</p></li>
                                    <li class="terms-li" data-animate="animate__fadeInUp"><p>Utilizamos cookies para personalizar tu navegación y ofrecerte contenido relevante.</p></li>
                                    <li class="terms-li" data-animate="animate__fadeInUp"><p>Tus datos de pago son procesados por pasarelas seguras y encriptadas; nosotros no los almacenamos.</p></li>
                                    <li class="terms-li" data-animate="animate__fadeInUp"><p>Tienes derecho a acceder, rectificar o eliminar tus datos personales en cualquier momento.</p></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Fin de la Política de Privacidad -->

        <!-- Detalles de la Política (Fallback) -->
        <section class="pay-policy bg-color section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="paymen-policy-wrap">
                            <div class="pay-icon">
                                <ul class="pay-policy-ul">
                                    <li data-animate="animate__fadeInUp">
                                        <span><i class="bi bi-shield-check"></i></span>
                                        <h6>Seguridad de Datos</h6>
                                    </li>
                                    <li data-animate="animate__fadeInUp">
                                        <span><i class="bi bi-person-lines-fill"></i></span>
                                        <h6>Tus Derechos</h6>
                                    </li>
                                    <li data-animate="animate__fadeInUp">
                                        <span><i class="bi bi-card-checklist"></i></span>
                                        <h6>Uso de la Información</h6>
                                    </li>
                                    <li data-animate="animate__fadeInUp">
                                        <span><i class="bi bi-toggles"></i></span>
                                        <h6>Control de Cookies</h6>
                                    </li>
                                    <li data-animate="animate__fadeInUp">
                                        <span><i class="bi bi-box-arrow-up-right"></i></span>
                                        <h6>Enlaces a Terceros</h6>
                                    </li>
                                </ul>
                            </div>
                            <div class="pay-text">
                                <h6 data-animate="animate__fadeInUp">Responsabilidad y Tratamiento de Datos</h6>
                                <ul class="pay-text-ul">
                                    <li data-animate="animate__fadeInUp">
                                        <p>{{ $settings['company_name']->value ?? 'TecnnyGames' }} se compromete a proteger la privacidad de sus usuarios. Esta política detalla cómo recopilamos, usamos y protegemos tu información personal. Al usar nuestro sitio web, aceptas las prácticas descritas en esta política.</p>
                                    </li>
                                    <li data-animate="animate__fadeInUp">
                                        <p>La información recopilada (nombre, dirección, correo electrónico) se utiliza exclusivamente para procesar tus pedidos, comunicarnos contigo sobre tu compra y mejorar nuestros servicios. Ocasionalmente, podríamos enviarte correos con promociones si has optado por recibirlos, de los cuales puedes darte de baja en cualquier momento.</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Fin de los Detalles -->
</x-layouts.app>
