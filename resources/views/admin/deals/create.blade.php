@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Today's Deal</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Today's Deal</li>
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
                            <form action="{{ route('deals.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label>Product</label>
                                            <select class="form-control" name="product_id" required>
                                                <option value=''>Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">({{ $product->product_code }}){{ Str::substr($product->product_title, 0, 20) }}...</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Start at</label>
                                            <div class="input-group date" id="start_at" data-target-input="nearest">
                                                <input type="text" name="start_at" class="form-control datetimepicker-input" data-target="#start_at" required/>
                                                <div class="input-group-append" data-target="#start_at" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>End at</label>
                                            <div class="input-group date" id="end_at" data-target-input="nearest">
                                                <input type="text" name="end_at" class="form-control datetimepicker-input" data-target="#end_at" required/>
                                                <div class="input-group-append" data-target="#end_at" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label>Status</label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="1" selected>Active</option>
                                                <option value="0">Inactive</option>
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

@section('script')
<script>
$(document).ready(function(){
    $('#start_at').datetimepicker({ icons: { time: 'far fa-clock' } });
    $('#end_at').datetimepicker({ icons: { time: 'far fa-clock' } });
});
</script>
@endsection


