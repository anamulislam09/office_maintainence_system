<?php

namespace App\Http\Controllers\admin;

use App\Models\Color;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::get();
        return view('admin.colors.index', compact('colors'));
    }

    public function create()
    {
        return view('admin.colors.create');
    }

    public function store(Request $request)
    {
        Color::create($request->all());
        return redirect('admin/catalogue/colors')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }
    public function edit(Color $color)
    {
        return view('admin.colors.edit', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        $color->update($request->all());
        return redirect('admin/catalogue/colors')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);
    }

    public function destroy(Color $color)
    {
        $color->delete();
        return redirect('admin/catalogue/colors')->with('alert',['messageType'=>'danger','message'=>'Data Deleted Successfully!']);
    }
}
