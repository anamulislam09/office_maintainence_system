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
                        <h1 class="m-0">Products Status</h1>
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
                    <section class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-primary p-1">
                                <h3 class="card-title">
                                    <a href="#"class="btn btn-light shadow rounded m-0">
                                        <span>Status Update</span></i></a>
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
                                                    <th>Product code</th>
                                                    <th>Category</th>
                                                    <th>SubCategory</th>
                                                    <th>Office Name</th>
                                                    <th>Assign Date</th>
                                                    <th>Assign By</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($productStatus as $key => $item)
                                                    @php
                                                        $product = App\Models\Product::where( 'id',$item->product_id, )->first();
                                                        $category = App\Models\Category::where('id', $product->cat_id)->where('main_cat_id', null)->first();
                                                        $sub_cat = App\Models\Category::where('id', $product->sub_cat_id)->first();
                                                        $office = App\Models\Office::where('id',$item->office_id,)->first();

                                                    @endphp
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $product->name }}</td>
                                                        <td>{{ $product->product_code }}</td>
                                                        <td>{{ $category->name }}</td>
                                                        <td>{{ $sub_cat ? $sub_cat->name : '' }}</td>
                                                        <td>{{ $office->title }}</td>
                                                        <td>{{ $item->created_date }}</td>
                                                        <td>{{ $item->created_by }}</td>
                                                        <td>
                                                            @if ($item->status == 1)
                                                                <span class="badge badge-primary">Live</span>
                                                            @elseif ($item->status == 0)
                                                                <span class="badge badge-warning">Not Working</span>
                                                            @else
                                                                <span class="badge badge-danger">Dead</span>
                                                            @endif
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
