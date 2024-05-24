@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Product</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Product</li>
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
                                <h3 class="card-title">Localization Form</h3>
                            </div>
                            <form action="{{ url('admin/catalogue/product-localization/' . $id . '/' . $locale) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf()
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Product Title *</label>
                                                <input value="{{ isset($data) ? $data->product_title : null }}"
                                                    class="form-control" type="text" name="product_title"
                                                    id="product_title" placeholder="Product Title" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Short Description</label>
                                                <input value="{{ isset($data) ? $data->short_desc : null }}"
                                                    class="form-control" type="text" name="short_desc" id="short_desc"
                                                    placeholder="Short Description" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Description *</label>
                                                <textarea id="description" name="description" required>{{ isset($data) ? $data->description : null }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Meta Title</label>
                                                <input value="{{ isset($data) ? $data->meta_title : null }}"
                                                    class="form-control" type="text" name="meta_title" id="meta_title"
                                                    placeholder="Meta Title">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Meta Keywords</label>
                                                <input value="{{ isset($data) ? $data->meta_keywords : null }}"
                                                    class="form-control" type="text" name="meta_keywords"
                                                    id="meta_keywords" placeholder="Meta Keywords">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Meta Description</label>
                                                <textarea id="meta_description" name="meta_description">{{ isset($data) ? $data->meta_description : null }}</textarea>
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
    </script>
@endsection
