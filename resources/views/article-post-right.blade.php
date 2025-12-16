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
                                    <span class="breadcrumb-text">Article post right sidebar</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- blog-page-deatil start -->
        <section class="blog-page-deatil section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="blog-detail-area">
                            <div class="blog-post-img" data-animate="animate__fadeInUp">
                                <img src="{{ asset('img/blog/blog-detail-page.jpg') }}" alt="blog-det-img" class="img-fluid">
                                <div class="blog-post-date">
                                    <i class="feather-calendar"></i>
                                    <span>27,Jan,2025</span>
                                </div>
                            </div>
                            <div class="blog-post-content" data-animate="animate__fadeInUp">
                                <div class="blog-post-title">
                                    <h2>Donec Neque Accumsan Nibh, Pretium Commodo Tincidunt</h2>
                                </div>
                                <div class="blog-post-info">
                                    <ul class="post-meta">
                                        <li>
                                            <a class="post-author" href="{{ route('blog.article.right') }}">
                                                <i class="feather-user"></i>
                                                <span class="p-author">Johnny deo</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="post-author" href="{{ route('blog.article.right') }}">
                                                <i class="feather-message-square"></i>
                                                <span class="p-author">2 comments</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="post-author" href="{{ route('blog.article.right') }}">
                                                <i class="feather-eye"></i>
                                                <span class="p-author">20 view</span>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="blog-post-social">
                                                <ul class="social-icon">
                                                    <li class="facebook">
                                                        <a href="https://facebook.com"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z"></path></svg></a>
                                                    </li>
                                                    <li class="twitter">
                                                        <a href="https://twitter.com"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path></svg></a>
                                                    </li>
                                                    <li class="pinterest">
                                                        <a href="https://pinterest.com"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z"></path></svg></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="blog-post-desc">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                </div>
                            </div>
                            <div class="blog-post-tags" data-animate="animate__fadeInUp">
                                <ul class="post-tags">
                                    <li>
                                        <a href="{{ route('blog.search') }}">#Electronic</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blog.search') }}">#computer</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blog.search') }}">#Headphone</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blog.search') }}">#Speaker</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blog.search') }}">#company</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blog.search') }}">#agency</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="blog-sidebar">
                            <div class="blog-search" data-animate="animate__fadeInUp">
                                <form class="search-bar" action="{{ route('search.index') }}">
                                    <div class="form-search">
                                        <input type="search" placeholder="Search" class="search-input">
                                        <button type="submit" class="search-btn"><i class="feather-search"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="blog-cat" data-animate="animate__fadeInUp">
                                <h6 class="blog-title">Categories</h6>
                                <ul class="cat-list">
                                    <li>
                                        <a href="{{ route('blog.grid.right') }}">Computer</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blog.grid.right') }}">Electronic</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blog.grid.right') }}">Fashion</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blog.grid.right') }}">Food</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blog.grid.right') }}">Furniture</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blog.grid.right') }}">Organic</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blog.grid.right') }}">Plant</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blog.grid.right') }}">Other</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="blog-recent-post" data-animate="animate__fadeInUp">
                                <h6 class="blog-title">Recent post</h6>
                                <ul class="recent-post-list">
                                    <li>
                                        <a class="recent-post-img" href="{{ route('blog.article.right') }}">
                                            <img src="{{ asset('img/blog/recent-post.jpg') }}" alt="recent-post" class="img-fluid">
                                        </a>
                                        <div class="recent-post-content">
                                            <a class="recent-post-title" href="{{ route('blog.article.right') }}">Donec Neque Accumsan Nibh, Pretium Commodo Tincidunt</a>
                                            <span class="recent-post-date">27,Jan,2025</span>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="recent-post-img" href="{{ route('blog.article.right') }}">
                                            <img src="{{ asset('img/blog/recent-post-2.jpg') }}" alt="recent-post" class="img-fluid">
                                        </a>
                                        <div class="recent-post-content">
                                            <a class="recent-post-title" href="{{ route('blog.article.right') }}">Donec Neque Accumsan Nibh, Pretium Commodo Tincidunt</a>
                                            <span class="recent-post-date">27,Jan,2025</span>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="recent-post-img" href="{{ route('blog.article.right') }}">
                                            <img src="{{ asset('img/blog/recent-post-3.jpg') }}" alt="recent-post" class="img-fluid">
                                        </a>
                                        <div class="recent-post-content">
                                            <a class="recent-post-title" href="{{ route('blog.article.right') }}">Donec Neque Accumsan Nibh, Pretium Commodo Tincidunt</a>
                                            <span class="recent-post-date">27,Jan,2025</span>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="recent-post-img" href="{{ route('blog.article.right') }}">
                                            <img src="{{ asset('img/blog/recent-post-4.jpg') }}" alt="recent-post" class="img-fluid">
                                        </a>
                                        <div class="recent-post-content">
                                            <a class="recent-post-title" href="{{ route('blog.article.right') }}">Donec Neque Accumsan Nibh, Pretium Commodo Tincidunt</a>
                                            <span class="recent-post-date">27,Jan,2025</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="blog-tags" data-animate="animate__fadeInUp">
                                <h6 class="blog-title">Tags</h6>
                                <ul class="post-tags">
                                    <li>
                                        <a href="{{ route('blog.search') }}">#Electronic</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blog.search') }}">#computer</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blog.search') }}">#Headphone</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blog.search') }}">#Speaker</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blog.search') }}">#company</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blog.search') }}">#agency</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="blog-instagram" data-animate="animate__fadeInUp">
                                <h6 class="blog-title">instagram</h6>
                                <ul class="instagram-list">
                                    <li>
                                        <a href="https://www.instagram.com/p/CjI3v4dv9yG/">
                                            <img src="{{ asset('img/insta/insta-1.jpg') }}" alt="insta" class="img-fluid">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/p/CjI3v4dv9yG/">
                                            <img src="{{ asset('img/insta/insta-2.jpg') }}" alt="insta" class="img-fluid">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/p/CjI3v4dv9yG/">
                                            <img src="{{ asset('img/insta/insta-3.jpg') }}" alt="insta" class="img-fluid">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/p/CjI3v4dv9yG/">
                                            <img src="{{ asset('img/insta/insta-4.jpg') }}" alt="insta" class="img-fluid">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/p/CjI3v4dv9yG/">
                                            <img src="{{ asset('img/insta/insta-5.jpg') }}" alt="insta" class="img-fluid">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/p/CjI3v4dv9yG/">
                                            <img src="{{ asset('img/insta/insta-6.jpg') }}" alt="insta" class="img-fluid">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- blog-page-deatil end -->
    </main>
    <!-- main section end-->
</x-app-layout>