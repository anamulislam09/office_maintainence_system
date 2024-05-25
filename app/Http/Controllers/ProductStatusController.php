<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Office;
use App\Models\Product;
use App\Models\ProductAllocate;
use App\Models\ProductStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductStatusController extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')->user()->office_id == 0) {
            $productStatus = ProductStatus::orderBy('id', 'desc')->get();
            // return view('admin.products.product_status.index', compact('productStatus'));
        } elseif (Auth::guard('admin')->user()->office_id == 1) {
            $productStatus = ProductStatus::orderBy('id', 'desc')->get();
            // return view('admin.products.product_status.index', compact('productStatus'));
        } else {
            $productStatus = ProductStatus::where('office_id', Auth::guard('admin')->user()->office_id)->orderBy('id', 'desc')->get();
            // return view('admin.products.product_status.index', compact('productStatus'));
        }
        return view('admin.products.product_status.index', compact('productStatus'));
    }

    public function create()
    {
        $categories = Category::where('main_cat_id', null)->where('status', 1)->get();
        return view('admin.products.product_status.create', compact('categories'));
    }

    public function show(Request $request)
    {
        $cat_id = $request->cat_id;

        if ($cat_id) {
            $products = ProductAllocate::join('products', 'product_allocates.product_id', '=', 'products.id')
                ->join('categories', 'products.sub_cat_id', '=', 'categories.id')
                ->where('product_allocates.office_id', Auth::guard('admin')->user()->office_id)->where('location', 1)
                ->where('products.cat_id', $cat_id)
                ->select('product_allocates.*', 'products.*', 'categories.name as cat_name')
                ->get();
        } else {
            $products = ProductAllocate::join('products', 'product_allocates.product_id', '=', 'products.id')
                ->join('categories', 'products.sub_cat_id', '=', 'categories.id')
                ->where('product_allocates.office_id', Auth::guard('admin')->user()->office_id)->where('location', 1)
                ->select('product_allocates.*', 'products.*', 'categories.name as cat_name')
                ->get();
        }

        return response()->json($products, 200);
    }

    public function Store(Request $request)
    {
        $admin = Admin::with('role')->where('id', Auth::guard('admin')->user()->id)->first();
        $data = $request->all();
        // dd($data['product_id']);
        if (!empty($data['product_id'])) {
            for ($i = 0; $i < count($data['product_id']); $i++) {
                ProductStatus::insert([
                    'product_id' => $data['product_id'][$i],
                    'office_id' => $data['office_id'][$i],
                    'status' => $data['status'][$i],
                    'created_date' => date('Y-m-d h:i:s'),
                    'created_by' => $admin->role->role,
                ]);
            }
        }else{
            return redirect()->back()->with('alert', ['messageType' => 'danger', 'message' => 'Product Not Found!']);
        }

        return redirect()->back()->with('alert', ['messageType' => 'success', 'message' => 'Product status updated successfully!']);
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
        $assign = ProductStatus::where('id', $id)->first();
        $products = Product::orderBy('id', 'desc')->get();
        // $offices = Office::where('head_office_id', !null)->where('zonal_office_id', '')->get();
        $offices = Office::where('head_office_id', '')->get();
        return view('admin.products.product_status.edit', compact('assign', 'products', 'offices'));
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
