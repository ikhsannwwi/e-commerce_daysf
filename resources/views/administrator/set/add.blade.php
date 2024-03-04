@extends('administrator.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header">
                        Set
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.set') }}">Set</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="{{ route('admin.set.save') }}" method="post" enctype="multipart/form-data"
                                class="form" id="form" data-parsley-validate>
                                @csrf
                                @method('POST')

                                <input type="hidden" name="total_harga" id="inputTotalHarga">

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="inputKategori" class="form-label">Kategori</label>
                                            <select class="wide mb-2" name="kategori" id="inputKategori"
                                                data-parsley-required="true">

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group mandatory">
                                                    <label for="namaField" class="form-label">Nama</label>
                                                    <input type="text" id="namaField" class="form-control"
                                                        placeholder="Masukan Nama" name="nama" autocomplete="off"
                                                        data-parsley-required="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="inputDeskripsi" class="form-label">Deskripsi</label>
                                                <textarea id="inputDeskripsi" class="form-control" placeholder="Masukkan Deskripsi" name="deskripsi"
                                                    style="height: 150px;" data-parsley-required="true"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="inputGambar" class="form-label">Gambar</label>
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th width="15px">No</th>
                                                                <th width="250px">Preview</th>
                                                                <th width="50px">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="fileinput-preview-gambar">
                                                            <!-- Tampilkan preview gambar-gambar yang diunggah di sini -->
                                                        </tbody>
                                                    </table>
                                                    <div class="mt-3">
                                                        <label for="inputGambar" class="btn btn-light btn-file">
                                                            <span class="fileinput-new">Select image</span>
                                                            <input type="file" class="d-none" id="inputGambar"
                                                                data-parsley-required="true" name="img[]" accept="image/*"
                                                                multiple>
                                                            <!-- Tambahkan atribut "multiple" di sini -->
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="inputNama" class="form-label">Detail Produk</label>
                                                    </div>
                                                    <div class="col-md-6 d-flex justify-content-end">
                                                        <button class="more-item btn btn-primary btn-sm" type="button"
                                                            id="triggerTambahDetail"><i class="fa fa-plus"></i> Tambah
                                                            Item</button>
                                                    </div>
                                                </div>
                                                <div class="main--overflow-y">
                                                    <table class="table" id="daftar_detail">
                                                        <thead>
                                                            <tr>
                                                                <th width="15px">No</th>
                                                                <th width="25%">Produk</th>
                                                                <th width="100px">Harga</th>
                                                                <th width="25%">Link Pembelian</th>
                                                                <th width="20%">Image</th>
                                                                <th width="2%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                    <div class="" style="color: #dc3545" id="accessErrorDetail">
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
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                </span>
                                            </button>
                                            <button type="reset" class="btn btn-secondary me-1 mb-1">Reset</button>
                                            <a href="{{ route('admin.set') }}" class="btn btn-danger me-1 mb-1">Cancel</a>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Template Detail -->
    <table class="template-detail" style="display: none;">
        <tr class="template-detail-list" childidx="0" style="position: relative;">
            <input type="hidden" class="input_id-item" name="detail[0][id]">
            <td class="no-item text-center"></td>
            <td>
                <div class="form-group">
                    <input type="text" name="detail[0][produk]" class="form-control produk-item"
                        data-parsley-required="true" autocomplete="off" placeholder="Masukan Nama Produk">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="text" name="detail[0][harga]" class="form-control text-end harga-item"
                        data-parsley-required="true" autocomplete="off" placeholder="Masukan Harga">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="text" name="detail[0][link_pembelian]" class="form-control link_pembelian-item"
                        data-parsley-required="true" autocomplete="off" placeholder="Masukan Link Pembelian">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <label for="inputImage_0" class="btn btn-light btn-file label_inputImage-item">
                        <span class="fileinput-new">Select image</span>
                        <input type="file" class="d-none inputImage-item"id="inputImage_0"
                            data-parsley-required="true" name="detail[0][image]" accept="image/*" multiple>
                    </label>
                    <div class="data_image-item"></div>
                </div>
            </td>
            <td class="text-center"><a href="javascript:void(0)" class="btn btn-outline-danger removeData"><i
                        class='fa fa-times'></a></td>
        </tr>
    </table>

    <!-- Basic Tables end -->
    @include('administrator.set.modal.crop')
@endsection
@push('css')
    <link href="{{ asset_administrator('assets/plugins/cropperjs/css/cropper.css') }}" rel="stylesheet" type="text/css">
@endpush
@push('js')
    <script src="{{ asset_administrator('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/parsleyjs/page/parsley.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/cropperjs/js/cropper.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"
        integrity="sha512-efAcjYoYT0sXxQRtxGY37CKYmqsFVOIwMApaEbrxJr4RwqVVGw8o+Lfh/+59TU07+suZn1BWq4fDl5fdgyCNkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        // Fungsi untuk menangani perubahan pada file input
        function handleFileInputChange() {
            const newInput = this; // 'this' mengacu pada elemen file input yang dipicu oleh perubahan

            // Mendapatkan file yang baru dipilih
            const newFiles = newInput.files;

            // Lakukan sesuatu dengan file yang baru dipilih
            for (let i = 0; i < newFiles.length; i++) {
                const newFile = newFiles[i];

                // Lakukan sesuatu dengan setiap file, misalnya, tampilkan informasi di konsol
                console.log(`File Baru: ${newFile.name}, Tipe: ${newFile.type}, Ukuran: ${newFile.size} bytes`);
            }

            // Anda dapat menambahkan logika lain sesuai kebutuhan Anda di sini
        }

        // Variabel untuk menyimpan array file
        let filesArray = [];

        const inputGambar = document.getElementById("inputGambar");
        const previewContainerGambarLainnya = document.querySelector(".fileinput-preview-gambar");

        inputGambar.addEventListener("change", function() {
            const files = this.files;

            // Set your desired maximum limit
            let maxLimit = 10;

            // Check if the number of selected files exceeds the limit
            if (files.length > maxLimit || filesArray.length > maxLimit || files.length > (maxLimit - filesArray
                    .length)) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-4',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });

                let content = ''
                if (files.length > maxLimit) {
                    maxLimit = maxLimit
                    content = 'Tidak boleh lebih dari ' + maxLimit + ' Image.'
                } else if (filesArray.length > maxLimit) {
                    maxLimit = maxLimit - filesArray.length
                    content = 'Tidak boleh lebih dari ' + maxLimit + ' Image.'
                } else if (files.length > (maxLimit - filesArray.length)) {
                    maxLimit = maxLimit - filesArray.length
                    content = 'Tidak boleh lebih dari ' + maxLimit + ' Image.'
                }

                swalWithBootstrapButtons.fire({
                    title: 'Gagal!',
                    text: content,
                    icon: 'error',
                    timer: 2500, // 2 detik
                    showConfirmButton: false
                });
                // You may want to clear the selected files or take other actions here
                return;
            }

            // Loop melalui semua file yang dipilih
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const imageType = /^image\//;

                if (!imageType.test(file.type)) {
                    continue;
                }

                const tableRow = document.createElement("tr");

                // No column
                const noCell = document.createElement("td");
                noCell.classList.add("text-center");
                noCell.textContent = $(".fileinput-preview-gambar").find('tr').length + 1;
                tableRow.appendChild(noCell);

                // Preview column
                const previewCell = document.createElement("td");
                previewCell.classList.add("text-center");
                const imgContainer = document.createElement("div");
                imgContainer.classList.add("img-thumbnail-container");
                const img = document.createElement("img");
                img.classList.add("img-thumbnail");
                img.width = 200; // Sesuaikan ukuran gambar sesuai kebutuhan
                img.src = URL.createObjectURL(file);
                imgContainer.appendChild(img);
                previewCell.appendChild(imgContainer);

                // Action column
                const actionCell = document.createElement("td");
                actionCell.classList.add("text-center");
                const deleteButton = document.createElement("a");
                deleteButton.href = "#";
                deleteButton.title = "Delete";
                deleteButton.classList.add("btn", "btn-danger", "btn-sm", "deleteImg", "mx-1");
                deleteButton.innerHTML = '<i class="fa fa-trash" aria-hidden="true"></i>';

                // Button Crop
                const cropButton = document.createElement("a");
                cropButton.href = "#";
                cropButton.title = "Crop";
                cropButton.classList.add("btn", "btn-outline-secondary", "btn-sm", "triggerCrop", "mx-1");
                cropButton.setAttribute("data-bs-toggle", "modal");
                cropButton.setAttribute("data-bs-target", "#ModalCrop");
                cropButton.setAttribute("data-src", URL.createObjectURL(file));
                cropButton.innerHTML = '<i class="fa fa-crop" aria-hidden="true"></i>';

                let trLength = $(".fileinput-preview-gambar").find('tr').length
                // Input hidden untuk data crop
                const dataImageItem = document.createElement("div");
                dataImageItem.classList.add("data_image-item");

                const widthItem = document.createElement("input");
                widthItem.type = "hidden";
                widthItem.classList.add("width-item");
                widthItem.name = 'dataImage[' + trLength + '][width]';

                const heightItem = document.createElement("input");
                heightItem.type = "hidden";
                heightItem.classList.add("height-item");
                heightItem.name = 'dataImage[' + trLength + '][height]';

                const xItem = document.createElement("input");
                xItem.type = "hidden";
                xItem.classList.add("x-item");
                xItem.name = 'dataImage[' + trLength + '][x]';

                const yItem = document.createElement("input");
                yItem.type = "hidden";
                yItem.classList.add("y-item");
                yItem.name = 'dataImage[' + trLength + '][y]';

                const ratio1 = document.createElement("input");
                ratio1.type = "hidden";
                ratio1.value = 2;
                ratio1.classList.add("ratio1-item");

                const ratio2 = document.createElement("input");
                ratio2.type = "hidden";
                ratio2.value = 3;
                ratio2.classList.add("ratio2-item");

                function refreshRowNumbers() {
                    const rows = previewContainerGambarLainnya.getElementsByTagName("tr");

                    for (let i = 0; i < rows.length; i++) {
                        const noCell = rows[i].getElementsByTagName("td")[0];
                        noCell.textContent = i + 1;

                        const inputWidth = rows[i].getElementsByClassName('width-item')[0];
                        inputWidth.name = 'dataImage[' + i + '][width]';

                        const inputHeight = rows[i].getElementsByClassName('height-item')[0];
                        inputHeight.name = 'dataImage[' + i + '][height]';

                        const inputX = rows[i].getElementsByClassName('x-item')[0];
                        inputX.name = 'dataImage[' + i + '][x]';

                        const inputY = rows[i].getElementsByClassName('y-item')[0];
                        inputY.name = 'dataImage[' + i + '][y]';
                    }
                }

                deleteButton.addEventListener("click", function() {

                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success mx-4',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    });

                    swalWithBootstrapButtons.fire({
                        title: 'Apakah anda yakin ingin menghapus image ini',
                        icon: 'warning',
                        buttonsStyling: false,
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Saya yakin!',
                        cancelButtonText: 'Tidak, Batalkan!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {

                            // Hapus gambar saat tombol "Hapus" diklik
                            const fileIndex = filesArray.indexOf(file);
                            if (fileIndex !== -1) {
                                filesArray.splice(fileIndex, 1);

                                // Buat objek DataTransfer baru
                                const newFilesList = new DataTransfer();

                                // Tambahkan file ke objek DataTransfer
                                filesArray.forEach(file => newFilesList.items.add(file));

                                // Set nilai baru untuk file input
                                inputGambar.files = newFilesList.files;

                                // Tambahkan event listener ke file input baru
                                inputGambar.addEventListener("change",
                                    handleFileInputChange);
                            }

                            tableRow.remove();

                            refreshRowNumbers();
                        }
                    });
                });

                actionCell.appendChild(deleteButton);
                actionCell.appendChild(cropButton);
                actionCell.appendChild(dataImageItem);

                dataImageItem.appendChild(widthItem);
                dataImageItem.appendChild(heightItem);
                dataImageItem.appendChild(xItem);
                dataImageItem.appendChild(yItem);
                dataImageItem.appendChild(ratio1);
                dataImageItem.appendChild(ratio2);

                tableRow.appendChild(noCell);
                tableRow.appendChild(previewCell);
                tableRow.appendChild(actionCell);

                // Append the table row to the tbody
                previewContainerGambarLainnya.appendChild(tableRow);

                // Tambahkan file ke dalam array
                filesArray.push(file);
                // Buat objek DataTransfer baru
                const newFilesList = new DataTransfer();

                // Tambahkan file ke objek DataTransfer
                filesArray.forEach(file => newFilesList.items.add(file));

                // Set nilai baru untuk file input
                inputGambar.files = newFilesList.files;

                // Tambahkan event listener ke file input baru
                inputGambar.addEventListener("change",
                    handleFileInputChange);
            }
        });
    </script>

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

                indicatorBlock();

                const tbody = document.querySelector("#daftar_detail tbody");
                const inputDetail = $("#daftar_detail");
                const accessErrorDetail = $("#accessErrorDetail");
                if (!tbody || !tbody.childElementCount) {
                    inputDetail.css("color", "#dc3545"); // Mengatur warna langsung menggunakan jQuery
                    accessErrorDetail.addClass('invalid-feedback');
                    inputDetail.addClass('is-invalid');
                    accessErrorDetail.text(
                        'Setidaknya harus ada salah satu detail formula'
                    ); // Set the error message from the response
                    console.log("Table body is empty");
                    indicatorNone();
                    return;
                } else {
                    inputDetail.css("color", ""); // Menghapus properti warna menggunakan jQuery
                    accessErrorDetail.removeClass('invalid-feedback');
                    inputDetail.removeClass('is-invalid');
                    accessErrorDetail.text('');
                }

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
                    var toasty = new Toasty(optionToast);
                    toasty.configure(optionToast);
                    toasty.error(validationErrors.join('\n'));
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

            var options = {
                searchable: true,
                placeholder: 'select',
                searchtext: 'search',
                selectedtext: 'dipilih'
            };
            var optionKategori = $('#inputKategori');
            var selectKategori = NiceSelect.bind(document.getElementById('inputKategori'), options);


            optionKategori.html(
                '<option id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin">' +
                '</i> Sedang memuat...</option>'
            );

            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: '{{ route('admin.set.getKategori') }}',
                method: 'GET',
                success: function(response) {
                    var data = response.kategori;
                    var optionsHtml = ''; // Store the generated option elements

                    // Iterate through each Data in the response data
                    for (var i = 0; i < data.length; i++) {
                        var dataKategori = data[i];
                        optionsHtml += '<option value="' + dataKategori.id + '">' + dataKategori
                            .nama + '</option>';
                    }

                    // Construct the final dropdown HTML
                    var finalDropdownHtml = '<option value="">Pilih Data</option>' + optionsHtml;

                    optionKategori.html(finalDropdownHtml);

                    selectKategori.update();

                    loadingSpinner.hide(); // Hide the loading spinner after data is loaded
                },
                error: function() {
                    // Handle the error case if the AJAX request fails
                    console.error('Gagal memuat data Data.');
                    optionKategori.html('<option>Gagal memuat data</option>')
                    loadingSpinner
                        .hide(); // Hide the loading spinner even if there's an error
                }
            });

            $('#triggerTambahDetail').off().on('click', function() {
                var tr_clone = $(".template-detail-list").clone();
                const no = 1;

                tr_clone.find(".no-item").text(no);

                tr_clone.removeClass("template-detail-list");
                tr_clone.addClass("detail-list");

                $("#daftar_detail").append(tr_clone);

                resetData();
            });

            function resetData() {

                var index = 0;
                $(".detail-list").each(function() {
                    var another = this;
                    var key = index;

                    $(this).find(".no-item").text(index + 1)
                    $(this).find(".label_inputImage-item").prop('for', 'inputImage_' + (index));
                    $(this).find(".inputImage-item").prop('id', 'inputImage_' + (index));

                    search_index = $(this).attr("childidx");
                    $(this).find('input, select').each(function() {
                        // Ubah nama atribut 'name' dengan pengindeksan yang benar
                        this.name = this.name.replace('[' + search_index + ']', '[' + index + ']');
                        $(another).attr("childidx", index);
                    });

                    $(this).find('.harga-item').inputmask('currency', {
                        rightAlign: false,
                        prefix: 'Rp ',
                        digits: 0,
                        groupSeparator: '.',
                        radixPoint: ',',
                        allowMinus: false,
                        autoGroup: true,
                        onBeforeMask: function(value, opts) {
                            return value.replace('Rp ', '');
                        }
                    }).on('keyup', function() {
                        updateTotalHarga()
                    });

                    $(this).find('.inputImage-item').on('change', function() {
                        const file = this.files[
                            0]; // Assuming you want to handle only the first file

                        const imageType = /^image\//;

                        if (!imageType.test(file.type)) {
                            // Handle non-image files or do nothing
                            return;
                        }

                        $(another).find('.triggerCrop-item').remove()
                        $(another).find('.data_image-item').empty()

                        // Button Crop
                        const cropButton = document.createElement("a");
                        cropButton.href = "#";
                        cropButton.classList.add("btn", "btn-outline-secondary", 'btn-sm',
                            "triggerCrop-item",
                            "mx-1");
                        cropButton.setAttribute("data-bs-toggle", "modal");
                        cropButton.setAttribute("data-bs-target", "#ModalCrop");
                        cropButton.setAttribute("data-src", URL.createObjectURL(file));
                        cropButton.innerHTML = "<i class='fa fa-eye'></i>";

                        const widthItem = document.createElement("input");
                        widthItem.type = "hidden";
                        widthItem.classList.add("width-item");
                        widthItem.name = 'detail[' + key + '][dataImage_width]';

                        const heightItem = document.createElement("input");
                        heightItem.type = "hidden";
                        heightItem.classList.add("height-item");
                        heightItem.name = 'detail[' + key + '][dataImage_height]';

                        const xItem = document.createElement("input");
                        xItem.type = "hidden";
                        xItem.classList.add("x-item");
                        xItem.name = 'detail[' + key + '][dataImage_x]';

                        const yItem = document.createElement("input");
                        yItem.type = "hidden";
                        yItem.classList.add("y-item");
                        yItem.name = 'detail[' + key + '][dataImage_y]';

                        const ratio1 = document.createElement("input");
                        ratio1.type = "hidden";
                        ratio1.classList.add("ratio1-item");
                        ratio1.value = 1;

                        const ratio2 = document.createElement("input");
                        ratio2.type = "hidden";
                        ratio2.classList.add("ratio2-item");
                        ratio2.value = 1;

                        // Assuming this is a jQuery element, use append() instead of appendChild()
                        $(this).parent().after(cropButton);
                        $(another).find('.data_image-item').append(widthItem);
                        $(another).find('.data_image-item').append(heightItem);
                        $(another).find('.data_image-item').append(xItem);
                        $(another).find('.data_image-item').append(yItem);
                        $(another).find('.data_image-item').append(ratio1);
                        $(another).find('.data_image-item').append(ratio2);
                    });

                    index++;
                });
            }

            function updateTotalHarga() {
                var total = 0;
                $(".detail-list").each(function() {
                    var harga = parseRupiah($(this).find(".harga-item")
                        .val());
                    if (!isNaN(harga)) {
                        total += harga;
                    }
                });
                $("#inputTotalHarga").val(total);
            }

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
