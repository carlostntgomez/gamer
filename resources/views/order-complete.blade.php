<x-app-layout>
    <!-- main section start-->
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
                                    <span class="breadcrumb-text">Order complete</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- order-complete start -->
        <section class="order-complete section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="order-area">
                            <!-- order-price start -->
                            <div class="order-price">
                                <ul class="total-order" data-animate="animate__fadeInUp">
                                    <li>
                                        <span class="order-no">Order no. 1724</span>
                                        <span class="order-date"><span class="order-date">23th jan 2025 3:04 pm</span></span>
                                    </li>
                                    <li>
                                        <span class="total-price">Order total</span>
                                        <span class="amount">$136,00</span>
                                    </li>
                                </ul>
                            </div>
                            <!-- order-price end -->
                            <!-- order-details start -->
                            <div class="order-details">
                                <span class="text-success order-i" data-animate="animate__fadeInUp"><i class="fa fa-check-circle"></i></span>
                                <h6 data-animate="animate__fadeInUp">Thank you for order</h6>
                                <span class="order-s" data-animate="animate__fadeInUp">Your order will ship within few hours</span>
                                <a href="{{ route('order.track') }}" class="tracking-link btn btn-style2" data-animate="animate__fadeInUp">Tracking details</a>
                            </div>
                            <!-- order-details start -->
                            <!-- order-delivery start -->
                            <div class="order-delivery">
                                <ul class="delivery-payment">
                                    <li class="delivery" data-animate="animate__fadeInUp">
                                        <h6>Delivery address</h6>
                                        <p>Lorem ipsum</p>
                                        <span class="order-span">7003 fairway street</span>
                                        <span class="order-span">New york</span>
                                        <span class="order-span">NY 10033</span>
                                        <span class="order-span">USA</span>
                                        <span class="order-span">Mobile No :+11-123456789</span>
                                    </li>
                                    <li class="pay" data-animate="animate__fadeInUp">
                                        <h6>Payment summary</h6>
                                        <p class="transition">Transaction No : 66282856617</p>
                                        <span class="order-span p-label">
                                            <span class="n-price">Price</span>
                                            <span class="o-price">$128,00</span>
                                        </span>
                                        <span class="order-span p-label">
                                            <span class="n-price">Shipping charge</span>
                                            <span class="o-price">$8,00</span>
                                        </span>
                                        <span class="order-span p-label">
                                            <span class="n-price">Order Total</span>
                                            <span class="o-price">$136,00</span>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <!-- order-delivery start -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- order-complete end -->
    </main>
</x-app-layout>