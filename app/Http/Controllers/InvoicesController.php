<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Models\invoices;
use App\Models\sections;
use Illuminate\Http\Request;
use App\Models\invoices_details;
use Illuminate\Support\Facades\DB;
use App\Models\invoices_attachments;
use App\Models\User;
use App\Notifications\AddInvoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\Add_new_invoice;
class InvoicesController extends Controller
{
    
    public function index()
    {
        $invoices = invoices::all();
        
            return view('invoices.invoices' , compact ('invoices'));   
    }

    public function getproducts($id)
    {
        $products = DB::table('products')->where('section_id',$id)->pluck('product_name','id');
        return json_encode($products);
    }

    public function create()
    {
        $invoices = invoices::all();
        $sections= sections::all();

        return view('invoices.add', compact('invoices' , 'sections'));
    }

    public function store(Request $request)

    {
       
        invoices::create([
            'invoices_number'=>$request->invoices_number ,
            'invoice_date'=>$request->invoice_date ,
            'due_date'=>$request->due_date ,
            'product'=>$request->product ,
            'section_id'=>$request->section ,
            'amount_collection'=>$request->amount_collection ,
            'amount_commission'=>$request->amount_commission ,
            'discount'=>$request->discount ,
            'value_vat'=>$request->value_vat ,
            'rate_vat'=> $request->rate_vat ,
            'total'=> $request->total,
            'status'=>'غير مدفوعه',
            'value_status'=>2 ,
            'note'=>$request->note,
            
        ]);


        $invoices_id = invoices::latest()->first()->id ;

        invoices_details::create([
            'invoices_id'=>$invoices_id ,
            'invoices_number'=>$request->invoices_number ,
            'product'=>$request->product ,
            'section'=>$request->section ,
            'status'=>'غير مدفوعه',
            'value_status'=>2,
            'note'=>$request->note ,
            'user'=>(Auth::user()->name) ,
        ]);

        if($request->hasFile('pic'))
        {
            $invoices_id = invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            
            $invoice_number = $request->invoices_number;


            $attachment = new invoices_attachments();
            $attachment->file_name = $file_name;
            $attachment->invoices_number=$invoice_number;
            $attachment->created_by = Auth::user()->name;
            $attachment->invoices_id=$invoices_id;
            $attachment->save();

            //move file

            $imagaName =$request->pic->getClientOriginalName();
            $request->pic->move(public_path('attachments/'.$invoice_number),$imagaName);

        }

        // $user= User::first();

        // Notification::send($user ,new AddInvoice($invoices_id));

        $userSchema = User::first();
        $invoices_id= invoices::latest()->first()->id ;
        $offerData = [
            
            'body' => ':تمت اضافه فاتوره بواسطه',
            'user'=>Auth::user()->name,
            'thanks' => 'شكرا لك',
            'offerText' => 'الفاتوره المضافه',
            'offerUrl' => url(route('invoicesDetails',$invoices_id)),
            'offer_id' => $invoices_id,
        ];
  
        Notification::send($userSchema, new Add_new_invoice($offerData));
       

        
   

        session()->flash('Add','تم اضافه الفاتوره بنجاح');
        return back();
    }
    public function edit($id)
    {
        $invoices = invoices::where('id',$id)->first();
        $section= sections::all();
        return view('invoices.edit_invoice',compact('invoices','section'));

    }


    public function update(Request $request )
    {
        $invoices = invoices::findOrFail($request->invoice_id);
        $invoices->update([
            'invoices_number'=>$request->invoices_number ,
            'invoice_date'=>$request->invoice_date ,
            'due_date'=>$request->due_date ,
            'product'=>$request->product ,
            'section_id'=>$request->section ,
            'amount_collection'=>$request->amount_collection ,
            'amount_commission'=>$request->amount_commission ,
            'discount'=>$request->discount ,
            'value_vat'=>$request->value_vat ,
            'rate_vat'=> $request->rate_vat ,
            'total'=> $request->total,
            'status'=>$request->status ,
            'value_status'=>2 ,
            'note'=>$request->note,
            
        ]);

        session()->flash('Edit','تم التعديل بنجاح');

        return back();
    }

