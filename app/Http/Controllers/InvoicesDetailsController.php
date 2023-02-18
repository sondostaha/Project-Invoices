<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\invoices;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use App\Models\sections;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\Request;


class InvoicesDetailsController extends Controller
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
        //
    }


    public function show($id)
    {
        $invoices = invoices::where('id',$id)->first();

        $details = invoices_details::where('invoices_id',$id)->get();

        $attachments= invoices_attachments::where('invoices_id',$id)->get();
       return view('invoices.details', compact('invoices','details','attachments'));
    }

    
    public function open_file($invoices_number , $file_name)
    {
       $files = Storage::disk('public_uploads')->get($invoices_number .'/'. $file_name);
       return response()->file($files);
    }

    public function get_file($invoices_number , $file_name)
    {
       $files = Storage::disk('public_uploads')->get($invoices_number.'/'.$file_name);
       return response()->download($files);
    }

    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }


    public function destroy(Request $request ,$invoices_number , $file_name)
    {
        $invoices = invoices_attachments::findOrFail($request->id_file);
        
        unlink(public_path('attachments/'.$invoices_number),$file_name);
        
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoices_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function edit()
    {
       
    }
}
