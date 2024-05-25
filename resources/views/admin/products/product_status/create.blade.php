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
          <div class="card-header" sty>
            <div class="row mt-3">
              <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                <select name="cat_id" id="cat_id" class="form-control">
                  <option value="0" selected>All Category</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-sm-12 col-md-6 col-lg-6">
                <button class="btn btn-warning" type="button" id="btn_show">Show</button>
              </div>
            </div>
          </div>
          <form action="{{ route('product-status.store') }}" method="POST" id="form">
            @csrf()
            <div class=" card-body row py-5" style="padding-top: 0px !important">
              <div class="col-12 ">
                <div class="table-responsive">
                  <table id="dataTable" class="table table-bordered table-striped mt-3">
                    <thead>
                      <tr>
                        <th style="width: 10%">SL</th>
                        <th style="width: 30%">Product Name</th>
                        <th style="width: 30%">Working Status</th>
                      </tr>
                    </thead>
                    <tbody id="item-table">
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
                '<option value="-1">Dead</option>' +
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
