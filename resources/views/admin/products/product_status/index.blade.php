@extends('layouts.admin.master')
@section('content')
    @php
        $basicInfo = App\Models\BasicInfo::first();
        $branch_office_exists = App\Models\Office::where('id', Auth::guard('admin')->user()->office_id)
            ->where('head_office_id', '!=', '')
            ->where('zonal_office_id', '!=', '')
            ->exists();
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
                                <div class="card-header">
                                    <div class="row">
                                        @if (!$branch_office_exists)
                                            <div class="col-lg-3">
                                                <select name="office_id" id="office_id" class="form-control form-control-sm">
    
                                                    <option value="0"> All office</option>
                                                    @if (Auth::guard('admin')->user()->office_id == 1 || Auth::guard('admin')->user()->office_id == 1)
                                                        @foreach ($offices as $office)
                                                            <option value="{{ $office->id }}">{{ $office->title }}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        @foreach ($offices as $office)
                                                            <option value="{{ $office->id }}">{{ $office->title }}
                                                            </option>
                                                            @php
                                                                $branch_offices = App\Models\Office::where(
                                                                    'zonal_office_id',
                                                                    $office->id,
                                                                )->get();
                                                            @endphp
                                                            @foreach ($branch_offices as $branch_office)
                                                                <option value="{{ $branch_office->id }}">
                                                                    {{ $branch_office->title }}
                                                                </option>
                                                            @endforeach
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        @else
                                        @endif


                                        <div class="col-lg-3">
                                            <select name="product_id" id="product_id"
                                                class="form-control form-control-sm select2">
                                                <option value="" selected disabled>Select Product</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <button class="btn btn-primary" id="filter">Filter</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="bootstrap-data-table-panel">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-striped table-bordered table-centre">
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
                                            <tbody id="tbody2">
                                                
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
                productStatus(office_id, product_id);
            });
        });

        function onLoad(){
            var office_id = "{{ Auth('admin')->user()->office_id }}";
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
                        option += `<option value="${element.id}">${element.name}(${element.product_code})</option>`;
                    });
                    $('#product_id').html(option);
                }
            })
        }

        function productStatus(office_id, product_id) {
            $.ajax({
                type: "GET",
                url: "{{ url('admin/product-status') }}/" + office_id + '/' + product_id,
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

                        $('#tbody2').html(tbody);
                        // $("#tbody2").show();
                        // $("#tbody2").reset();
                    } else {
                        $('#tbody2').html(
                            '<tr><td colspan="8" class="text-center">No data available</td></tr>');
                        // $("#tbody2").show();
                        // $("#tbody2").hide();
                    }
                }
            });
        }

    </script>
@endsection
