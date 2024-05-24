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
                                <h3 class="card-title">Create Form</h3>
                            </div>
                            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Product Title *</label>
                                                <input class="form-control" type="text" name="product_title"
                                                    id="product_title" placeholder="Product Title" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Short Description</label>
                                                <input class="form-control" type="text" name="short_desc" id="short_desc"
                                                    placeholder="Short Description" required>
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="form-group">
                                                <label>Description *</label>
                                                <textarea id="description" name="description" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <label style="margin-left: 10px;">Product Image (327 X 358)</label>
                                            <div class="form-group">
                                                <label class="col-7">
                                                    <img id="product_image_view" style="width:100px!imporatant; height:100px!imporatant;" class="img-thumbnail" src="{{ asset('public/uploads/admin/placeholder.png') }}">
                                                    <input class="variant-image" style="display:none" onchange="productImage(this);" type="file" name="product_image" id="product_image" accept="image/*">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Product Code *</label>
                                                <input class="form-control" type="text" name="product_code"
                                                    id="product_code" value="" placeholder="Product Code" required>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Old Price</label>
                                                <input type="number" id="old_price" name="old_price" class="form-control" style="text-align:right" min='0' placeholder="0.00">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>New Price*</label>
                                                <input required type="number" id="new_price" name="new_price"
                                                    class="form-control" style="text-align:right" min='0' placeholder="0.00" required>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Weight(gm)*</label>
                                                <input required type="number" id="product_weight" name="product_weight"
                                                    class="form-control" style="text-align:right" min='0' placeholder="0.00" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Sub Category *</label>
                                                <select name="sub_cat_id" id="sub_cat_id" class="form-control" required>
                                                    <option value="" selected>Select</option>
                                                    @foreach ($subCategories as $subCat)
                                                        <option value="{{ $subCat->id }}">{{ $subCat->title }}</option>
                                                    @endforeach
                                                </select>       
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Sub Child</label>
                                                <select class="form-control" name="sub_child_id" id="sub_child_id">
                                                    <option value="0">Select Sub-Child</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label>Color*</label>
                                                <select class="select2" name="colors" id="colors" multiple="multiple" data-placeholder="Select Colors" style="width: 100%;" required>
                                                    @foreach ($colors as $color)
                                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label>Sizes*</label>
                                                <div class="select2-purple">
                                                    <select class="select2" name="sizes" id="sizes" multiple="multiple" data-placeholder="Select Sizes" data-dropdown-css-class="select2-purple" style="width: 100%;" required>
                                                        @foreach ($sizes as $size)
                                                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-primary" style="margin-top: 32px" id="generate">Generate</button>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th width="10%">S/N</th>
                                                            <th width="15%">Color</th>
                                                            <th width="15%">Size</th>
                                                            <th width="15%">Stock</th>
                                                            <th width="35%">Image (499 X 597)</th>
                                                            <th width="10%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="item-table">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Trending Type</label>
                                                <select class="form-control" name="trending_type" id="trending_type">
                                                    <option value="0" selected>No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Best Seller</label>
                                                <select class="form-control" name="best_seller" id="best_seller">
                                                    <option value="0" selected>No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>New Arrivals</label>
                                                <select class="form-control" name="new_arrival" id="new_arrival">
                                                    <option value="0" selected>No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control" name="status" id="status">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Meta Title</label>
                                                <input class="form-control" type="text" name="meta_title" id="meta_title" placeholder="Meta Title">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Meta Keywords</label>
                                                <input class="form-control" type="text" name="meta_keywords" id="meta_keywords" placeholder="Meta Keywords">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Meta Description</label>
                                                <textarea id="meta_description" name="meta_description"></textarea>
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
        $(document).ready(function(){
            
            $('#sub_cat_id').change(function() {
                   $.ajax({
                        url: "{{ url('admin/catalogue/load-sub-child') }}/"+$(this).val(),
                        method: "GET",
                        dataType: "json",
                        success: function(data){
                            var output = '<option value="0">Select Sub-Child</option>';
                            $.each(data,function(key,value)
                            {
                                output += '<option value="'+value.id+'">'+value.title+'</option>';
                            });
                            $('#sub_child_id').html(output);
                        }
                    });
            });

            $('#generate').click(function(){
                let product_details = '';
                let id = 0;
                $('#colors :selected').each(function(){
                    let coloName = $(this).text();
                    let coloID = $(this).val();
            
                    $('#sizes :selected').each(function(){
                        let sizeName = $(this).text();
                        let sizeID = $(this).val();
                        product_details += '<tr>';
                        product_details += '<td align="center" valign="middle" class="serial"></td>';
                        product_details += '<td align="left" valign="middle">' + coloName + '</td>';
                        product_details += '<td align="left" valign="middle">' + sizeName + '</td>';
                        product_details += '<td><input type="number" name="stock[]" class="form-control form-control-sm" style="text-align:right" min="0" placeholder="0.00" required></td>';

                        product_details += '<td align="left" valign="middle"><label class="col-3">';
                        product_details +=     '<img id="image-'+id+'" style="width:100px!imporatant; height:100px!imporatant;" class="img-thumbnail" src="{{ asset("public/uploads/admin/placeholder.png") }}">'
                        product_details +=      '<input hidden onchange="variantImage('+id+');" class="form-control form-control-sm variantImage" type="file" name="image[]" required>';
                        product_details += '</label></td>';
                        
                        product_details += '<input type="hidden" name="color_id[]" value="' + coloID + '">';
                        product_details += '<input type="hidden" name="size_id[]" value="' + sizeID + '">';
                        product_details += '<td align="center" valign="middle">';
                        product_details += '<button class="btn btn-danger btn-sm item-delete"><i class="fa fa-trash" style="cursor:pointer"></i></button></td>';
                        product_details += '</tr>';

                        id++;
                    });
                });
                $('.item-table').html(product_details);
                serialMaintain();
            });

            const serialMaintain = () =>{
                var i = 1;
                $('.serial').each(function(key, element){
                    $(element).html(i);
                    i++;
                });
            }
            $('.item-table').on('click','.item-delete',function(){ 
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

    function variantImage(id){
        let input = document.getElementsByClassName("variantImage")[id];
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#image-'+id).attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    
</script>
@endsection
