@php
    use Illuminate\Support\Facades\DB;
    $privileges = DB::table('privileges')
        ->join('menus', function ($join) {
            $join->on('privileges.menu_id', '=', 'menus.id');
        })
        ->where('privileges.role_id', Auth::guard('admin')->user()->type)
        ->select('menus.menu_name')
        ->get()
        ->toArray();
    $privileges = array_column($privileges, 'menu_name');

@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-0 bg-dark">
    <a href="{{ url('admin/profile/update-admin-details') }}" class="brand-link bg-success">
        {{-- <img src="{{ Auth::guard('admin')->user()->image? asset('public/uploads/admin/'. Auth::guard('admin')->user()->image): asset('public/frontend-assets/img/user.png') }}" alt="{{ $basicInfo->title }} Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8" height="30" width="30"> --}}
        <span class="brand-text font-weight text-light">{{ Str::ucfirst(Auth::guard('admin')->user()->name) }}</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if (Auth::guard('admin')->user()->type == 'superadmin' || in_array('Dashboard', $privileges))
                    <li class="nav-item {{ request()->is('admin/dashboard') ? 'menu-open' : '' }}">
                        <a href="{{ url('admin/dashboard') }}"
                            class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                        (Auth::guard('admin')->user()->office_id == '1' && in_array('Basic Info Manage', $privileges)))
                    <li class="nav-item {{ request()->is('admin/basic-infos*') ? 'menu-open' : '' }}">
                        <a href="{{ url('admin/basic-infos') }}"
                            class="nav-link {{ Request::routeIs('customers*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Basic Info Manage</p>
                        </a>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                        (Auth::guard('admin')->user()->office_id == '1' && in_array('Admin', $privileges)))
                    <li class="nav-item {{ request()->is('admin/admin*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin/admin*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Admin
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                                    (Auth::guard('admin')->user()->office_id == '1' && in_array('Role Manage', $privileges)))
                                <li class="nav-item">
                                    <a href="{{ url('admin/admin/roles') }}"
                                        class="nav-link {{ request()->is('admin/admin/roles*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Role Manage</p>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                                    (Auth::guard('admin')->user()->office_id == '1' && in_array('Admin Manage', $privileges)))
                                <li class="nav-item">
                                    <a href="{{ url('admin/admin/admins') }}"
                                        class="nav-link {{ request()->is('admin/admin/admins*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Admin Manage</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->type == 'superadmin' || in_array('Office', $privileges))
                    <li
                        class="nav-item {{ Request::routeIs('office.index') || Request::routeIs('office.create') || Request::routeIs('office.edit') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin/office/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Office Manage
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                                    (Auth::guard('admin')->user()->office_id == '1' && in_array('Office', $privileges)))
                                <li class="nav-item">
                                    <a href="{{ route('office.create') }}"
                                        class="nav-link {{ request()->is('admin/office/create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add New </p>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                                    (Auth::guard('admin')->user()->office_id == '1' || in_array('Office', $privileges)))
                                <li class="nav-item">
                                    <a href="{{ route('office.index') }}"
                                        class="nav-link {{ request()->is('admin/office/all') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Offices </p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- @if (Auth::guard('admin')->user()->type == 'superadmin' || in_array('Brand Manage', $privileges))
                    <li class="nav-item">
                        <a href="{{ route('brand.index') }}"
                            class="nav-link {{ request()->is('admin/brand*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Brand Manage</p>
                        </a>
                    </li>
                @endif --}}

                @if (Auth::guard('admin')->user()->type == 'superadmin' || in_array('Brand', $privileges))
                    <li
                        class="nav-item {{ Request::routeIs('brand.index') || Request::routeIs('brand.create') || Request::routeIs('brand.edit') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin/brand/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Brand Manage
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (Auth::guard('admin')->user()->type == 'superadmin' || in_array('Brand', $privileges))
                                <li class="nav-item">
                                    <a href="{{ route('brand.index') }}"
                                        class="nav-link {{ Request::routeIs('brand.index') || Request::routeIs('brand.edit') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Brand</p>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::guard('admin')->user()->type == 'superadmin' || in_array('Brand', $privileges))
                                <li class="nav-item">
                                    <a href="{{ route('brand.create') }}"
                                        class="nav-link {{ Request::routeIs('brand.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add New</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                @endif
                @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                        Auth::guard('admin')->user()->office_id == '1' ||
                        in_array('Categories ', $privileges))
                    <li
                        class="nav-item {{ Request::routeIs('category.index') || Request::routeIs('category.create') || Request::routeIs('category.edit') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin/category/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Categories Manage
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                                    Auth::guard('admin')->user()->office_id == '1' ||
                                    in_array('Category', $privileges))
                                <li class="nav-item">
                                    <a href="{{ route('category.index') }}"
                                        class="nav-link {{ Request::routeIs('category.index') || Request::routeIs('category.edit') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Category</p>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                                    Auth::guard('admin')->user()->office_id == '1' ||
                                    in_array('Category', $privileges))
                                <li class="nav-item">
                                    <a href="{{ route('category.create') }}"
                                        class="nav-link {{ Request::routeIs('category.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add New</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                        Auth::guard('admin')->user()->office_id == '1' ||
                        in_array('accessory', $privileges))
                    <li class="nav-item">
                        <a href="{{ route('accessories.index') }}"
                            class="nav-link {{ request()->is('admin/accessories*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Accessory Manage</p>
                        </a>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->type == 'superadmin' || in_array('Supplier', $privileges))
                    <li
                        class="nav-item {{ Request::routeIs('supplier.index') || Request::routeIs('supplier.create') || Request::routeIs('supplier.edit') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin/supplier/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Supplier Manage
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (Auth::guard('admin')->user()->type == 'superadmin' || in_array('Supplier', $privileges))
                                <li class="nav-item">
                                    <a href="{{ route('supplier.index') }}"
                                        class="nav-link {{ Request::routeIs('supplier.index') || Request::routeIs('supplier.edit') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Suppliers</p>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::guard('admin')->user()->type == 'superadmin' || in_array('Supplier', $privileges))
                                <li class="nav-item">
                                    <a href="{{ route('supplier.create') }}"
                                        class="nav-link {{ Request::routeIs('supplier.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add New</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->type == 'superadmin' || in_array('Product', $privileges))
                    <li
                        class="nav-item {{ Request::routeIs('product.index') || Request::routeIs('product.create') || Request::routeIs('product.edit') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin/product/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Products Manage
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (Auth::guard('admin')->user()->type == 'superadmin' || in_array('Product', $privileges))
                                <li class="nav-item">
                                    <a href="{{ route('product.index') }}"
                                        class="nav-link {{ Request::routeIs('product.index') || Request::routeIs('product.edit') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Product</p>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                                    (Auth::guard('admin')->user()->office_id == '1' && in_array('Product', $privileges)))
                                <li class="nav-item">
                                    <a href="{{ route('product.create') }}"
                                        class="nav-link {{ Request::routeIs('product.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add New</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->type == 'superadmin' || in_array('Product-allocate', $privileges))
                    <li
                        class="nav-item {{ Request::routeIs('product-allocate.index') || Request::routeIs('product-allocate.create') || Request::routeIs('product-allocate.edit') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->is('admin/product-allocate/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Products Assign
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (Auth::guard('admin')->user()->type == 'superadmin' || in_array('Product-allocate', $privileges))
                                <li class="nav-item">
                                    <a href="{{ route('product-allocate.index') }}"
                                        class="nav-link {{ Request::routeIs('product-allocate.index') || Request::routeIs('product-allocate.edit') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Assign Products</p>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::guard('admin')->user()->type == 'superadmin' || in_array('Product-allocate', $privileges))
                                <li class="nav-item">
                                    <a href="{{ route('product-allocate.create') }}"
                                        class="nav-link {{ Request::routeIs('product-allocate.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Assign</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                        Auth::guard('admin')->user()->office_id == '1' ||
                        in_array('Product-status', $privileges))
                    <li
                        class="nav-item {{ Request::routeIs('product-status.index') || Request::routeIs('product-status.create') || Request::routeIs('product-status.edit') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->is('admin/product-status/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Products Status
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                                    Auth::guard('admin')->user()->office_id == '1' ||
                                    in_array('Product', $privileges))
                                <li class="nav-item">
                                    <a href="{{ route('product-status.index') }}"
                                        class="nav-link {{ Request::routeIs('product-status.index') || Request::routeIs('product-status.edit') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>See All</p>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::guard('admin')->user()->office_id == '1' || in_array('Product', $privileges))
                                <li class="nav-item">
                                    <a href="{{ route('product-status.create') }}"
                                        class="nav-link {{ Request::routeIs('product-status.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Update Status</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                        (Auth::guard('admin')->user()->office_id == '1' || in_array('Transfer Request', $privileges)))
                    <li class="nav-item {{ request()->is('admin/transfer-request/*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->is('admin/transfer-request/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Transfer Request
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                                    (Auth::guard('admin')->user()->office_id == '1' || in_array('Transfer Request, Add', $privileges)))
                                <li class="nav-item">
                                    <a href="{{ url('admin/transfer-request/create') }}"
                                        class="nav-link {{ request()->is('admin/transfer-request/create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Request</p>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                                    (Auth::guard('admin')->user()->office_id == '1' || in_array('Update Details', $privileges)))
                                <li class="nav-item">
                                    <a href="{{ url('admin/transfer-request/all') }}"
                                        class="nav-link {{ request()->is('admin/transfer-request/all') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Request</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                        (Auth::guard('admin')->user()->office_id == '1' || in_array('Receive', $privileges)))
                    <li class="nav-item {{ request()->is('admin/receive-request/*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->is('admin/receive-request/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Receive
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {{-- @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                                    (Auth::guard('admin')->user()->office_id == '1' || in_array('Add', $privileges)))
                                <li class="nav-item">
                                    <a href="{{ url('admin/transfer-request/create') }}"
                                        class="nav-link {{ request()->is('admin/transfer-request/create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Request</p>
                                    </a>
                                </li>
                            @endif --}}
                            @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                                    (Auth::guard('admin')->user()->office_id == '1' || in_array('Receive', $privileges)))
                                <li class="nav-item">
                                    <a href="{{ url('admin/receive-request/all') }}"
                                        class="nav-link {{ request()->is('admin/receive-request/all') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Receive</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                        (Auth::guard('admin')->user()->office_id == '1' || in_array('Settings', $privileges)))
                    <li class="nav-item {{ request()->is('admin/profile/*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin/profile/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Settings
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                                    (Auth::guard('admin')->user()->office_id == '1' || in_array('Update Password', $privileges)))
                                <li class="nav-item">
                                    <a href="{{ url('admin/profile/update-admin-password') }}"
                                        class="nav-link {{ request()->is('admin/profile/update-admin-password*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Update Password</p>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::guard('admin')->user()->type == 'superadmin' ||
                                    (Auth::guard('admin')->user()->office_id == '1' || in_array('Update Details', $privileges)))
                                <li class="nav-item">
                                    <a href="{{ url('admin/profile/update-admin-details') }}"
                                        class="nav-link {{ request()->is('admin/profile/update-admin-details*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Update Details</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
<aside class="control-sidebar control-sidebar-dark"></aside>
