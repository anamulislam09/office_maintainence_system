<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Product;
use App\Models\ProductAllocate;
use App\Models\ReceiveRequest;
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
        // dd($transferRequests);
        $transferPrtoduct = TransferRequestDetails::where('transfer_request_id', $transferRequests->id)->get();
        $productId = $transferPrtoduct->pluck('product_id')->toArray();
        // dd($productId);
        $products = Product::whereIn('id', $productId)->get();

        // $products = Product::where('id', $transferRequests->product_id)->get();

        return view('admin.received_request.others_office', compact('transferRequests','products'));
    }

    // public function edit($id)
    // {
    //     $data = ReceiveRequest::where('id', $id)->first();
    //     return view('admin.transfer_request.edit', compact('data'));
    // }

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

    // public function destroy($id)
    // {
    //     $data = ReceiveRequest::findOrFail($id);
    //     $data->delete();
    //     return redirect()->route('category.index')->with('alert', ['messageType' => 'danger', 'message' => 'Category Deleted Successfully!']);
    // }
}
