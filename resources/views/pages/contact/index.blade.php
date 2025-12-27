<x-layouts.app>
    {{-- Título de la página para el navegador --}}
    <x-slot name="title">
        Contacto | TecnnyGames
    </x-slot>

    <!-- Breadcrumb (Migas de Pan) -->
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
                                <span class="breadcrumb-text">Contacto</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin del Breadcrumb -->

    <!-- Mapa de Google -->
    <section class="google-map contact-us-page section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-capture">
                        <div class="section-title">
                            <h2 data-animate="animate__fadeInUp"><span>Ponte en Contacto</span></h2>
                        </div>
                    </div>
                    <div class="map-wrap">
                        <div class="map-wrapper" data-animate="animate__fadeInUp">
                            <div class="map-info" id="map">
                                {{-- Aquí puedes insertar el iframe de tu ubicación en Google Maps --}}
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3901.988031294674!2d-77.03023888518737!3d-12.042426991472535!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c8b5d3a2d3a9%3A0x1da55a1d56f5b8c!2sPlaza%20de%20Armas%20de%20Lima!5e0!3m2!1ses!2spe!4v1678886543210!5m2!1ses!2spe" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin del Mapa -->

    <!-- Formulario y Datos de Contacto -->
    <section class="form-contact section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="contact-content">
                        <!-- Formulario de Contacto -->
                        <div class="contact-detail form-warp">
                            <div class="form-title">
                                <h6 data-animate="animate__fadeInUp">Envíanos un Mensaje</h6>
                            </div>
                            <div class="contact-form-list">
                                {{-- Este formulario debería apuntar a una ruta POST en el futuro --}}
                                <form method="post" action="#">
                                    @csrf
                                    <ul class="form-fill">
                                        <li class="form-fill-li name" data-animate="animate__fadeInUp">
                                            <label>Nombre</label>
                                            <input type="text" name="name" autocomplete="name" placeholder="Tu Nombre Completo">
                                        </li>
                                        <li class="form-fill-li email" data-animate="animate__fadeInUp">
                                            <label>Correo Electrónico</label>
                                            <input type="email" name="email" autocomplete="email" placeholder="tucorreo@ejemplo.com">
                                        </li>
                                        <li class="form-fill-li phone number" data-animate="animate__fadeInUp">
                                            <label>Número de Teléfono</label>
                                            <input type="tel" name="phone" placeholder="Tu número de teléfono">
                                        </li>
                                        <li class="form-fill-li message" data-animate="animate__fadeInUp">
                                            <label>Mensaje</label>
                                            <textarea rows="10" name="message" placeholder="Escribe tu consulta aquí..." class="custom-textarea"></textarea>
                                        </li>
                                    </ul>
                                    <div class="contact-submit" data-animate="animate__fadeInUp">
                                        <button type="submit" class="btn btn-style2">
                                            <span>Enviar Mensaje</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Fin del Formulario -->

                        <!-- Información de Contacto -->
                        <div class="contact-detail get-info">
                            <div class="form-title">
                                <h6 data-animate="animate__fadeInUp">Nuestros Datos</h6>
                            </div>
                            <ul class="get-info-ul">
                                <li class="get-info-li" data-animate="animate__fadeInUp">
                                    <span class="get-icon"><i class="bi bi-geo"></i></span>
                                    <span class="get-add contact-block">
                                        <span>Av. Principal del Gaming 123,</span>
                                        <span>Lima, Perú</span>
                                    </span>
                                </li>
                                <li class="get-info-li" data-animate="animate__fadeInUp">
                                    <span class="get-icon"><i class="bi bi-telephone"></i></span>
                                    <div class="contact-block">
                                        <a href="tel:+51123456789" class="get-add">Soporte: +51 123 456 789</a>
                                        <a href="tel:+51987654321" class="get-add">Ventas: +51 987 654 321</a>
                                    </div>
                                </li>
                                <li class="get-info-li" data-animate="animate__fadeInUp">
                                    <span class="get-icon"><i class="bi bi-envelope"></i></span>
                                    <div class="contact-block">
                                        <a href="mailto:soporte@tecnnygames.com" class="get-add">soporte@tecnnygames.com</a>
                                        <a href="mailto:ventas@tecnnygames.com" class="get-add get-sup">ventas@tecnnygames.com</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- Fin de la Información de Contacto -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin del Formulario y Datos -->

</x-layouts.app>
