@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Products</h1>
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
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a
                                        href="{{ route('product.index') }}"class="btn btn-light text-dark shadow rounded m-0">
                                        <span>Cancle Edit</span></a>
                                </h3>
                            </div>
                            <form action="{{ route('product.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                {{-- @method('PATCH') --}}
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                                            <label>Category</label>
                                            <select name="cat_id" id="" class="form-control">
                                                <option value="" selected disabled>Select Once</option>
                                                {{-- subcategoris --}}
                                                @foreach ($data as $main_cat)
                                                    <option value="{{ $main_cat->id }}"
                                                        @if ($product->cat_id == $main_cat->id) selected @endif>
                                                        {{ $main_cat->name }}</option>
                                                    @foreach ($main_cat->subcategoris as $subcat)
                                                        <option value="{{ $subcat->id }}"
                                                            @if ($product->sub_cat_id == $subcat->id) selected @endif>
                                                            &nbsp;&rightarrow;{{ $subcat->name }}</option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                                            <label>Brand</label>
                                            <select name="brand_id" id="" class="form-control">
                                                <option value="" selected disabled>Select Once</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        @if ($product->brand_id == $brand->id) selected @endif>
                                                        {{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                                            <label>Supplier</label>
                                            <select name="supplier_id" id="" class="form-control">
                                                <option value="" selected disabled>Select Once</option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->supplier_id }}"
                                                        @if ($supplier->supplier_id == $product->supplier_id) selected @endif">
                                                        {{ $supplier->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                                            <label>Product Name *</label>
                                            <input class="form-control" type="text" name="name" id="product_title"
                                                value="{{ $product->name }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                                            <label>Product Code *</label>
                                            <input class="form-control" type="text" name="product_code" id="product_code"
                                                value="{{ $product->product_code }}">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                                            <label>Purchase Date *</label>
                                            <input class="form-control" type="date" name="purchase_date"
                                                id="purchase_date" value="{{ $product->purchase_date }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                                            <label>Product Garranty <span class="text-warning"
                                                    style="font-size: 14px">(Months)</span></label>
                                            <input class="form-control" type="text" name="garranty" id="garranty"
                                                value="{{ $product->garranty ? $product->garranty : '' }}">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                                            <label>Purchase Price</label>
                                            <input class="form-control" type="text" name="purchase_price"
                                                id="purchase_price"
                                                value="{{ $product->purchase_price ? $product->purchase_price : 0 }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                                            <label>Description *</label>
                                            <textarea id="description" class="form-control" name="descriptions">{{ $product->descriptions ? $product->descriptions : '' }}</textarea>
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
{{-- @section('script')
    <script>
        function productImageBack(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#product_image_back_view').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).ready(function() {

            $('#sub_cat_id').change(function() {
                $.ajax({
                    url: "{{ url('admin/catalogue/load-sub-child') }}/" + $(this).val(),
                    method: "GET",
                    dataType: "json",
                    success: function(data) {
                        var output = '<option value="0">Select Sub-Child</option>';
                        $.each(data, function(key, value) {
                            output += '<option value="' + value.id + '">' + value
                                .title + '</option>';
                        });
                        $('#sub_child_id').html(output);
                    }
                });
            });

            $('#generate').click(function() {

                let appendedProduct = [];
                let old_color_id = [];
                let old_size_id = [];
                $('.color_id').each(function(index, item) {
                    old_color_id[index] = item.value
                });
                $('.size_id').each(function(index, item) {
                    old_size_id[index] = item.value
                });

                var duplicate = 0;
                $('#colors :selected').each(function() {
                    let coloID = $(this).val();
                    $('#sizes :selected').each(function() {
                        let sizeID = $(this).val();
                        for (let i = 0; i < old_color_id.length; i++) {
                            if (old_color_id[i] === coloID && old_size_id[i] === sizeID) {
                                duplicate += 1;
                            }
                        }

                    });
                });

                if (duplicate) return alert("Duplicate Combination Found!");


                let product_details = '';
                let id = 0;
                $('#colors :selected').each(function() {
                    let coloName = $(this).text();
                    let coloID = $(this).val();

                    $('#sizes :selected').each(function() {
                        let sizeName = $(this).text();
                        let sizeID = $(this).val();
                        product_details += '<tr>';
                        product_details +=
                            '<td align="center" valign="middle" class="serial"></td>';
                        product_details += '<td align="left" valign="middle">' + coloName +
                            '</td>';
                        product_details += '<td align="left" valign="middle">' + sizeName +
                            '</td>';
                        product_details +=
                            '<td><input type="number" name="stock[]" class="form-control form-control-sm" style="text-align:right" min="0" placeholder="0.00" required></td>';

                        product_details +=
                            '<td align="left" valign="middle"><label class="col-3">';
                        product_details += '<img id="image-' + id +
                            '" style="width:100px!imporatant; height:100px!imporatant;" class="img-thumbnail" src="{{ asset('public/uploads/admin/placeholder.png') }}">'
                        product_details += '<input hidden onchange="variantImage(' + id +
                            ');" class="form-control form-control-sm variantImage" type="file" name="image[]" required>';
                        product_details += '</label></td>';

                        product_details +=
                            '<input type="hidden" name="color_id[]" value="' + coloID +
                            '">';
                        product_details += '<input type="hidden" name="size_id[]" value="' +
                            sizeID + '">';
                        product_details += '<td align="center" valign="middle">';
                        product_details +=
                            '<button class="btn btn-danger btn-sm item-delete"><i class="fa fa-trash" style="cursor:pointer"></i></button></td>';
                        product_details += '</tr>';

                        id++;
                    });
                });


                $('.item-table').append(product_details);
                serialMaintain();
            });
            const serialMaintain = () => {
                var i = 1;
                $('.serial').each(function(key, element) {
                    $(element).html(i);
                    i++;
                });
            }

            serialMaintain();

            $('.item-table').on('click', '.item-delete', function() {
                $(this).parents('tr').remove();
                serialMaintain();
            });


            $('#description').summernote({
                placeholder: 'Product Description',
                tabsize: 2,
                height: 100
            });
            $('#meta_description').summernote({
                placeholder: 'Meta Description',
                tabsize: 2,
                height: 100
            });


        });

        function productImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#product_image_view').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function variantImage(id) {
            let input = document.getElementsByClassName("variantImage")[id];
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#image-' + id).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function oldVariantImage(id) {
            let input = document.getElementById('oldVariantImage-' + id);
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#oldImage-' + id).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection --}}
