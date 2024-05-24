<?php

namespace App\Http\Controllers\admin;

use App\Models\Service;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller  
{
    public function index()
    {
        $services = Service::orderBy('id','desc')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['slug'] = strtolower(str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strip_tags($request->title)))));
        Service::create($data);
        return redirect('admin/services')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request,Service $service)
    {
        $data = $request->all();
        $data['slug'] = strtolower(str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strip_tags($request->title)))));
        $service->update($data);
        return redirect('admin/services')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);
    }

    public function localization(Request $request, $id, $locale)
    {
        if($request->isMethod('post'))
        {
            Service::find($id)->update([$locale=>$request->all(),]);
            return redirect('admin/services')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);
        }else{
            $data = Service::find($id)->translate($locale);
            return view('admin.services.localization', compact('data','id','locale'));
        }
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->back()->with('alert',['messageType'=>'danger','message'=>'Data Deleted Successfully!']);
    }
}
