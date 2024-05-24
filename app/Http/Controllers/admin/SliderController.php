<?php

namespace App\Http\Controllers\admin;

use App\Models\Slider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $fileName = 'bgimg-'. time().'.'. $data['bgImg']->getClientOriginalExtension();
        $data['bgImg']->move(public_path('uploads/slider'), $fileName);
        $data['bgImg'] = $fileName;

        $fileName = 'proimg-'. time().'.'. $data['proImg']->getClientOriginalExtension();
        $data['proImg']->move(public_path('uploads/slider'), $fileName);
        $data['proImg'] = $fileName;

        Slider::create($data);
        return redirect('admin/sliders')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);

    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $data = $request->all();
        if(isset($data['bgImg'])){
            $fileName = 'bgimg-'. time().'.'. $data['bgImg']->getClientOriginalExtension();
            $data['bgImg']->move(public_path('uploads/slider'), $fileName);
            $data['bgImg'] = $fileName;

            $imagePath = public_path('uploads/slider/'.$slider->bgImg);
            if($slider->bgImg) unlink($imagePath);
        }
        if(isset($data['proImg'])){
            $fileName = 'proimg-'. time().'.'. $data['proImg']->getClientOriginalExtension();
            $data['proImg']->move(public_path('uploads/slider'), $fileName);
            $data['proImg'] = $fileName;

            $imagePath = public_path('uploads/slider/'.$slider->proImg);
            if($slider->proImg) unlink($imagePath);
        }

        $slider->update($data);
        return redirect('admin/sliders')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);
    }

    public function destroy(Slider $slider)
    {
        $imagePath = public_path('uploads/slider/'.$slider->proImg);
        if($slider->proImg) unlink($imagePath);

        $imagePath = public_path('uploads/slider/'.$slider->bgImg);
        if($slider->bgImg) unlink($imagePath);

        $slider->delete();

        return redirect()->back()->with('alert',['messageType'=>'danger','message'=>'Data Deleted Successfully!']);
    }
}
