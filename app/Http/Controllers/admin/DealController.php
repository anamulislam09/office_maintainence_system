<?php

namespace App\Http\Controllers\admin;

use App\Models\Deal;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class DealController extends Controller
{
    public function index()
    {
        $deals = Deal::with('product')->orderBy('id', 'desc')->get();
        return view('admin.deals.index', compact('deals'));
    }

    public function create()
    {
        $products = Product::where('status','=',1)->orderBy('id', 'desc')->get();
        return view('admin.deals.create', compact('products'));
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $date = new \DateTime($data['start_at']);
        $data['start_at'] = date_format($date, 'Y-m-d H:i:s');
        $date = new \DateTime($data['end_at']);
        $data['end_at'] = date_format($date, 'Y-m-d H:i:s');
        Deal::create($data);
        return redirect('admin/deals')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);

    }
    public function show(Deal $deal)
    {
        //
    }
    public function edit(Deal $deal)
    {
        $products = Product::where('status','=',1)->orderBy('id', 'desc')->get();
        return view('admin.deals.edit', compact('products','deal'));
    }

    public function update(Request $request, Deal $deal)
    {
        $data = $request->all();
        $date = new \DateTime($data['start_at']);
        $data['start_at'] = date_format($date, 'Y-m-d H:i:s');
        $date = new \DateTime($data['end_at']);
        $data['end_at'] = date_format($date, 'Y-m-d H:i:s');
        $deal->update($data);
        return redirect('admin/deals')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }
    public function destroy(Deal $deal)
    {
        $deal->delete();
        return redirect()->back()->with('alert',['messageType'=>'danger','message'=>'Data Deleted Successfully!']);
    }
}
