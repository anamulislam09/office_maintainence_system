@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Supplier</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Supplier</li>
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
                                        href="{{ route('supplier.index') }}"class="btn btn-light text-dark shadow rounded m-0">
                                        <span>Cancle Edit</span></a>
                                </h3>
                            </div>
                            <form action="{{ route('supplier.update') }}" method="POST">
                                @csrf()
                                {{-- @method('patch') --}}
                                <input type="hidden" name="id" value="{{ $supplier->id }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Brand Name</label>
                                            <input value="{{ $supplier->name }}" type="text" class="form-control"
                                                name="name" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                                            <label>Phone</label>
                                            <input type="text" class="form-control" name="phone" value="{{ $supplier->phone }}">
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" value="{{ $supplier->email }}">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                                            <label>Address</label>
                                            <input type="text" class="form-control" name="address" value="{{ $supplier->address }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                        <label>Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" {{ $supplier->status == 1 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ $supplier->status == 0 ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                        </select>
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
