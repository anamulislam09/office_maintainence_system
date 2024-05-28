<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Office;
use App\Models\Product;
use App\Models\ProductAllocate;
use App\Models\ReceiveRequest;
use App\Models\TransferRequest;
use App\Models\TransferRequestDetails;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class ReceiveRequestController extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')->user()->office_id == 1) {
            $products = Product::orderBy('id', 'desc')->get();
            return view('admin.products.product.index', compact('products'));
        } elseif ((Auth::guard('admin')->user()->office_id !== 0) && (Auth::guard('admin')->user()->office_id !== 1)) {
            return view('admin.received_request.index');
            // return view('admin.received_request.index', compact('assignments', 'products'));
        }
    }

    public function getOfficeData($id)
    {
        $assignments = ProductAllocate::where('office_id', Auth::guard('admin')->user()->office_id)
            ->where('location', 2)->whereNull('updated_date')
            ->get();
        $productIds = $assignments->pluck('product_id')->toArray();
        $products = Product::whereIn('id', $productIds)->orderBy('id', 'desc')->get();
        return view('admin.received_request.head_office', compact('assignments', 'products'));
    }

    public function getData()
    {
        $transferRequests = DB::table('transfer_requests')
            ->where('request_to_office_id', Auth::guard('admin')->user()->office_id)
            ->where('status', 2)
            ->first();
        $office = Office::where('id', $transferRequests->request_to_office_id)->first();

        return view('admin.received_request.others_office', compact('transferRequests', 'office'));
    }


    public function ToshowProduct($id)
    {
        $transferPrtoduct = TransferRequestDetails::where('transfer_request_id', $id)->get();
        $productId = $transferPrtoduct->pluck('product_id')->toArray();
        $products = Product::whereIn('id', $productId)->orderBy('id', 'desc')->get();
        return view('admin.transfer_request.product', compact('products'));
    }

    public function approved($id)
    {
        $admin = Admin::with('role')->find(Auth::guard('admin')->user()->id);
        $data = TransferRequest::find($id);
        $data->status = 3;
        $data->save();

        $transferProducts = TransferRequestDetails::where('transfer_request_id', $id)->get();

        foreach ($transferProducts as $product) {
            $product_allocate = ProductAllocate::where('office_id', $data->request_to_office_id)
                ->where('product_id', $product->product_id)
                ->first();
            if ($product_allocate) {
                $product_allocate->location = 1;
                $product_allocate->updated_date = date('Y-m-d h:m:s');
                $product_allocate->save();
            }
            // $data['product_id'] = $product->product_id;
            // $data['office_id'] = Auth::guard('admin')->user()->office_id;
            // $data['product_id'] = $product->product_id;

            // Product::create($data);
        }

        return redirect()->back()->with('alert', ['messageType' => 'success', 'message' => 'Successfully done!']);
    }


    public function update($id)
    {
        $data = ProductAllocate::where('id', $id)->first();
        $data['updated_date'] = date('Y-m-d h:m:s');
        $data['location'] = 1;
        // dd($data);
        $data->save();

        return redirect()->route('receive-request.index')->with('alert', ['messageType' => 'warning', 'message' => 'Request Approved Successfully!']);
    }

    public function cancel($id)
    {
        $data = ProductAllocate::where('id', $id)->first();
        $data['updated_date'] = date('Y-m-d h:m:s');
        $data['location'] = 4;
        $update = $data->save();
        if ($update) {
            $product = Product::where('id', $data->product_id)->first();
            $product['isassign'] = 0;
            $product->save();
        }

        return redirect()->route('receive-request.index')->with('alert', ['messageType' => 'warning', 'message' => 'Request Rejected!']);
    }
}
