<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Product;
use App\Models\ProductAllocate;
use App\Models\TransferRequest;
use App\Models\TransferRequestDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferRequestController extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')->user()->office_id == '0' || Auth::guard('admin')->user()->office_id == '1') {
            $data = TransferRequest::orderBy('id', 'desc')->get();
            return view('admin.transfer_request.index', compact('data'));
        }else{
            $data = TransferRequest::where('request_from_office_id', Auth::guard('admin')->user()->office_id)->orderBy('id', 'desc')->get();
            return view('admin.transfer_request.index', compact('data'));
        }
    }

    public function create()
    {
        $offices = Office::where('head_office_id', '')->get();


        $products = ProductAllocate::where('office_id', Auth::guard('admin')->user()->office_id)->get();
        if (Auth::guard('admin')->user()->office_id == '0' || Auth::guard('admin')->user()->office_id == '1') {
            $products = Product::get();
            return view('admin.transfer_request.create', compact('offices', 'products'));
        }
        return view('admin.transfer_request.create', compact('offices', 'products'));
    }

    public function store(Request $request)
    {
        $product_id = $request->product_id;
        $data['request_from_office_id'] = Auth::guard('admin')->user()->office_id;
        $data['request_to_office_id'] =  $request->office_id;
        $data['created_by_id'] = Auth::guard('admin')->user()->name;
        $data['date'] = date('Y-m-d h:i:s');
        $data['note'] = $request->note;
        $request = TransferRequest::create($data);
        if ($request) {
            $trRequest = TransferRequest::latest()->first();
            $item['transfer_request_id'] = $trRequest->id;
            $item['product_id'] = $product_id;
            $item['note'] = $request->note;
            TransferRequestDetails::create($item);
        }
        return redirect()->route('transfer-request.index')->with('alert', ['messageType' => 'success', 'message' => 'Category Added Successfully!']);
    }

    public function edit($id)
    {
        $data = TransferRequest::where('id', $id)->first();
        return view('admin.transfer_request.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $data = TransferRequest::where('id', $request->id)->first();
        $data['name'] = $request->name;
        $data['status'] = $request->status;
        $data->save();

        return redirect()->route('category.index')->with('alert', ['messageType' => 'warning', 'message' => 'Category Updated Successfully!']);
    }

    public function destroy($id)
    {
        $data = TransferRequest::findOrFail($id);
        $data->delete();
        return redirect()->route('category.index')->with('alert', ['messageType' => 'danger', 'message' => 'Category Deleted Successfully!']);
    }
}
