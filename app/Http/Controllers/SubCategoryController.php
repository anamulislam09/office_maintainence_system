<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $data = SubCategory::orderBy('id', 'desc')->get();
        return view('admin.subcategories.index', compact('data'));
    }

    public function create()
    {
        $category = Category::all();
        return view('admin.subcategories.create', compact('category'));
    }

    public function store(Request $request)
    {
        $data['name'] = $request->name;
        $data['category_id'] = $request->category_id;
        SubCategory::create($data);
        return redirect()->route('subcategory.index')->with('alert',['messageType'=>'success','message'=>'SubCategory Added Successfully!']);
    }

    public function edit($id)
    {
        $subcategory = SubCategory::where('id', $id)->first();
        return view('admin.subcategories.edit', compact('subcategory'));
    }

    public function update(Request $request)
    {
        $data = SubCategory::where('id', $request->id)->first();
        $data['name'] = $request->name;
        $data['category_id'] = $request->category_id;
        $data->save();

        return redirect()->route('subcategory.index')->with('alert',['messageType'=>'warning','message'=>'SubCategory Updated Successfully!']);
    }

    public function destroy($id)
    {
        $data = SubCategory::findOrFail($id);
        $data->delete();
        return redirect()->route('subcategory.index')->with('message', 'SubCategory deleted successfully.');
    }
}
