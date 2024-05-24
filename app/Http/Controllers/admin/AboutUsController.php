<?php

namespace App\Http\Controllers\admin;

use App\Models\AboutUs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::first();
        return view('admin.about-us.index', compact('aboutUs'));
    }

    public function edit($id)
    {
        $aboutUs = AboutUs::find($id);
        return view('admin.about-us.edit', compact('aboutUs'));
    }

    public function update(Request $request,$id)
    {
        $aboutUs = AboutUs::find($id);
        $data = $request->all();
        
        if(isset($data['image'])){
            $fileName = 'image-'. time().'.'. $data['image']->getClientOriginalExtension();
            $data['image']->move(public_path('uploads/about-us'), $fileName);
            $data['image'] = $fileName;

            $imagePath = public_path('uploads/about-us/'.$aboutUs->image);
            if($aboutUs->image) unlink($imagePath);

        }else unset($data['image']);

        $aboutUs->update($data);
        return redirect('admin/about-us')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);

    }

}
