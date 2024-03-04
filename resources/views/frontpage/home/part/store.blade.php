<section class="py-11">
    <div class="bg-holder overlay overlay-0"
        style="background-image:url({{ template_frontpage('assets/img/gallery/cta.png') }});background-position:center;background-size:cover;">
    </div>
    <!--/.bg-holder-->

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="carousel slide carousel-fade" id="carouseCta" data-bs-ride="carousel">
                    <div class="carousel-inner" id="carouselStore">

                        
{{--                         
                        <div class="row">
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouseCta"
                                data-bs-slide="prev"><span class="carousel-control-prev-icon"
                                    aria-hidden="true"></span><span class="visually-hidden">Previous</span></button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouseCta"
                                data-bs-slide="next"><span class="carousel-control-next-icon"
                                    aria-hidden="true"></span><span class="visually-hidden">Next </span></button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('js')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: `{{ array_key_exists('frontpage_api', $settings) ? $settings['frontpage_api'] : '' }}toko`,
                method: 'GET',
                success: function(response) {
                    var datas = response.data;

                    let carouselStore = '';
                    let content = '';
                    let firstItem = true;

                    datas.forEach(function(data) {

                        carouselStore += `<div class="carousel-item ${firstItem ? 'active' : ''}">
                            <div class="row h-100 align-items-center g-2">
                                <div class="col-12">
                                    <div class="text-light text-center py-2">
                                        <h5 class="display-4 fw-normal text-400 fw-normal mb-4">visit our Outlets in
                                        </h5>
                                        <h1 class="display-1 text-white fw-normal mb-8">${data.nama}</h1><a
                                            class="btn btn-lg text-light fs-1" href="#!" role="button">See
                                            Addresses
                                            <svg class="bi bi-arrow-right-short" xmlns="http://www.w3.org/2000/svg"
                                                width="23" height="23" fill="currentColor" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z">
                                                </path>
                                            </svg></a>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                        
                            if (firstItem) {
                                firstItem = false;
                            }
                    });

                    if (datas.length === 0) {
                        $('#carouselStore').append('<div class="col-12 d-flex justify-content-center display-4 fw-normal text-400 fw-normal">Store not found!</div>');
                    }else{
                        $('#carouselStore').append(carouselStore);
                    }
                },
                error: function() {
                    $('#carouselStore').append(`<div class="col-12 d-flex justify-content-center mt-2">Failed load data!</div>`);
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
