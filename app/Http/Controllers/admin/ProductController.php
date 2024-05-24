<?php

namespace App\Http\Controllers\admin;

use App\Models\Product;
use App\Models\SubChild;
use App\Models\SubCategory;
use App\Models\ProductDetails;
use App\Models\Color;
use App\Models\Size;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category','sub_category', 'sub_child'])->orderBy('id', 'desc')->get();

        // 'product_id',
        // 'locale',
        // 'product_title',
        // 'short_desc',
        // 'description',
        // 'meta_title',
        // 'meta_description',
        // 'meta_keywords',

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $subCategories = SubCategory::where('status', '=', 1)->get();
        $colors = Color::where('status', '=', 1)->get();
        $sizes = Size::where('status', '=', 1)->get();
        return view('admin.products.create', compact('subCategories','colors','sizes'));
    }
    public function SubChild($id)
    {
        $data = SubChild::where('status', '=', 1)->where('sub_cat_id','=',$id)->get();
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['cat_id'] = SubCategory::find($data['sub_cat_id'])->cat_id;
        $data['slug'] = strtolower(str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strip_tags($data['product_title'])))));

        $fileName = 'thumb-img-'. time().'.'. $data['product_image']->getClientOriginalExtension();
        $data['product_image']->move(public_path('uploads/product'), $fileName);
        $data['product_image'] = $fileName;

        $fileName = 'thumb-img-back-'. time().'.'. $data['product_image_back']->getClientOriginalExtension();
        $data['product_image_back']->move(public_path('uploads/product'), $fileName);
        $data['product_image_back'] = $fileName;

        $product = Product::create($data);
        
        //Product Details
        $data2['product_id'] = $product->id;
        for ($i=0; $i < count($data['color_id']); $i++) {   
            $data2['image'] = $fileName = 'pro_img-'. time().'-'.$i.'.'. $data['image'][$i]->getClientOriginalExtension();
            $data['image'][$i]->move(public_path('uploads/product'), $fileName);

            $data2['color_id'] = $data['color_id'][$i];
            $data2['size_id'] = $data['size_id'][$i];
            $data2['stock'] = $data['stock'][$i];
            ProductDetails::create($data2);
        }
        return redirect('admin/catalogue/products')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }


    public function edit(Product $product)
    {
        $subCategories = SubCategory::where('status', '=', 1)->get();
        $subChild = SubChild::where('sub_cat_id', '=', $product->sub_cat_id)->get();
        $colors = Color::where('status', '=', 1)->get();
        $sizes = Size::where('status', '=', 1)->get();
        $productDetails = ProductDetails::with(['color','size'])->where('product_id', '=', $product->id)->get();
        return view('admin.products.edit', compact('subCategories','colors','sizes','product', 'productDetails', 'subChild'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->all();

        $data['cat_id'] = SubCategory::find($data['sub_cat_id'])->cat_id;
        $data['slug'] = strtolower(str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strip_tags($data['product_title'])))));
        if(isset($data['product_image'])){
            $fileName = 'thumb-img-'. time().'.'. $data['product_image']->getClientOriginalExtension();
            $data['product_image']->move(public_path('uploads/product'), $fileName);
            $data['product_image'] = $fileName;
            if($product->product_image) unlink(public_path('uploads/product/'. $product->product_image));
        }
        if(isset($data['product_image_back'])){
            $fileName = 'thumb-img-back-'. time().'.'. $data['product_image_back']->getClientOriginalExtension();
            $data['product_image_back']->move(public_path('uploads/product'), $fileName);
            $data['product_image_back'] = $fileName;
            if($product->product_image_back) unlink(public_path('uploads/product/'. $product->product_image_back));
        }


        $product->update($data);

        // Product Details

        //Deleting Product Details...
        $oldProductDetails = ProductDetails::where('product_id','=', $product->id)->get();
        foreach ($oldProductDetails as $key => $value) {
            $c = 0;
            for ($i=0; $i < count($data['color_id']); $i++){ 
                if($data['color_id'][$i] == $value->color_id && $data['size_id'][$i] == $value->size_id){
                    $c++;
                }
            }
            if(!$c){
                unlink(public_path('uploads/product/'. $value->image));
                ProductDetails::destroy($value->id);
            }
        }

        for ($i=0; $i < count($data['color_id']); $i++){
            $data2 = [];
            $isExist = ProductDetails::where(['product_id'=>$product->id, 'color_id'=>$data['color_id'][$i],'size_id'=>$data['size_id'][$i]])->first();
            if($isExist){
                if(isset($data['image'][$i])){
                    $data2['image'] = $fileName = 'pro_img-'. time().'-'.$i.'.'. $data['image'][$i]->getClientOriginalExtension();
                    $data['image'][$i]->move(public_path('uploads/product'), $fileName);
                    if($isExist->image){
                        unlink(public_path('uploads/product/'. $isExist->image));
                    }
                }
                $data2['stock'] = $data['stock'][$i];
                $d =  ProductDetails::find($isExist->id)->update($data2);
            }else{
                    $data2['image'] = $fileName = 'pro_img-'. time().'-'.$i.'.'. $data['image'][$i]->getClientOriginalExtension();
                    $data['image'][$i]->move(public_path('uploads/product'), $fileName);

                    $data2['product_id'] = $product->id;
                    $data2['color_id'] = $data['color_id'][$i];
                    $data2['size_id'] = $data['size_id'][$i];
                    $data2['stock'] = $data['stock'][$i];
                    ProductDetails::create($data2);
            }

        }
        return redirect('admin/catalogue/products')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);

    }
    public function localization(Request $request, $id, $locale)
    {
        if($request->isMethod('post'))
        {
            Product::find($id)->update([$locale=>$request->all(),]);
            return redirect('admin/catalogue/products')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);
        }else{
            $data = Product::find($id)->translate($locale);
            return view('admin.products.localization', compact('data','id','locale'));
        }
    }

    public function destroy($id)
    {

    }
}
