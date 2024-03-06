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
                                <li class="breadcrumb-item active" aria-current="page">Frontpage</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            @if (isallowed('settings', 'frontpage_general'))
                                <div class="col-lg-6 col-12">
                                    <div class="card card-large-icons">
                                        <div class="card-icon bg-main-background-color text-white">
                                            <i class="fas fa-bars"></i>
                                        </div>
                                        <div class="card-body">
                                            <h4>General</h4>
                                            <p>General Settings.</p>
                                            <a href="{{ route('admin.settings.frontpage.general') }}" class="card-cta">Change
                                                Setting <i class="fas fa-chevron-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (isallowed('settings', 'frontpage_api'))
                                <div class="col-lg-6 col-12">
                                    <div class="card card-large-icons">
                                        <div class="card-icon bg-main-background-color text-white">
                                            <i class="fas fa-cog"></i>
                                        </div>
                                        <div class="card-body">
                                            <h4>Configure Api</h4>
                                            <p>Configure Api Frontpage.</p>
                                            <a href="{{ route('admin.settings.frontpage.api') }}" class="card-cta">Change
                                                Setting <i class="fas fa-chevron-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
