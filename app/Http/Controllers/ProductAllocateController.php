<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Product;
use App\Models\ProductAllocate;
use Illuminate\Http\Request;

class ProductAllocateController extends Controller
{
    public function index()
    {
        // $assign_products = ProductAllocate::orderBy('id', 'desc')->get();
        $assignments = ProductAllocate::join('products', 'product_allocates.product_id', '=', 'products.id')
            ->join('offices', 'product_allocates.office_id', '=', 'offices.id')->where('product_allocates.location', '!=', 4)
            ->select('product_allocates.*', 'products.name as product_name', 'products.product_code as product_code', 'offices.title as office_name', 'offices.head_office_id as head_office_id',  'offices.zonal_office_id as zonal_office_id')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.products.product_allocate.index', compact('assignments'));
    }

    public function create()
    {
        $products = Product::where('isassign', 0)->orderBy('id', 'desc')->get();
        $offices = Office::where('head_office_id', '')->get();
        return view('admin.products.product_allocate.create', compact('products', 'offices'));
    }

    public function store(Request $request)
    {
        $office_id = $request->office_id;
        $data['product_id'] = $request->product_id;
        $data['office_id'] = $office_id;
        $data['assign_date'] = date('Y-m-d h:m:s');
        // $data['status'] = $request->status;
        $data['location'] = $office_id == 1 ? 1 : 2;
        $assign = ProductAllocate::create($data);
        if ($assign) {
            $product = Product::where('id', $request->product_id)->first();
            $product['isassign'] = 1;
            $product->save();
        }

        return redirect()->back()->with('alert', ['messageType' => 'success', 'message' => 'Product Assign Successfully!']);
    }

    // unique id serial function
    public function formatSrl($srl)
    {
        switch (strlen($srl)) {
            case 1:
                $zeros = '000000';
                break;
            case 2:
                $zeros = '00000';
                break;
            case 3:
                $zeros = '0000';
                break;
            case 4:
                $zeros = '000';
                break;
            default:
                $zeros = '0';
                break;
        }
        return $zeros . $srl;
    }

    // where('isassign', 0)

    public function edit($id)
    {
        $assign = ProductAllocate::where('id', $id)->first();
        $products = Product::orderBy('id', 'desc')->get();
        // $offices = Office::where('head_office_id', !null)->where('zonal_office_id', '')->get();
        $offices = Office::where('head_office_id', '')->get();
        return view('admin.products.product_allocate.edit', compact('assign', 'products', 'offices'));
    }

    public function update(Request $request)
    {
        $cat = ProductAllocate::where('id', $request->cat_id)->first();

        $data = Product::where('id', $request->id)->first();
        $data['cat_id'] = $cat->main_cat_id ? $cat->main_cat_id : $request->cat_id;
        $data['sub_cat_id'] = $cat->main_cat_id ? $request->cat_id : null;
        $data['name'] = $request->name;
        $data['brand_id'] = $request->brand_id;
        $data['purchase_date'] = $request->purchase_date;
        $data['warranty'] = $request->warranty;
        $data['garranty'] = $request->garranty;
        $data['descriptions'] = $request->descriptions;
        $data->save();

        return redirect()->route('product.index')->with('alert', ['messageType' => 'warning', 'message' => 'Product Updated Successfully!']);
    }

    public function destroy($id)
    {
        $data = Product::findOrFail($id);
        $data->delete();
        return redirect()->route('product.index')->with('alert', ['messageType' => 'danger', 'message' => 'Product Deleted Successfully!']);
    }
}
