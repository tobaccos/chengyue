<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'product';
    protected $primaryKey = 'id';
    protected $fillable = ['name','clert','state','type_id','con_attr','pic','content','thumbing','show_time','cue','code','com_id','min','max','rate'];
    //public $timestamps = true;
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
