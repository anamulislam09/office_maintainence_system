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
                        <h1 class="m-0">Product Receive</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Receive</li>
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
                                        <span>All Receive</span></i></a>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="">
                                    <a href="#" data-office-id="1" id="officeId" class="btn btn-sm btn-info"
                                        style="margin-right: 2px">From Head Office
                                    </a>
                                    <a href="#" class="btn btn-sm btn-success" id="getBtn" style="margin-right: 2px">Others
                                    </a>
                                </div>
                                <div class="bootstrap-data-table-panel">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-striped table-bordered table-centre">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Product Name</th>
                                                    <th>Product Code</th>
                                                    {{-- <th>Status</th> --}}
                                                    <th>Request</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_body">
                                                {{-- @foreach ($assignments as $key => $assignment)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                @foreach ($products as $product)
                                                    @if ($product->id === $assignment->product_id)
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ $product->product_code }}</td>
                                                    <td>
                                                        @if ($product->status == 1)
                                                            <span class="badge badge-primary">Active</span>
                                                        @else
                                                            <span class="badge badge-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                        @break
                                                    @endif
                                                @endforeach
                                                        <td>
                                                            <span class="badge badge-warning">Pending</span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <a href="{{ route('receive-request.accept', $assignment->id) }}"
                                                                    class="btn btn-sm btn-info"
                                                                    style="margin-right: 2px">Accepted
                                                                </a>
                                                                <a href="{{ route('receive-request.cancel', $assignment->id) }}"
                                                                    class="btn btn-sm btn-danger"
                                                                    style="margin-right: 2px">Cancel
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach --}}
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

@section('script')
    <script>
         $('body').on('click', '#officeId', function() {
            // let user_id = $(this).data('id');
            var officeId = this.getAttribute('data-office-id');
            $.get("/admin/transfer-request/get-data/" + officeId, function(data) {
                $('#table_body').html(data);
            })
        })

         $('body').on('click', '#getBtn', function() {
            $.get("/admin/transfer-request/get-data/" , function(data) {
                $('#table_body').html(data);
            })
        })


//         document.getElementById('getProductsBtn').addEventListener('click', function(event) {
//             event.preventDefault(); // Prevent the default anchor tag behavior

//             // Construct the URL with JavaScript
//             var officeId = this.getAttribute('data-office-id');
//             var url = '{{ url('admin/transfer-request/get-data') }}/' + officeId;

//             // Send AJAX request to retrieve products
//             fetch(url)
//                 .then(response => response.json())
//                 .then(data => {
//                     // console.log($data);
//                     populateTable(data);
//                 })
//                 .catch(error => console.error('Error:', error));
//         });

//         function populateTable(data) {
//     var tableBody = document.getElementById('table_body');
//     tableBody.innerHTML = ''; // Clear previous content

//     // Check if data is an array
//     if (Array.isArray(data)) {
//         // Iterate over each data item and create table rows
//         data.forEach(function(item, index) {
//             console.log(item.product_name);
//             var row = document.createElement('tr');
//             row.innerHTML = `
//                 <td>${index + 1}</td>
//                 <td>${item.product_name}</td>
//                 <td>${item.product_code}</td>
//                 <td>
//                     ${item.status == 1 ? '<span class="badge badge-primary">Active</span>' : '<span class="badge badge-danger">Inactive</span>'}
//                 </td>
//                 <td>
//                     <span class="badge badge-warning">Pending</span>
//                 </td>
//                 <td>
//                     <div class="d-flex justify-content-center">
//                         <a href="/receive-request/accept/${item.id}" class="btn btn-sm btn-info" style="margin-right: 2px">Accepted</a>
//                         <a href="/receive-request/cancel/${item.id}" class="btn btn-sm btn-danger" style="margin-right: 2px">Cancel</a>
//                     </div>
//                 </td>
//             `;
//             tableBody.appendChild(row);
//         });
//     } else {
//         console.error('Data is not an array:', data);
//     }
// }
    </script>
@endsection
