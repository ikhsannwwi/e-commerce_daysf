<section>
    <div class="container">
        <div class="row h-100">
            <div class="col-lg-7 mx-auto text-center mb-6">
                <h5 class="fw-bold fs-3 fs-lg-5 lh-sm mb-3">Best Sellers</h5>
            </div>
            <div class="col-12">
                <div id="divLoadDataBestSeller" class="d-flex justify-content-center"></div>
                <section id="splide-best_sellers" class="splide" style="padding: 1rem!important;"
                    aria-label="Splide Basic HTML Example">
                    <div class="splide__track">
                        <ul class="splide__list" id="splideBest">

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
            var divLoadData = $('#divLoadDataBestSeller');
            divLoadData.html('<div id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin"></i> Sedang memuat...' +
                '</div>');
            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: `{{ array_key_exists('frontpage_api', $settings) ? $settings['frontpage_api'] : '' }}best-seller`,
                method: 'GET',
                headers: {
                    'Authorization': 'daysf_store'
                },
                success: function(response) {
                    let datas = response.data;
                    console.log(datas)
                    let content = '';
                    datas.forEach(function(data) {
                        content += `<li class="splide__slide">
                                <div class="card card-span h-100 text-white"><img class="img-fluid h-100"
                                        src="${(data.produk.image.length !== 0) ? '{{ array_key_exists('frontpage_api', $settings) ? str_replace('/api', '', $settings['frontpage_api']) : '' }}administrator/assets/media/produk/'+ data.produk.image[0].image : "http://placehold.it/500x500?text=Not Found"}"
                                        alt="..." />
                                    <div class="card-img-overlay ps-0"> </div>
                                    <div class="card-body ps-0 bg-200">
                                        <h5 class="fw-bold text-1000 text-truncate">${data.produk.nama}</h5>
                                        <div class="fw-bold"><span
                                                class="text-600 me-2 text-decoration-line-through">${(data.produk.promo.length !== 0 ? formatRupiah(parseFloat(data.produk.harga)) : '' )}</span><span
                                                class="text-danger">${(data.produk.promo.length !== 0 ? formatRupiah(parseFloat(data.produk.promo[0].diskon)) : formatRupiah(parseFloat(data.produk.harga)) )}</span></div>
                                    </div><a class="stretched-link" href="#"></a>
                                </div>
                            </li>`
                    });

                    $('#splideBest').html(
                        content
                    );

                    let perPage = 4;

                    if (window.innerWidth <= 767) {
                        perPage = 1;
                    }

                    let splide_best_sellers = new Splide('#splide-best_sellers', {
                        type: 'loop',
                        perPage: perPage,
                        focus: 'center',
                        autoplay: true,
                    });
                    splide_best_sellers.mount();
                    loadingSpinner.hide(); // Sembunyikan elemen animasi setelah data dimuat
                },
                error: function() {
                    loadingSpinner.append(
                        `<div class="col-12 mt-2">Failed load data!</div>`
                    );
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
