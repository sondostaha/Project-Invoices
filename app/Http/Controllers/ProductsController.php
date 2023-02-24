<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    
    public function index()
    {
        $sections = sections::all();
        $products =products::all();
        return view('products.products' , compact('sections','products') );
    }

  
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $products = $request->all();

        $request->validate([
            'product_name' => 'required|unique:products|max:255',
            'description' => 'required',
            'section_id'=>'required'
        ],[
            'product_name.required'=>'الرجاء ادخال اسم المنتج' ,
            'description.required'=>'الرجاء ادخال الملاحظات',
            'section_id.required'=>'الرجاء تحديد القسم',
            'product_name.unique'=>'اسم المنتج مدخل مسبقا'
            
        ]);
        products::create
       ([
            'product_name'=>$request->product_name,
            'description'=>$request->description,
            'section_id'=>$request->section_id
       ]);

       session()->flash('Add','تم اضافه المنتج بنحاج');
       return redirect('/products');


    
    }
    

   
    public function show(products $products)
    {
        //
    }

    public function edit(products $products)
    {
        //
    }


    public function update(Request $request)
    {
        $id = sections::where('section_name','=',$request->section_name)->first()->id;
        
        $products = products::findOrFail($request->pro_id);

        $products->update([
            'product_name'=>$request->product_name,
            'description'=>$request->description,
            'section_id'=>$id
        ]);

        session()->flash('Edit','تم التعديل بنجاح');
        return redirect('/products');
    }

 
    public function destroy(Request $request)
    {
        $products = products::findOrFail($request->pro_id)->delete();
        session()->flash('Delete','تم الحذف بنجاح');
        return redirect('/products');
    }
}
