<section id="PromoSection">
    <div class="container">
        <div class="row h-100">
            <div class="col-lg-7 mx-auto text-center">
                <h5 class="fw-bold fs-3 fs-lg-5 lh-sm mb-3">Promo</h5>
            </div>
            <div class="col-12">
                <nav>
                    <div class="tab-content" id="promo-nav_tabContent">

                        <ul class="nav nav-pills justify-content-center" role="tablist" id="navByPromo">

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
                url: `{{ array_key_exists('frontpage_api', $settings) ? $settings['frontpage_api'] : '' }}promo?notShow=%5B""%5D`,
                headers: {
                    'Authorization': 'daysf_store'
                },
                method: 'GET',
                success: function(response) {
                    var data = response.data;

                    let perPage = 4;

                    if (window.innerWidth <= 767) {
                        perPage = 1;
                    }

                    let navByPromo = '';
                    let content = '';
                    let firstItem = true;

                    data.forEach(function(item) {
                        navByPromo += `<li class="nav-item" role="presentation">
                                <button class="nav-link ${firstItem ? 'active show' : ''}" id="promo-${item.id}-tab" data-bs-toggle="pill"
                                    data-bs-target="#promo-${item.id}" type="button" role="tab"
                                    aria-controls="promo-${item.id}" aria-selected="${firstItem}">${item.nama}</button>
                            </li>`;
                        // Set firstItem to false after encountering the first item
                        let sliderContent = '';
                        item.detail.forEach(function(detail) {
                            console.log(detail)
                            sliderContent += `<li class="splide__slide">
                                    <div class="card card-span h-100 text-white"><img
                                            class="img-fluid h-80"
                                            src="${(detail.produk.image.length !== 0) ? '{{ array_key_exists('frontpage_api', $settings) ? str_replace("/api", "",$settings['frontpage_api']) : '' }}administrator/assets/media/produk/'+ detail.produk.image[0].image : "{{ template_frontpage('assets/img/gallery/handbag.png') }}"}" // Update this to the correct property of your product
                                            alt="${detail.produk.nama}" />
                                        <div class="card-img-overlay ps-0"> </div>
                                        <div class="card-body ps-0 bg-200">
                                            <h5 class="fw-bold text-1000 text-truncate">${detail.produk.nama}</h5>
                                            <div class="fw-bold"><span
                                                    class="text-600 me-2 text-decoration-line-through">${formatRupiah(parseFloat(detail.produk.harga))}</span><span
                                                    class="text-primary">${formatRupiah(parseFloat(detail.diskon))}</span></div>
                                        </div><a class="stretched-link" href="#"></a>
                                    </div>
                                </li>`;
                        });

                                        content += `<div class="tab-pane fade ${firstItem ? 'show active' : ''}" id="promo-${item.id}" role="tabpanel"
                                aria-labelledby="promo-${item.id}-tab">
                                <section class="splide" id="promo_splide-${item.id}" style="padding: 1rem!important;"
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

                    if (data.length === 0) {
                        $('#navByPromo').html('<div class="col-12 d-flex justify-content-center mt-2">Tidak ada promo untuk hari ini!</div>');
                    }else{
                        $('#navByPromo').html(navByPromo);
                    }
                    $('#promo-nav_tabContent').append(content);

                    // Initialize Splide sliders after the content is added to the DOM
                    data.forEach(function(item) {
                        let splidePromo = new Splide(`#promo_splide-${item.id}`, {
                            type: 'loop',
                            perPage: perPage,
                            perMove: 1,
                        });
                        splidePromo.mount();
                    });
                },
                error: function() {
                    $('#navByPromo').html(`<div class="col-12 d-flex justify-content-center mt-2">Failed load data!</div>`);
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
