<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Office;
use App\Models\Product;
use App\Models\ProductAllocate;
use App\Models\TransferRequest;
use App\Models\TransferRequestDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferRequestController extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')->user()->office_id == '0' || Auth::guard('admin')->user()->office_id == '1') {
            $transferRequests = DB::table('transfer_requests')
                ->join('transfer_request_details', 'transfer_requests.id', '=', 'transfer_request_details.transfer_request_id')
                ->join('products', 'transfer_request_details.product_id', '=', 'products.id')
                ->join('product_allocates', 'transfer_request_details.product_id', '=', 'product_allocates.product_id')
                ->join('categories', 'products.cat_id', '=', 'categories.id')
                ->join('offices as from_office', 'transfer_requests.request_from_office_id', '=', 'from_office.id')
                ->join('offices as to_office', 'transfer_requests.request_to_office_id', '=', 'to_office.id')
                ->select(
                    'transfer_requests.*',
                    'transfer_request_details.note as transfer_note',
                    'product_allocates.location',
                    'products.name',
                    'products.id AS product_id',
                    'categories.name as cat_name',
                    'from_office.title AS from_office_name',
                    'to_office.title AS to_office_name'
                )
                ->get();
            return view('admin.transfer_request.index', compact('transferRequests'));
        } else {
            // $data = TransferRequest::where('request_from_office_id', Auth::guard('admin')->user()->office_id)->orderBy('id', 'desc')->get();
            $transferRequests = DB::table('transfer_requests')
                ->join('transfer_request_details', 'transfer_requests.id', '=', 'transfer_request_details.transfer_request_id')
                ->join('products', 'transfer_request_details.product_id', '=', 'products.id')
                ->join('product_allocates', 'transfer_request_details.product_id', '=', 'product_allocates.product_id')
                ->join('categories', 'products.cat_id', '=', 'categories.id')
                ->join('offices as from_office', 'transfer_requests.request_from_office_id', '=', 'from_office.id')
                ->join('offices as to_office', 'transfer_requests.request_to_office_id', '=', 'to_office.id')
                ->select(
                    'transfer_requests.*',
                    'transfer_request_details.note as transfer_note',
                    'product_allocates.location',
                    'products.name',
                    'categories.name as cat_name',
                    'from_office.title AS from_office_name',
                    'to_office.title AS to_office_name'
                )
                ->get();

            return view('admin.transfer_request.index', compact('transferRequests'));
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
        $note = $request->note;
        $admin = Admin::with('role')->where('id', Auth::guard('admin')->user()->id)->first();

        $data['request_from_office_id'] = $request->transfer_from_office_id;
        $data['request_to_office_id'] =  $request->transfer_to_office_id;
        $data['created_by'] = $admin->role->role;
        $data['created_date'] = date('Y-m-d h:i:s');
        $data['status'] = 0;
        $request = TransferRequest::create($data);
        if ($request) {
            $trRequest = TransferRequest::latest()->first();
            for ($i = 0; $i < count($product_id); $i++) {
                $item['transfer_request_id'] = $trRequest->id;
                $item['product_id'] = $product_id[$i];
                $item['note'] = $note[$i];
                TransferRequestDetails::create($item);

                $productsAllocate = ProductAllocate::where('product_id', $product_id[$i])->first();
                $productsAllocate['location'] = 3;
                $productsAllocate['updated_date'] = date('Y-m-d h:i:s');
                $productsAllocate->save();
            }
        }
        return redirect()->route('transfer-request.index')->with('alert', ['messageType' => 'success', 'message' => 'Transfer request successfully done!']);
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
