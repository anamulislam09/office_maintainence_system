@extends('layouts.admin.master')
@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Product Transfer Request</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Transfer Request</li>
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
                <h3 class="card-title">Form</h3>
              </div>
              <form id="form-submit" action="{{ route('transfer-request.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf()
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-sm-12 col-md-4 col-lg-4 ">
                      <label>Transfer To </label>
                      <select name="transfer_to_office_id" id="transfer_to_office_id" class="form-control">
                        <option value="" selected disabled>Select Once</option>
                        @foreach ($offices as $office)
                          <option value="{{ $office->id }}">{{ $office->title }}</option>
                          @php
                            $zonal_offices = App\Models\Office::where('head_office_id', $office->id)
                                ->where('zonal_office_id', '')
                                ->get();
                          @endphp
                          @foreach ($zonal_offices as $zonal_office)
                            <option value="{{ $zonal_office->id }}">
                              &nbsp;&rightarrow;{{ $zonal_office->title }}</option>
                            @php
                              $branch_offices = App\Models\Office::where('zonal_office_id', $zonal_office->id)->get();
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
                    <div class="form-group col-sm-12 col-md-4 col-lg-4 ">
                      <label>Transfer From </label>
                      <select name="transfer_from_office_id" id="transfer_from_office_id" class="form-control">
                        <option value="" selected disabled>Select Once</option>
                        @foreach ($offices as $office)
                          <option value="{{ $office->id }}">{{ $office->title }}</option>
                          @php
                            $zonal_offices = App\Models\Office::where('head_office_id', $office->id)
                                ->where('zonal_office_id', '')
                                ->get();
                          @endphp
                          @foreach ($zonal_offices as $zonal_office)
                            <option value="{{ $zonal_office->id }}">
                              &nbsp;&rightarrow;{{ $zonal_office->title }}</option>
                            @php
                              $branch_offices = App\Models\Office::where('zonal_office_id', $zonal_office->id)->get();
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
                    {{-- <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label>Date *</label>
                                            <input name="date" id="date" type="date"
                                                value="{{ isset($data['purchase']) ? $data['purchase']->note : date('Y-m-d') }}"
                                                class="form-control" required>
                                        </div> --}}
                    <div class="form-group col-sm-12 col-md-4 col-lg-4 ">
                      <label>Choose Products</label>
                      <select name="product_id" id="product_id_temp" class="form-control">
                        <option value="" selected disabled>Select Once</option>
                          {{-- @foreach ($products as $product)
                            <option value="{{ $product->id }}" product-title="{{ $product->name }}"
                              product-code="{{ $product->product_code }}">
                              {{ $product->name }} ({{ $product->product_code }})
                            </option>
                          @endforeach --}}
                      </select>
                    </div>
                    <div class="form-group col-sm-12 col-md-12 col-lg-12">
                      <div class="table-responsive">
                        <table id="table" class="table table-striped table-bordered table-centre p-0 m-0">
                          <thead>
                            <tr>
                              <th width="5%">SN</th>
                              <th width="20%">Product Name</th>
                              <th width="20%">Product Code</th>
                              <th width="50%">Product Note</th>
                              <th width="5%">Action</th>
                            </tr>
                          </thead>
                          <tbody id="table-data">
                          </tbody>
                        </table>
                      </div>
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
@section('script')
  <script>
    $(document).ready(function() {
      $('#product_id_temp').on('change', function(e) {
        let product_id = $('#product_id_temp').val();
        let product_title = $('#product_id_temp option:selected').attr('product-title');
        let product_code = $('#product_id_temp option:selected').attr('product-code');

        var td = '';
        td += '<tr>';
        td += '<td class="serial"></td>';
        td += '<td><input type="hidden" value="' + product_id + '" name="product_id[]">' +
          product_title + '</td>';
        td += '<td><input type="hidden" value="' + product_code +
          '" name="product_code[]"  required>' + product_code + '</td>';
        td +=
          '<td> <textarea id="note" class="form-control" name="note[]" style="font-size: 15px;" placeholder="Enter some notes about why you want to transfer this product."></textarea> </td>';
        td +=
          '<td><button class="btn btn-sm btn-danger btn-del" type="button"><i class="fa-solid fa-trash btn-del"></i></button></td>';
        td += '</tr>';

        $('#table-data').append(td);
        $(".serial").each(function(index) {
          $(this).html(index + 1);
        });
        // $('#item_id_temp').val('');
        // calculate(true);
      });


      $('#table-data').bind('click', function(e) {
        $(e.target).is('.btn-del') && e.target.closest('tr').remove();
        $(".serial").each(function(index) {
          $(this).html(index + 1);
        });
      });

    });

    $('#form-submit').submit(function(e) {
      if (!$('input[name="product_id[]"]').length) {
        e.preventDefault();
        Swal.fire("Please Insert Item!");
      }
    });


    $("#transfer_from_office_id").change(function() {
      let transfer_from_office_id = $(this).val();
      $("#product_id_temp").html('<option value="">Select One</option>')
      $.ajax({
        url: '/admin/transfer-request/get-product',
        type: 'post',
        data: 'transfer_from_office_id=' + transfer_from_office_id + '&_token={{ csrf_token() }}',
        success: function(result) {
            // console.log(result);
          $('#product_id_temp').html(result);
        }
      })
    })
  </script>
@endsection
