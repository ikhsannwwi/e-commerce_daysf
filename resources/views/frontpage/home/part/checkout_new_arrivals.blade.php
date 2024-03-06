<section class="py-0" id="sectionSet">
    <div class="container">
        <div class="row h-100">
            <div class="col-lg-7 mx-auto text-center mb-6">
                <h5 class="fs-3 fs-lg-5 lh-sm mb-3">Checkout New Arrivals</h5>
            </div>
            <div class="col-12">
                <div id="divLoadDataCNA" class="d-flex justify-content-center"></div>
                <section class="splide" id="splideCNA" style="padding: 1rem!important;"
                    aria-label="Splide Basic HTML Example">
                    <div class="splide__track">
                        <ul class="splide__list" id="splideSet">

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
            var divLoadData = $('#divLoadDataCNA');
            divLoadData.html('<div id="loadingSpinnerCNA" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin"></i> Sedang memuat...' +
                '</div>');
            var loadingSpinnerCNA = $('#loadingSpinnerCNA');

            loadingSpinnerCNA.show(); // Tampilkan elemen animasi
            $.ajax({
                url: `{{ route('web.getSet') }}`,
                method: 'GET',
                headers: {
                    'Authorization': 'daysf_store'
                },
                success: function(response) {
                    var datas = response.data;
                    let content = '';
                    console.log(datas)
                    datas.forEach(function(data) {
                        content += `<li class="splide__slide">
                                <div class="card card-span h-100 text-white"><img class="card-img h-100"
                                        src="${(data.image.length !== 0) ? '{{ route('web.index') }}/administrator/assets/media/set/'+ data.image[0].image : "http://placehold.it/500x500?text=Not Found"}""
                                        alt="..." />
                                    <div class="card-img-overlay bg-dark-gradient d-flex flex-column-reverse">
                                        <h6 class="text-primary">${formatRupiah(data.total_harga)}</h6>
                                        <p class="text-400 fs-1">Set for ${data.kategori.nama}</p>
                                        <h4 class="text-light">${data.nama}</h4>
                                    </div><a class="stretched-link" href="#"></a>
                                </div>
                            </li>`
                    });

                    $('#splideSet').html(
                        content
                    );

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
                    loadingSpinnerCNA.hide(); // Sembunyikan elemen animasi setelah data dimuat
                },
                error: function() {
                    loadingSpinnerCNA.append(
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
