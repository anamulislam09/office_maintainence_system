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
                                                    <th>Purchase Price</th>
                                                    <th>purchase Date</th>
                                                    <th>Garranty</th>
                                                    <th>Garranty End date</th>
                                                    <th>Assign Status</th>
                                                    <th>Category</th>
                                                    <th>Subcategory</th>
                                                    <th>Brand Name</th>
                                                    <th>Supplier Name</th>
                                                    <th>Serial No</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- @foreach ($products as $key => $product)
                                                @php
                                                    $category = App\Models\Category::where('id', $product->cat_id)->where('main_cat_id', null)->first();
                                                    $sub_cat = App\Models\Category::where('id', $product->sub_cat_id)->first();
                                                    $brand = App\Models\Brand::where('id', $product->brand_id)->first();
                                                    $supplier = App\Models\Supplier::where('supplier_id', $product->supplier_id)->first();
                                                @endphp
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $product->name }}</td>
                                                        <td>{{ $product->product_code }}</td>
                                                        <td>{{ $product->purchase_price }}</td>
                                                        <td>{{ $product->purchase_date }}</td>
                                                        <td>{{ $product->garranty }}</td>
                                                        <td>{{ $product->garranty_end_date }}</td>
                                                        <td>
                                                            @if ($product->isassign == 1)
                                                                <span class="badge badge-warning">Assigned</span>
                                                            @else
                                                                <span class="badge badge-primary">Not Assign</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $category->name }}</td>
                                                        <td>{{ $sub_cat ? $sub_cat->name : ''}}</td>
                                                        <td>{{ $brand->name }}</td>
                                                        <td>{{ $supplier? $supplier->name : ''}}</td>
                                                        <td>{{ $product->serial_no }}</td>
                                                        <td>{{ $product->descriptions }}</td>
                                                        
                                                        <td>
                                                            @if ($product->status == 1)
                                                                <span class="badge badge-primary">Active</span>
                                                            @else
                                                                <span class="badge badge-danger">Inactive</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <a href="{{ route('product.edit', $product->id) }}"
                                                                    class="btn btn-sm btn-info" style="margin-right: 2px">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                                <a href="{{ route('product.show', $product->id) }}"
                                                                    class="btn btn-sm btn-success" style="margin-right: 2px">
                                                                    <i class="fa-solid fa-eye"></i>
                                                                </a>

                                                                <form action="{{ route('product.destroy', $product->id) }}" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach --}}
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
