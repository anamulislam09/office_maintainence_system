<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;
use Auth;

class OfficeController extends Controller
{
    public function index()
    {
        if(Auth::guard('admin')->user()->office_id == 0){
            $data = Office::orderBy('id', 'desc')->get();
            return view('admin.office.index', compact('data'));
            
        }elseif(Auth::guard('admin')->user()->office_id == 1){
            $data = Office::where('head_office_id', !null)->orderBy('id', 'desc')->get();
            return view('admin.office.index', compact('data'));
        }else{
            $data = Office::where('zonal_office_id', Auth::guard('admin')->user()->office_id)->orderBy('id', 'desc')->get();
            return view('admin.office.index', compact('data'));
        }
    }

    public function create()
    {
        $office = Office::where('status', 1)->where('zonal_office_id','')->orderBy('id', 'desc')->get();
        return view('admin.office.create', compact('office'));
    }
    
    public function store(Request $request)
    {
        $data = $request->all();
        $data['head_office_id'] = 1;
        $data['office_code'] = Office::max('office_code') + 1;
        Office::create($data);
        return redirect()->route('office.index')->with('alert',['messageType'=>'success','message'=>'Office Added Successfully!']);
    }

        // unique id serial function
        public function formatSrl($srl)
        {
            switch (strlen($srl)) {
                case 1:
                    $zeros = '00000';
                    break;
                case 2:
                    $zeros = '0000';
                    break;
                case 3:
                    $zeros = '000';
                    break;
                case 4:
                    $zeros = '00';
                    break;
                default:
                    $zeros = '0';
                    break;
            }
            return $zeros . $srl;
        }

    public function edit($id)
    {
        $office = Office::where('id', $id)->first();
        return view('admin.office.edit', compact('office'));
    }

    public function update(Request $request)
    {
        $data = Office::where('id', $request->id)->first();
        $data['title'] = $request->title;
        $data['location'] = $request->location;
        $data['status'] = $request->status;
        $data->save();

        return redirect()->route('office.index')->with('alert',['messageType'=>'warning','message'=>'Office Updated Successfully!']);
    }

    public function destroy($id)
    {
        $data = Office::findOrFail($id);
        $data->delete();
        return redirect()->route('office.index')->with('alert',['messageType'=>'danger','message'=>'Office Deleted Successfully!']);
    }
}
