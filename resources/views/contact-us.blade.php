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
                                    <span class="breadcrumb-text">Contact us</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- google-map  start -->
        <section class="google-map contact-us-page section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <!-- contact title start -->
                        <div class="section-capture">
                            <div class="section-title">
                                <h2 data-animate="animate__fadeInUp"><span>Contact us</span></h2>
                            </div>
                        </div>
                        <!-- contact title end -->
                        <div class="map-wrap">
                            <div class="map-wrapper" data-animate="animate__fadeInUp">
                                <div class="map-info" id="map">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3178.943120902953!2d-7.963813984699448!3d37.177822679872456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd1ab161c81fb0ff%3A0x867380c80c46b1d!2sAmendoeira%20Organics!5e0!3m2!1sen!2spt!4v1631184615272!5m2!1sen!2spt" allowfullscreen="" loading="lazy"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <!-- google-map  end -->
        <!-- drop-detail  start -->
        <section class="form-contact section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="contact-content">
                            <!-- contact us from start -->
                            <div class="contact-detail form-warp">
                                <div class="form-title">
                                    <h6 data-animate="animate__fadeInUp">Drop us message</h6>
                                </div>
                                <div class="contact-form-list">
                                    <form method="post">
                                        <ul class="form-fill">
                                            <li class="form-fill-li name" data-animate="animate__fadeInUp">
                                                <label>Name</label>
                                                <input type="text" name="q" autocomplete="name" placeholder="Name">
                                            </li>
                                            <li class="form-fill-li email" data-animate="animate__fadeInUp">
                                                <label>Email address</label>
                                                <input type="email" name="q" autocomplete="email" placeholder="Email address">
                                            </li>
                                            <li class="form-fill-li phone number" data-animate="animate__fadeInUp">
                                                <label>Phone number</label>
                                                <input type="tel" name="q" placeholder="Phone number">
                                            </li>
                                            <li class="form-fill-li message" data-animate="animate__fadeInUp">
                                                <label>Message</label>
                                                <textarea rows="10" placeholder="Message" class="custom-textarea"></textarea>
                                            </li>
                                        </ul>
                                        <div class="contact-submit" data-animate="animate__fadeInUp">
                                            <button type="submit" class="btn btn-style2">
                                            <span>Send</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- contact us from start -->
                            <!-- contact get info. start -->
                            <div class="contact-detail get-info">
                                <div class="form-title">
                                    <h6 data-animate="animate__fadeInUp">Get in touch</h6>
                                </div>
                                <ul class="get-info-ul">
                                    <li class="get-info-li" data-animate="animate__fadeInUp">
                                        <span class="get-icon"><i class="bi bi-geo"></i></span>
                                        <span class="get-add contact-block">
                                            <span>401 Broadway, 24th floor,</span>
                                            <span>orchard view, london, UK</span>
                                        </span>
                                    </li>
                                    <li class="get-info-li" data-animate="animate__fadeInUp">
                                        <span class="get-icon"><i class="bi bi-telephone"></i></span>
                                        <div class="contact-block">
                                            <a href="tel:(+91)123456789" class="get-add">(+00) 1 23 45 67 89</a>
                                            <a href="tel:(+91)123456789" class="get-add">(+1) 1 23 45 67 89</a>
                                        </div>
                                    </li>
                                    <li class="get-info-li" data-animate="animate__fadeInUp">
                                        <span class="get-icon"><i class="bi bi-envelope"></i></span>
                                        <div class="contact-block">
                                            <a href="mailto:demo@support.com" class="get-add">demo@support.com</a>
                                            <a href="mailto:support@spacingtech.com" class="get-add get-sup">support@spacingtech.com</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- contact get info. end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- drop-detail  end  -->
    </main>
    <!-- main section end-->
</x-app-layout>