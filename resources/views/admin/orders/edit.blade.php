@extends('layouts.admin.master')
@section('content')
    @php
        $basicInfo = App\Models\BasicInfo::first();
    @endphp
    <div class="content-wrapper">
        <div class="content-header">
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
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Form</h3>
                            </div>
                            <form action="{{ route('orders.update', $order->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @method('PATCH')
                                <div class="card-body p-1 m-1">
                                    <div class="row p-0 m-0">
                                        <div class="col-sm-12  pt-0 mt-0" style="padding:2px;">
                                            <div class="row p-0 m-0" style="border:1px #16ab53 solid; background:#D3D3D3;">
                                                <input hidden name="order_id" id="order_id" value="{{ $order->id }}">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Order #</label>
                                                        <input readonly placeholder="Order No."
                                                            class="form-control pop_input" type="text" name="order_no"
                                                            id="order_no" value="{{ $order->order_no }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Customer ID</label>
                                                        <input readonly class="form-control pop_input" type="number"
                                                            value="{{ $order->user->id }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Customer Email</label><i aria-hidden="true"></i>
                                                        <input readonly class="form-control pop_input" type="text"
                                                            value="{{ $order->user->email }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12" style="padding:2px;">
                                            <div class="row p-0 m-0" style="border:1px #16ab53 solid; background:#D3D3D3;">
                                                <div class="col-md-12 text-center" style="padding-top:2px;">
                                                    <h4
                                                        style="color: #00A343; text-transform: uppercase; letter-spacing: 1px;">
                                                        Shipping Address
                                                    </h4>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Full Name</label>
                                                        <input readonly
                                                            value="{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}"
                                                            class="form-control pop_input" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Company Name</label>
                                                        <input readonly value="{{ $order->shipping_company_name }}"
                                                            class="form-control pop_input" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label>Country Name</label>
                                                        <input readonly value="{{ $order->shipping_country->country_name }}"
                                                            class="form-control pop_input" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label>Phone</label>
                                                        <input readonly value="{{ $order->shipping_phone }}"
                                                            class="form-control pop_input" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input readonly value="{{ $order->shipping_email }}"
                                                            class="form-control pop_input" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Street Address</label>
                                                        <input readonly value="{{ $order->shipping_street_address }}"
                                                            class="form-control pop_input" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>City</label>
                                                        <input readonly value="{{ $order->shipping_city }}"
                                                            class="form-control pop_input" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>State</label>
                                                        <input readonly value="{{ $order->shipping_state }}"
                                                            class="form-control pop_input" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>ZIP</label>
                                                        <input readonly value="{{ $order->shipping_zip_code }}"
                                                            class="form-control pop_input" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12" style="padding:2px;">
                                            <div class="row p-0 m-0"
                                                style="border:1px #16ab53 solid; background:#D3D3D3;">
                                                <div class="col-md-12 text-center" style="padding-top:2px;">
                                                    <h4
                                                        style="color: #EC570E; text-transform: uppercase; letter-spacing: 1px;">
                                                        Billing Address
                                                    </h4>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Full Name</label>
                                                        <input readonly
                                                            value="{{ $order->billing_first_name }} {{ $order->billing_last_name }}"
                                                            class="form-control pop_input" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Company Name</label>
                                                        <input readonly value="{{ $order->billing_company_name }}"
                                                            class="form-control pop_input" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label>Country Name</label>
                                                        <input readonly
                                                            value="{{ $order->billing_country->country_name }}"
                                                            class="form-control pop_input" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label>Phone</label>
                                                        <input readonly value="{{ $order->billing_phone }}"
                                                            class="form-control pop_input" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input readonly value="{{ $order->billing_email }}"
                                                            class="form-control pop_input" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Street Address</label>
                                                        <input readonly value="{{ $order->billing_street_address }}"
                                                            class="form-control pop_input" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>City</label>
                                                        <input readonly value="{{ $order->billing_city }}"
                                                            class="form-control pop_input" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>State</label>
                                                        <input readonly value="{{ $order->billing_state }}"
                                                            class="form-control pop_input" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>ZIP</label>
                                                        <input readonly value="{{ $order->billing_zip_code }}"
                                                            class="form-control pop_input" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12" style="padding:2px;">
                                            <div class="row p-0 m-0"
                                                style="border:1px #16ab53 solid; background:#D3D3D3;">
                                                <div class="col-md-12 text-center" style="padding-top:2px;">
                                                    <h4 style="color: #9C0EEC; text-transform: uppercase; letter-spacing: 1px;">
                                                        Order Details
                                                    </h4>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <div class="bootstrap-data-table-panel">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered table-centre">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S/N</th>
                                                                        <th>Product Code</th>
                                                                        <th>Color</th>
                                                                        <th>Size</th>
                                                                        <th>Price</th>
                                                                        <th>Quantity</th>
                                                                        <th>Subtotal</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="item-table">
                                                                    @foreach ($order->order_details as $key => $value)
                                                                        <tr>
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>{{ $value->product->product_code }}</td>
                                                                            <td>{{ $value->color->name }}</td>
                                                                            <td>{{ $value->size->code }}</td>
                                                                            <td>{{ $basicInfo->currency_symbol }} {{ $value->price }}</td>
                                                                            <td>{{ $value->quantity }}</td>
                                                                            <td>{{ $basicInfo->currency_symbol }} {{ $value->price * $value->quantity }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12  pb-0 mb-0" style="padding:2px;">
                                            <div class="row p-0 m-0"
                                                style="border:1px #16ab53 solid; background:#D3D3D3;">
                                                <div class="col-md-4 form-group">
                                                    <label>Total Weight(gm)</label>
                                                    <input readonly class="form-control pop_input" type="number"
                                                        value="{{ $order->total_weight }}" />
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>Total Quantity</label>
                                                    <input readonly class="form-control pop_input" type="number"
                                                        value="{{ $order->total_qty }}" />
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>Total Amount</label>
                                                    <input readonly class="form-control pop_input" type="number"
                                                        value="{{ $order->total_price }}" />
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>Discount</label>
                                                    <input readonly class="form-control pop_input" type="number"
                                                        value="{{ $order->total_discount }}" />
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>Shipping Charge</label>
                                                    <input readonly class="form-control pop_input" type="number"
                                                        value="{{ $order->shipping_charge }}" />
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>Payable Amount</label>
                                                    <input readonly class="form-control pop_input" type="number"
                                                        value="{{ $order->payable_amount }}" />
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label>Order Status</label>
                                                    <select required class="custom-select form-control pop_input" name="order_status" id="order_status">
                                                        <option {{ $order->order_status == 'Delivered' ? 'disabled' : null }} {{ $order->order_status == 'Pending' ? 'selected' : null }} value="Pending">Pending</option>
                                                        <option {{ $order->order_status == 'Delivered' ? 'disabled' : null }} {{ $order->order_status == 'Processing' ? 'selected' : null }} value="Processing">Processing</option>
                                                        <option {{ $order->order_status == 'Delivered' ? 'disabled' : null }} {{ $order->order_status == 'Shipped' ? 'selected' : null }} value="Shipped">Shipped</option>
                                                        <option {{ $order->order_status == 'Delivered' ? 'selected' : null }} value="Delivered">Delivered</option>
                                                        <option {{ $order->order_status == 'Delivered' ? 'disabled' : null }} {{ $order->order_status == 'Cancelled' ? 'selected' : null }} value="Cancelled">Cancelled</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>Paid Amount</label>
                                                    <input step="0.01" required placeholder="0.00" class="form-control pop_input" type="number" name="paid_amount" id="paid_amount"
                                                        value="{{ $order->paid_amount }}">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>Payment Method</label>
                                                    <select required class="custom-select form-control pop_input"
                                                        name="payment_method" id="payment_method">
                                                        <option value="">Select Payment Method</option>
                                                        <option
                                                            {{ $order->payment_method == 'Paypal' ? 'selected' : null }}
                                                            value="Paypal">Paypal</option>
                                                        <option
                                                            {{ $order->payment_method == 'Cash Payment' ? 'selected' : null }}
                                                            value="Cash Payment">Cash Payment</option>
                                                        <option
                                                            {{ $order->payment_method == 'Master Card' ? 'selected' : null }}
                                                            value="Master Card">Master Card</option>
                                                        <option
                                                            {{ $order->payment_method == 'Others' ? 'selected' : null }}
                                                            value="Others">Others</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>Payment Status</label>
                                                    <select class="custom-select form-control pop_input"
                                                        name="payment_status" id="payment_status">
                                                        <option value="">Select Payment Status</option>
                                                        <option {{ $order->payment_status == 'Paid' ? 'selected' : null }}
                                                            value="Paid">Paid</option>
                                                        <option
                                                            {{ $order->payment_status == 'Unpaid' ? 'selected' : null }}
                                                            value="Unpaid">Unpaid</option>s
                                                    </select>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>Tracking No.</label>
                                                    <input placeholder="Tracking No." class="form-control pop_input"
                                                        type="text" name="tracking_no" id="tracking_no"
                                                        value="{{ $order->tracking_no }}">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>Shipped By</label>
                                                    <select required class="custom-select form-control pop_input"
                                                        name="shipped_by" id="shipped_by">
                                                        <option value="">Select Shipped By</option>
                                                        <option
                                                            {{ $order->shipped_by == 'www.ups.com' ? 'selected' : null }}
                                                            value="www.ups.com">www.ups.com</option>
                                                        <option
                                                            {{ $order->shipped_by == 'www.usps.com' ? 'selected' : null }}
                                                            value="www.usps.com">www.usps.com</option>
                                                        <option
                                                            {{ $order->shipped_by == 'www.dhl.com' ? 'selected' : null }}
                                                            value="www.dhl.com">www.dhl.com</option>
                                                        <option
                                                            {{ $order->shipped_by == 'www.fedex.com' ? 'selected' : null }}
                                                            value="www.fedex.com">www.fedex.com</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>Shipping Option</label>
                                                    <select required class="custom-select form-control pop_input"
                                                        name="shipping_option" id="shipping_option">
                                                        <option value="">Select Shipping Option</option>
                                                        <option
                                                            {{ $order->shipping_option == 'Ground' ? 'selected' : null }}
                                                            value="Ground">Ground</option>
                                                        <option
                                                            {{ $order->shipping_option == '2nd Day' ? 'selected' : null }}
                                                            value="2nd Day">2nd Day</option>
                                                        <option
                                                            {{ $order->shipping_option == '3rd Day' ? 'selected' : null }}
                                                            value="3rd Day">3rd Day</option>
                                                        <option
                                                            {{ $order->shipping_option == 'Over Night' ? 'selected' : null }}
                                                            value="Over Night">Over Night</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label>Notes</label>
                                                    <input readonly placeholder="Notes" class="form-control pop_input"
                                                        type="text" name="notes" id="notes"
                                                        value="{{ $order->notes }}">
                                                </div>
                                                {{-- <div class="col-md-12 form-group">
                                                    <label>Send Mail</label>
                                                    <select required class="custom-select form-control pop_input"
                                                        name="send_mail">
                                                        <option value="0">No</option>
                                                        <option value="1" selected>Yes</option>
                                                    </select>
                                                </div> --}}
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

@section('script')
    <script>
        $(document).ready(function() {
            $('#order_status').on('change', function() {
                var order_status = $(this).val();
                if(order_status=='Delivered'){
                        Swal.fire({
                            title: "Are you sure?",
                            text: "You want to set order status as Delivered. Status can not be changed later!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes!"
                        }).then((result) => {
                            if (!result.isConfirmed) {
                                location.reload();
                            }
                        });
                }
            });

        });
    </script>
@endsection
