<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Product;
use App\Models\ProductStatus;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $offices = Office::get();
        return view('admin.reports.index', compact('offices'));
    }

    public function filterProductStatus($office_id, $product_id)
    {
        // dd("hello");
        // if ($office_id == 0 && $product_id == 0) {
        //     $data['productStatus'] = DB::table('product_statuses')
        //         ->join('products', 'products.id', '=', 'product_statuses.product_id')
        //         ->join('categories', 'products.cat_id', '=', 'categories.id')
        //         ->join('offices', 'product_statuses.office_id', '=', 'offices.id')
        //         ->select('products.name as product_name', 'offices.title as office_name', 'products.*', 'product_statuses.*', 'categories.name as category_name')
        //         ->orderBy('product_statuses.created_date', 'desc')
        //         ->get();
        // } else {
        //     // if ($office_id == Auth::guard('admin')->user()->office_id && $product_id == 0) {
        //     $data['productStatus'] = DB::table('product_statuses')
        //         ->join('products', 'products.id', '=', 'product_statuses.product_id')
        //         ->join('categories', 'products.cat_id', '=', 'categories.id')
        //         ->join('offices', 'product_statuses.office_id', '=', 'offices.id')
        //         ->select('products.name as product_name', 'offices.title as office_name', 'products.*', 'product_statuses.*', 'categories.name as category_name')
        //         ->where('product_statuses.office_id', $office_id)
        //         // ->where('product_statuses.product_id', $product_id)
        //         ->orderBy('product_statuses.created_date', 'desc')
        //         ->get();
        // }

        $data['productStatus'] = DB::table('product_statuses as ps')
            ->join('products as p', 'p.id', '=', 'ps.product_id')
            ->join('categories as c', 'p.cat_id', '=', 'c.id')
            ->join('offices as o', 'ps.office_id', '=', 'o.id')
            ->select(
                'ps.status',
                'ps.created_date',
                'ps.created_by',
                'p.name as product_name',
                'p.product_code as product_code',
                'o.title as office_name',
                'c.name as category_name'
            );

        if ($office_id) {
            $data['productStatus'] = $data['productStatus']->where('ps.office_id', $office_id);
        }

        if ($product_id) {
            $data['productStatus'] = $data['productStatus']->where('ps.product_id', $product_id);
        }

        $data['productStatus'] = $data['productStatus']
            ->orderBy('ps.created_date', 'desc')
            ->get();
        return response()->json($data, 200);
    }
    public function filterProductList($office_id)
    {
        $productList = Product::query()->join('product_allocates', 'product_allocates.product_id', '=', 'products.id');
        if ($office_id) $productList = $productList->where('product_allocates.office_id', $office_id);
        $productList = $productList->select('products.name', 'products.id', 'products.product_code')->get();
        return response()->json($productList, 200);
    }

    public function getProducts()
    {
        $products = Product::where('isassign', 1)->get();
        return view('admin.reports.product_monitors', compact('products'));
    }

    public function monitor($product_id)
    {
        // $ProductStatus = ProductStatus::where('product_id', $product_id)->get();
        $data['productStatus'] = DB::table('product_statuses as ps')
        ->join('products as p', 'p.id', '=', 'ps.product_id')
        ->join('categories as c', 'p.cat_id', '=', 'c.id')
        ->join('offices as o', 'ps.office_id', '=', 'o.id')
        ->select(
            'ps.status',
            'ps.created_date',
            'ps.created_by',
            'p.name as product_name',
            'p.product_code as product_code',
            'o.title as office_name',
            'c.name as category_name'
        );
        if ($product_id) {
            $data['productStatus'] = $data['productStatus']->where('ps.product_id', $product_id);
        }
        $data['productStatus'] = $data['productStatus']
            ->orderBy('ps.created_date', 'desc')
            ->get();
        return response()->json($data, 200);
    }
}
