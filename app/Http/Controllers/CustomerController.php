<?php

namespace App\Http\Controllers;
use App\Models\invoices;
use App\Models\sections;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $sections = sections::all();
        return view('reports.customer_report', compact('sections'));
    }
    public function searchReport (Request $request)
    {
        $sections = sections::all();

        if($request->section && $request->product &&  $request->start_at=='' && $request->end_at =='')
        {
            $invoices = invoices::Select('*')->where('section_id',$request->section)->get();
            $sections = sections::all();
            return view('reports.customer_report' ,compact('sections','invoices'));

        }
        else
        {
            $start_date = date($request->start_at);
            $end_date= date($request->end_at);
            
            $invoices = invoices::whereBetween('invoice_date',[$start_date,$end_date])->where('section_id',$request->section)->get();
            $sections= sections::all();
            return view('reports.customer_report', compact('start_date','end_date','sections','invoices'));
        }
    }
}
