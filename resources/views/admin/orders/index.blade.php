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
                        <h1 class="m-0">Orders</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Orders</li>
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
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="bootstrap-data-table-panel">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-striped table-bordered table-centre">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Order No</th>
                                                    <th>Order Date</th>
                                                    <th>Customer Name</th>
                                                    <th>Phone</th>
                                                    <th>Total</th>
                                                    <th>Order Status</th>
                                                    <th>Payment Status</th>
                                                    <th>Payment Method</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $order)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><a target="_blank" href="{{ url('admin/orders/invoice/'.$order->id) }}"><b>{{ $order->order_no }}</b></a></td>
                                                        <td>
                                                            @php
                                                                $date = date_create($order->created_at);
                                                                echo date_format($date,"d M Y");
                                                            @endphp
                                                        </td>
                                                        <td>{{ $order->user->name }}</td>
                                                        <td>{{ $order->shipping_phone }}</td>
                                                        <td>{{ $basicInfo->currency_symbol }} {{ $order->total_price }}</td>
                                                        @php
                                                            switch ($order->order_status) {
                                                                case 'Pending':
                                                                    $badge = 'warning';
                                                                    break;
                                                                case 'Processing':
                                                                    $badge = 'info';
                                                                    break;
                                                                case 'Shipped':
                                                                    $badge = 'primary';
                                                                    break;
                                                                case 'Delivered':
                                                                    $badge = 'danger';
                                                                    break;
                                                                case 'Cancelled':
                                                                    $badge = 'dark';
                                                                    break;
                                                                default:
                                                                    $badge = 'dark';
                                                                }
                                                        @endphp
                                                        <td><span class="badge badge-{{ $badge }}">{{ $order->order_status }}</span></td>
                                                        <td><span class="badge badge-{{ $order->payment_status=='Paid'? 'success' : 'danger' }}">{{ $order->payment_status }}</span></td>
                                                        <td>{{ $order->payment_method }}</td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-info">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                                <a target="_blank" href="{{ url('admin/orders/invoice/'.$order->id.'/print') }}" class="btn btn-warning ml-1">
                                                                    <i class="fa fa-print"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Order No</th>
                                                    <th>Order Date</th>
                                                    <th>Customer Name</th>
                                                    <th>Phone</th>
                                                    <th>Total</th>
                                                    <th>Order Status</th>
                                                    <th>Payment Status</th>
                                                    <th>Payment Method</th>
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
