<?php

namespace App\Http\Controllers\admin;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\ProductDetails;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->orderBy('id','desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function invoice($id, $print=null)
    {
        $order = Order::with(['order_details','user','shipping_country','billing_country'])->find($id);
        return view('admin.orders.invoice', compact('order','print'));
    }

    public function edit($id)
    {
        $order = Order::with(['order_details','user','shipping_country','billing_country'])->find($id);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $data['order_status'] = $request->order_status;
        $data['paid_amount'] = $request->paid_amount;
        $data['payment_method'] = $request->payment_method;
        $data['payment_status'] = $request->payment_status;
        $data['tracking_no'] = $request->tracking_no;
        $data['shipped_by'] = $request->shipped_by;
        $data['shipping_option'] = $request->shipping_option;
        $data['notes'] = $request->notes;
        $order = Order::find($id);
        $orderDetails = OrderDetails::where('order_id','=',$id)->get();
        if($order->order_status !='Delivered' && $data['order_status'] == 'Delivered')
        {
            foreach ($orderDetails as $key => $item){
                $productDetails = ProductDetails::where(['product_id'=> $item->product_id, 'color_id'=> $item->color_id, 'size_id'=> $item->size_id])->first();
                $stock = $productDetails->stock - $item->quantity;
                $stock = $stock < 0 ? 0 : $stock;
                $productDetails->update(['stock'=>$stock]);
                $product = Product::find($item->product_id);
                $product->update(['total_sale'=>$product->total_sale + $item->quantity]);
            }
        }
        $order->update($data);
        return redirect('/admin/orders')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);

    }
}
