<x-layouts.app>
    @props([
        'settings' => \App\Models\Setting::all()->keyBy('key'),
    ])
    {{-- Título de la página --}}
    <x-slot name="title">
        Términos y Condiciones | {{ $settings['company_name']->value ?? 'TecnnyGames' }}
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
                                <span class="breadcrumb-text">Términos y Condiciones</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin del Breadcrumb -->

    @if(!empty($settings['terms_conditions_content']->value))
        <section class="terms-rules section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="section-capture">
                            <div class="section-title">
                                <h2 data-animate="animate__fadeInUp"><span>Términos y Condiciones</span></h2>
                            </div>
                        </div>
                         <div class="t-condition-block">
                            <ul class="condition-ul">
                                <li data-animate="animate__fadeInUp">
                                    <p>{!! nl2br(e($settings['terms_conditions_content']->value)) !!}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <!-- Reglas y Términos (Fallback) -->
        <section class="terms-rules section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="section-capture">
                            <div class="section-title">
                                <h2 data-animate="animate__fadeInUp"><span>Términos y Condiciones</span></h2>
                            </div>
                        </div>
                        <div class="terms-banner-rules">
                            <div class="banner-wrap" data-animate="animate__fadeInUp">
                                <div class="banner-bgimg" style="background-image: url('{{ asset('img/team/terms.jpg') }}');"></div>
                                <div class="banner-img">
                                    <img src="{{ asset('img/team/terms.jpg') }}" class="img-fluid" alt="Términos y Condiciones">
                                </div>
                            </div>
                            <div class="rules-wrap">
                                <h6 data-animate="animate__fadeInUp">Acuerdo de Uso</h6>
                                <ul class="terms-ul">
                                    <li class="terms-li" data-animate="animate__fadeInUp">
                                        <p>Bienvenido a {{ $settings['company_name']->value ?? 'TecnnyGames' }}. Al acceder y utilizar nuestro sitio web, aceptas cumplir con los términos y condiciones descritos en este documento. Si no estás de acuerdo, por favor, no utilices nuestros servicios.</p>
                                    </li>
                                    <li class="terms-li" data-animate="animate__fadeInUp">
                                        <p>Este acuerdo establece los derechos y obligaciones tanto para el usuario como para {{ $settings['company_name']->value ?? 'TecnnyGames' }}. Es tu responsabilidad revisar periódicamente estos términos para estar al tanto de cualquier modificación.</p>
                                    </li>
                                    <li class="terms-li" data-animate="animate__fadeInUp">
                                        <p>Nos reservamos el derecho de modificar, añadir o eliminar partes de estos términos en cualquier momento. Los cambios serán efectivos inmediatamente después de su publicación en esta página.</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Fin de Reglas y Términos -->

        <!-- Condiciones de los Términos (Fallback) -->
        <section class="temrs-condition section-ptb bg-color">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="t-condition-block">
                            <ul class="condition-ul">
                                <li data-animate="animate__fadeInUp">
                                    <h6>Propiedad Intelectual</h6>
                                    <p>Todo el contenido de este sitio, incluyendo textos, gráficos, logos, e imágenes, es propiedad de {{ $settings['company_name']->value ?? 'TecnnyGames' }} y está protegido por las leyes de derechos de autor. No se permite la reproducción total o parcial sin nuestro consentimiento explícito.</p>
                                </li>
                                <li data-animate="animate__fadeInUp">
                                    <h6>Uso del Sitio</h6>
                                    <p>Te comprometes a utilizar este sitio web únicamente para fines legítimos. Está prohibido publicar o transmitir material que viole los derechos de otros, que sea ilegal, amenazante, difamatorio o que incite a conductas que constituyan un delito.</p>
                                </li>
                                <li data-animate="animate__fadeInUp">
                                    <h6>Cuentas de Usuario</h6>
                                    <p>Eres responsable de mantener la confidencialidad de tu contraseña y cuenta. Todas las actividades que ocurran bajo tu cuenta son tu responsabilidad. Notifícanos de inmediato sobre cualquier uso no autorizado.</p>
                                </li>
                                <li data-animate="animate__fadeInUp">
                                    <h6>Precios y Stock</h6>
                                    <p>Nos esforzamos por mantener la información de precios y stock actualizada. Sin embargo, nos reservamos el derecho de corregir cualquier error y de cancelar pedidos si la información era incorrecta.</p>
                                </li>
                                <li data-animate="animate__fadeInUp">
                                    <h6>Limitación de Responsabilidad</h6>
                                    <p>{{ $settings['company_name']->value ?? 'TecnnyGames' }} no será responsable por daños directos, indirectos, incidentales o consecuentes que resulten del uso o la incapacidad de usar este sitio web.</p>
                                </li>
                                <li data-animate__animate__fadeInUp">
                                    <h6>Ley Aplicable</h6>
                                    <p>Estos términos se rigen por las leyes de {{ $settings['legal_country']->value ?? 'la República del Perú' }}. Cualquier disputa será sometida a la jurisdicción de los tribunales de {{ $settings['legal_jurisdiction_city']->value ?? 'Lima, Perú' }}.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Fin de Condiciones -->

</x-layouts.app>
