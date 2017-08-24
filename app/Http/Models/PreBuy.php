<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PreBuy extends Model
{
    //
    protected $table = 'pre_buy';
    protected $primaryKey = 'id';
    protected $fillable = ['name','clert','state','type_id','com_attr','number','pic','content','thumbing','show_time','end_time','cue','com_id','min','max','rate'];
    //public $timestamps = true;
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
