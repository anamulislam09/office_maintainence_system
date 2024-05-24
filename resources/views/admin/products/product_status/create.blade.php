@extends('layouts.admin.master')
@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Product Status Update</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Products-Status</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header">

            <div class="row">
              <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                <label>Category</label>
                <select name="cat_id" id="cat_id" class="form-control">
                  <option value="0" selected>All Category</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach

                  {{-- @foreach ($data as $main_cat)
                    <option value="{{ $main_cat->id }}">{{ $main_cat->name }}</option>
                    @foreach ($main_cat->subcategoris as $subcat)
                      <option value="{{ $subcat->id }}">
                        &nbsp;&rightarrow;{{ $subcat->name }}</option>
                    @endforeach
                  @endforeach --}}
                </select>
              </div>
              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                {{-- <label></label> --}}
                <button class="btn btn-warning mt-4" type="button" id="btn_show"
                  style="margin-top: 31px !important">Show</button>
                {{-- <a href="#"class="btn btn-light text-dark shadow rounded mt-3" id="show">
                                    <i class="fas fa-plus"></i><span>Show All</span>
                                </a> --}}
              </div>
            </div>


            {{-- <a href="#"class="btn btn-light text-dark shadow rounded m-0" id="show">
                            <i class="fas fa-plus"></i><span>Show All</span>
                        </a> --}}
          </div>
          <form action="{{ route('product-status.store') }}" method="POST" id="form">
            @csrf()
            <div class=" card-body row py-5">
              <div class="col-12 ">
                <div class="table-responsive">
                  <table id="dataTable" class="table table-bordered table-striped mt-3">
                    <thead>
                      <tr>
                        <th style="width: 10%">SL</th>
                        <th style="width: 30%">Product Name</th>
                        <th style="width: 30%">Working Status</th>
                        {{-- <th style="width: 10%">Dead</th> --}}
                        {{-- <th style="width: 20%">Action</th> --}}
                      </tr>
                    </thead>
                    <tbody id="item-table">
                      {{-- @foreach ($assign_products as $key => $item)
                                                @php
                                                    $products = App\Models\Product::where(
                                                        'id',
                                                        $item->product_id,
                                                    )->first();
                                                @endphp
                                                <input type="hidden" name="product_id[]" value="{{ $item->product_id }}">
                                                <input type="hidden" name="office_id[]" value="{{ $item->office_id }}">
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $products->name }}</td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select name="status[]" id="" class="form-control"
                                                                style="height:30px; font-size:15px; padding:0% ">
                                                                <option value="" selected disabled>Select Once
                                                                </option>
                                                                <option value="1" selected>Working</option>
                                                                <option value="0">Not Working</option>
                                                                <option value="-1">Dead</option>
                                                            </select>
                                                        </div>  
                                                    </td>
                                                </tr>
                                            @endforeach --}}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
@endsection
@section('script')
  <script>
    $(document).ready(function() {
      $('#form').hide();
      $('#btn_show').on('click', function() {
        let cat_id = $('#cat_id').val();
        $('#form').show();

        $.ajax({
          url: "{{ route('product-status.show') }}",
          method: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            cat_id: cat_id
          },
          dataType: 'JSON',
          success: function(res) {
            // console.log(res);

            var tbody = '';
            res.forEach((element, index) => {
              tbody += '<tr>';
              tbody += '<input type="hidden" name="product_id[]" value="' + element.product_id + '">';
              tbody += '<input type="hidden" name="office_id[]" value="' + element.office_id + '">';
              tbody += '<td>' + (index + 1) + '</td>';
              tbody += '<td>' + element.name + '</td>';
              tbody += '<td>' +
                '<select name="status[]" class="form-control">' +
                '<option value="1" selected>Working</option>' +
                '<option value="0">Not Working</option>' +
                '<option value="2">Dead</option>' +
                '</select>' + '</td>';
              tbody += '</tr>';
            });
            $('#item-table').html(tbody);
          }
        });
      });
    });
  </script>
@endsection
