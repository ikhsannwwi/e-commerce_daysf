@extends('administrator.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header">
                        Kategori Set
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.kategori_set') }}">Kategori Set</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="{{ route('admin.kategori_set.update') }}" method="post" enctype="multipart/form-data"
                                class="form" id="form" data-parsley-validate>
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="id" id="inputId" value="{{$data->id}}">

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="inputNama" class="form-label">Nama</label>
                                            <input type="text" id="inputNama" class="form-control" value="{{$data->nama}}"
                                                placeholder="Masukan Nama" name="nama" autocomplete="off"
                                                data-parsley-required="true">
                                            <div class="" style="color: #dc3545" id="accessErrorNama"></div>
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
                                        <button type="reset" class="btn btn-secondary me-1 mb-1">Reset</button>
                                        <a href="{{ route('admin.kategori_set') }}" class="btn btn-danger me-1 mb-1">Cancel</a>
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

    <script type="text/javascript">
        $(document).ready(function() {
            
            var optionToast = {
                classname: "toast",
                transition: "fade",
                insertBefore: true,
                duration: 4000,
                enableSounds: true,
                autoClose: true,
                progressBar: true,
                sounds: {
                    info: toastMessages.path + "/sounds/info/1.mp3",
                    // path to sound for successfull message:
                    success: toastMessages.path + "/sounds/success/1.mp3",
                    // path to sound for warn message:
                    warning: toastMessages.path + "/sounds/warning/1.mp3",
                    // path to sound for error message:
                    error: toastMessages.path + "/sounds/error/1.mp3",
                },

                onShow: function(type) {
                    console.log("a toast " + type + " message is shown!");
                },
                onHide: function(type) {
                    console.log("the toast " + type + " message is hidden!");
                },

                // the placement where prepend the toast container:
                prependTo: document.body.childNodes[0],
            };

            //validate parsley form
            const form = document.getElementById("form");
            const validator = $(form).parsley();

            const submitButton = document.getElementById("formSubmit");

            submitButton.addEventListener("click", async function(e) {
                e.preventDefault();

                // Perform remote validation
                const remoteValidationResult = await validateRemoteNama();
                const inputNama = $("#inputNama");
                const accessErrorNama = $("#accessErrorNama");
                if (!remoteValidationResult.valid) {
                    // Remote validation failed, display the error message
                    accessErrorNama.addClass('invalid-feedback');
                    inputNama.addClass('is-invalid');

                    accessErrorNama.text(remoteValidationResult
                        .errorMessage);

                        var toasty = new Toasty(optionToast);
                        toasty.configure(optionToast);
                        toasty.error(remoteValidationResult
                        .errorMessage);
                    return;
                } else {
                    accessErrorNama.removeClass('invalid-feedback');
                    inputNama.removeClass('is-invalid');
                    accessErrorNama.text('');
                }

                // Validate the form using Parsley
                if ($(form).parsley().validate()) {
                    // Disable the submit button and show the "Please wait..." message
                    submitButton.querySelector('.indicator-label').style.display = 'none';
                    submitButton.querySelector('.indicator-progress').style.display =
                        'inline-block';

                    // Perform your asynchronous form submission here
                    // Simulating a 2-second delay for demonstration
                    setTimeout(function() {
                        // Re-enable the submit button and hide the "Please wait..." message
                        submitButton.querySelector('.indicator-label').style.display =
                            'inline-block';
                        submitButton.querySelector('.indicator-progress').style.display =
                            'none';

                        // Submit the form
                        form.submit();
                    }, 2000);
                } else {
                    // Handle validation errors
                    const validationErrors = [];
                    $(form).find(':input').each(function() {
                        const field = $(this);
                        if (!field.parsley().isValid()) {
                            const attrName = field.attr('name');
                            const errorMessage = field.parsley().getErrorsMessages().join(
                                ', ');
                            validationErrors.push(attrName + ': ' + errorMessage);
                        }
                    });
                    var toasty = new Toasty(optionToast);
                    toasty.configure(optionToast);
                    toasty.error(validationErrors.join('\n'));
                    console.log("Validation errors:", validationErrors.join('\n'));
                }
            });

            const inputId = $('#inputId')

            async function validateRemoteNama() {
                const inputNama = $('#inputNama');
                const remoteValidationUrl = "{{ route('admin.kategori_set.checkNama') }}";
                const csrfToken = "{{ csrf_token() }}";

                try {
                    const response = await $.ajax({
                        method: "POST",
                        url: remoteValidationUrl,
                        data: {
                            _token: csrfToken,
                            nama: inputNama.val(),
                            id: inputId.val()
                        }
                    });

                    // Assuming the response is JSON and contains a "valid" key
                    return {
                        valid: response.valid === true,
                        errorMessage: response.message
                    };
                } catch (error) {
                    console.error("Remote validation error:", error);
                    return {
                        valid: false,
                        errorMessage: "An error occurred during validation."
                    };
                }
            }
        });
    </script>
@endpush
