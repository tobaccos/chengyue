<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    protected $table = 'activity';
    protected $primaryKey = 'id';
    protected $fillable = ['name','clert','state','type_id','com_attr','pic','content','thumbing','show_time','cue','com_id','min','max','number','rate'];
    //public $timestamps = true;
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
