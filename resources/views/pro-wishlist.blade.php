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
                                    <span class="breadcrumb-text">pro-wishlist</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- order history start -->
        <section class="order-histry-area section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="password-block">
                            <!-- order profile start -->
                            <div class="profile-info">
                                <div class="account-profile">
                                    <div class="pro-img">
                                        <a href="javascript:void(0)" data-animate="animate__fadeInUp">
                                            <img src="{{ asset('img/testi/test-1.jpg') }}" class="img-fluid" alt="testi-1">
                                        </a>
                                    </div>
                                    <div class="profile-text">
                                        <h6 data-animate="animate__fadeInUp">David williams</h6>
                                        <span data-animate="animate__fadeInUp">Joined April 06, 2025</span>
                                    </div>
                                </div>
                                <div class="account-detail">
                                    <ul class="profile-ul">
                                        <li class="profile-li" data-animate="animate__fadeInUp">
                                            <a href="{{ route('account.orders') }}">
                                                <span>Orders</span>
                                                <span class="pro-count">5</span>
                                            </a>
                                        </li>
                                        <li class="profile-li" data-animate="animate__fadeInUp">
                                            <a href="{{ route('account.profile') }}">Profile</a>
                                        </li>
                                        <li class="profile-li" data-animate="animate__fadeInUp">
                                            <a href="{{ route('account.addresses') }}">Address</a>
                                        </li>
                                        <li class="profile-li" data-animate="animate__fadeInUp">
                                            <a href="{{ route('wishlist.index') }}" class="active">
                                                <span>Wishlist</span>
                                                <span class="pro-count">3</span>
                                            </a>
                                        </li>
                                        <li class="profile-li" data-animate="animate__fadeInUp">
                                            <a href="{{ route('account.password.edit') }}">
                                                <span>Change password</span>
                                            </a>
                                        </li>
                                        <li class="profile-li" data-animate="animate__fadeInUp">
                                            <a href="{{ route('account.tickets') }}">
                                                <span>My tickets</span>
                                                <span class="pro-count">4</span>
                                            </a>
                                        </li>
                                        <li class="profile-li" data-animate="animate__fadeInUp">
                                            <a href="{{ route('home') }}">
                                                <span>Sign out</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- order profile end -->
                            <!-- order info start -->
                            <div class="profile-form order-info">
                                <div class="pro-add-title">
                                    <h6 data-animate="animate__fadeInUp">Wishlist</h6>
                                </div>
                                <div class="wishlist-area">
                                    <div class="wishlist-details">
                                        <div class="wishlist-item" data-animate="animate__fadeInUp">
                                            <span class="wishlist-head">My wishlist:</span>
                                            <span class="sp-link-title">3 item</span>
                                        </div>
                                        <div class="wishlist-all-pro">
                                            <div class="wishlist-pro">
                                                <div class="wishlist-pro-image">
                                                    <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" data-animate="animate__fadeInUp">
                                                        <img src="{{ asset('img/menu/home-pro-banner1.jpg') }}" class="img-fluid" alt="p-1">
                                                    </a>
                                                </div>
                                                <div class="pro-details">
                                                    <h6>
                                                    <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" data-animate="animate__fadeInUp">Portable speaker</a>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="qty-item">
                                                <a href="{{ route('cart.index') }}" class="add-wishlist" data-animate="animate__fadeInUp">Add to cart</a>
                                                <a href="{{ route('checkout.index') }}" class="add-wishlist" data-animate="animate__fadeInUp">Buy now</a>
                                            </div>
                                            <div class="all-pro-price">
                                                <div class="price-box" data-animate="animate__fadeInUp">
                                                    <span class="new-price">$21.00</span>
                                                    <span class="old-price">$25.00</span>
                                                </div>
                                                <span class="wishalist-icon" data-animate="animate__fadeInUp"><i class="fa fa-heart text-danger"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wishlist-area">
                                    <div class="wishlist-details">
                                        <div class="wishlist-all-pro">
                                            <div class="wishlist-pro">
                                                <div class="wishlist-pro-image">
                                                    <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" data-animate="animate__fadeInUp">
                                                        <img src="{{ asset('img/menu/home-pro-banner3.jpg') }}" class="img-fluid" alt="p-2">
                                                    </a>
                                                </div>
                                                <div class="pro-details">
                                                    <h6>
                                                    <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" data-animate="animate__fadeInUp">Ev charging plug</a>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="qty-item">
                                                <a href="{{ route('cart.index') }}" class="add-wishlist" data-animate="animate__fadeInUp">Add to cart</a>
                                                <a href="{{ route('checkout.index') }}" class="add-wishlist" data-animate="animate__fadeInUp">Buy now</a>
                                            </div>
                                            <div class="all-pro-price">
                                                <div class="price-box" data-animate="animate__fadeInUp">
                                                    <span class="new-price">$54.00</span>
                                                    <span class="old-price">$65.00</span>
                                                </div>
                                                <span class="wishalist-icon" data-animate="animate__fadeInUp"><i class="fa fa-heart text-danger"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wishlist-area">
                                    <div class="wishlist-details">
                                        <div class="wishlist-all-pro">
                                            <div class="wishlist-pro">
                                                <div class="wishlist-pro-image">
                                                    <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" data-animate="animate__fadeInUp">
                                                        <img src="{{ asset('img/menu/home-pro-banner5.jpg') }}" class="img-fluid" alt="p-3">
                                                    </a>
                                                </div>
                                                <div class="pro-details" data-animate="animate__fadeInUp">
                                                    <h6>
                                                    <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">Verse earphones</a>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="qty-item">
                                                <a href="{{ route('cart.index') }}" class="add-wishlist" data-animate="animate__fadeInUp">Add to cart</a>
                                                <a href="{{ route('checkout.index') }}" class="add-wishlist" data-animate="animate__fadeInUp">Buy now</a>
                                            </div>
                                            <div class="all-pro-price">
                                                <div class="price-box" data-animate="animate__fadeInUp">
                                                    <span class="new-price">$21.00</span>
                                                    <span class="old-price">$45.00</span>
                                                </div>
                                                <span class="wishalist-icon" data-animate="animate__fadeInUp"><i class="fa fa-heart text-danger"></i></span>
                                            </div>
                                        </div>
                                        <div class="other-link">
                                            <ul class="other-ul">
                                                <li class="wishlist-other-link" data-animate="animate__fadeInUp">
                                                    <a href="{{ route('collection.index') }}" class="btn btn-style2">Continue shopping</a>
                                                </li>
                                                <li class="wishlist-other-link" data-animate="animate__fadeInUp">
                                                    <a href="{{ route('wishlist.empty') }}" class="btn btn-style2">Clear wishlist</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- order info end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- order history end -->
    </main>
    <!-- main section end-->
</x-app-layout>