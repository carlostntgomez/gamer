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
                                    <span class="breadcrumb-text">Account</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- password-area start -->
        <section class="password-area section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="password-block">
                            <!-- account profile start -->
                            <div class="profile-info">
                                <div class="account-profile">
                                    <div class="pro-img">
                                        <a href="javascript:void(0)" data-animate="animate__fadeInUp">
                                            <img src="{{ asset('img/testi/test-1.jpg') }}" class="img-fluid" alt="testi-1">
                                        </a>
                                    </div>
                                    <div class="profile-text" data-animate="animate__fadeInUp">
                                        <h6>Miranda joy</h6>
                                        <span>Joined April 06, 2025</span>
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
                                            <a href="{{ route('wishlist.pro') }}">
                                                <span>Wishlist</span>
                                                <span class="pro-count">3</span>
                                            </a>
                                        </li>
                                        <li class="profile-li" data-animate="animate__fadeInUp">
                                            <a href="{{ route('account.password.edit') }}" class="active">
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
                            <!-- account profile start -->
                            <!-- change password start -->
                            <div class="profile-form">
                                <div class="pro-add-title">
                                    <h6 data-animate="animate__fadeInUp">Change passowrd</h6>
                                </div>
                                <form>
                                    <ul class="pro-input-label" data-animate="animate__fadeInUp">
                                        <li>
                                            <label>Email address</label>
                                            <input type="text" name="name" placeholder="Email address">
                                        </li>
                                    </ul>
                                    <ul class="pro-input-label" data-animate="animate__fadeInUp">
                                        <li>
                                            <label>Old password</label>
                                            <input type="text" name="name" placeholder="First name">
                                        </li>
                                    </ul>
                                    <ul class="pro-input-label" data-animate="animate__fadeInUp">
                                        <li>
                                            <label>New password</label>
                                            <input type="text" name="name" placeholder="New password">
                                        </li>
                                    </ul>
                                    <ul class="pro-submit" data-animate="animate__fadeInUp">
                                        <li class="label-info">
                                            <label class="box-area">
                                                <span class="agree-text">Subscribe me to newsletter</span>
                                                <input type="checkbox" class="cust-checkbox">
                                                <span class="cust-check"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <a href="{{ route('account.profile') }}" class="btn btn-style2 checkout disabled">Update profile</a>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                            <!-- change password end -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- password-area end -->
    </main>
</x-app-layout>