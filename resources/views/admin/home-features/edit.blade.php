@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Home Feature</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Home Feature</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Create Form</h3>
                            </div>
                            <form action="{{ route('home-features.update', $homeFeature->id ) }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @method('PATCH')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Feature Title</label>
                                                <input value="{{ $homeFeature->feature_title }}" class="form-control" type="text" name="feature_title" placeholder="Feature Title">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group" style="margin-bottom: 0px;">
                                                <label>Image</label>
                                            </div>
                                            <label class="col-4">
                                                <img id="feature_image_view" style="width:100px!imporatant; height:100px!imporatant;" class="img-thumbnail" src="{{ asset($homeFeature->feature_image ? 'public/uploads/home-feature/' . $homeFeature->feature_image : 'public/admin-assets/dist/img/placeholder.png') }}">
                                                <input style="display:none" onchange="featureImage(this);" type="file" name="feature_image" id="feature_image" accept="image/*">
                                            </label>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Feature Size</label>
                                                <select disabled required class="form-control" name="feature_size">
                                                    <option value="1" {{ $homeFeature->feature_size==1? 'selected' : null }}>1st Image (479 X 593 Pixels)</option>
                                                    <option value="2" {{ $homeFeature->feature_size==2? 'selected' : null }}>2nd Image (807 X 545 Pixels)</option>
                                                    <option value="3" {{ $homeFeature->feature_size==3? 'selected' : null }}>3th Image (575 X 262 Pixels)</option>
                                                    <option value="4" {{ $homeFeature->feature_size==4? 'selected' : null }}>4th Image (575 X 262 Pixels)</option>
                                                    <option value="5" {{ $homeFeature->feature_size==5? 'selected' : null }}>5th Image (420 X 456 Pixels)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Feature URL</label>
                                                <input value="{{ $homeFeature->feature_url }}" class="form-control" type="text" name="feature_url" placeholder="Feature URL" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Feature Serial</label>
                                                <select required disabled class="form-control" name="feature_serial">
                                                    <option value="1" {{ $homeFeature->feature_serial==1?'selected':null }}>1</option>
                                                    <option value="2" {{ $homeFeature->feature_serial==2?'selected':null }}>2</option>
                                                    <option value="3" {{ $homeFeature->feature_serial==3?'selected':null }}>3</option>
                                                    <option value="4" {{ $homeFeature->feature_serial==4?'selected':null }}>4</option>
                                                    <option value="5" {{ $homeFeature->feature_serial==5?'selected':null }}>5</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select required disabled class="form-control" name="feature_status">
                                                    <option value="1" selected>Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
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
function featureImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#feature_image_view').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
