<section class="py-0">

    <div class="container">
        <div class="row h-100">
            <div class="col-lg-7 mx-auto text-center mt-7 mb-5">
                <h5 class="fw-bold fs-3 fs-lg-5 lh-sm">Best Deals</h5>
            </div>
            <div class="col-12">
                <section class="splide" id="splide-best_deals" style="padding: 1rem!important;" aria-label="Splide Basic HTML Example">
                    <div class="splide__track">
                        <ul class="splide__list">
                            <li class="splide__slide">
                                <div class="card card-span h-100 text-white"><img class="img-fluid h-100"
                                        src="{{ template_frontpage('assets/img/gallery/handbag.png') }}"
                                        alt="..." />
                                    <div class="card-img-overlay ps-0"> </div>
                                    <div class="card-body ps-0 bg-200">
                                        <h5 class="fw-bold text-1000 text-truncate">Marie Claire 1</h5>
                                        <div class="fw-bold"><span
                                                class="text-600 me-2 text-decoration-line-through">$399</span><span
                                                class="text-danger">$365</span></div>
                                    </div><a class="stretched-link" href="#"></a>
                                </div>
                            </li>
                            <li class="splide__slide">
                                <div class="card card-span h-100 text-white"><img class="img-fluid h-100"
                                        src="{{ template_frontpage('assets/img/gallery/handbag.png') }}"
                                        alt="..." />
                                    <div class="card-img-overlay ps-0"> </div>
                                    <div class="card-body ps-0 bg-200">
                                        <h5 class="fw-bold text-1000 text-truncate">Marie Claire 2</h5>
                                        <div class="fw-bold"><span
                                                class="text-600 me-2 text-decoration-line-through">$399</span><span
                                                class="text-danger">$365</span></div>
                                    </div><a class="stretched-link" href="#"></a>
                                </div>
                            </li>
                            <li class="splide__slide">
                                <div class="card card-span h-100 text-white"><img class="img-fluid h-100"
                                        src="{{ template_frontpage('assets/img/gallery/handbag.png') }}"
                                        alt="..." />
                                    <div class="card-img-overlay ps-0"> </div>
                                    <div class="card-body ps-0 bg-200">
                                        <h5 class="fw-bold text-1000 text-truncate">Marie Claire 3</h5>
                                        <div class="fw-bold"><span
                                                class="text-600 me-2 text-decoration-line-through">$399</span><span
                                                class="text-danger">$365</span></div>
                                    </div><a class="stretched-link" href="#"></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </section>
            </div>
            <div class="col-12 d-flex justify-content-center mt-5"> <a class="btn btn-lg btn-dark"
                    href="#!">View All </a></div>
        </div>
    </div>
    <!-- end of .container-->

</section>
@push('js')
    <script>
        $(document).ready(function() {
            let perPage = 4;

            if (window.innerWidth <= 767) {
                perPage = 1;
            }

            let splide_pills_dresses = new Splide('#splide-best_deals', {
                type: 'loop',
                perPage: perPage,
            });
            splide_pills_dresses.mount();
        });
    </script>
@endpush