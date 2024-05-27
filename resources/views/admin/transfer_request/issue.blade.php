@extends('layouts.admin.master')
@section('content')
    @php
        $basicInfo = App\Models\BasicInfo::first();
    @endphp
    <div class="content-wrapper">
        <div class="content-header">
            @include('layouts.admin.flash-message')
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">All Issue</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href=Transfer"{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Issue</li>
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
                                <h3 class="card-title">
                                    <a href="#"class="btn btn-light shadow rounded m-0">
                                        <span>All Issue</span></i></a>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="bootstrap-data-table-panel">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-striped table-bordered table-centre">
                                            <thead>
                                                <tr>
                                                    {{-- <th>SN</th> --}}
                                                    <th>Transfer To</th>
                                                    <th>Created By</th>
                                                    <th>Issue date</th>
                                                    <th>Status</th>
                                                    {{-- @if (Auth::guard('admin')->user()->office_id !== '0' || Auth::guard('admin')->user()->office_id !== '1') --}}
                                                    <th>Action</th>
                                                    {{-- @endif --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    {{-- <td>{{ 1 </td> --}}
                                                    <td>{{ $office_name }}</td>
                                                    <td>{{ $transferRequests->created_by }}</td>
                                                    <td>{{ $transferRequests->created_date }}</td>
                                                    <td>
                                                        @if ($transferRequests->status == 1)
                                                            <span class="badge badge-primary">Pending</span>
                                                        @elseif ($transferRequests->status == 2)
                                                            <span class="badge badge-info">Assigned</span>
                                                        @elseif ($transferRequests->status == 3)
                                                            <span class="badge badge-success">Accepted</span>
                                                        @else
                                                            <span class="badge badge-danger">Rejected</span>
                                                        @endif
                                                    </td>
                                                    </td>
                                                    {{-- @if (Auth::guard('admin')->user()->office_id !== '0' || Auth::guard('admin')->user()->office_id !== '1') --}}
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <a href="#" id="transferRequest"
                                                                data-id="{{ $transferRequests->id }}" data-toggle="modal"
                                                                data-target="#myModal" class="btn btn-sm btn-success"
                                                                style="margin-right: 2px">
                                                                <i class="fas fa fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('transfer-request.issued', $transferRequests->id) }}"
                                                                class="btn btn-sm btn-info" style="margin-right: 2px">
                                                                Issue
                                                            </a>
                                                        </div>
                                                    </td>
                                                    {{-- @endif --}}
                                                </tr>
                                            </tbody>
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

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title m-auto">All Issue Products</h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('body').on('click', '#transferRequest', function() {
            let transfer_id = $(this).data('id');

            $.get("/admin/transfer-request/products/" + transfer_id, function(data) {
                $('.modal-body').html(data);

            })
        })
    </script>
@endsection
