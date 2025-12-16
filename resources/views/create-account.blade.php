<x-app-layout>
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
                                    <span class="breadcrumb-text">Create Account</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- customer-page start -->
        <section class="customer-page section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <!-- account login title start -->
                        <div class="section-capture">
                            <div class="section-title">
                                <h2 data-animate="animate__fadeInUp"><span>Create account</span></h2>
                            </div>
                        </div>
                        <!-- account login title end -->
                        <!-- account login start  -->
                        <div class="log-acc-page">
                            <div class="contact-form-list">
                                <form method="post">
                                    <ul class="form-fill">
                                        <li class="form-fill-li Name" data-animate="animate__fadeInUp">
                                            <label>Name</label>
                                            <input type="text" name="q" autocomplete="name" placeholder="Name">
                                        </li>
                                        <li class="form-fill-li Email" data-animate="animate__fadeInUp">
                                            <label>Email address</label>
                                            <input type="email" name="q" autocomplete="email" placeholder="Email address">
                                        </li>
                                        <li class="form-fill-li Phone number" data-animate="animate__fadeInUp">
                                            <label>Phone number</label>
                                            <input type="tel" name="q" placeholder="Phone number">
                                        </li>
                                        <li class="form-fill-li Password" data-animate="animate__fadeInUp">
                                            <label>Password</label>
                                            <input type="tel" name="q" placeholder="Password">
                                        </li>
                                    </ul>
                                    <div class="form-action-button">
                                        <div class="read-agree">
                                            <label data-animate="animate__fadeInUp">
                                                <span class="agree-text">I have read and agree with the
                                                    <a href="{{ route('page.terms_condition') }}">terms & condition.</a>
                                                </span>
                                                <input type="checkbox" name="q" class="cust-checkbox create-checkbox">
                                                <span class="cust-check"></span>
                                            </label>
                                            <button type="submit" class="btn btn-style2 create disabled" data-animate="animate__fadeInUp">Create</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="acc-wrapper" data-animate="animate__fadeInUp">
                                <h6>Already have account?</h6>
                                <div class="account-optional">
                                    <a href="{{ route('auth.login') }}">Log in</a>
                                </div>
                            </div>
                        </div>
                        <!-- account login start -->
                    </div>
                </div>
            </div>
        </section>
        <!-- customer-page end  -->
    </main>
</x-app-layout>
