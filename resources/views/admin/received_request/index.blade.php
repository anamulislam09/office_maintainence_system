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
                        <h1 class="m-0">Product Received Request</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Received Request</li>
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
                                        <span>All Received Request</span></i></a>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="bootstrap-data-table-panel">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-striped table-bordered table-centre">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Product Name</th>
                                                    <th>Product Code</th>
                                                    <th>Status</th>
                                                    <th>Request</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($assignments as $key => $assignment)
                                                {{-- <p>ProductAllocate ID: {{ $assignment->id }}</p>
                                                <p>Product ID: {{ $assignment->product_id }}</p> --}}
                                                {{-- Access other attributes of ProductAllocate as needed --}}
                                                
                                                {{-- Find the corresponding product --}}
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                @foreach($products as $product)
                                                    @if($product->id === $assignment->product_id)
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ $product->product_code }}</td>
                                                    <td>
                                                        @if ($product->status == 1)
                                                            <span class="badge badge-primary">Active</span>
                                                        @else
                                                            <span class="badge badge-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                        @break
                                                    @endif
                                                @endforeach
                                                        <td>
                                                            <span class="badge badge-warning">Pending</span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <a href="{{ route('receive-request.accept', $assignment->id) }}"
                                                                    class="btn btn-sm btn-info"
                                                                    style="margin-right: 2px">Accepted
                                                                </a>
                                                                <a href="{{ route('receive-request.cancel', $assignment->id) }}"
                                                                    class="btn btn-sm btn-danger"
                                                                    style="margin-right: 2px">Cancel
                                                                </a>
                                                            </div>
                                                        </td>
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
