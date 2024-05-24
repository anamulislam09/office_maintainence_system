@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Coupon</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Coupon</li>
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
                                <h3 class="card-title">Edit Form</h3>
                            </div>
                            <form action="{{ route('coupons_manage.update', $coupon->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @method('put')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Coupon Type</label>
                                                <input value="{{ $coupon->coupon_type }}" placeholder="Coupon Type"
                                                    class="form-control" type="text" name="coupon_type" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Coupon Code</label>
                                                <input value="{{ $coupon->coupon_code }}" placeholder="Coupon Code"
                                                    class="form-control" type="text" name="coupon_code" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Discount (%)</label>
                                                <input value="{{ $coupon->discount_perc }}" placeholder="0.00"
                                                    class="form-control" type="number" name="discount_perc" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input value="{{ $coupon->start_date }}" placeholder="Start Date"
                                                    class="form-control" type="date" name="start_date" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input value="{{ $coupon->end_date }}" placeholder="End Date"
                                                    class="form-control" type="date" name="end_date" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group" style="margin-bottom: 0px;">
                                                <label>Coupon Image</label>
                                            </div>
                                            <label style="cursor:pointer">
                                                <input class="form-control" name="coupon_img" type="file">
                                            </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Home View</label>
                                                <select class="form-control" name="home_view" required>
                                                    <option value="1">Show</option>
                                                    <option value="0">Hide</option>
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
