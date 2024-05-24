@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Products Assign</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Products</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a
                                        href="{{ route('product-allocate.index') }}"class="btn btn-light text-dark shadow rounded m-0">
                                        <span>Cancle Edit</span></a>
                                </h3>
                            </div>
                            <form action="{{ route('product-allocate.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf()
                                {{-- @method('PATCH') --}}
                                {{-- <input type="hidden" name="id" value="{{$products->id}}"> --}}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                                            <label>Choose Product</label>
                                            <select name="product_id" id="" class="form-control">
                                                <option value="" selected disabled>Select Once</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"@if ($product->id == $assign->product_id) selected @endif>
                                                        {{ $product->name }} @if ($product->isassign == 0)
                                                            <span class="badge badge-primary"> &rightarrow;( Not Assign)</span>
                                                        @else
                                                            <span class="badge badge-warning"> &rightarrow;( Assigned)</span>
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                                            <label>Choose Office</label>
                                            <select name="office_id" id="" class="form-control">
                                                <option value="" selected disabled>Select Once</option>

                                                @foreach ($offices as $office)
                                                    <option value="{{ $office->id }}"
                                                        @if ($office->id == $assign->office_id) selected @endif>
                                                        {{ $office->title }}</option>
                                                    @php
                                                        $zonal_offices = App\Models\Office::where(
                                                            'head_office_id',
                                                            $office->id,
                                                        )
                                                            ->where('zonal_office_id', '')
                                                            ->get();
                                                    @endphp
                                                    @foreach ($zonal_offices as $zonal_office)
                                                        <option value="{{ $zonal_office->id }}"
                                                            @if ($zonal_office->id == $assign->office_id) selected @endif>
                                                            &nbsp;&rightarrow;{{ $zonal_office->title }}</option>
                                                        @php
                                                            $branch_offices = App\Models\Office::where(
                                                                'zonal_office_id',
                                                                $zonal_office->id,
                                                            )->get();
                                                        @endphp
                                                        @foreach ($branch_offices as $branch_office)
                                                            <option value="{{ $branch_office->id }}"
                                                                @if ($branch_office->id == $assign->office_id) selected @endif>
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
