@extends('layouts.admin.master')
@section('content')
<style>
    table, tbody, tr,td{
        font-size: 14px;
    }
</style>
    @php
        $basicInfo = App\Models\BasicInfo::first();
    @endphp
    <div class="content-wrapper">
        <div class="content-header">
            @include('layouts.admin.flash-message')
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Products Assign</h1>
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
                    <section class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-primary p-1">
                                <h3 class="card-title">
                                    <a
                                        href="{{ route('product-allocate.create') }}"class="btn btn-light shadow rounded m-0"><i
                                            class="fas fa-plus"></i>
                                        <span>Add New</span></i></a>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="bootstrap-data-table-panel">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-striped table-bordered table-centre">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Product Name</th>
                                                    <th>Product Code</th>
                                                    <th>Office Name</th>
                                                    <th>Assign Date</th>
                                                    {{-- <th>Status</th> --}}
                                                    <th>Location</th>
                                                    {{-- <th>Action</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($assignments as $key => $assignment)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $assignment->product_name }}</td>
                                                        <td>{{ $assignment->product_code }}</td>
                                                        <td>{{ $assignment->office_name }}</td>
                                                        <td>{{ $assignment->assign_date }}</td>
                                                        {{-- <td>
                                                            @if ($assignment->status == 1)
                                                                <span class="badge badge-primary">Live</span>
                                                            @elseif ($assignment->status == 0)
                                                                <span class="badge badge-warning">Not Working</span>
                                                            @else
                                                                <span class="badge badge-danger">Dead</span>
                                                            @endif
                                                        </td> --}}
                                                        <td>
                                                            @if ($assignment->location == 1)
                                                                <span class="badge badge-primary">Local</span>
                                                            @elseif ($assignment->location == 2)
                                                                <span class="badge badge-info">Transit</span>
                                                            @elseif ($assignment->location == 3)
                                                                <span class="badge badge-success">Transfered</span>
                                                            @elseif ($assignment->location == 4)
                                                                <span class="badge badge-danger">Rejected</span>
                                                            @else
                                                                <span class="badge badge-warning">monitor</span>
                                                            @endif
                                                        </td>
                                                        {{-- <td>
                                                            <div class="d-flex justify-content-center">
                                                                <a href="{{ route('product-allocate.edit', $assignment->id) }}"
                                                                    class="btn btn-sm btn-info" style="margin-right: 2px">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>

                                                                <form
                                                                    action="{{ route('product-allocate.destroy', $assignment->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td> --}}
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
@endsection