    public function status_show($id)
    {
        $invoices = invoices::where('id',$id)->first();
        $section= sections::all();

        $details = invoices_details::where('invoices_id',$id)->get();
        return view('invoices.update_status',compact('invoices','section','details'));
    }

    public function update_status(Request $request , $id)
    {
        $invoices=invoices::findOrFail($id);

       if($request->status==='مدفوعه'){

        $invoices->update([
            'value_status'=>1,
            'status' =>$request->status,
            'payment_date' => $request->payment_date,

        ]);
        

        $invoices_id = invoices::latest()->first()->id ;

        invoices_details::create([
            'invoices_id'=>$invoices_id ,
            'invoices_number'=>$request->invoices_number ,
            'product'=>$request->product ,
            'section'=>$request->section ,
            'status'=>$request->status,
            'value_status'=>1,
            'note'=>$request->note ,
            'user'=>(Auth::user()->name) ,
        ]);

        }
        elseif($request->status==='غير مدفوعه')
        {

            $invoices->update([
                'value_status'=>2,
                'status' =>$request->status,
                'payment_date' => $request->payment_date,
    
            ]);
        
           
            $invoices_id = invoices::latest()->first()->id ;
    
            invoices_details::create([
                'invoices_id'=>$invoices_id ,
                'invoices_number'=>$request->invoices_number ,
                'product'=>$request->product ,
                'section'=>$request->section ,
                'status'=>$request->status,
                'value_status'=>2,
                'note'=>$request->note ,
                'user'=>(Auth::user()->name) ,
            ]);
        }else
        {
            $invoices->update([
                'value_status'=>3,
                'status' =>$request->status,
                'payment_date' => $request->payment_date,
    
            ]);
        
           
            $invoices_id = invoices::latest()->first()->id ;
    
            invoices_details::create([
                'invoices_id'=>$invoices_id ,
                'invoices_number'=>$request->invoices_number ,
                'product'=>$request->product ,
                'section'=>$request->section ,
                'status'=>$request->status,
                'value_status'=>3,
                'note'=>$request->note ,
                'user'=>(Auth::user()->name) ,
            ]);
        }

        
        session()->flash('Edit','تم تعديل حاله الدفع بنجاح');

        return back();
    }
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoice = invoices::where('id',$id)->first();
        $details = invoices_attachments::where('invoices_id',$id)->first();

        $id_page =$request->id_page ;


        if(! $id_page==2){

            if(!empty($details->invoices_number))
            {
                Storage::disk('public_uploads')->deleteDirectory($details->invoices_number);
            }
    
            $invoice->forceDelete();
    
            session()->flash('delete_invoice');
    
            return redirect('/invoices');
    
        }else{

    
        $invoice->delete();

        session()->flash('delete_invoice');

        return redirect('/archive');

    }
    }


    public function InvoicesPaid()
    {
        $invoices_paid = invoices::where('value_status',1)->get();

        return view('invoices.invoices_paid',compact('invoices_paid'));
    }

    public function invoices_unpaid()
    {
        $invoices = invoices::where('value_status',2)->get();

        return view('invoices.invoices_unpaid',compact('invoices'));
    }

    public function invoices_partial()
    {
        $invoices = invoices::where('value_status',3)->get();

        return view('invoices.invoices_partial',compact('invoices'));
    }

    public function Print_Invoices($id)
    {
        $invoice= invoices::where('id',$id)->first();

        return view('invoices.Print_Invoices',compact('invoice'));
    }

    public function export() 
    {
        return Excel::download(new InvoicesExport, 'قائمه الفواتير.xlsx');
    }
    public function MarkAsRead()
    {
        
        $unreadNotification = auth()->user()->unreadNotifications ;
        if($unreadNotification)
        {
            $unreadNotification->markAsRead();
            return back();
        }
        
    }
}
