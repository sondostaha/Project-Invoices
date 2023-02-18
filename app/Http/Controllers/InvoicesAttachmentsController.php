<?php

namespace App\Http\Controllers;

use App\Models\invoices_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesAttachmentsController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
       
    }


    public function store(Request $request)
    {
        $request->validate([
            'file_name'=>'mimes:png,jpg,pdf,jpeg'
        ],[
            'file_name.mimes'=>'png,jpg,pdf,jpeg يرجي ادخال صيغه الملف '
        ]);


        $image = $request->file('file_name');
        $file_name = $image->getClientOriginalName();
        $invoice_number = $request->invoices_number;


         $attachment = new invoices_attachments();
        $attachment->file_name = $file_name;
        $attachment->invoices_number=$invoice_number;
        $attachment->created_by = Auth::user()->name;
        $attachment->invoices_id=$request->invoices_id;
        $attachment->save();

            //move file

        $imagaName =$request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('attachments/'.$invoice_number),$imagaName);

        session()->flash('Add','تم اضافه المرفق بنجاح');
        return back();
    }



    public function show(invoices_attachments $invoices_attachments)
    {
        //
    }

    public function edit(invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices_attachments  $invoices_attachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices_attachments  $invoices_attachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoices_attachments $invoices_attachments)
    {
        //
    }
}
