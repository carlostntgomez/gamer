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
                                    <span class="breadcrumb-text">profile</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!--profile start -->
        <section class="pro-address-area section-ptb">
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
                                            <a href="{{ route('account.profile') }}" class="active">Profile</a>
                                        </li>
                                        <li class="profile-li" data-animate="animate__fadeInUp">
                                            <a href="{{ route('account.addresses') }}">Address</a>
                                        </li>
                                        <li class="profile-li" data-animate="animate__fadeInUp">
                                            <a href="{{ route('wishlist.pro') }}">
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
                            <div class="profile-form profile-address">
                                <div class="billing-area">
                                    <form>
                                        <div class="pro-add-title">
                                            <h6 data-animate="animate__fadeInUp">Profile</h6>
                                        </div>
                                        <div class="billing-form">
                                            <ul class="input-2">
                                                <li class="billing-li" data-animate="animate__fadeInUp">
                                                    <label>First name</label>
                                                    <input type="text" name="name" placeholder="First name">
                                                </li>
                                                <li class="billing-li" data-animate="animate__fadeInUp">
                                                    <label>Last name</label>
                                                    <input type="text" name="name" placeholder="Last name">
                                                </li>
                                                <li class="billing-li" data-animate="animate__fadeInUp">
                                                    <label>Email address</label>
                                                    <input type="text" name="name" placeholder="Email address" required>
                                                </li>
                                                <li class="billing-li" data-animate="animate__fadeInUp">
                                                    <label>Phone number</label>
                                                    <input type="text" name="name" placeholder="Phone number">
                                                </li>
                                                <li class="billing-li" data-animate="animate__fadeInUp">
                                                    <label>New password</label>
                                                    <input type="text" name="name" placeholder="New password">
                                                </li>
                                                <li class="billing-li" data-animate="animate__fadeInUp">
                                                    <label>Confirm password</label>
                                                    <input type="text" name="name" placeholder="Confirm password">
                                                </li>
                                            </ul>
                                            <ul class="pro-submit">
                                                <li class="label-info" data-animate="animate__fadeInUp">
                                                    <label class="box-area">
                                                        <span class="text">Subscribe me to newsletter</span>
                                                        <input type="checkbox" class="cust-checkbox">
                                                        <span class="cust-check"></span>
                                                    </label>
                                                </li>
                                                <li data-animate="animate__fadeInUp">
                                                    <a href="{{ route('wishlist.pro') }}" class="btn btn-style2 checkout disabled">Update profile</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- order info end -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- profile end -->
    </main>
</x-app-layout>