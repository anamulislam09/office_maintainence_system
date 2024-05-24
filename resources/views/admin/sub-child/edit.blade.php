@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Accessory</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Accessory</li>
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
                                {{-- <a href="{{route('accessories.index')}}" class="btn btn-outline btn-end">Cancel Edit</a> --}}
                            </div>
                            <form action="{{ route('accessories.update') }}" method="POST">
                                @csrf()
                                {{-- @method('patch') --}}
                                <input type="hidden" name="id" value="{{$accessory->id}}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-10 col-lg-10">
                                            <label>Accessory Name</label>
                                            <input value="{{ $accessory->name }}" type="text" class="form-control" name="name" required>
                                        </div>
                                        
                                        <div class="form-group col-sm-12 col-md-10 col-lg-10">
                                            <label>Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="1" {{ $accessory->status==1? 'selected':'' }}>Active</option>
                                                <option value="0" {{ $accessory->status==0? 'selected':'' }}>Inactive</option>
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