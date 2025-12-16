<x-app-layout>
    <main>
        <!-- breadcrumb start -->
        <section class="breadcrumb-area">
            <div class="container">
                <div class="col">
                    <div class="row">
                        <div class="breadcrumb-index">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-ul">
                                <li class="breadcrumb-li">
                                    <a class="breadcrumb-link" href="{{ route('home') }}">Inicio</a>
                                </li>
                                <li class="breadcrumb-li">
                                    <span class="breadcrumb-text">404</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <section class="page-not-found section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="search-error-wrapper">
                            <h2 data-animate="animate__fadeInUp">404</h2>
                            <p data-animate="animate__fadeInUp">Lo sentimos, pero la página que buscas no existe, ha sido eliminada, ha cambiado de nombre o no está disponible temporalmente.</p>
                            <a href="{{ route('home') }}" class="btn btn-style2" data-animate="animate__fadeInUp">Ir a inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-app-layout>
