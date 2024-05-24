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
                        <h1 class="m-0">Product Transfer Request</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Transfer Request</li>
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
                                        <span>All Transfer</span></i></a>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="bootstrap-data-table-panel">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-striped table-bordered table-centre">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Request To</th>
                                                    <th>Request From</th>
                                                    <th>Product Name</th>
                                                    <th>Request date</th>
                                                    <th>Note</th>
                                                    <th>Status</th>
                                                    @if (Auth::guard('admin')->user()->office_id == '0' || Auth::guard('admin')->user()->office_id == '1')
                                                        <th>Action</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $key => $item)
                                                    @php
                                                        $request_to_name = App\Models\Office::where(
                                                            'id',
                                                            $item->request_to_office_id,
                                                        )->first();
                                                        $request_from_name = App\Models\Office::where(
                                                            'id',
                                                            $item->request_from_office_id,
                                                        )->first();
                                                        $requestDetails = App\Models\TransferRequestDetails::where(
                                                            'transfer_request_id',
                                                            $item->id,
                                                        )->first();
                                                        $product = App\Models\product::where(
                                                            'id',
                                                            $requestDetails->product_id,
                                                        )->first();
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $request_to_name->title }}</td>
                                                        <td>{{ $request_from_name->title }}</td>
                                                        <td>{{ $product->name }}</td>
                                                        <td>{{ $item->date }}</td>
                                                        <td>{{ $item->note }}</td>

                                                        <td>
                                                            @if ($item->status == 0)
                                                                <span class="badge badge-warning">Pending</span>
                                                            @elseif ($item->status == 1)
                                                                <span class="badge badge-primary">Approved</span>
                                                            @elseif ($item->status == 2)
                                                                <span class="badge badge-primary">Accepted</span>
                                                            @else
                                                                <span class="badge badge-primary">Cancelled</span>
                                                            @endif
                                                        </td>

                                                        @if (Auth::guard('admin')->user()->office_id == '0' || Auth::guard('admin')->user()->office_id == '1')
                                                            <td>
                                                                <div class="d-flex justify-content-center">
                                                                    <a href="{{ route('product.edit', $product->id) }}"
                                                                        class="btn btn-sm btn-info"
                                                                        style="margin-right: 2px">
                                                                        Approved
                                                                    </a>
                                                                    <a href="{{ route('product.edit', $product->id) }}"
                                                                        class="btn btn-sm btn-danger"
                                                                        style="margin-right: 2px">
                                                                        Cancelled
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        @endif

                                                    </tr>
                                                @endforeach
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
@endsection
