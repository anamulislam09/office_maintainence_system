@extends('layouts.admin.master')
@section('content')
<style>
    table, tbody, tr,td{
        font-size: 14px;
    }
</style>
    @php
        $basicInfo = App\Models\BasicInfo::first();
    @endphp
    <div class="content-wrapper">
        <div class="content-header">
            @include('layouts.admin.flash-message')
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Product Tracking</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tracking</li>
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
                                    <a href="#" class="btn btn-light shadow rounded m-0">
                                        <span>Tracking </span>
                                    </a>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="card-header" style="margin: 0px !important">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <label for="product_id">Choose Product</label>
                                            <select name="product_id" id="product_id"
                                                class="form-control form-control-sm select2">
                                                <option value="0" selected disabled> Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}
                                                        ({{ $product->product_code }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="bootstrap-data-table-panel">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Product Name</th>
                                                    <th>Product Code</th>
                                                    <th>Category</th>
                                                    <th>Office Name</th>
                                                    <th>Created Date</th>
                                                    <th>Created By</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="item-table">
                                                <!-- Data will be appended here -->
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
        $(document).ready(function() {
            $('.select2').select2();
            var table = $('#example1').DataTable(); // Initialize DataTable on page load
            $('#product_id').on('change', function() {
                var productId = $(this).val();
                productStatus(productId);
            });

            function productStatus(productId) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('admin/report/product-monitors') }}/" + productId,
                    dataType: "json",
                    success: function(res) {
                        var tbody = '';
                        // if (res.productStatus && res.productStatus.length > 0) {
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
                                    tbody +=
                                        '<span class="badge badge-warning">Not Working</span>';
                                } else if (element.status == 1) {
                                    tbody += '<span class="badge badge-primary">Working</span>';
                                } else {
                                    tbody += '<span class="badge badge-danger">Dead</span>';
                                }
                                tbody += '</td>';
                                tbody += '</tr>';
                            });
                        // } else {
                        //     tbody =
                        //         '<tr><td colspan="8" class="text-center">No data available</td></tr>';
                        // }

                        table.clear().destroy(); // Clear and destroy the DataTable
                        $('#item-table').html(tbody); // Update table body
                        table = $('#example1').DataTable(); // Reinitialize DataTable
                    }
                });
            }
        });
    </script>
@endsection
