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
                        <h1 class="m-0">Status Reports</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Reports</li>
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
                                        <span>All Status </span></i></a>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <select name="office_id" id="office_id" class="form-control form-control-sm">
                                                <option value="0"> All office</option>
                                                @foreach ($offices as $office)
                                                    <option value="{{ $office->id }}">{{ $office->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <select name="product_id" id="product_id"
                                                class="form-control form-control-sm select2">
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                            <button class="btn btn-primary btn-sm" id="filter">Filter</button>
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
            onLoad();
            $('#office_id').on('change', function() {
                loadProduct($(this).val());
            });
            $('#filter').on('click', function() {
                var office_id = $('#office_id').val();
                var product_id = $('#product_id').val();
                // alert(office_id);
                // alert(product_id);
                productStatus(office_id, product_id);
            });
        });

        function onLoad() {
            var office_id = 0;
            var product_id = 0;
            $('#office_id').val(office_id);
            loadProduct(office_id);
            var product_id = $('#product_id').val();
            productStatus(office_id, product_id);
        }

        function loadProduct(office_id) {
            $.ajax({
                type: "GET",
                url: "{{ url('admin/product-list') }}/" + office_id,
                dataType: "json",
                success: function(res) {
                    let option = `<option value="0" selected> All Products</option>`;
                    res.forEach(element => {
                        option +=
                            `<option value="${element.id}">${element.name}(${element.product_code})</option>`;
                    });
                    $('#product_id').html(option);
                }
            })
        }

        function productStatus(office_id, product_id) {
            $.ajax({
                type: "GET",
                url: "{{ url('admin/status/all-report') }}/" + office_id + '/' + product_id,
                dataType: "json",
                success: function(res) {
                    $('#product_id').html(res.product);
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
