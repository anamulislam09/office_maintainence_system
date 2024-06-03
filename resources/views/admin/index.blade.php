@php
    use Illuminate\Support\Facades\DB;
    use App\Models\ProductStatus;
    $privileges = DB::table('privileges')
        ->join('menus', function ($join) {
            $join->on('privileges.menu_id', '=', 'menus.id');
        })
        ->where('privileges.role_id', Auth::guard('admin')->user()->type)
        ->select('menus.menu_name')
        ->get()
        ->toArray();
    $privileges = array_column($privileges, 'menu_name');
    // dd(Auth::guard('admin')->user()->type);
    // dd($privileges);
    $basicInfo = App\Models\BasicInfo::first();
    // dd(in_array('Total Users',$privileges));
@endphp
@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            @include('layouts.admin.flash-message')
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @if (Auth::guard('admin')->user()->type == 'superadmin' || Auth::guard('admin')->user()->type == '2')
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    @php
                                        $office = App\Models\Office::count();
                                    @endphp
                                    <p>Total Office</p>
                                    <h3 class="text-center">{{ $office }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('office.index') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    @if (Auth::guard('admin')->user()->type == 'superadmin' || Auth::guard('admin')->user()->type == '2')
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    @php
                                        $zonal_office = App\Models\Office::where('zonal_office_id', '')->count();
                                    @endphp
                                    <p>Total Zone Office</p>
                                    <h3 class="text-center">{{ $zonal_office }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    @if (Auth::guard('admin')->user()->type == 'superadmin' || Auth::guard('admin')->user()->type == '2')
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    @php
                                        $branch_office = App\Models\Office::where('head_office_id', '!=', '')
                                            ->where('zonal_office_id', '!=', '')
                                            ->count();
                                    @endphp
                                    <p>Total Branch Office</p>
                                    <h3 class="text-center">{{ $branch_office }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    @php
                        $branch_office_exists = App\Models\Office::where('id', Auth::guard('admin')->user()->office_id)
                            ->where('head_office_id', '!=', '')
                            ->where('zonal_office_id', '!=', '')
                            ->exists();
                    @endphp
                    @if (Auth::guard('admin')->user()->type != 'superadmin' && Auth::guard('admin')->user()->type != '2')
                        <div class="col-lg-3 col-6" @if ($branch_office_exists) hidden @endif>
                            <div class="small-box bg-success">
                                <div class="inner">
                                    @php
                                        $branch_office = App\Models\Office::whereNotNull('head_office_id')
                                            ->where('zonal_office_id', Auth::guard('admin')->user()->office_id)
                                            ->count();
                                    @endphp
                                    <p>Total Branch Office</p>
                                    <h3 class="text-center">{{ $branch_office }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @else
                    @endif
                    @if (Auth::guard('admin')->user()->type == 'superadmin' || Auth::guard('admin')->user()->type == '2')
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    @php
                                        $brand = App\Models\Brand::count();
                                    @endphp
                                    <p>Total Brand</p>
                                    <h3>{{ $brand }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('brand.index') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    @if (Auth::guard('admin')->user()->type == 'superadmin' || Auth::guard('admin')->user()->type == '2')
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-white" style="background-color:blueviolet">
                                <div class="inner">
                                    @php
                                        $supplier = App\Models\Supplier::count();
                                    @endphp
                                    <p>Total Supplier</p>
                                    <h3>{{ $supplier }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('supplier.index') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    @if (Auth::guard('admin')->user()->type == 'superadmin' || Auth::guard('admin')->user()->type == '2')
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-white" style="background-color:rgb(59, 109, 9)">
                                <div class="inner">
                                    @php
                                        $category = App\Models\Category::count();
                                    @endphp
                                    <p>Total Category</p>
                                    <h3>{{ $category }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('category.index') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                            Auth::guard('admin')->user()->type == '2' ||
                            in_array('Product Live', $privileges))
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-white" style="background-color:darkslategrey">
                                <div class="inner">
                                    @php
                                        if (
                                            Auth::guard('admin')->user()->type != 'superadmin' &&
                                            Auth::guard('admin')->user()->type != '2'
                                        ) {
                                        $products = App\Models\ProductAllocate::where(
                                                'office_id',
                                                Auth::guard('admin')->user()->office_id,
                                            )
                                                ->whereIn('location', [1, 3])
                                                ->count();
                                        } else {
                                           $products = App\Models\Product::count();
                                            
                                        }
                                    @endphp
                                    <p>Total Product</p>
                                    <h3>{{ $products }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('product.index') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                                {{-- @endif --}}

                            </div>
                        </div>
                    @endif
                    @if (Auth::guard('admin')->user()->type == 'superadmin' || Auth::guard('admin')->user()->type == '2')
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-white" style="background-color:rgb(2, 53, 53)">
                                <div class="inner">
                                    @php

                                        $assign_products = App\Models\Product::where('isassign', 1)->count();
                                    @endphp
                                    <p>Total Assign Product</p>
                                    <h3>{{ $assign_products }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('product.index') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    @if (Auth::guard('admin')->user()->type == 'superadmin' || Auth::guard('admin')->user()->type == '2')
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-white" style="background-color:rgb(2, 29, 29)">
                                <div class="inner">
                                    @php
                                        $assign_not_products = App\Models\Product::where('isassign', 0)->count();
                                    @endphp
                                    <p>Total Not Assign Product</p>
                                    <h3>{{ $assign_not_products }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('product.index') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    @if (Auth::guard('admin')->user()->type == 'superadmin' || in_array('Total Products', $privileges))
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-white" style="background-color:darkseagreen">
                                <div class="inner">
                                    @php
                                        if (
                                            Auth::guard('admin')->user()->type != 'superadmin' &&
                                            Auth::guard('admin')->user()->type != '2'
                                        ) {
                                            $subquery = ProductStatus::selectRaw(
                                                'MAX(id) as id, product_id, MAX(created_date) as last_created',
                                            )->groupBy('product_id');
                                            $WorkingStatuses = ProductStatus::joinSub(
                                                $subquery,
                                                'product_latest',
                                                function ($join) {
                                                    $join->on('product_statuses.id', '=', 'product_latest.id');
                                                },
                                            )
                                                ->where('status', '=', '1')
                                                ->where('office_id', Auth::guard('admin')->user()->office_id)
                                                ->get();
                                            $product_ids = $WorkingStatuses->pluck('product_id')->toArray();
                                            $productWorkingStatuses = App\Models\ProductAllocate::where(
                                                'office_id',
                                                Auth::guard('admin')->user()->office_id,
                                            )
                                                ->whereIn('product_id', $product_ids)
                                                ->where('location', '=', '1')
                                                ->count();
                                        } else {
                                            $subquery = ProductStatus::selectRaw(
                                                'MAX(id) as id, MAX(created_date) as last_created',
                                            )->groupBy('product_id');
                                            $productWorkingStatuses = ProductStatus::joinSub(
                                                $subquery,
                                                'product_latest',
                                                function ($join) {
                                                    $join->on('product_statuses.id', '=', 'product_latest.id');
                                                },
                                            )
                                                ->where('status', '=', '1')
                                                ->count();
                                        }
                                    @endphp
                                    <p>Total Working Products</p>
                                    <h3>{{ $productWorkingStatuses }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    @if (Auth::guard('admin')->user()->type == 'superadmin' || in_array('Product Not Working', $privileges))
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-white" style="background-color:lightskyblue">
                                <div class="inner">
                                    @php
                                        if (
                                            Auth::guard('admin')->user()->type != 'superadmin' &&
                                            Auth::guard('admin')->user()->type != '2'
                                        ) {
                                            $subquery = ProductStatus::selectRaw(
                                                'MAX(id) as id, product_id, MAX(created_date) as last_created',
                                            )->groupBy('product_id');
                                            $NotWorking = ProductStatus::joinSub($subquery, 'product_latest', function (
                                                $join,
                                            ) {
                                                $join->on('product_statuses.id', '=', 'product_latest.id');
                                            })
                                                ->where('status', '=', '0')
                                                ->where('office_id', Auth::guard('admin')->user()->office_id)
                                                ->get();
                                            $product_ids = $NotWorking->pluck('product_id')->toArray();
                                            $productNotWorking = App\Models\ProductAllocate::where(
                                                'office_id',
                                                Auth::guard('admin')->user()->office_id,
                                            )
                                                ->whereIn('product_id', $product_ids)
                                                ->where('location', '=', '1')
                                                ->count();
                                            // dd($productNotWorking);
                                        } else {
                                            $subquery = ProductStatus::selectRaw(
                                                'MAX(id) as id, MAX(created_date) as last_created',
                                            )->groupBy('product_id');
                                            $productNotWorking = ProductStatus::joinSub(
                                                $subquery,
                                                'product_latest',
                                                function ($join) {
                                                    $join->on('product_statuses.id', '=', 'product_latest.id');
                                                },
                                            )
                                                ->where('status', '=', '0')
                                                ->count();
                                        }
                                    @endphp
                                    <p>Not Working Products</p>
                                    <h3>{{ $productNotWorking }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    @if (Auth::guard('admin')->user()->type == 'superadmin' || in_array('Product Dead', $privileges))
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-white" style="background-color:rgb(255, 153, 0)">
                                <div class="inner">
                                    @php
                                        if (
                                            Auth::guard('admin')->user()->type != 'superadmin' &&
                                            Auth::guard('admin')->user()->type != '2'
                                        ) {
                                            $subquery = ProductStatus::selectRaw(
                                                'MAX(id) as id, product_id, MAX(created_date) as last_created',
                                            )->groupBy('product_id');

                                            $dead = ProductStatus::joinSub($subquery, 'product_latest', function (
                                                $join,
                                            ) {
                                                $join->on('product_statuses.id', '=', 'product_latest.id');
                                            })
                                                ->where('product_statuses.status', '=', '-1')
                                                ->where(
                                                    'product_statuses.office_id',
                                                    Auth::guard('admin')->user()->office_id,
                                                )
                                                ->get();

                                            $product_ids = $dead->pluck('product_id')->toArray();

                                            $totalDeadProduct = App\Models\ProductAllocate::where(
                                                'office_id',
                                                Auth::guard('admin')->user()->office_id,
                                            )
                                                ->whereIn('product_id', $product_ids)
                                                ->where('location', '=', '1')
                                                ->count();
                                        } else {
                                            $subquery = ProductStatus::selectRaw(
                                                'MAX(id) as id, MAX(created_date) as last_created',
                                            )->groupBy('product_id');
                                            $totalDeadProduct = ProductStatus::joinSub(
                                                $subquery,
                                                'product_latest',
                                                function ($join) {
                                                    $join->on('product_statuses.id', '=', 'product_latest.id');
                                                },
                                            )
                                                ->where('status', '=', '-1')
                                                ->count();
                                        }
                                    @endphp
                                    <p>Total Dead Product</p>
                                    <h3>{{ $totalDeadProduct }}</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    @if (Auth::guard('admin')->user()->type == 'superadmin' || in_array('New Customers', $privileges))
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <p>New Customers</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    @if (Auth::guard('admin')->user()->type == 'superadmin' || in_array('Latest Orders', $privileges))
                        <section class="col-lg-7 connectedSortable">
                            <div class="card">
                                <div class="card-header border-transparent">
                                    <h3 class="card-title">Latest Orders</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table m-0">
                                            <thead>
                                                <tr>
                                                    <th>Order No</th>
                                                    <th>Customer Name</th>
                                                    <th>Mobile</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- @foreach ($data['latestOrders'] as $key => $latestOrder)
                                                    <tr>
                                                        <td><a target="_blank"
                                                                href="{{ url('admin/orders/invoice/' . $latestOrder->id) }}">{{ $latestOrder->order_no }}</a>
                                                        </td>
                                                        <td>{{ $latestOrder->user->name }}</td>
                                                        <td>{{ $latestOrder->user->phone }}</td>
                                                        @php
                                                            switch ($latestOrder->order_status) {
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
                                                        <td><span
                                                                class="badge badge-{{ $badge }}">{{ $latestOrder->order_status }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer clearfix">
                                    <a href="{{ url('admin/orders') }}" class="btn btn-sm btn-info float-left">View All
                                        Orders</a>
                                </div>
                            </div>
                        </section>
                    @endif
                    <!-- /.Left col -->
                    <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    <section class="col-lg-5 connectedSortable">

                        <!-- Map card -->
                        <div class="card bg-gradient-primary">
                            <div class="card-header border-0">
                                <h3 class="card-title">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    Visitors
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                                        <i class="far fa-calendar-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="world-map" style="height: 250px; width: 100%;"></div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <div id="sparkline-1"></div>
                                        <div class="text-white">Visitors</div>
                                    </div>
                                    <div class="col-4 text-center">
                                        <div id="sparkline-2"></div>
                                        <div class="text-white">Online</div>
                                    </div>
                                    <div class="col-4 text-center">
                                        <div id="sparkline-3"></div>
                                        <div class="text-white">Sales</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                        <!-- Calendar -->
                        <div class="card bg-gradient-success">
                            <div class="card-header border-0">

                                <h3 class="card-title">
                                    <i class="far fa-calendar-alt"></i>
                                    Calendar
                                </h3>
                                <div class="card-tools">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success btn-sm dropdown-toggle"
                                            data-toggle="dropdown" data-offset="-52">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a href="#" class="dropdown-item">Add new event</a>
                                            <a href="#" class="dropdown-item">Clear events</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">View calendar</a>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div id="calendar" style="width: 100%"></div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
@endsection
