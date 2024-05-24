<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $data = Location::orderBy('id', 'desc')->get();
        return view('admin.assign-location.index', compact('data'));
    }

    public function create()
    {
        return view('admin.assign-location.create');
    }
    
    public function store(Request $request)
    {
        $data['title'] = $request->title;
        $data['address'] = $request->adress;
        Location::create($data);
        return redirect()->route('location.create')->with('alert',['messageType'=>'success','message'=>'Location Added Successfully!']);
    }

    public function edit($id)
    {
        $location = Location::where('id', $id)->first();
        return view('admin.assign-location.edit', compact('location'));
    }

    public function update(Request $request)
    {
        $data = Location::where('id', $request->id)->first();
        $data['title'] = $request->title;
        $data['address'] = $request->address;
        $data['status'] = $request->status;
        $data->save();

        return redirect()->route('location.index')->with('alert',['messageType'=>'warning','message'=>'Location Updated Successfully!']);
    }

    public function destroy($id)
    {
        $data = Location::findOrFail($id);
        $data->delete();
        return redirect()->route('category.index')->with('message', 'Location deleted successfully.');
    }
}
