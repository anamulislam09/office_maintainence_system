<?php

namespace App\Http\Controllers;

use App\Models\ReceiveRequest;
use Illuminate\Http\Request;

class ReceiveRequestController extends Controller
{
    public function index()
    {
        $data = ReceiveRequest::orderBy('id', 'desc')->get();
        return view('admin.received_request.index', compact('data'));
    }

    public function edit($id)
    {
        $data = ReceiveRequest::where('id', $id)->first();
        return view('admin.transfer_request.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $data = ReceiveRequest::where('id', $request->id)->first();
        $data['name'] = $request->name;
        $data['status'] = $request->status;
        $data->save();

        return redirect()->route('category.index')->with('alert',['messageType'=>'warning','message'=>'Category Updated Successfully!']);
    }

    public function destroy($id)
    {
        $data = ReceiveRequest::findOrFail($id);
        $data->delete();
        return redirect()->route('category.index')->with('alert',['messageType'=>'danger','message'=>'Category Deleted Successfully!']);
    }
}
