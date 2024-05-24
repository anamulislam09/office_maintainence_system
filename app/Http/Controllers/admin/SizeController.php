<?php

namespace App\Http\Controllers\admin;

use App\Models\Size;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::get();
        return view('admin.sizes.index', compact('sizes'));
    }

    public function create()
    {
        return view('admin.sizes.create');
    }

    public function store(Request $request)
    {
        Size::create($request->all());
        return redirect('admin/catalogue/sizes')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }
    public function edit(Size $size)
    {
        return view('admin.sizes.edit', compact('size'));
    }

    public function update(Request $request, Size $size)
    {
        $size->update($request->all());
        return redirect('admin/catalogue/sizes')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);
    }

    public function destroy(Size $color)
    {
        $color->delete();
        return redirect('admin/catalogue/sizes')->with('alert',['messageType'=>'danger','message'=>'Data Deleted Successfully!']);
    }
}
