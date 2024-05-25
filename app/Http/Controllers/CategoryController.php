<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $data = Category::orderBy('id', 'desc')->get();
        return view('admin.categories.index', compact('data'));
    }

    public function create() 
    {
        // $data = Category::get();
        $data = Category::with('subcategoris')->where('main_cat_id', null)->orderBy('id', 'desc')->get();
        return view('admin.categories.create', compact('data'));
    }

    public function store(Request $request)
    {
        $data['name'] = $request->name;
        $data['main_cat_id'] = $request->main_cat_id;
        Category::create($data);
        return redirect()->route('category.index')->with('alert',['messageType'=>'success','message'=>'Category Added Successfully!']);
    }

    public function edit($id)
    {
        $data = Category::where('id', $id)->first();
        return view('admin.categories.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $data = Category::where('id', $request->id)->first();
        $data['name'] = $request->name;
        $data['status'] = $request->status;
        $data->save();

        return redirect()->route('category.index')->with('alert',['messageType'=>'warning','message'=>'Category Updated Successfully!']);
    }

    public function destroy($id)
    {
        $data = Category::findOrFail($id);
        $data->delete();
        return redirect()->route('category.index')->with('alert',['messageType'=>'danger','message'=>'Category Deleted Successfully!']);
    }
}
