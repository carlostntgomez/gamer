<x-layouts.app>
    {{-- Título de la página para el navegador --}}
    <x-slot name="title">
        Sobre Nosotros | TecnnyGames
    </x-slot>

    <!-- Breadcrumb (Migas de Pan) -->
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
                                <span class="breadcrumb-text">Sobre Nosotros</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin del Breadcrumb -->

    <!-- Sección principal "Sobre Nosotros" -->
    <section class="about-vision2 section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="about-content">
                        <div class="section-capture">
                            <div class="section-title">
                                <h2 data-animate="animate__fadeInUp"><span>Sobre Nosotros</span></h2>
                            </div>
                        </div>
                        <div class="about-banner section-pb" data-animate="animate__fadeInUp">
                            {{-- Usamos asset() para generar la URL correcta a la imagen --}}
                            <img src="{{ asset('img/about/about-home.jpg') }}" class="img-fluid" alt="Sobre TecnnyGames">
                        </div>
                        <div class="abt-vision">
                            <ul class="abt-vision-ul">
                                <li class="abt-vision-li">
                                    <div class="abt-vision-content">
                                        <img src="{{ asset('img/about/our-mission.png') }}" class="img-fluid" data-animate="animate__fadeInUp" alt="Nuestra Misión">
                                        <h6 data-animate="animate__fadeInUp">Nuestra Misión</h6>
                                        <p data-animate="animate__fadeInUp">Nuestra misión es ser el epicentro de la cultura gamer, ofreciendo un catálogo inigualable de videojuegos, consolas y accesorios, respaldado por un servicio al cliente que entiende y comparte tu pasión.</p>
                                    </div>
                                </li>
                                <li class="abt-vision-li">
                                    <div class="abt-vision-content">
                                        <img src="{{ asset('img/about/our-idea.png') }}" class="img-fluid"  data-animate="animate__fadeInUp" alt="Nuestra Visión">
                                        <h6 data-animate="animate__fadeInUp">Nuestra Visión</h6>
                                        <p data-animate="animate__fadeInUp">Aspiramos a construir la comunidad de videojuegos más grande y vibrante de Latinoamérica, un espacio donde cada gamer se sienta en casa, descubra nuevas aventuras y comparta sus experiencias.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin de la sección "Sobre Nosotros" -->

    <!-- Contador de logros -->
    <section class="project-count bg-color section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="single-count">
                        <ul>
                            <li class="count-wrap" data-animate="animate__fadeInUp">
                                <div class="count-info">
                                    <div class="count">
                                        <span class="count-number">8</span>
                                        <span>+</span>
                                    </div>
                                    <h6>Años en el Mercado</h6>
                                </div>
                                <div class="counter-icon">
                                    <img src="{{ asset('img/about/years.png') }}" class="img-fluid" alt="Años">
                                </div>
                            </li>
                            <li class="count-wrap" data-animate="animate__fadeInUp">
                                <div class="count-info">
                                    <div class="count">
                                        <span class="count-number">500</span>
                                        <span>K+</span>
                                    </div>
                                    <h6>Clientes Felices</h6>
                                </div>
                                <div class="counter-icon">
                                    <img src="{{ asset('img/about/clients.png') }}" class="img-fluid" alt="Clientes">
                                </div>
                            </li>
                            <li class="count-wrap" data-animate="animate__fadeInUp">
                                <div class="count-info">
                                    <div class="count">
                                        <span class="count-number">2500</span>
                                        <span>+</span>
                                    </div>
                                    <h6>Productos en Catálogo</h6>
                                </div>
                                <div class="counter-icon">
                                    <img src="{{ asset('img/about/shops.png') }}" class="img-fluid" alt="Productos">
                                </div>
                            </li>
                            <li class="count-wrap" data-animate="animate__fadeInUp">
                                <div class="count-info">
                                    <div class="count">
                                        <span class="count-number">1.2</span>
                                        <span>M+</span>
                                    </div>
                                    <h6>Ventas Totales</h6>
                                </div>
                                <div class="counter-icon">
                                    <img src="{{ asset('img/about/sales.png') }}" class="img-fluid" alt="Ventas">
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin del contador -->

    <!-- Sección de Nuestro Equipo -->
    <section class="about-team-3 section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="our-team">
                        <div class="section-capture">
                            <div class="section-title">
                                <h2 data-animate="animate__fadeInUp"><span class="title-main">Nuestro Equipo</span></h2>
                            </div>
                        </div>
                        <ul class="team-ul">
                            <li class="team-li">
                                <div class="team-content">
                                    <a href="javascript:void(0)" data-animate="animate__fadeInUp">
                                        <img src="{{ asset('img/team/team-1.jpg') }}" class="img-fluid" alt="Foto del CEO">
                                    </a>
                                    <div class="team-info">
                                        <h6 data-animate="animate__fadeInUp">Carlos Mendoza</h6>
                                        <span data-animate="animate__fadeInUp">Fundador & CEO</span>
                                        <p data-animate="animate__fadeInUp">Gamer de corazón y estratega de negocios, Carlos fundó TecnnyGames con la visión de crear un paraíso para los videojugadores.</p>
                                    </div>
                                </div>
                            </li>
                            <li class="team-li">
                                <div class="team-content">
                                    <a href="javascript:void(0)" data-animate="animate__fadeInUp">
                                        <img src="{{ asset('img/team/team-2.jpg') }}" class="img-fluid" alt="Foto de la Jefa de Comunidad">
                                    </a>
                                    <div class="team-info">
                                        <h6 data-animate="animate__fadeInUp">Laura Fernández</h6>
                                        <span data-animate__fadeInUp">Jefa de Comunidad</span>
                                        <p data-animate="animate__fadeInUp">Laura es el puente entre TecnnyGames y nuestros clientes. Organiza torneos, gestiona las redes y se asegura de que todos se sientan escuchados.</p>
                                    </div>
                                </div>
                            </li>
                            <li class="team-li">
                                <div class="team-content">
                                    <a href="javascript:void(0)" data-animate="animate__fadeInUp">
                                        <img src="{{ asset('img/team/team-3.jpg') }}" class="img-fluid" alt="Foto del Director de Logística">
                                    </a>
                                    <div class="team-info">
                                        <h6 data-animate="animate__fadeInUp">Javier "Rápido" Ríos</h6>
                                        <span data-animate="animate__fadeInUp">Director de Logística</span>
                                        <p data-animate="animate__fadeInUp">Javier es el mago que se asegura de que tu pedido llegue a la velocidad de la luz y en perfectas condiciones. ¡Un verdadero speedrunner de los envíos!</p>
                                    </div>
                                </div>
                            </li>
                            <li class="team-li">
                                <div class="team-content">
                                    <a href="javascript:void(0)" data-animate="animate__fadeInUp">
                                        <img src="{{ asset('img/team/team-4.jpg') }}" class="img-fluid" alt="Foto de la Curadora de Contenido">
                                    </a>
                                    <div class="team-info">
                                        <h6 data-animate="animate__fadeInUp">Valeria Soto</h6>
                                        <span data-animate="animate__fadeInUp">Curadora de Contenido</span>
                                        <p data-animate="animate__fadeInUp">Valeria es nuestra experta en juegos. Prueba y selecciona cada título para asegurarse de que solo ofrecemos lo mejor de lo mejor en nuestro catálogo.</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin de la sección de equipo -->

</x-layouts.app>
