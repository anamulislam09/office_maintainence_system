@extends('layouts.admin.master')
@section('content')
  @php
    $basicInfo = App\Models\BasicInfo::first();
  @endphp
  <div class="content-wrapper">
    <div class="content-header">
      @include('layouts.admin.flash-message')
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">All Issue Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href=Transfer"{{ url('admin/dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Issue</li>
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
                  <a href="#"class="btn btn-light shadow rounded m-0">
                    <span>All Issue</span></i></a>
                </h3>
              </div>
              <div class="card-body">
                <div class="bootstrap-data-table-panel">
                  <div class="table-responsive">
                    <table id="example1" class="table table-striped table-bordered table-centre">
                      <thead>
                        <tr>
                          <th>SN</th>
                          <th>Request To</th>
                          <th>Request From</th>
                          <th>Product Name</th>
                          <th>Category Name</th>
                          <th>Created By</th>
                          <th>Request date</th>
                          <th>Note</th>
                          <th>Status</th>
                          {{-- @if (Auth::guard('admin')->user()->office_id !== '0' || Auth::guard('admin')->user()->office_id !== '1') --}}
                          <th>Action</th>
                          {{-- @endif --}}
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($transferRequests as $key => $request)
                          <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $request->to_office_name }}</td>
                            <td>{{ $request->from_office_name }}</td>
                            <td>{{ $request->name }}</td>
                            <td>{{ $request->cat_name }}</td>
                            <td>{{ $request->created_by }}</td>
                            <td>{{ $request->created_date }}</td>
                            <td>{{ $request->transfer_note }}</td>
                            <td>
                              @if ($request->transfer_status == 1)
                                <span class="badge badge-primary">Pending</span>
                              @elseif ($request->transfer_status == 2)
                                <span class="badge badge-info">Assigned</span>
                              @elseif ($request->transfer_status == 3)
                                <span class="badge badge-success">Accepted</span>
                              @else
                                <span class="badge badge-danger">Rejected</span>
                              @endif
                            </td>
                            </td>
                            {{-- @if (Auth::guard('admin')->user()->office_id !== '0' || Auth::guard('admin')->user()->office_id !== '1') --}}
                            <td>
                              <div class="d-flex justify-content-center">
                                <a href="{{ route('transfer-request.issue', $request->transfer_id) }}"
                                  class="btn btn-sm btn-info" style="margin-right: 2px">
                                  Issue
                                </a>
                                {{-- <a href="{{ route('transfer-request.cancel', $request->product_id) }}"
                                                                        class="btn btn-sm btn-danger"
                                                                        style="margin-right: 2px">
                                                                        Cancelled
                                                                    </a> --}}
                              </div>
                            </td>
                            {{-- @endif --}}
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