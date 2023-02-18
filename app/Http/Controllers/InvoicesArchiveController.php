<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;

class InvoicesArchiveController extends Controller
{
   
    public function index()
    {
        $invoices = invoices::onlyTrashed()->get();

        return view('invoices.archive',compact('invoices'));
    }


    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request)
    {
        $id = $request->invoice_id;
        $return = invoices::withTrashed()->where('id',$id)->restore();
        session()->flash('restore_invoice');
        return redirect('/invoices');
    }

    
    public function destroy(Request $request)
    {
        $return = invoices::withTrashed()->where('id',$request->invoice_id)->first();
        $return->forceDelete();
        session()->flash('delete_archive');
        return redirect('/invoices');
    }
}
