<section id="categoryWomen">
    <div class="container">
        <div class="row h-100">
            <div class="col-lg-7 mx-auto text-center">
                <h5 class="fw-bold fs-3 fs-lg-5 lh-sm mb-3">Shop By Category</h5>
            </div>
            <div class="col-12">
                <nav>
                    <div class="tab-content" id="nav-tabContent">

                        <ul class="nav nav-pills justify-content-center" role="tablist" id="navByCategory">

                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</section>
@push('js')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: `{{ array_key_exists('frontpage_api', $settings) ? $settings['frontpage_api'] : '' }}kategori?notShow=%5B"celana"%5D`,
                method: 'GET',
                success: function(response) {
                    var data = response.data;

                    let perPage = 4;

                    if (window.innerWidth <= 767) {
                        perPage = 1;
                    }

                    let navByCategory = '';
                    let content = '';
                    let firstItem = true;

                    data.forEach(function(item) {
                        navByCategory += `<li class="nav-item" role="presentation">
                                <button class="nav-link ${firstItem ? 'active show' : ''}" id="category-${item.id}-tab" data-bs-toggle="pill"
                                    data-bs-target="#category-${item.id}" type="button" role="tab"
                                    aria-controls="category-${item.id}" aria-selected="${firstItem}">${item.nama}</button>
                            </li>`;
                        // Set firstItem to false after encountering the first item
                        let sliderContent = '';
                        item.produk.forEach(function(produk) {
                            // Replace the template_frontpage with the correct syntax
                            sliderContent += `<li class="splide__slide">
                                    <div class="card card-span h-100 text-white"><img
                                            class="img-fluid h-80"
                                            src="${(produk.image.length !== 0) ? '{{ array_key_exists('frontpage_api', $settings) ? str_replace("/api", "",$settings['frontpage_api']) : '' }}administrator/assets/media/produk/'+ produk.image[0].image : "{{ template_frontpage('assets/img/gallery/handbag.png') }}"}" // Update this to the correct property of your product
                                            alt="${produk.nama}" />
                                        <div class="card-img-overlay ps-0"> </div>
                                        <div class="card-body ps-0 bg-200">
                                            <h5 class="fw-bold text-1000 text-truncate">${produk.nama}</h5>
                                            <div class="fw-bold"><span
                                                    class="text-600 me-2 text-decoration-line-through">${(produk.promo.length !== 0 ? formatRupiah(parseFloat(produk.harga)) : '' )}</span><span
                                                    class="text-primary">${(produk.promo.length !== 0 ? formatRupiah(parseFloat(produk.promo[0].diskon)) : formatRupiah(parseFloat(produk.harga)) )}</span></div>
                                        </div><a class="stretched-link" href="#"></a>
                                    </div>
                                </li>`;
                                        });

                                        content += `<div class="tab-pane fade ${firstItem ? 'show active' : ''}" id="category-${item.id}" role="tabpanel"
                                aria-labelledby="category-${item.id}-tab">
                                <section class="splide" id="splide-${item.id}" style="padding: 1rem!important;"
                                    aria-label="Splide Basic HTML Example">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            ${sliderContent}
                                        </ul>
                                    </div>
                                </section>
                                <div class="col-12 d-flex justify-content-center mt-2"> <a class="btn btn-lg btn-dark"
                                        href="#!">View All </a></div>
                            </div>`;
                        if (firstItem) {
                            firstItem = false;
                        }
                    });

                    $('#navByCategory').html(navByCategory);
                    $('#nav-tabContent').append(content);

                    // Initialize Splide sliders after the content is added to the DOM
                    data.forEach(function(item) {
                        let splideInstance = new Splide(`#splide-${item.id}`, {
                            type: 'loop',
                            perPage: perPage,
                            perMove: 1,
                        });
                        splideInstance.mount();
                    });
                },
                error: function() {
                    $('#navByCategory').html(`<div class="col-12 d-flex justify-content-center mt-2">Failed load data!</div>`);
                }
            });

            
            function formatRupiah(amount) {
                // Use Number.prototype.toLocaleString() to format the number as currency
                return 'Rp ' + Number(amount).toLocaleString('id-ID');
            }

            function parseRupiah(rupiahString) {
                // Remove currency symbol, separators, and parse as integer
                const parsedValue = parseInt(rupiahString.replace(/[^\d]/g, ''));
                return isNaN(parsedValue) ? 0 : parsedValue;
            }

            function formatNumber(number) {
                // Use Number.prototype.toLocaleString() to format the number as currency
                return Number(number).toLocaleString('id-ID');
            }

            function parseNumber(number) {
                // Remove currency symbol, separators, and parse as integer
                // Replace dot only if it exists in the number
                const parsedValue = parseInt(number.replace(/[^\d]/g, ''));
                return isNaN(parsedValue) ? 0 : parsedValue;
            }
        });
    </script>
@endpush
