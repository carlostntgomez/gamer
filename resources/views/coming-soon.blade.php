<x-app-layout>
    <!-- coming-soon start -->
    <section class="coming-soon-area">
        <div class="customer-area">
            <div class="customer-content">
                <div class="comming-wrap">
                    <div class="acc-form">
                        <div class="header-theme-logo">
                            <a href="{{ route('home') }}" class="theme-logo" data-animate="animate__fadeInUp">
                                <img src="{{ asset('img/logo/logo.png') }}" class="img-fluid" alt="logo">
                            </a>
                        </div>
                        <div class="image">
                            <a href="javascript:void(0)" class="about-image">
                                <img src="{{ asset('img/coming-soon/coming-soon.jpg') }}" class="img-fluid" alt="coming-soon">
                            </a>
                        </div>
                        <h2 data-animate="animate__fadeInUp">Hello guys!</h2>
                        <h4 class="password-coming-title" data-animate="animate__fadeInUp">We're coming soon...</h4>
                    </div>
                    <div class="timer-section1" id="the-24h-countdown" data-animate="animate__fadeInUp">
                        <ul class="clock"></ul>
                    </div>
                    <div class="crap-search" data-animate="animate__fadeInUp">
                        <form method="post" class="search-bar" role="search">
                            <div class="form-search">
                                <input type="search" name="q" placeholder="Enter your email" aria-label="Search our store" id="search" class="input-text" required="" autocomplete="off">
                                <a href="{{ route('home') }}" class="btn-style2">subscribe</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- coming-soon end -->
</x-app-layout>