@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Product Assign</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Products-Assign</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Assign Form</h3>
                    </div>
                    <div class="row py-5">
                        <div class="col-8 m-auto mt-3 border">
                            <form action="{{ route('product-allocate.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf()

                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                                            <label>Choose Product</label>
                                            <select name="product_id" id="" class="form-control" required>
                                                <option value="" selected disabled>Select Once</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }} ( {{ $product->product_code }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                                            <label>Choose Office</label>
                                            <select name="office_id" id="" class="form-control" required>
                                                <option value="" selected disabled>Select Once</option>
                                                @foreach ($offices as $office)
                                                    <option value="{{ $office->id }}">{{ $office->title }}</option>
                                                    @php
                                                        $zonal_offices = App\Models\Office::where(
                                                            'head_office_id', $office->id)->where('zonal_office_id', '')->get();
                                                    @endphp
                                                    @foreach ($zonal_offices as $zonal_office)
                                                        <option value="{{ $zonal_office->id }}">
                                                            &nbsp;&rightarrow;{{ $zonal_office->title }}</option>
                                                        @php
                                                            $branch_offices = App\Models\Office::where(
                                                                'zonal_office_id',
                                                                $zonal_office->id,
                                                            )->get();
                                                        @endphp
                                                        @foreach ($branch_offices as $branch_office)
                                                            <option value="{{ $branch_office->id }}">
                                                                &nbsp;&rightarrow;&rightarrow; {{ $branch_office->title }}
                                                            </option>
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
