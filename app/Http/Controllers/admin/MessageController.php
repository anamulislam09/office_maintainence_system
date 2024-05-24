<?php

namespace App\Http\Controllers\admin;

use App\Models\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::orderBy('status','asc')->get();
        return view('admin.messages.index', compact('messages'));
    }

    public function updateStatus($id)
    {
        Message::find($id)->update(['status'=>1]);
        return redirect()->back()->with('alert',['messageType'=>'success','message'=>'Data Read Successfully!']);
    }

    public function destroy($id)
    {
        Message::destroy($id);
        return redirect()->back()->with('alert',['messageType'=>'danger','message'=>'Data Deleted Successfully!']);
    }
}
