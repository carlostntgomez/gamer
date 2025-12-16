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
                                    <span class="breadcrumb-text">Pro tickets</span>
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
                                            <a href="{{ route('account.tickets') }}" class="active">
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
                                    <h6 class="wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Tickets</h6>
                                </div>
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                                            <th>Ticket subject</th>
                                            <th>Date submitted</th>
                                            <th>Type</th>
                                            <th>Priority</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="wow animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                                            <td>My new ticket</td>
                                            <td>02/05/2025</td>
                                            <td>Website problem</td>
                                            <td class="delayed">High</td>
                                            <td>Open</td>
                                        </tr>
                                        <tr class="wow animate__animated animate__fadeInUp" data-wow-delay="0.4s">
                                            <td>Another ticket</td>
                                            <td>03/06/2025</td>
                                            <td>Partner request</td>
                                            <td class="process">Medium</td>
                                            <td>Closed</td>
                                        </tr>
                                        <tr class="wow animate__animated animate__fadeInUp" data-wow-delay="0.5s">
                                            <td>Yet another ticket</td>
                                            <td>19/04/2025</td>
                                            <td>Complaint</td>
                                            <td class="canceled">Urgent</td>
                                            <td>Closed</td>
                                        </tr>
                                        <tr class="no-bottom-border wow animate__animated animate__fadeInUp" data-wow-delay="0.6s">
                                            <td>My old ticket</td>
                                            <td>05/06/2025</td>
                                            <td>Info inquiry</td>
                                            <td class="delivered">Low</td>
                                            <td>Closed</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- order info end -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- order history end -->
    </main>
</x-app-layout>