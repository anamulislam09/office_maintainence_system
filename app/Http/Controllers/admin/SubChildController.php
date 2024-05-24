<?php

namespace App\Http\Controllers\admin;

use App\Models\SubCategory;
use App\Models\Category;
use App\Models\SubChild;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class SubChildController extends Controller
{
    public function index()
    {
        $subChildren = SubChild::with('subcategory')->orderBy('id', 'desc')->get();
        return view('admin.sub-child.index', compact('subChildren'));
    }

    public function create()
    {
        $categories = Category::orderBy('title', 'asc')->get();
        return view('admin.sub-child.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['admin_id'] = Auth::guard('admin')->user()->id;
        $data['slug'] = strtolower(str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strip_tags($request->title)))));
        SubChild::create($data);
        return redirect('admin/catalogue/sub-child')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function edit(SubChild $subChild)
    {
        $cat_id = SubCategory::where('id','=', $subChild->sub_cat_id)->orderBy('title', 'asc')->first()->cat_id;
        $categories = Category::orderBy('title', 'asc')->get();
        $subCategories = SubCategory::where('cat_id','=', $cat_id)->orderBy('title', 'asc')->get();
        return view('admin.sub-child.edit', compact('categories', 'subCategories', 'subChild'));
    }

    public function update(Request $request, SubChild $subChild)
    {
        $data = $request->all();
        $data['slug'] = strtolower(str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strip_tags($request->title)))));
        $subChild->update($data);
        return redirect('/admin/catalogue/sub-child')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);
    }
    public function localization(Request $request, $id, $locale)
    {
        if($request->isMethod('post'))
        {
            Subchild::find($id)->update([$locale=>$request->all(),]);
            return redirect('admin/catalogue/sub-child')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);
        }else{
            $data = SubChild::find($id)->translate($locale);
            return view('admin.sub-child.localization', compact('data','id','locale'));
        }
    }

    public function destroy(SubChild $subChild)
    {
        $data = Product::where('sub_child_id',$subChild->id)->get();
        if(count($data)) return redirect()->back()->with('alert',['messageType'=>'danger','message'=>'This data can not be delele!']);
        $subChild->delete();
        return redirect()->back()->with('alert',['messageType'=>'danger','message'=>'Data Deleted Successfully!']);
    }
}
