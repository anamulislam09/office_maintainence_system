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
                    'transfer_requests.status as transfer_status',
                    'transfer_request_details.note as transfer_not',
                    'product_allocates.location',
                    'products.name',
                    'products.id AS product_id',
                    'categories.name as cat_name',
                    'from_office.title AS from_office_name',
                    'to_office.title AS to_office_name'
                )
                ->get();
                // dd($transferRequests);
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
                    'transfer_requests.status as transfer_status',
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

    // show all transfer issu form Branch and zonal office 
    public function issue()
    {
        $transferRequests = DB::table('transfer_requests')
            ->where('request_from_office_id', Auth::guard('admin')->user()->office_id)
            ->where('status', 1)
            ->first();

        // $office_name = Office::where('id', $transferRequests->request_to_office_id)->value('title');
        return view('admin.transfer_request.issue', compact('transferRequests'));
    }

    // transfer issu show all product 
    public function showProduct($id)
    {
        $transferPrtoduct = TransferRequestDetails::where('transfer_request_id', $id)->get();
        $productId = $transferPrtoduct->pluck('product_id')->toArray();
        $products = Product::whereIn('id', $productId)->orderBy('id', 'desc')->get();
        return view('admin.received_request.product', compact('products'));
    }

    // product transfer issu approved method 
    public function issued($id)
    {
        // $admin = Admin::with('role')->find(Auth::guard('admin')->user()->id);
        // $data = TransferRequest::find($id);

        // $data->status = 2;
        // $data->updated_by = $admin->role->role;
        // $data->updated_date = now();
        // $data->save();

        // $transferProducts = TransferRequestDetails::where('transfer_request_id', $id)->get();

        // foreach ($transferProducts as $product) {
        //     $product_allocate = ProductAllocate::where('office_id', $data->request_from_office_id)
        //         ->where('product_id', $product->product_id)
        //         ->first();
        //     if ($product_allocate) {
        //         $product_allocate->location = 2;
        //         $product_allocate->updated_date = date('Y-m-d h:m:s');
        //         $product_allocate->save();
        //     }

        //     $data['product_id'] = $product->product_id;
        //     $data['office_id'] = $data->request_to_office_id;
        //     $data['product_id'] = $product->product_id;
        //     $data['assign_date'] = date('Y-m-d h:m:s');
        //     $data['location'] = 2;
        //     ProductAllocate::create($data);
        // }


        $admin = Admin::with('role')->find(Auth::guard('admin')->user()->id);
        $transferRequest = TransferRequest::find($id);
    
        $transferRequest->status = 2;
        $transferRequest->updated_by = $admin->role->role;
        $transferRequest->updated_date = now();
        $transferRequest->save();
    
        $transferProducts = TransferRequestDetails::where('transfer_request_id', $id)->get();
    
        foreach ($transferProducts as $product) {
            $productAllocate = ProductAllocate::where('office_id', $transferRequest->request_from_office_id)
                ->where('product_id', $product->product_id)
                ->first();
            if ($productAllocate) {
                $productAllocate->location = 2;
                $productAllocate->updated_date = now(); // Use Laravel's now() helper for current datetime
                $productAllocate->save();
            }
    
            // Create a new ProductAllocate instance for each product
            $newProductAllocate = new ProductAllocate();
            $newProductAllocate->product_id = $product->product_id;
            $newProductAllocate->office_id = $transferRequest->request_to_office_id;
            $newProductAllocate->assign_date = now(); // Use Laravel's now() helper for current datetime
            $newProductAllocate->location = 2;
            $newProductAllocate->save();
        }
    


        return redirect()->back()->with('alert', ['messageType' => 'success', 'message' => 'Product Transfer!']);
    }

    public function create()
    {
        $offices = Office::where('head_office_id', '')->get();
        $products = Product::get();
        return view('admin.transfer_request.create', compact('offices', 'products'));
    }

    // insert sub category category using ajax request
    public function getProduct(Request $request)
    {
        $transfer_from_office_id = $request->post('transfer_from_office_id');

        // Fetch product IDs from product_allocates table
        $productAllocates = DB::table('product_allocates')
            ->where('office_id', $transfer_from_office_id)
            ->where('location', 1)
            ->pluck('product_id');  // Assuming 'product_id' is the column name

        // Fetch products using the retrieved IDs
        $products = DB::table('products')
            ->whereIn('id', $productAllocates)
            ->where('isassign', 1)
            ->get();

        // Generate the HTML for the dropdown
        $html = '<option value="" selected disabled>Select One</option>';
        foreach ($products as $product) {
            $html .= '<option value="' . $product->id . '" product-title="' . $product->name . '"
                  product-code="' . $product->product_code . '">
                  ' . $product->name . ' (' . $product->product_code . ')</option>';
        }

        // Return the HTML as a response
        echo $html;
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
        $data['status'] = 1;
        $request = TransferRequest::create($data);
        if ($request) {
            $trRequest = TransferRequest::latest()->first();
            for ($i = 0; $i < count($product_id); $i++) {
                $item['transfer_request_id'] = $trRequest->id;
                $item['product_id'] = $product_id[$i];
                $item['note'] = $note[$i];
                TransferRequestDetails::create($item);

                // $productsAllocate = ProductAllocate::where('product_id', $product_id[$i])->first();
                // $productsAllocate['location'] = 3;
                // $productsAllocate['updated_date'] = date('Y-m-d h:i:s');
                // $productsAllocate->save();
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
