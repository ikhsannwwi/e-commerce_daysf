@extends('administrator.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                Set
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Set</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-6">
                                @if (isallowed('set', 'add'))
                                    <a href="{{ route('admin.set.add') }}" class="btn btn-primary mx-3 float-end">Tambah
                                        Data</a>
                                @endif
                                {{-- <a href="javascript:void(0)" class="btn btn-primary float-end" id="filterButton">Filter</a> --}}
                            </div>
                        </div>
                    </div>
                    {{-- @include('administrator.set.filter.main') --}}
                    <div class="card-body">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th width="15px">No</th>
                                    <th width="50%">Kategori</th>
                                    <th width="50%">Nama</th>
                                    <th width="225px">Total Harga</th>
                                    <th width="225px">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Basic Tables end -->

    @include('administrator.set.modal.detail')
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            var data_table = $('#datatable').DataTable({
                "oLanguage": {
                    "oPaginate": {
                        "sFirst": "<i class='ti-angle-left'></i>",
                        "sPrevious": "&#8592;",
                        "sNext": "&#8594;",
                        "sLast": "<i class='ti-angle-right'></i>"
                    }
                },
                processing: true,
                serverSide: true,
                order: [
                    [0, 'asc']
                ],
                scrollX: true, // Enable horizontal scrolling
                ajax: {
                    url: '{{ route('admin.set.getData') }}',
                    dataType: "JSON",
                    type: "GET",
                },
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'kategori.nama',
                        name: 'kategori.nama'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'total_harga',
                        name: 'total_harga'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        sortable: false,
                        class: 'text-center'
                    },
                ],
            });

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


            $(document).on('click', '.delete', function(event) {
                var id = $(this).data('id');
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-4',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: 'Apakah anda yakin ingin menghapus data ini',
                    icon: 'warning',
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Saya yakin!',
                    cancelButtonText: 'Tidak, Batalkan!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('admin.set.delete') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "_method": "DELETE",
                                "id": id,
                            },
                            success: function(response) {
                                data_table.ajax.reload(null, false);
                                var toasty = new Toasty(optionToast);
                                toasty.configure(optionToast);
                                toasty.success(response.message);
                            },
                            error: function(response) {
                                var toasty = new Toasty(optionToast);
                                toasty.configure(optionToast);
                                toasty.error(response.responseJSON.message);
                            }
                        });
                    }
                });
            });

        });
    </script>
@endpush
