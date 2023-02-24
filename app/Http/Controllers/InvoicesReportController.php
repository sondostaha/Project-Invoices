<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\sections;
use Illuminate\Http\Request;

class InvoicesReportController extends Controller
{
    public function report_page()
    {
        return view('reports.invoices_report');
    }

    public function searchReport(Request $request)
    {
        $search = $request->search;

        

        if($search==1){

            //في حاله عدم تحديد التاريخ 

            if($request->type && $request->start_at=='' && $request->end_at ==''){
               
                $invoices = invoices::Select('*')->where('status',$request->type)->get();
                $type = $request->type;
                return view('reports.invoices_report', compact('type','invoices'));
            }
            else
            {
                $start_date = date($request->start_at);
                $end_date= date($request->end_at);
                $type = $request->type;
                $invoices = invoices::whereBetween('invoice_date',[$start_date,$end_date])->where('status',$request->type)->get();
                return view('reports.invoices_report',compact('type','start_date','end_date' ,'invoices'));
            }
        }
        else
        {
            $invoices = invoices::select('*')->where('invoice_date',$request->invoice_number)->get();
            return view('reports.invoices_report', compact('invoices'));
        }
    }
   
}
