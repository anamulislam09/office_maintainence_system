@extends('layouts.admin.master')
@section('content')
    @php
        $basicInfo = App\Models\BasicInfo::first();
        $branch_office_exists = App\Models\Office::where('id', Auth::guard('admin')->user()->office_id)
            ->whereNotNull('head_office_id')
            ->whereNotNull('zonal_office_id')
            ->exists();

        if ($branch_office_exists) {
            dd('exist');
        } else {
            dd('No');
        }
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
                                        @if (empty($branch_office))
                                            <div class="col-lg-3">
                                                <select name="office_id" id="office_id"
                                                    class="form-control form-control-sm select2">
                                                    <option value="" selected disabled>Select Office</option>
                                                    <option value="0"> All office</option>
                                                    @if (Auth::guard('admin')->user()->office_id == 0 && Auth::guard('admin')->user()->office_id == 1)
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
                                                <option value="0"> All office</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }} (
                                                        {{ $product->product_code }})</option>
                                                @endforeach
                                            </select>
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
                                                    <th>SubCategory</th>
                                                    <th>Office Name</th>
                                                    <th>Created Date</th>
                                                    <th>Created By</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            {{-- <tbody id="tbody1"></tbody> --}}
                                            <tbody id="tbody2">
                                                @foreach ($productStatus as $key => $item)
                                                    @php
                                                        $product = App\Models\Product::where(
                                                            'id',
                                                            $item->product_id,
                                                        )->first();
                                                        $category = App\Models\Category::where('id', $product->cat_id)
                                                            ->where('main_cat_id', null)
                                                            ->first();
                                                        $sub_cat = App\Models\Category::where(
                                                            'id',
                                                            $product->sub_cat_id,
                                                        )->first();
                                                        $office = App\Models\Office::where(
                                                            'id',
                                                            $item->office_id,
                                                        )->first();

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


@section('script')
    <script>
        $('.select2').select2();
        $(function() {
            $("#office_id").change(function() {
                resetTable()
                // $("#tbody2").hide();
                var office_id = $(this).val();
                customerLeader(office_id);
            });

            $("#product_id").change(function() {
                resetTable()
                // $("#tbody2").hide();
                var product_id = $(this).val();
                customerLeader(product_id);
            });
        });

        function resetTable() {
            // Clear the content of the table body
            $('#tbody2').empty();
            // Optionally, hide the table body if necessary
            $("#tbody2").hide();
        }

        function customerLeader(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('admin/product-status') }}/" + id,
                dataType: "json",
                success: function(res) {
                    if (res.productStatus && res.productStatus.length > 0) {
                        var tbody = '';
                        res.productStatus.forEach((element, index) => {
                            tbody += '<tr>'
                            tbody += '<td>' + (index + 1) + '</td>'
                            tbody += '<td>' + element.product_name + '</td>'
                            tbody += '<td>' + element.product_code + '</td>'
                            tbody += '<td>' + element.category_name + '</td>'
                            tbody += '<td>' + element.office_name + '</td>'
                            tbody += '<td>' + element.created_date + '</td>'
                            tbody += '<td>' + element.created_by + '</td>'
                            tbody += '<td>' + element.status + '</td>'
                            tbody += '</tr>'
                        });
                        $('#tbody2').html(tbody);
                        $("#tbody2").show();
                        $("#tbody2").reset();
                    } else {
                        // Handle case where productStatus is empty
                        $('#tbody2').html(
                            '<tr><td colspan="8" class="text-center">No data available</td></tr>');
                        $("#tbody2").show();
                        $("#tbody2").hide();
                    }
                }
            });
        }
    </script>
@endsection
