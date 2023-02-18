<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
  
    public function index()
    {
        $section = sections::all();
        return view('sections.sections' , compact('section'));
    }



   
    public function store(Request $request)
    {
       
        
        $request->validate([
            'section_name' => 'required|unique:sections|max:255',
            'description' => 'required',
        ],[
            'section_name.required'=>'الرجاء ادخال اسم القسم' ,
            'description.required'=>'الرجاء ادخال الملاحظات',
            'section_name.unique'=>'اسم القسم مدخل مسبقا'
        ]);
       sections::create
       ([
            'section_name'=>$request->section_name,
            'description'=>$request->description,
            'created_by'=>(Auth::user()->name)
       ]);

       session()->flash('Add','تمت الاضافه بنجاح');
       return redirect('/sections' );
    }

  
    public function show(sections $sections)
    {
        
    }

   
    public function edit($id)
    {
        
    }

   
    public function update(Request $request)
    {
        $id = $request->id;

        $this->validate($request, [

            'section_name' => 'required|max:255|unique:sections,section_name,'.$id,
            'description' => 'required',
        ],[

            'section_name.required' =>'يرجي ادخال اسم القسم',
            'section_name.unique' =>'اسم القسم مسجل مسبقا',
            'description.required' =>'يرجي ادخال البيان',

        ]);

        $sections = sections::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        session()->flash('edit','تم تعديل القسم بنجاج');
        return redirect('/sections');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        sections::findOrFail($id)->delete();
        session()->flash('delete','تم حذف الققسم بنجاح');
        return redirect('/sections');
    }
}
