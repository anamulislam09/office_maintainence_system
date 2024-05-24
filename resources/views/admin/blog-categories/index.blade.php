@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            @include('layouts.admin.flash-message')
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Blog Category</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Blog Category</li>
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
                                    <a href="{{ route('blog-category.create') }}"class="btn btn-light shadow rounded m-0"><i
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
                                                    <th>SL</th>
                                                    <th>Category</th>
                                                    <th>URL</th>
                                                    <th>Status</th>
                                                    <th>Language</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($blogCategorys as $blogCategory)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $blogCategory->cat_name }}</td>
                                                        <td>{{ $blogCategory->cat_url }}</td>
                                                        <td>
                                                            @if ($blogCategory->cat_status == 1)
                                                                Active
                                                            @else
                                                                Inactive
                                                            @endif
                                                        </td><td>
                                                            @foreach (Config::get('languages') as $lang => $language)
                                                                    <a href="{{ url('admin/blog-category-localization/'. $blogCategory->id . '/'. $lang) }}">
                                                                        @if($blogCategory->translate($lang))
                                                                                <i class="fa-solid fa-check text-success"></i>
                                                                        @else
                                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                                        @endif
                                                                        {{ $lang }} &nbsp;
                                                                    </a>
                                                            @endforeach
                                                        </td>
                                                        <td class="d-flex justify-content-center">
                                                            <form action="{{ route('blog-category.destroy', $blogCategory->id) }}" method="POST">
                                                                <a class="btn btn-primary" href="{{ route('blog-category.edit', $blogCategory->id) }}">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Category</th>
                                                    <th>URL</th>
                                                    <th>Status</th>
                                                    <th>Language</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
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