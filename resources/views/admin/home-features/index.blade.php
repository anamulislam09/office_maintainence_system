@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            @include('layouts.admin.flash-message')
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Home Feature</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Home Feature</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-primary p-1">
                                {{-- <h3 class="card-title">
                                </h3> --}}
                            </div>
                            <div class="card-body">
                                <div class="bootstrap-data-table-panel">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-striped table-bordered table-centre">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Title</th>
                                                    <th>Size</th>
                                                    <th>URL</th>
                                                    <th>Serial</th>
                                                    <th>Image</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($homeFeatures as $homeFeature)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $homeFeature->feature_title }}</td>
                                                        <td>{{ $homeFeature->feature_size }}</td>
                                                        <td>{{ $homeFeature->feature_url }}</td>
                                                        <td>{{ $homeFeature->feature_serial }}</td>
                                                        <td>
                                                            <img height="70px" width="70px" src="{{ asset($homeFeature->feature_image ? 'public/uploads/home-feature/' . $homeFeature->feature_image : 'public/admin-assets/dist/img/placeholder.png') }}">
                                                        </td>
                                                        <td>
                                                            @if ($homeFeature->feature_status == 1)
                                                                Active
                                                            @else
                                                                Inactive
                                                            @endif
                                                        </td>
                                                        <td class="d-flex justify-content-center">
                                                            <a class="btn btn-primary mx-2"
                                                                href="{{ route('home-features.edit', $homeFeature->id) }}">
                                                                <i class="fas fa-edit"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Title</th>
                                                    <th>Size</th>
                                                    <th>URL</th>
                                                    <th>Serial</th>
                                                    <th>Image</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
@endsection
