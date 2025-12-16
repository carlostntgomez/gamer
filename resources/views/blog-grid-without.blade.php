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
                                    <a class="breadcrumb-link" href="{{ url('/') }}">Home</a>
                                </li>
                                <li class="breadcrumb-li">
                                    <span class="breadcrumb-text">blog grid without</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- article-area start -->
        <section class="article-area section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="blog-grid-wrapper without-wrap">
                            <div class="blog-grid-wrap blog-article">
                                <div class="blog-grid-view">
                                    <ul class="blog-area-wrap">
                                        <li class="blog-slider" data-animate="animate__fadeInUp">
                                            <div class="blog-post">
                                                <div class="blog-img">
                                                    <a href="{{ url('article-post') }}" class="banner-img">
                                                        <img src="{{ asset('img/blog/blog1.jpg') }}" class="img-fluid" alt="blog1">
                                                        <span class="blog-icon">
                                                            <i class="fas fa-paperclip"></i>
                                                        </span>
                                                        <span class="blog-date-time">
                                                            <span class="blog-date">02</span>
                                                            <span class="blog-month">Jan</span>
                                                            <span class="blog-year">2025</span>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="blog-content">
                                                    <div class="blog-tag">
                                                        <h2 class="wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">This book is a treatise on</h2>
                                                    </div>
                                                    <p class="blog-title wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Lorem ipsum dolor sit amet, consectetuer adipiscing elit doli. Aenean commodo ligula eget dolor. ...</p>
                                                    <a href="{{ url('article-post') }}" class="blog-btn btn-style2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Read more</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="blog-slider" data-animate="animate__fadeInUp">
                                            <div class="blog-post">
                                                <div class="blog-img">
                                                    <a href="{{ url('article-post') }}" class="banner-img">
                                                        <img src="{{ asset('img/blog/blog2.jpg') }}" class="img-fluid" alt="blog2">
                                                        <span class="blog-icon">
                                                            <i class="fas fa-paperclip"></i>
                                                        </span>
                                                        <span class="blog-date-time">
                                                            <span class="blog-date">02</span>
                                                            <span class="blog-month">Jan</span>
                                                            <span class="blog-year">2025</span>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="blog-content">
                                                    <div class="blog-tag">
                                                        <h2 class="wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">The standard chunk of Lorem</h2>
                                                    </div>
                                                    <p class="blog-title wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Lorem ipsum dolor sit amet, consectetuer adipiscing elit doli. Aenean commodo ligula eget dolor. ...</p>
                                                    <a href="{{ url('article-post') }}" class="blog-btn btn-style2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Read more</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="blog-slider" data-animate="animate__fadeInUp">
                                            <div class="blog-post">
                                                <div class="blog-img">
                                                    <a href="{{ url('article-post') }}" class="banner-img">
                                                        <img src="{{ asset('img/blog/blog3.jpg') }}" class="img-fluid" alt="blog3">
                                                        <span class="blog-icon">
                                                            <i class="fas fa-paperclip"></i>
                                                        </span>
                                                        <span class="blog-date-time">
                                                            <span class="blog-date">02</span>
                                                            <span class="blog-month">Jan</span>
                                                            <span class="blog-year">2025</span>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="blog-content">
                                                    <div class="blog-tag">
                                                        <h2 class="wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Repeat predefined chunks</h2>
                                                    </div>
                                                    <p class="blog-title wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Lorem ipsum dolor sit amet, consectetuer adipiscing elit doli. Aenean commodo ligula eget dolor. ...</p>
                                                    <a href="{{ url('article-post') }}" class="blog-btn btn-style2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Read more</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="blog-slider" data-animate="animate__fadeInUp">
                                            <div class="blog-post">
                                                <div class="blog-img">
                                                    <a href="{{ url('article-post') }}" class="banner-img">
                                                        <img src="{{ asset('img/blog/blog4.jpg') }}" class="img-fluid" alt="blog4">
                                                        <span class="blog-icon">
                                                            <i class="fas fa-paperclip"></i>
                                                        </span>
                                                        <span class="blog-date-time">
                                                            <span class="blog-date">02</span>
                                                            <span class="blog-month">Jan</span>
                                                            <span class="blog-year">2025</span>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="blog-content">
                                                    <div class="blog-tag">
                                                        <h2 class="wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">It is a long established fact that</h2>
                                                    </div>
                                                    <p class="blog-title wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Lorem ipsum dolor sit amet, consectetuer adipiscing elit doli. Aenean commodo ligula eget dolor. ...</p> 
                                                    <a href="{{ url('article-post') }}" class="blog-btn btn-style2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Read more</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="blog-slider" data-animate="animate__fadeInUp">
                                            <div class="blog-post">
                                                <div class="blog-img">
                                                    <a href="{{ url('article-post') }}" class="banner-img">
                                                        <img src="{{ asset('img/blog/blog5.jpg') }}" class="img-fluid" alt="blog5">
                                                        <span class="blog-icon">
                                                            <i class="fas fa-paperclip"></i>
                                                        </span>
                                                        <span class="blog-date-time">
                                                            <span class="blog-date">02</span>
                                                            <span class="blog-month">Jan</span>
                                                            <span class="blog-year">2025</span>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="blog-content">
                                                    <div class="blog-tag">
                                                        <h2 class="wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">All the lorem ipsum generators</h2>
                                                    </div>
                                                    <p class="blog-title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit doli. Aenean commodo ligula eget dolor. ...</p>
                                                    <a href="{{ url('article-post') }}" class="blog-btn btn-style2">Read more</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="blog-slider" data-animate="animate__fadeInUp">
                                            <div class="blog-post">
                                                <div class="blog-img">
                                                    <a href="{{ url('article-post') }}" class="banner-img">
                                                        <img src="{{ asset('img/blog/blog6.jpg') }}" class="img-fluid" alt="blog6">
                                                        <span class="blog-icon">
                                                            <i class="fas fa-paperclip"></i>
                                                        </span>
                                                        <span class="blog-date-time">
                                                            <span class="blog-date">02</span>
                                                            <span class="blog-month">Jan</span>
                                                            <span class="blog-year">2025</span>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="blog-content">
                                                    <div class="blog-tag">
                                                        <h2 class="wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Lorem ipsum which looks</h2>
                                                    </div>
                                                    <p class="blog-title wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Lorem ipsum dolor sit amet, consectetuer adipiscing elit doli. Aenean commodo ligula eget dolor. ...</p>
                                                    <a href="{{ url('article-post') }}" class="blog-btn btn-style2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Read more</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="blog-slider" data-animate="animate__fadeInUp">
                                            <div class="blog-post">
                                                <div class="blog-img">
                                                    <a href="{{ url('article-post') }}" class="banner-img">
                                                        <img src="{{ asset('img/blog/blog7.jpg') }}" class="img-fluid" alt="blog7">
                                                        <span class="blog-icon">
                                                            <i class="fas fa-paperclip"></i>
                                                        </span>
                                                        <span class="blog-date-time">
                                                            <span class="blog-date">02</span>
                                                            <span class="blog-month">Jan</span>
                                                            <span class="blog-year">2025</span>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="blog-content">
                                                    <div class="blog-tag">
                                                        <h2 class="wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Various versions have evolved over</h2>
                                                    </div>
                                                    <p class="blog-title wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Lorem ipsum dolor sit amet, consectetuer adipiscing elit doli. Aenean commodo ligula eget dolor. ...</p>
                                                    <a href="{{ url('article-post') }}" class="blog-btn btn-style2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Read more</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="blog-slider" data-animate="animate__fadeInUp">
                                            <div class="blog-post">
                                                <div class="blog-img">
                                                    <a href="{{ url('article-post') }}" class="banner-img">
                                                        <img src="{{ asset('img/blog/blog8.jpg') }}" class="img-fluid" alt="blog8">
                                                        <span class="blog-icon">
                                                            <i class="fas fa-paperclip"></i>
                                                        </span>
                                                        <span class="blog-date-time">
                                                            <span class="blog-date">02</span>
                                                            <span class="blog-month">Jan</span>
                                                            <span class="blog-year">2025</span>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="blog-content">
                                                    <div class="blog-tag">
                                                        <h2 class="wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Various versions have evolved over</h2>
                                                    </div>
                                                    <p class="blog-title wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Lorem ipsum dolor sit amet, consectetuer adipiscing elit doli. Aenean commodo ligula eget dolor. ...</p>
                                                    <a href="{{ url('article-post') }}" class="blog-btn btn-style2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Read more</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="blog-slider" data-animate="animate__fadeInUp">
                                            <div class="blog-post">
                                                <div class="blog-img">
                                                    <a href="{{ url('article-post') }}" class="banner-img">
                                                        <img src="{{ asset('img/blog/blog1.jpg') }}" class="img-fluid" alt="blog1">
                                                        <span class="blog-icon">
                                                            <i class="fas fa-paperclip"></i>
                                                        </span>
                                                        <span class="blog-date-time">
                                                            <span class="blog-date">02</span>
                                                            <span class="blog-month">Jan</span>
                                                            <span class="blog-year">2025</span>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="blog-content">
                                                    <div class="blog-tag">
                                                        <h2 class="wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">This book is a treatise on</h2>
                                                    </div>
                                                    <p class="blog-title wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Lorem ipsum dolor sit amet, consectetuer adipiscing elit doli. Aenean commodo ligula eget dolor. ...</p>
                                                    <a href="{{ url('article-post') }}" class="blog-btn btn-style2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Read more</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="paginatoin-area">
                                        <ul class="pagination-page-box" data-animate="animate__fadeInUp">
                                            <li class="number active"><a href="javascript:void(0)" class="theme-glink">1</a></li>
                                            <li class="number"><a href="javascript:void(0)" class="gradient-text">2</a></li>
                                            <li class="page-next"><a href="javascript:void(0)" class="theme-glink"><i class="fa -solid fa-angle-right"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- article-area end -->
    </main>
</x-app-layout>