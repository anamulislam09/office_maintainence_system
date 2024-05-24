<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Office;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Auth;

class ProductController extends Controller
{
    public function index()
    {

        if (Auth::guard('admin')->user()->office_id == 0) {
            $products = Product::orderBy('id', 'desc')->get();
            return view('admin.products.product.index', compact('products'));
        } elseif (Auth::guard('admin')->user()->office_id == 1) {
            $products = Product::orderBy('id', 'desc')->get();
            return view('admin.products.product.index', compact('products'));
        } elseif((Auth::guard('admin')->user()->office_id !== 0) && (Auth::guard('admin')->user()->office_id !== 1)) {

            // $office = Office::where('id', Auth::guard('admin')->user()->office_id)->orderBy('id', 'desc')->get();
            // // dd($office);
            // $data = Office::where('id', $office->zonal_office_id)->get();
            // dd($data);

            $products = Product::orderBy('id', 'desc')->get();
            return view('admin.products.product.index', compact('products'));
            
        }
    }

    public function create()
    {
        $data = Category::with('subcategoris')->where('main_cat_id', null)->orderBy('id', 'desc')->get();
        $brands = Brand::orderBy('id', 'desc')->get();
        $suppliers = Supplier::orderBy('id', 'desc')->get();
        return view('admin.products.product.create', compact('data', 'brands', 'suppliers'));
    }

    public function store(Request $request)
    {
        $date = $request->purchase_date;
        $garrenty = $request->garranty;
        $garranty_end_date = date('Y-m-d', strtotime("+$garrenty months", strtotime($date)));

        $code = 1;
        $isExist = Product::exists();
        if ($isExist) {
            $sr_no = Product::max('serial_no');
            $serial_no = explode('-', $sr_no)[1];
            $data['serial_no'] = 'Sr-' . $this->formatSrl(++$serial_no);
        } else {
            $data['serial_no'] = 'Sr-' . $this->formatSrl($code);
        }

        $cat = Category::where('id', $request->cat_id)->first();

        $data['cat_id'] = $cat->main_cat_id ? $cat->main_cat_id : $request->cat_id;
        $data['sub_cat_id'] = $cat->main_cat_id ? $request->cat_id : null;
        $data['name'] = $request->name;
        $data['brand_id'] = $request->brand_id;
        $data['supplier_id'] = $request->supplier_id;
        $data['product_code'] = $request->product_code;
        $data['purchase_date'] = $date;
        $data['purchase_price'] = $request->purchase_price;
        $data['garranty'] = $garrenty;
        $data['garranty_end_date'] = $request->garranty ? $garranty_end_date : '';
        $data['descriptions'] = $request->descriptions;

        Product::create($data);
        return redirect()->route('product.index')->with('alert', ['messageType' => 'success', 'message' => 'Product Added Successfully!']);
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

    public function show($id)
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('admin.products.product.index', compact('products'));
    }

    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        $data = Category::with('subcategoris')->where('main_cat_id', null)->orderBy('id', 'desc')->get();
        $brands = Brand::orderBy('id', 'desc')->get();
        $suppliers = Supplier::orderBy('id', 'desc')->get();

        return view('admin.products.product.edit', compact('product', 'data', 'brands', 'suppliers'));
    }

    public function update(Request $request)
    {
        $cat = Category::where('id', $request->cat_id)->first();
        $date = $request->purchase_date;
        $garrenty = $request->garranty;
        $garranty_end_date = date('Y-m-d', strtotime("+$garrenty months", strtotime($date)));

        $data = Product::where('id', $request->id)->first();
        $data['cat_id'] = $cat->main_cat_id ? $cat->main_cat_id : $request->cat_id;
        $data['sub_cat_id'] = $cat->main_cat_id ? $request->cat_id : null;
        $data['name'] = $request->name;
        $data['brand_id'] = $request->brand_id;
        $data['supplier_id'] = $request->supplier_id;
        $data['product_code'] = $request->product_code;
        $data['purchase_date'] = $date;
        $data['purchase_price'] = $request->purchase_price;
        $data['garranty'] = $garrenty;
        $data['garranty_end_date'] = $request->garranty ? $garranty_end_date : '';
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
