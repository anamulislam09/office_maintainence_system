@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Office</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Office</li>
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
                                    <a href="{{ route('office.index') }}"class="btn btn-light text-dark shadow rounded m-0">
                                        <span>Cancle Edit</span></a>
                                </h3>
                            </div>
                            <form action="{{ route('office.update') }}" method="POST">
                                @csrf()
                                {{-- @method('patch') --}}
                                <input type="hidden" name="id" value="{{ $office->id }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-10 col-lg-10">
                                            <label>Title</label>
                                            <input value="{{ $office->title }}" type="text" class="form-control"
                                                name="title" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-10 col-lg-10">
                                            <label>Address</label>
                                            <input value="{{ $office->location }}" type="text" class="form-control"
                                                name="location" required>
                                        </div>

                                        <div class="form-group col-sm-12 col-md-10 col-lg-10">
                                            <label>Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="1" {{ $office->status == 1 ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0" {{ $office->status == 0 ? 'selected' : '' }}>Inactive
                                                </option>
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
