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
                                    <span class="breadcrumb-text">Order history</span>
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
                                        <h6 data-animate="animate__fadeInUp">Miranda joy</h6>
                                        <span data-animate="animate__fadeInUp">Joined April 06, 2025</span>
                                    </div>
                                </div>
                                <div class="account-detail">
                                    <ul class="profile-ul">
                                        <li class="profile-li" data-animate="animate__fadeInUp">
                                            <a href="{{ route('account.orders') }}" class="active">
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
                            <div class="profile-form order-info" data-animate="animate__fadeInUp">
                                <div class="pro-add-title">
                                    <h6>Order</h6>
                                </div>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Date purchased</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>78A643CD409</td>
                                            <td>April 08, 2025</td>
                                            <td class="canceled">Canceled</td>
                                            <td>$760.50</td>
                                        </tr>
                                        <tr>
                                            <td>34VB5540K83</td>
                                            <td>April 11, 2025</td>
                                            <td class="process">In progress</td>
                                            <td>$540.30</td>
                                        </tr>
                                        <tr>
                                            <td>78A643CD409</td>
                                            <td>April 15, 2025</td>
                                            <td class="delayed">Delayed</td>
                                            <td>$412.00</td>
                                        </tr>
                                        <tr>
                                            <td>78A643CD409</td>
                                            <td>April 18, 2025</td>
                                            <td class="delivered">Delivered</td>
                                            <td>$805.00</td>
                                        </tr>
                                        <tr class="no-bottom-border">
                                            <td>78A643CD409</td>
                                            <td>April 21, 2025</td>
                                            <td class="delivered">Delivered</td>
                                            <td>$270.20</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- order info end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- order history end -->
    </main>
</x-app-layout>