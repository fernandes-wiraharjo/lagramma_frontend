<section class="section footer-landing pb-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="footer-info d-flex flex-column h-100">
                    <img src="{{ URL::asset('build/images/logo-white.png') }}" alt="" class="lg-footer-logo">
                    {{-- <p class="footer-desc mt-4 mb-2 me-3">LA GRAMMA</p> --}}
                    {{-- <p class="footer-desc mt-4 mb-2 me-3">Hampers Lebaran, Lapis Legit & Nastar Premium Pontianak</p> --}}

                    <div class="footer-social mt-auto pt-3">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <a href="#!" class="text-reset social-link">
                                    <img src="{{ URL::asset('build/images/instagram.png') }}" alt="Instagram"
                                        class="social-logo">
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#!" class="text-reset social-link">
                                    <img src="{{ URL::asset('build/images/tiktok.png') }}" alt="Tiktok"
                                        class="social-logo">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row pl-0 pl-lg-3">
                    <div class="col-md-3">
                        <div class="mt-lg-0 mt-4">
                            <h5 class="footer-title">Categories</h5>
                            <ul class="list-unstyled footer-link mt-3">
                                <li><a href="#!">Lapis Legit</a></li>
                                <li><a href="#!">Nastar</a></li>
                                <li><a href="#!">Cookies</a></li>
                                <li><a href="#!">Patisserie</a></li>
                                <li><a href="#!">PIA</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mt-lg-0 mt-4">
                            <h5 class="footer-title">Information</h5>
                            <ul class="list-unstyled footer-link mt-3">
                                <!-- <li><a href="#!">Custom Service</a></li> -->
                                <li><a href="#!">FAQs</a></li>
                                <!-- <li><a href="#!">Ordering</a></li> -->
                                <!-- <li><a href="#!">Tracking</a></li> -->
                                <li><a href="#!">Contacts</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mt-lg-0 mt-4">
                            <h5 class="footer-title">My Account</h5>
                            <ul class="list-unstyled footer-link mt-3">
                                <!-- <li><a href="#!">Sign In</a></li> -->
                                <li><a href="{{ route('view-cart') }}">View Cart</a></li>
                                <!-- <li><a href="#!">My Wishlist</a></li> -->
                                <li><a href="{{ config('app.backend_url') }}/orders" id="footer-view-my-order" class="d-none" target="_blank">View My Order</a></li>
                                <li><a href="#!">Help</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mt-lg-0 mt-4">
                            <h5 class="footer-title">Customer Service</h5>
                            <ul class="list-unstyled footer-link mt-3">
                                <!-- <li><a href="#!">Payment Methods</a></li> -->
                                <!-- <li><a href="#!">Money-back!</a></li> -->
                                <!-- <li><a href="#!">Returns</a></li> -->
                                <!-- <li><a href="#!">Shipping</a></li> -->
                                <li><a href="#!">Terms and conditions</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Author Section --}}
        <div class="row mt-4 pb-3 pt-3 align-items-center fs-12">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script> © La Gramma. Develop by <a href="https://fernandesdev.com/" target=
                "_blank" class="text-reset text-decoration-underline">Fernandes Wiraharjo</a>
            </div>
            <!-- <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a href="#!"><img src="{{ URL::asset('build/images/ecommerce/payment/visa.png') }}" alt="" height="30"></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#!"><img src="{{ URL::asset('build/images/ecommerce/payment/discover.png') }}" alt="" height="30"></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#!"><img src="{{ URL::asset('build/images/ecommerce/payment/american-express.png') }}" alt="" height="30"></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#!"><img src="{{ URL::asset('build/images/ecommerce/payment/paypal.png') }}" alt="" height="30"></a>
                        </li>
                    </ul>
                </div>
            </div> -->
        </div>
    </div>
</section>
