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
                                    <span class="breadcrumb-text">Checkout style</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- checkout-area start -->
        <section class="chekout-tab-area section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="checkout-tab">
                            <ul class="nav nav-tabs">
                                <li  class="nav-item">
                                    <a href="#home" class="nav-link active" data-bs-toggle="tab">1</a>
                                </li>
                                <li  class="nav-item">
                                    <a href="#profile" class="nav-link" data-bs-toggle="tab">2</a>
                                </li>
                                <li  class="nav-item">
                                    <a href="#one" class="nav-link" data-bs-toggle="tab">3</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="home">
                                <div class="checkout-style-2">
                                    <div class="billing-area">
                                        <form>
                                            <h2 class="wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Billing details</h2>
                                            <div class="billing-form">
                                                <ul class="input-2" data-animate="animate__fadeInUp">
                                                    <li class="billing-li">
                                                        <label>First name</label>
                                                        <input type="text" name="f-name" placeholder="First name">
                                                    </li>
                                                    <li class="billing-li">
                                                        <label>Last name</label>
                                                        <input type="text" name="l-name" placeholder="Last name">
                                                    </li>
                                                </ul>
                                                <ul class="billing-ul" data-animate="animate__fadeInUp">
                                                    <li class="billing-li wow animate__animated animate__fadeInUp" data-wow-delay="0.2">
                                                        <label>Company name (Optional)</label>
                                                        <input type="text" name="company details" placeholder="Company name">
                                                    </li>
                                                    <li class="billing-li wow animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                                                        <label>Country</label>
                                                        <select>
                                                            <option>Select a country</option>
                                                            <option>United country</option>
                                                            <option>Russia</option>
                                                            <option>italy</option>
                                                            <option>France</option>
                                                            <option>Ukraine</option>
                                                            <option>Germany</option>
                                                            <option>india</option>
                                                            <option>Australia</option>
                                                            <option>canada</option>
                                                        </select>
                                                    </li>
                                                    <li class="billing-li" data-animate="animate__fadeInUp">
                                                        <label>Street address</label>
                                                        <input type="text" name="address" placeholder="Street address">
                                                    </li>
                                                    <li class="billing-li" data-animate="animate__fadeInUp">
                                                        <label>Apartment,suite,unit etc. (Optional)</label>
                                                        <input type="text" name="--">
                                                    </li>
                                                    <li class="billing-li" data-animate="animate__fadeInUp">
                                                        <label>Town / City</label>
                                                        <input type="text" name="city">
                                                    </li>
                                                    <li class="billing-li" data-animate="animate__fadeInUp">
                                                        <label>State / Country</label>
                                                        <input type="text" name="--">
                                                    </li>
                                                    <li class="billing-li" data-animate="animate__fadeInUp">
                                                        <label>Postcode / Zip</label>
                                                        <input type="text" name="--">
                                                    </li>
                                                </ul>
                                                <ul class="input-2" data-animate="animate__fadeInUp">
                                                    <li class="billing-li">
                                                        <label>Email address</label>
                                                        <input type="text" name="mail" placeholder="Email address">
                                                    </li>
                                                    <li class="billing-li">
                                                        <label>Phone number</label>
                                                        <input type="text" name="phone" placeholder="Phone number">
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile">
                                <div class="checkout-style-2">
                                    <div class="billing-area">
                                        <div class="billing-details">
                                            <form>
                                                <h2 data-animate="animate__fadeInUp">Shipping details</h2>
                                                <ul class="shipping-form pro-submit">
                                                    <li class="check-box label-info" data-animate="animate__fadeInUp">
                                                        <label class="box-area">
                                                            <a href="#ship-btn" data-bs-toggle="collapse" class="text">Ship to a different address?</a>
                                                            <input type="checkbox" class="cust-checkbox">
                                                            <span class="cust-check"></span>
                                                        </label>
                                                    </li>
                                                </ul>
                                                <div class="billing-form collapse" id="ship-btn">
                                                    <ul class="input-2" data-animate="animate__fadeInUp">
                                                        <li class="billing-li">
                                                            <label>Full name</label>
                                                            <input type="text" name="q">
                                                        </li>
                                                        <li class="billing-li">
                                                            <label>Mobile number</label>
                                                            <input type="text" name="q">
                                                        </li>
                                                    </ul>
                                                    <ul class="billing-ul">
                                                        <li class="billing-li" data-animate="animate__fadeInUp">
                                                            <label>Flat, House no., Building, Company, Apartment</label>
                                                            <input type="text" name="q">
                                                        </li>
                                                        <li class="billing-li" data-animate="animate__fadeInUp">
                                                            <label>Area, Street, Sector, Village</label>
                                                            <input type="text" name="q">
                                                        </li>
                                                        <li class="billing-li" data-animate="animate__fadeInUp">
                                                            <label>Landmark</label>
                                                            <input type="text" name="q" placeholder="E.g. near apollo hospital">
                                                        </li>
                                                    </ul>
                                                    <ul class="input-2">
                                                        <li class="billing-li" data-animate="animate__fadeInUp">
                                                            <label>Landmark</label>
                                                            <input type="text" name="q" placeholder="E.g. near apollo hospital">
                                                        </li>
                                                        <li class="billing-li" data-animate="animate__fadeInUp">
                                                            <label>Country/Region</label>
                                                            <select>
                                                                <option>Australia</option>
                                                                <option>canada</option>
                                                                <option>France</option>
                                                                <option>Germany</option>
                                                                <option>Russia</option>
                                                                <option selected>india</option>
                                                                <option>italy</option>
                                                                <option>Ukraine</option>
                                                                <option>United country</option>
                                                            </select>
                                                        </li>
                                                        <li class="billing-li" data-animate="animate__fadeInUp">
                                                            <label>Pincode</label>
                                                            <input type="text" name="q" placeholder="6 digits [0-9] PIN code">
                                                        </li>
                                                        <li class="billing-li" data-animate="animate__fadeInUp">
                                                            <label>State</label>
                                                            <select>
                                                                <option>Andaman and Nicobar Islands</option>
                                                                <option>Andhra Pradesh</option>
                                                                <option>Bihar</option>
                                                                <option>Chandigarh</option>
                                                                <option>Delhi</option>
                                                                <option selected>Gujarat</option>
                                                                <option>Haryana</option>
                                                                <option>Jammu and Kashmir</option>
                                                                <option>Karnataka</option>
                                                                <option>Ladakh</option>
                                                            </select>
                                                        </li>
                                                    </ul>
                                                    <ul class="billing-ul pro-submit">
                                                        <li class="billing-li" data-animate="animate__fadeInUp">
                                                            <label>Order notes (Optional)</label>
                                                            <textarea name="comments" rows="5" cols="80"></textarea>
                                                        </li>
                                                        <li class="billing-li label-info" data-animate="animate__fadeInUp">
                                                            <label class="box-area">
                                                                <span class="text">May be used to assist delivery</span>
                                                                <input type="checkbox" class="cust-checkbox">
                                                                <span class="cust-check"></span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                    <div class="ship-btn" data-animate="animate__fadeInUp">
                                                        <a href="{{ route('checkout.index') }}" class="btn btn-style2" data-wow-delay="0.9s">Use this address</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="one">
                                    <div class="checkout-style-2">
                                        <div class="checkout-area">
                                            <div class="order-area">
                                                <div class="check-pro">
                                                    <h2 class="wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">In your cart (8)</h2>
                                                    <ul class="check-ul">
                                                        <li>
                                                            <div class="check-pro-img">
                                                                <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                                                                    <img src="{{ asset('img/menu/home-pro-banner4.jpg') }}" class="img-fluid" alt="p-1">
                                                                </a>
                                                            </div>
                                                            <div class="check-content">
                                                                <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" data-animate="animate__fadeInUp">Ev charging plug</a>
                                                                <span class="check-code" data-animate="animate__fadeInUp">
                                                                    <span>Product code:</span>
                                                                    <span>CA70051541B</span>
                                                                </span>
                                                                <div class="check-qty-pric" data-animate="animate__fadeInUp">
                                                                    <span class="check-qty">4 X</span>
                                                                    <span class="check-price">$11,00</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="check-pro-img">
                                                                <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" data-animate="animate__fadeInUp">
                                                                    <img src="{{ asset('img/menu/home-pro-banner5.jpg') }}" class="img-fluid" alt="p-2">
                                                                </a>
                                                            </div>
                                                            <div class="check-content">
                                                                <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" data-animate="animate__fadeInUp">Verse earphones</a>
                                                                <span class="check-code" data-animate="animate__fadeInUp">
                                                                    <span>Product code:</span>
                                                                    <span>CA70051541B</span>
                                                                </span>
                                                                <div class="check-qty-pric" data-animate="animate__fadeInUp">
                                                                    <span class="check-qty">4 X</span>
                                                                    <span class="check-price">$21,00</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="order-area">
                                                <h2 data-animate="animate__fadeInUp">Order detail</h2>
                                                <ul class="order-history">
                                                    <li class="order-details" data-animate="animate__fadeInUp">
                                                        <span>Product:</span>
                                                        <span>Total</span>
                                                    </li>
                                                    <li class="order-details" data-animate="animate__fadeInUp">
                                                        <span>Candy nut chocolate</span>
                                                        <span>$44,00</span>
                                                    </li>
                                                    <li class="order-details" data-animate="animate__fadeInUp">
                                                        <span>A bekery doughnutss</span>
                                                        <span>$84,00</span>
                                                    </li>
                                                    <li class="order-details" data-animate="animate__fadeInUp">
                                                        <span>Subtotal</span>
                                                        <span>$128,00</span>
                                                    </li>
                                                    <li class="order-details" data-animate="animate__fadeInUp">
                                                        <span>Shipping Charge</span>
                                                        <span>Free shipping</span>
                                                    </li>
                                                    <li class="order-details" data-animate="animate__fadeInUp">
                                                        <span>Total</span>
                                                        <span>$128,00</span>
                                                    </li>
                                                </ul>
                                                <form>
                                                    <ul class="order-form pro-submit">
                                                        <li class="label-info" data-animate="animate__fadeInUp">
                                                            <label class="box-area">
                                                                <span class="text">Direct bank transfer</span>
                                                                <input type="checkbox" class="cust-checkbox">
                                                                <span class="cust-check"></span>
                                                            </label>
                                                        </li>
                                                        <li class="label-info" data-animate="animate__fadeInUp">
                                                            <label class="box-area">
                                                                <span class="text">Paypal</span>
                                                                <input type="checkbox" class="cust-checkbox">
                                                                <span class="cust-check"></span>
                                                            </label>
                                                        </li>
                                                        <li class="label-info" data-animate="animate__fadeInUp">
                                                            <label class="box-area">
                                                                <span class="text">Cash on hand</span>
                                                                <input type="checkbox" class="cust-checkbox">
                                                                <span class="cust-check"></span>
                                                            </label>
                                                        </li>
                                                        <li class="pay-icon" data-animate="animate__fadeInUp">
                                                            <a href="javascript:void(0)"><i class="fa-solid fa-credit-card"></i></a>
                                                            <a href="javascript:void(0)"><i class="fa-brands fa-cc-visa"></i></a>
                                                            <a href="javascript:void(0)"><i class="fa-brands fa-cc-paypal"></i></a>
                                                            <a href="javascript:void(0)"><i class="fa-brands fa-cc-mastercard"></i></a>
                                                        </li>
                                                    </ul>
                                                </form>
                                                <div class="checkout-btn" data-animate="animate__fadeInUp">
                                                    <a href="{{ route('checkout.complete') }}" class="btn-style2 checkout disabled">Place order</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- checkout-area end -->
    </main>
</x-app-layout>
