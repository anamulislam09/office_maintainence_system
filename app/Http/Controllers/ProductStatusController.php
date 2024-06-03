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
            $offices = Office::get();
        } elseif (Auth::guard('admin')->user()->office_id == 1) {
            $offices = Office::get();;
        } else {
            $offices = Office::where('id', Auth::guard('admin')->user()->office_id)->first();
        }
        return view('admin.products.product_status.index', compact('offices'));
    }

    public function filterProductStatus($office_id, $product_id)
    {
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
            )
            ->whereIn('ps.id', function ($query) {
                $query->select(DB::raw('MAX(ps2.id)'))
                    ->from('product_statuses as ps2')
                    ->groupBy('ps2.product_id');
            });
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
        $productList = $productList->where('product_allocates.location', '1');
        $productList = $productList->select('products.name', 'products.id', 'products.product_code')->get();
        return response()->json($productList, 200);
    }

    public function create()
    {
        $categories = Category::where('main_cat_id', null)->where('status', 1)->get();
        return view('admin.products.product_status.create', compact('categories'));
    }

    public function show(Request $request)
    {
        $cat_id = $request->cat_id;

        // $latestStatusSubquery = DB::table('product_statuses')
        //     ->select('product_statuses.product_id', 'product_statuses.status')
        //     ->join(DB::raw('(SELECT MAX(id) AS id, product_id FROM product_statuses GROUP BY product_id) AS ps'), 'ps.id', '=', 'product_statuses.id');

        // // Main query to get products along with their latest status
        // $productsQuery = ProductAllocate::join('products', 'product_allocates.product_id', '=', 'products.id')
        //     ->join('categories', 'products.sub_cat_id', '=', 'categories.id')
        //     ->joinSub($latestStatusSubquery, 'ps2', function ($join) {
        //         $join->on('ps2.product_id', '=', 'products.id');
        //     })
        //     ->where('product_allocates.office_id', Auth::guard('admin')->user()->office_id)
        //     ->where('location', 1)
        //     ->select('product_allocates.*', 'products.*', 'categories.name as cat_name', 'ps2.status');

        // if ($cat_id) {
        //     $productsQuery->where('products.cat_id', $cat_id);
        // }

        // $products = $productsQuery->get();

        $latestStatusSubquery = DB::table('product_statuses')
            ->select('product_statuses.product_id', 'product_statuses.status')
            ->join(DB::raw('(SELECT MAX(id) AS id, product_id FROM product_statuses GROUP BY product_id) AS ps'), 'ps.id', '=', 'product_statuses.id');
        $productsQuery = DB::table('product_allocates')
            ->join('products', 'products.id', '=', 'product_allocates.product_id')
            ->join('categories', 'products.sub_cat_id', '=', 'categories.id')
            ->joinSub($latestStatusSubquery, 'ps2', function ($join) {
                $join->on('ps2.product_id', '=', 'products.id');
            })
            ->where('product_allocates.office_id', Auth::guard('admin')->user()->office_id)
            ->where('product_allocates.location', 1)
            ->select('products.name', 'products.product_code', 'product_allocates.*', 'ps2.status', 'categories.name as cat_name');
        if ($cat_id) {
            $productsQuery->where('products.cat_id', $cat_id);
        }
        $products = $productsQuery->get();
        return response()->json($products, 200);
    }

    public function Store(Request $request)
    {
        $admin = Admin::with('role')->where('id', Auth::guard('admin')->user()->id)->first();
        $data = $request->all();
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
}
