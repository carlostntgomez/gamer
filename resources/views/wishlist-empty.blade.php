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
                                    <a class="breadcrumb-link" href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="breadcrumb-li">
                                    <span class="breadcrumb-text">Wishlist</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- Wishlist empty start -->
        <section class="cart-page section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="empty-cart-page">
                            <div class="section-capture">
                                <div class="section-title">
                                    <h2 data-animate="animate__fadeInUp"><span>Wishlist empty</span></h2>
                                    <p data-animate="animate__fadeInUp">Sorry your wishlist has currently no more products, click on 'here' given below for continue browsing.</p>
                                    <p data-animate="animate__fadeInUp">Continue browsing
                                        <a href="{{ route('collection.index') }}">here</a>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Wishlist empty end -->
    </main>
</x-app-layout>