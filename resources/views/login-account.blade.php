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
        <!-- customer-page start -->
        <section class="customer-page section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <!-- account login title start -->
                        <div class="log-acc" id="CustomerLoginForm">
                            <div class="section-capture">
                                <div class="section-title">
                                    <h2 data-animate="animate__fadeInUp"><span>Login account</span></h2>
                                </div>
                            </div>
                            <!-- account login title end -->
                            <!-- account login start  -->
                            <div class="log-acc-page">
                                <div class="contact-form-list">
                                    <form method="post">
                                        <ul class="form-fill">
                                            <li class="form-fill-li Email" data-animate="animate__fadeInUp">
                                                <label>Email address</label>
                                                <input type="email" name="q" autocomplete="email" placeholder="Email address">
                                            </li>
                                            <li class="form-fill-li Password" data-animate="animate__fadeInUp">
                                                <label>Password</label>
                                                <input type="tel" name="q" placeholder="Password">
                                            </li>
                                        </ul>
                                        <div class="form-action-button" data-animate="animate__fadeInUp">
                                            <div class="button-forget">
                                                <button type="submit" class="btn btn-style2">Sign in</button>
                                                <a href="javascript:void(0)" onclick="myFunction()">Forgot your password?</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="acc-wrapper" data-animate="animate__fadeInUp">
                                    <h6>Already have account?</h6>
                                    <div class="account-optional">
                                        <a href="{{ route('auth.register') }}">Create a account</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="log-acc" id="RecoverPasswordForm" style="display: none;">
                            <!-- account title start -->
                            <div class="content-main-title">
                                <div class="section-capture">
                                    <div class="section-title">
                                        <h2><span>Login account</span></h2>
                                    </div>
                                </div>
                            </div>
                            <!-- account title end -->
                            <!-- account login start -->
                            <div class="log-acc-page">
                                <div class="contact-form-list">
                                    <form method="post">
                                        <ul class="form-fill">
                                            <li class="form-fill-li Email">
                                                <label>Email address</label>
                                                <input type="email" name="q" autocomplete="email" placeholder="Email address">
                                            </li>
                                        </ul>
                                        <div class="form-action-button">
                                            <div class="button-forget">
                                                <button type="submit" class="btn btn-style2">Cancel</button>
                                                <a href="javascript:void(0)" onclick="myFunction()">Cancel</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- account login end -->
                        </div>
                        <!-- account login start -->
                    </div>
                </div>
            </div>
            <script>
            function myFunction() {
            var x = document.getElementById("RecoverPasswordForm");
            var y= document.getElementById("CustomerLoginForm");
            if (x.style.display === "none") {
            x.style.display = "block";
            }
            else {
            x.style.display = "none";
            }
            if (y.style.display === "none") {
            y.style.display = "block";
            }
            else {
            y.style.display = "none";
            }
            }
            </script>
        </section>
        <!-- customer-page end  -->
    </main>
</x-app-layout>
