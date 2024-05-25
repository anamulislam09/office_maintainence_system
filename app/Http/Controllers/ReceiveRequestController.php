<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductAllocate;
use App\Models\ReceiveRequest;
use Illuminate\Http\Request;
use Auth;


class ReceiveRequestController extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')->user()->office_id == 1) {
            $products = Product::orderBy('id', 'desc')->get();
            return view('admin.products.product.index', compact('products'));
        } elseif ((Auth::guard('admin')->user()->office_id !== 0) && (Auth::guard('admin')->user()->office_id !== 1)) {
            $assignments = ProductAllocate::where('office_id', Auth::guard('admin')->user()->office_id)
                ->where('location', 2)
                ->get();
            // Get the list of product IDs from the assignments
            $productIds = $assignments->pluck('product_id')->toArray();
            // Fetch products based on the product IDs
            $products = Product::whereIn('id', $productIds)->orderBy('id', 'desc')->get();

            return view('admin.received_request.index', compact('assignments', 'products'));
        }
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
        $data['location'] = 3;
        $update = $data->save();
        if($update){
            $product = Product::where('id', $data->product_id)->first();
            $product['isassign'] = 2;
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
