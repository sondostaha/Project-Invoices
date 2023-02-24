<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

  
    public function index()
    {


        $count_inv = invoices::count();
        $cound_invPaid = invoices::where('value_status',1)->count();
        $cound_inUnpaid= invoices::where('value_status',2)->count();
        $count_inPartial =  invoices::where('value_status',3)->count();

        
        $rount_inPaid = round($cound_invPaid / $count_inv *100); 
        $rount_inUnpaid = round($cound_inUnpaid / $count_inv *100); 
        $rount_inPartial = round($count_inPartial / $count_inv *100); 



        $chartjs = app()->chartjs
         ->name('barChartTest')
         ->type('bar')
         ->size(['width' => 300, 'height' => 200])
         ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
         ->datasets([
           
             [
                "label" => "الفواتير  المدفوعة",
                'backgroundColor' => ['#AACB73'],
                'data' => [$rount_inPaid]
            ],
            [
                "label" => "الفواتير الغير المدفوعة",
                'backgroundColor' => ['#F55050'],
                'data' => [$rount_inUnpaid]
            ],
            [
                "label" => "الفواتير المدفوعة جزئيا",
                'backgroundColor' => ['#FFB84C'],
                'data' => [$rount_inPartial]
            ],
         ])
         ->options([]);

         $chartjs2 = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['الفواتير المدفوعه', 'الفواتير غير مدفوعه','الفواتير المدفوعه جزئيا'])
        ->datasets([
            [
                'backgroundColor' => ['#AACB73', '#F55050','#FFB84C'],
                'hoverBackgroundColor' => ['#AACB73', '#F55050' ,'#FFB84C'],
                'data' => [$rount_inPaid, $rount_inUnpaid,$rount_inPartial]
            ]
        ])
        ->options([]);

        return view('home', compact('chartjs' ,'chartjs2'));
    }



}
