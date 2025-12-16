<x-app-layout>
    <!-- main section start-->
    <main>
        <!-- breadcrumb start -->
        <section class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="breadcrumb-index">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-ul">
                                <li class="breadcrumb-li">
                                    <a class="breadcrumb-link" href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="breadcrumb-li">
                                    <span class="breadcrumb-text">Privacy policy</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- privacy-policy start -->
        <section class=" privacy-policy section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <!-- faq title start -->
                        <div class="section-capture">
                            <div class="section-title">
                                <h2 data-animate="animate__fadeInUp"><span>Privacy policy</span></h2>
                            </div>
                        </div>
                        <!-- faq title end -->
                        <!-- policy content start -->
                        <div class="terms-banner-rules">
                            <div class="banner-wrap">
                                <div class="banner-bgimg" style="background-image: url('{{ asset('img/policy/Privacy-policy.jpg') }}');"></div>
                                <div class="banner-img" data-animate="animate__fadeInUp">
                                    <img src="{{ asset('img/policy/Privacy-policy.jpg') }}" class="img-fluid" alt="Terms-&amp;-conditions">
                                </div>
                            </div>
                            <div class="rules-wrap">
                                <ul class="terms-ul">
                                    <li class="terms-li" data-animate="animate__fadeInUp"><p>There are many variations of passages of Lorem Ipsum available.</p></li>
                                    <li class="terms-li" data-animate="animate__fadeInUp"><p>It was popularized in 1960s with the release sheets containing Lorem Ipsum.</p></li>
                                    <li class="terms-li" data-animate="animate__fadeInUp"><p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem laudantium.</p></li>
                                    <li class="terms-li" data-animate="animate__fadeInUp"><p>Randomised words which don't look even slightly believable.</p></li>
                                    <li class="terms-li" data-animate="animate__fadeInUp"><p>Temporibus voluptates repudiandae sint et molestiae non recusandae.</p></li>
                                </ul>
                            </div>
                        </div>
                        <!-- policy content end -->
                    </div>
                </div>
            </div>
        </section>
        <!-- privacy-policy end -->
        <!-- pay policy start -->
        <section class="pay-policy bg-color section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="paymen-policy-wrap">
                            <div class="pay-icon">
                                <ul class="pay-policy-ul">
                                    <li data-animate="animate__fadeInUp">
                                        <span><i class="bi bi-shield-check"></i></span>
                                        <h6>Secure payment</h6>
                                    </li>
                                    <li data-animate="animate__fadeInUp">
                                        <span><i class="bi bi-wallet2"></i></span>
                                        <h6>Money back</h6>
                                    </li>
                                    <li data-animate="animate__fadeInUp">
                                        <span><i class="bi bi-eye-slash"></i></span>
                                        <h6>Hidden cost</h6>
                                    </li>
                                    <li data-animate="animate__fadeInUp">
                                        <span><i class="bi bi-person-check"></i></span>
                                        <h6>Customer support</h6>
                                    </li>
                                    <li data-animate="animate__fadeInUp">
                                        <span><i class="bi bi-graph-up"></i></span>
                                        <h6>Market purpose</h6>
                                    </li>
                                </ul>
                            </div>
                            <div class="pay-text">
                                <h6 data-animate="animate__fadeInUp">Liability</h6>
                                <ul class="pay-text-ul">
                                    <li data-animate="animate__fadeInUp">
                                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
                                    </li>
                                    <li data-animate="animate__fadeInUp">
                                        <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- pay policy end -->
        <!-- payment-method start -->
        <section class="payment-method section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="section-capture">
                            <div class="section-title">
                                <h2 data-animate="animate__fadeInUp"><span>Popular methods</span></h2>
                            </div>
                        </div>
                        <div class="method-wrap">
                            <ul class="method-ul"> 
                                <li class="method-li" data-animate="animate__fadeInUp">
                                    <img src="{{ asset('img/payment/pay-1.jpg') }}" class="img-fluid" alt="pay-1">
                                    <h6>Visa payment</h6>
                                    <p>Lorem ipsum is printing & typesetting industry's standard text</p>
                                </li>
                                <li class="method-li" data-animate="animate__fadeInUp">
                                    <img src="{{ asset('img/payment/pay-2.jpg') }}" class="img-fluid" alt="pay-2">
                                    <h6>Maestro payment</h6>
                                    <p>Lorem ipsum is printing & typesetting industry's standard text</p>
                                </li>
                                <li class="method-li" data-animate="animate__fadeInUp">
                                    <img src="{{ asset('img/payment/pay-3.jpg') }}" class="img-fluid" alt="pay-3">
                                    <h6>Paypal payment</h6>
                                    <p>Lorem ipsum is printing & typesetting industry's standard text</p>
                                </li>
                                <li class="method-li" data-animate="animate__fadeInUp">
                                    <img src="{{ asset('img/payment/pay-4.jpg') }}" class="img-fluid" alt="pay-4">
                                    <h6>Discover payment</h6>
                                    <p>Lorem ipsum is printing & typesetting industry's standard text</p>
                                </li>
                                <li class="method-li" data-animate="animate__fadeInUp">
                                    <img src="{{ asset('img/payment/pay-5.jpg') }}" class="img-fluid" alt="pay-5">
                                    <h6>Master payment</h6>
                                    <p>Lorem ipsum is printing & typesetting industry's standard text</p>
                                </li>
                                <li class="method-li" data-animate="animate__fadeInUp">
                                    <img src="{{ asset('img/payment/pay-6.jpg') }}" class="img-fluid" alt="pay-6">
                                    <h6>Express payment</h6>
                                    <p>Lorem ipsum is printing & typesetting industry's standard text</p>
                                </li>
                                <li class="method-li" data-animate="animate__fadeInUp">
                                    <img src="{{ asset('img/payment/pay-7.jpg') }}" class="img-fluid" alt="pay-7">
                                    <h6>Google payment</h6>
                                    <p>Lorem ipsum is printing & typesetting industry's standard text</p>
                                </li>
                                <li class="method-li" data-animate="animate__fadeInUp">
                                    <img src="{{ asset('img/payment/pay-8.jpg') }}" class="img-fluid" alt="pay-8">
                                    <h6>Wallet payment</h6>
                                    <p>Lorem ipsum is printing & typesetting industry's standard text</p>
                                </li>
                                <li class="method-li" data-animate="animate__fadeInUp">
                                    <img src="{{ asset('img/payment/pay-9.jpg') }}" class="img-fluid" alt="pay-9">
                                    <h6>Shopify payment</h6>
                                    <p>Lorem ipsum is printing &amp; typesetting industry's standard text</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- payment-method section end -->
    </main>
</x-app-layout>