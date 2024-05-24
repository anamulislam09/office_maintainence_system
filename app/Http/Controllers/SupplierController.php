<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    public function index()
    {
        $suppliers = Supplier::orderBy('id', 'desc')->get();
        return view('admin.products.supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.products.supplier.create');
    }

    public function store(Request $request)
    {
        $id = 1;
        $isExist = Supplier::exists();
        if ($isExist) {
            $supplier_id = Supplier::max('supplier_id');
            $supplier_id = explode('-', $supplier_id)[1];
            $data['supplier_id'] = 'Sup-' . $this->formatSrl(++$supplier_id);
        } else {
            $data['supplier_id'] = 'Sup-' . $this->formatSrl($id);
        }

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        Supplier::create($data);
        return redirect()->route('supplier.index')->with('alert', ['messageType' => 'success', 'message' => 'Supplier Added Successfully!']);
    }

    public function edit($id)
    {
        $supplier = Supplier::where('id', $id)->first();
        return view('admin.products.supplier.edit', compact('supplier'));
    }

    public function update(Request $request)
    {
        $data = Supplier::where('id', $request->id)->first();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['status'] = $request->status;
        $data->save();
        return redirect()->route('supplier.index')->with('alert', ['messageType' => 'warning', 'message' => 'Supplier Updated Successfully!']);
    }

    public function destroy($id)
    {
        $data = Supplier::findOrFail($id);
        $data->delete();
        return redirect()->route('supplier.index')->with('alert', ['messageType' => 'danger', 'message' => 'Supplier Deleted Successfully!']);
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
}
