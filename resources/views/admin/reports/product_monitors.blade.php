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
                        <h1 class="m-0">Product Monitors</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Monitors</li>
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
                                        <span> Monitors </span></i></a>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <select name="product_id" id="product_id"
                                                class="form-control form-control-sm select2">
                                                <option value="0" selected> All Products</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}
                                                        ({{ $product->product_code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- <div class="col-lg-3 col-md-3 col-sm-6">
                                            <select name="product_id" id="product_id"
                                                class="form-control form-control-sm select2">
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                            <button class="btn btn-primary btn-sm" id="filter">Filter</button>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="bootstrap-data-table-panel">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Product Name</th>
                                                    <th>Product code</th>
                                                    <th>Category</th>
                                                    <th>Office Name</th>
                                                    <th>Created Date</th>
                                                    <th>Created By</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="item-table">

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
@section('script')
    <script>
        $('.select2').select2();
        $(function() {
            // alert(0);
            $('#product_id').on('change', function() {
                // alert($(this).val());
                productStatus($(this).val());
            });
        });

        function productStatus(product_id) {
            $.ajax({
                type: "GET",
                url: "{{ url('admin/product-monitors/all') }}/" + product_id,
                dataType: "json",
                success: function(res) {
                    if (res.productStatus && res.productStatus.length > 0) {
                        var tbody = '';
                        res.productStatus.forEach((element, index) => {
                            tbody += '<tr>';
                            tbody += '<td>' + (index + 1) + '</td>';
                            tbody += '<td>' + element.product_name + '</td>';
                            tbody += '<td>' + element.product_code + '</td>';
                            tbody += '<td>' + element.category_name + '</td>';
                            tbody += '<td>' + element.office_name + '</td>';
                            tbody += '<td>' + element.created_date + '</td>';
                            tbody += '<td>' + element.created_by + '</td>';
                            tbody += '<td>';
                            if (element.status == 0) {
                                tbody += '<span class="badge badge-warning">Not Working</span>';
                            } else if (element.status == 1) {
                                tbody += '<span class="badge badge-primary">Working</span>';
                            } else {
                                tbody += '<span class="badge badge-danger">Dead</span>';
                            }
                            tbody += '</td>';
                            tbody += '</tr>';
                        });
                        $('#item-table').html(tbody);
                    } else {
                        $('#item-table').html(
                            '<tr><td colspan="8" class="text-center">No data available</td></tr>');
                    }
                }
            });
        }
    </script>
@endsection
