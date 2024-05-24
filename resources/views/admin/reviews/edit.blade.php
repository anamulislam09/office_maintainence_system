@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Reviews</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Reviews</li>
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
                                <h3 class="card-title">Edit Form</h3>
                            </div>
                            <form action="{{ route('reviews.update', $review->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @method('patch')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>Home Feature</label>
                                            <select name="home_feature" id="home_feature" class="form-control">
                                                <option value="1" {{ $review->home_feature == 1 ? 'selected':'' }}>Show</option>
                                                <option value="0" {{ $review->home_feature == 0 ? 'selected':'' }}>Hide</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-12">
                                            <label>Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="1" {{ $review->status==1? 'selected':'' }}>Active</option>
                                                <option value="0" {{ $review->status==0? 'selected':'' }}>Inactive</option>
                                            </select>
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