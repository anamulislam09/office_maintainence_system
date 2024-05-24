<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Auth;

class AssignLocationItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = Location::orderBy('id', 'desc')->get();
        // return view('admin.assign-location.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.assign-location.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data = $request->all();

        // $data['title'] = $request->title;
       
        // $location = Location::create($data);
        // return redirect()->route('location.create')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssignLocationItem  $assignLocationItem
     * @return \Illuminate\Http\Response
     */
    public function show(AssignLocationItem $assignLocationItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssignLocationItem  $assignLocationItem
     * @return \Illuminate\Http\Response
     */
    public function edit(AssignLocationItem $assignLocationItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AssignLocationItem  $assignLocationItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssignLocationItem $assignLocationItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssignLocationItem  $assignLocationItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssignLocationItem $assignLocationItem)
    {
        //
    }
}
