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
                                        <table id="example1" class="table table-striped table-bordered table-centre item_table">
                                            
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

    <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title m-auto">All Issue Products</h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
         $('body').on('click', '#officeId', function() {
            // let user_id = $(this).data('id');
            var officeId = this.getAttribute('data-office-id');
            $.get("/admin/transfer-request/get-data/" + officeId, function(data) {
                $('.item_table').html(data);
            })
        })

         $('body').on('click', '#getBtn', function() {
            $.get("/admin/transfer-request/get-data" , function(data) {
                $('.item_table').html(data);
            })
        })

        $('body').on('click', '#transferRequest', function() {
            let transfer_id = $(this).data('id');

            $.get("/admin/transfer-request-to/products/" + transfer_id, function(data) {
                $('.modal-body').html(data);

            })
        })
    </script>
@endsection
