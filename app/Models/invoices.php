<?php

namespace App\Models;
use App\Models\invoices_attachments;
use App\Models\sections;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class invoices extends Model
{
    use SoftDeletes ;
    protected $guarded =[];

    public function section()
    {
        return $this->belongsTo('App\Models\sections');
    }


    
}
