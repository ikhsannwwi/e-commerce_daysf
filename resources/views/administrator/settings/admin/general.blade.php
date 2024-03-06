@extends('administrator.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header">
                        Settings
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.settings') }}">Menu Setting</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.settings.admin') }}">Admin</a></li>
                                <li class="breadcrumb-item active" aria-current="page">General</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="{{ route('admin.settings.admin.general.update') }}" method="post"
                                enctype="multipart/form-data" class="form" id="form" data-parsley-validate>
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="namaAppField" class="form-label">Nama App</label>
                                            <input type="text" id="namaAppField" class="form-control"
                                                placeholder="Masukan Nama App"
                                                value="{{ array_key_exists('nama_app_admin', $settings) ? $settings['nama_app_admin'] : 'StartWeb' }}"
                                                name="nama_app_admin" autocomplete="off" data-parsley-required="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="footerAppAdmin" class="form-label">Footer App Admin</label>
                                            <input type="text" id="footerAppAdmin" class="form-control"
                                                placeholder="Masukan Footer App Admin"
                                                value="{{ array_key_exists('footer_app_admin', $settings) ? $settings['footer_app_admin'] : 'StartWeb' }}"
                                                name="footer_app_admin" autocomplete="off" data-parsley-required="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="logoAppAdminInputFile" class="form-label">Logo App Admin</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-preview-logo thumbnail mb20" data-trigger="fileinput">
                                                    <img width="200px"
                                                        src="{{ array_key_exists('logo_app_admin', $settings) ? img_src($settings['logo_app_admin'], 'settings') : '' }}">
                                                </div>
                                                <div class="mt-3">
                                                    <label for="logoAppAdminInputFile" class="btn btn-light btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <input type="file" class="d-none" id="logoAppAdminInputFile"
                                                            name="logo_app_admin">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="faviconInputFile" class="form-label">Favicon</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-preview-favicon thumbnail mb20" data-trigger="fileinput">
                                                    <img width="200px"
                                                        src="{{ array_key_exists('favicon', $settings) ? img_src($settings['favicon'], 'settings') : '' }}">
                                                </div>
                                                <div class="mt-3">
                                                    <label for="faviconInputFile" class="btn btn-light btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <input type="file" class="d-none" id="faviconInputFile"
                                                            name="favicon">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" id="formSubmit" class="btn btn-primary me-1 mb-1">
                                            <span class="indicator-label">Submit</span>
                                            <span class="indicator-progress" style="display: none;">
                                                Tunggu Sebentar...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Basic Tables end -->
@endsection

@push('js')
<script src="{{ asset_administrator('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset_administrator('assets/plugins/parsleyjs/page/parsley.js') }}"></script>

    <!-- Tambahkan FileInput JavaScript -->
    <script src="{{ asset_administrator('assets/plugins/form-jasnyupload/fileinput.min.js') }}"></script>

    <script>
        const logoInputFile = document.getElementById("logoAppAdminInputFile");
        const previewContainerLogo = document.querySelector(".fileinput-preview-logo");

        logoInputFile.addEventListener("change", function() {
            const files = this.files;

            // Hapus gambar-gambar sebelumnya
            previewContainerLogo.innerHTML = '';

            // Ambil satu file saja
            const file = files[0];
            const imageType = /^image\//;

            if (imageType.test(file.type)) {
                const imgContainer = document.createElement("div");
                imgContainer.classList.add("img-thumbnail-container");

                const img = document.createElement("img");
                img.classList.add("img-thumbnail");
                img.width = 350; // Sesuaikan ukuran gambar sesuai kebutuhan
                img.src = URL.createObjectURL(file);

                imgContainer.appendChild(img);
                previewContainerLogo.appendChild(imgContainer);
            }
        });
        
        const faviconInputFile = document.getElementById("faviconInputFile");
        const previewContainerFavicon = document.querySelector(".fileinput-preview-favicon");

        faviconInputFile.addEventListener("change", function() {
            const files = this.files;

            // Hapus gambar-gambar sebelumnya
            previewContainerFavicon.innerHTML = '';

            // Ambil satu file saja
            const file = files[0];
            const imageType = /^image\//;

            if (imageType.test(file.type)) {
                const imgContainer = document.createElement("div");
                imgContainer.classList.add("img-thumbnail-container");

                const img = document.createElement("img");
                img.classList.add("img-thumbnail");
                img.width = 350; // Sesuaikan ukuran gambar sesuai kebutuhan
                img.src = URL.createObjectURL(file);

                imgContainer.appendChild(img);
                previewContainerFavicon.appendChild(imgContainer);
            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            //validate parsley form
            const form = document.getElementById("form");
            const validator = $(form).parsley();

            const submitButton = document.getElementById("formSubmit");

            submitButton.addEventListener("click", async function(e) {
                e.preventDefault();
                indicatorBlock();

                // Validate the form using Parsley
                if ($(form).parsley().validate()) {
                    indicatorSubmit();

                    // Submit the form
                    form.submit();
                } else {
                    // Handle validation errors
                    const validationErrors = [];
                    $(form).find(':input').each(function() {
                        const field = $(this);
                        indicatorNone();
                        if (!field.parsley().isValid()) {
                            const attrName = field.attr('name');
                            const errorMessage = field.parsley().getErrorsMessages().join(
                                ', ');
                            validationErrors.push(attrName + ': ' + errorMessage);
                        }
                    });
                    console.log("Validation errors:", validationErrors.join('\n'));
                }
            });

            function indicatorSubmit() {
                submitButton.querySelector('.indicator-label').style.display =
                    'none';
                submitButton.querySelector('.indicator-progress').style.display =
                    'inline-block';
            }

            function indicatorNone() {
                submitButton.querySelector('.indicator-label').style.display =
                    'inline-block';
                submitButton.querySelector('.indicator-progress').style.display =
                    'none';
                submitButton.disabled = false;
            }

            function indicatorBlock() {
                // Disable the submit button and show the "Please wait..." message
                submitButton.disabled = true;
                submitButton.querySelector('.indicator-label').style.display = 'none';
                submitButton.querySelector('.indicator-progress').style.display =
                    'inline-block';
            }

        });
    </script>
@endpush
