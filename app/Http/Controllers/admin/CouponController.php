<?php

namespace App\Http\Controllers\admin;

use App\Models\Coupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'desc')->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'coupon_type' => 'required',
            'coupon_code' => 'required',
            'discount_perc' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'coupon_img' => 'required|image|mimes:jpeg,png,pdf,jpg,gif,svg|max:2048',
            'home_view' => 'required',
        ]);

        $input = $request->all();

        if ($img = $request->file('coupon_img')) {
            $imagesDoc = 'cpn-'. time().'.'.$img->getClientOriginalExtension();
            $img->move(public_path('uploads/coupon'), $imagesDoc);
            $input['coupon_img'] = $imagesDoc;

        } else {
            unset($input['coupon_img']);
        }
        Coupon::create($input);
        return redirect('admin/coupons_manage')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function edit($id)
    {
        $coupon = Coupon::find($id);
        return view('admin.coupons.edit', compact('coupon'));
    }
    public function update(Request $request, $id)
    {
        $coupon = Coupon::find($id);
        $request->validate([
            'coupon_type' => 'required',
            'coupon_code' => 'required',
            'discount_perc' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'home_view' => 'required',
        ]);
        $input = $request->all();
        if ($img = $request->file('coupon_img')) {

            $imagesDoc = 'cpn-'. time().'.'.$img->getClientOriginalExtension();
            $img->move(public_path('uploads/coupon'), $imagesDoc);
            $input['coupon_img'] = $imagesDoc;
            if($coupon->coupon_img){
                unlink(public_path('uploads/coupon/'. $coupon->coupon_img));
            }
        } else {
            unset($input['coupon_img']);
        }

        $coupon->update($input);
        return redirect('admin/coupons_manage')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);
    }

    public function destroy($id)
    {
        $coupon = Coupon::find($id);
        if($coupon->coupon_img){
            unlink(public_path('uploads/coupon/'. $coupon->coupon_img));
        }
        $coupon->delete();
        
        return redirect()->back()->with('alert',['messageType'=>'danger','message'=>'Data Deleted Successfully!']);
    }
}
