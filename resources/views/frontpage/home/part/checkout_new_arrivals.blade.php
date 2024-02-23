<section class="py-0">
    <div class="container">
        <div class="row h-100">
            <div class="col-lg-7 mx-auto text-center mb-6">
                <h5 class="fs-3 fs-lg-5 lh-sm mb-3">Checkout New Arrivals</h5>
            </div>
            <div class="col-12">
                <section class="splide" id="splideCNA" style="padding: 1rem!important;"
                    aria-label="Splide Basic HTML Example">
                    <div class="splide__track">
                        <ul class="splide__list">
                            <li class="splide__slide">
                                <div class="card card-span h-100 text-white"><img class="card-img h-100"
                                        src="{{ template_frontpage('assets/img/gallery/full-body.png') }}"
                                        alt="..." />
                                    <div class="card-img-overlay bg-dark-gradient d-flex flex-column-reverse">
                                        <h6 class="text-primary">$175</h6>
                                        <p class="text-400 fs-1">Jumper set for Women</p>
                                        <h4 class="text-light">Flat Hill Slingback</h4>
                                    </div><a class="stretched-link" href="#"></a>
                                </div>
                            </li>
                            <li class="splide__slide">
                                <div class="card card-span h-100 text-white"><img class="card-img h-100"
                                        src="{{ template_frontpage('assets/img/gallery/formal-coat.png') }}"
                                        alt="..." />
                                    <div class="card-img-overlay bg-dark-gradient d-flex flex-column-reverse">
                                        <h6 class="text-primary">$175</h6>
                                        <p class="text-400 fs-1">Jumper set for Women</p>
                                        <h4 class="text-light">Ocean Blue Ring</h4>
                                    </div><a class="stretched-link" href="#"></a>
                                </div>
                            </li>
                            <li class="splide__slide">
                                <div class="card card-span h-100 text-white"><img class="card-img h-100"
                                        src="{{ template_frontpage('assets/img/gallery/ocean-blue.png') }}"
                                        alt="..." />
                                    <div class="card-img-overlay bg-dark-gradient d-flex flex-column-reverse">
                                        <h6 class="text-primary">$175</h6>
                                        <p class="text-400 fs-1">Jumper set for Women</p>
                                        <h4 class="text-light">Brown Leathered Wallet</h4>
                                    </div><a class="stretched-link" href="#"></a>
                                </div>
                            </li>
                            <li class="splide__slide">
                                <div class="card card-span h-100 text-white"><img class="card-img h-100"
                                        src="{{ template_frontpage('assets/img/gallery/sweater.png') }}"
                                        alt="..." />
                                    <div class="card-img-overlay bg-dark-gradient d-flex flex-column-reverse">
                                        <h6 class="text-primary">$175</h6>
                                        <p class="text-400 fs-1">Jumper set for Women</p>
                                        <h4 class="text-light">Silverside Wristwatch</h4>
                                    </div><a class="stretched-link" href="#"></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
@push('js')
    <script>
        $(document).ready(function() {
            let perPage = 4;

            if (window.innerWidth <= 767) {
                perPage = 1;
            }

            let splideCNA = new Splide('#splideCNA', {
                type: 'loop',
                perPage: perPage,
                perMove: 1,
                autoplay: true,
            });
            splideCNA.mount();
        });
    </script>
@endpush
