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
use Illuminate\Support\Facades\DB;

class ProductStatusController extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')->user()->office_id == 0) {
            $productStatus = ProductStatus::orderBy('id', 'desc')->get();
            $offices = Office::get();
            $products = Product::where('isassign', 1)->get();
            // return view('admin.products.product_status.index', compact('productStatus', 'offices', 'products'));
        } elseif (Auth::guard('admin')->user()->office_id == 1) {
            $productStatus = ProductStatus::where('office_id', Auth::guard('admin')->user()->office_id)->orderBy('id', 'desc')->get();
            $offices = Office::get();
            $products = Product::where('isassign', 1)->get();
            // return view('admin.products.product_status.index', compact('productStatus', 'offices', 'products'));
        } else {
            $productStatus = ProductStatus::where('office_id', Auth::guard('admin')->user()->office_id)->orderBy('id', 'desc')->get();
            $offices = Office::where('id', Auth::guard('admin')->user()->office_id)->get();
            $products = Product::where('isassign', 1)->get();
            // return view('admin.products.product_status.index', compact('productStatus'));
        }
        return view('admin.products.product_status.index', compact('productStatus', 'offices', 'products'));
    }

    public function filterProductStatus($office_id, $product_id)
    {
        if ($office_id == 0 && $product_id == 0) {
            $data['productStatus'] = DB::table('product_statuses')
                ->join('products', 'products.id', '=', 'product_statuses.product_id')
                ->join('categories', 'products.cat_id', '=', 'categories.id')
                ->join('offices', 'product_statuses.office_id', '=', 'offices.id')
                ->select('products.name as product_name', 'offices.title as office_name', 'products.*', 'product_statuses.*', 'categories.name as category_name')
                ->orderBy('product_statuses.created_date', 'desc')
                ->get();
            $products = Product::where('isassign', 1)->get();

            $data['product'] = '<option value="" selected disabled>Select One</option>';
            $data['product'] .= '<option value="0" >All Products</option>';
            foreach ($products as $product) {
                $data['product'] .= '<option value="' . $product->id . '" product-title="' . $product->name . '"
                          product-code="' . $product->product_code . '">
                          ' . $product->name . ' (' . $product->product_code . ')</option>';
            }
        } else {
            
            $data['productStatus'] = DB::table('product_statuses')
                ->join('products', 'products.id', '=', 'product_statuses.product_id')
                ->join('categories', 'products.cat_id', '=', 'categories.id')
                ->join('offices', 'product_statuses.office_id', '=', 'offices.id')
                ->select('products.name as product_name', 'offices.title as office_name', 'products.*', 'product_statuses.*', 'categories.name as category_name')
                ->where('product_statuses.office_id', $office_id)
                ->orderBy('product_statuses.created_date', 'desc')
                ->get();

            // $data['productStatus'] = DB::table('product_statuses')
            //     ->join('products', 'products.id', '=', 'product_statuses.product_id')
            //     ->join('categories', 'products.cat_id', '=', 'categories.id')
            //     ->join('offices', 'product_statuses.office_id', '=', 'offices.id')
            //     ->select(
            //         'products.name as product_name',
            //         'offices.title as office_name',
            //         'products.*',
            //         'product_statuses.*',
            //         'categories.name as category_name'
            //     )
            //     ->where(function ($query) use ($product_id, $office_id) {
            //         $query->where('product_statuses.product_id', $product_id)
            //             ->orWhere('product_statuses.office_id', $office_id);
            //     })
            //     ->orderBy('product_statuses.created_date', 'desc')
            //     ->get();

           
        }
        return response()->json($data, 200);
    }

    public function create()
    {
        $categories = Category::where('main_cat_id', null)->where('status', 1)->get();
        return view('admin.products.product_status.create', compact('categories'));
    }
    public function filterProductList($office_id)
    {
        $productList = Product::query()->join('product_allocates', 'product_allocates.product_id','=','products.id');
        if($office_id) $productList = $productList->where('product_allocates.office_id', $office_id);
        $productList = $productList->select('products.name','products.id','products.product_code')->get();
        return response()->json($productList, 200);
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
        } else {
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
