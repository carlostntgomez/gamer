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
                                    <span class="breadcrumb-text">billing-info</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- order-complete start -->
        <section class="contact section-ptb">
            <div class="container">
                <div class="col">
                    <div class="row">
                        <div class="billing-area">
                            <div class="billing-title">
                                <h6 data-animate="animate__fadeInUp">Billing address</h6>
                                <div class="billing-address-1">
                                    <ul class="add-name">
                                        <li class="billing-name" data-animate="animate__fadeInUp">
                                            <label>First name</label>
                                            <input type="text" name="name" placeholder="First name">
                                        </li>
                                        <li class="billing-name" data-animate="animate__fadeInUp">
                                            <label>Last name</label>
                                            <input type="text" name="name" placeholder="Last name">
                                        </li>
                                        <li class="billing-name" data-animate="animate__fadeInUp">
                                            <label>Address 1</label>
                                            <input type="text" name="address" placeholder="Address line 1">
                                        </li>
                                        <li class="billing-name" data-animate="animate__fadeInUp">
                                            <label>Address 2</label>
                                            <input type="text" name="address" placeholder="Address line 2">
                                        </li>
                                        <li class="billing-name billing-info" data-animate="animate__fadeInUp">
                                            <label>City</label>
                                            <input type="text" name="city" placeholder="Enter your city">
                                        </li>
                                        <li class="billing-name billing-info" data-animate="animate__fadeInUp">
                                            <label>State</label>
                                            <input type="text" name="State" placeholder="Enter your state">
                                        </li>
                                        <li class="billing-name billing-info" data-animate="animate__fadeInUp">
                                            <label>Pincode</label>
                                            <input type="text" name="pin" placeholder="Enter your pincode">
                                        </li>
                                        <li class="billing-name billing-country" data-animate="animate__fadeInUp">
                                            <label>Country</label>
                                            <select>
                                                <option>Afghanistan</option>
                                                <option>Austria </option>
                                                <option>Belgium</option>
                                                <option>Bhutan</option>
                                                <option>Canada</option>
                                                <option>France</option>
                                                <option>Germany</option>
                                                <option selected>India</option>
                                                <option>Maldives</option>
                                                <option>Nepal</option>
                                            </select>
                                        </li>
                                        <li class="billing-name billing-country" data-animate="animate__fadeInUp">
                                            <label>Phone number</label>
                                            <input type="text" name="phone" placeholder="Enter your phone number">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="billing-title">
                                <h6 data-animate="animate__fadeInUp">Shipping address</h6>
                                <div class="billing-address-1">
                                    <ul class="add-name"> 
                                        <li class="billing-name" data-animate="animate__fadeInUp">
                                            <label>First name</label>
                                            <input type="text" name="name" placeholder="First name">
                                        </li>
                                        <li class="billing-name" data-animate="animate__fadeInUp">
                                            <label>Last name</label>
                                            <input type="text" name="name" placeholder="Last name">
                                        </li>
                                        <li class="billing-name" data-animate="animate__fadeInUp">
                                            <label>Address 1</label>
                                            <input type="text" name="address" placeholder="Address line 1">
                                        </li>
                                        <li class="billing-name" data-animate="animate__fadeInUp">
                                            <label>Address 2</label>
                                            <input type="text" name="address" placeholder="Address line 2">
                                        </li>
                                        <li class="billing-name billing-info" data-animate="animate__fadeInUp">
                                            <label>City</label>
                                            <input type="text" name="city" placeholder="Enter your city">
                                        </li>
                                        <li class="billing-name billing-info" data-animate="animate__fadeInUp">
                                            <label>State</label>
                                            <input type="text" name="State" placeholder="Enter your state">
                                        </li>
                                        <li class="billing-name billing-info" data-animate="animate__fadeInUp">
                                            <label>Pincode</label>
                                            <input type="text" name="pin" placeholder="Enter your pincode">
                                        </li>
                                        <li class="billing-name billing-country" data-animate="animate__fadeInUp">
                                            <label>Country</label>
                                            <select>
                                                <option>Afghanistan</option>
                                                <option>Austria </option>
                                                <option>Belgium</option>
                                                <option>Bhutan</option>
                                                <option>Canada</option>
                                                <option>France</option>
                                                <option>Germany</option>
                                                <option selected>India</option>
                                                <option>Maldives</option>
                                                <option>Nepal</option>
                                            </select>
                                        </li>
                                        <li class="billing-name billing-country" data-animate="animate__fadeInUp">
                                            <label>Phone number</label>
                                            <input type="text" name="phone" placeholder="Enter your phone number">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- button start -->
                            <div class="billing-button" data-animate="animate__fadeInUp">
                                <button type="button" onclick="location. href='{{ url('checkout-style') }}'" class="btn btn-style2">Back</button>
                                <button type="button" onclick="location. href='{{ url('/') }}'" class="btn btn-style2">Next</button>
                            </div>
                            <!-- button end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- order-complete end -->
    </main>
</x-app-layout>