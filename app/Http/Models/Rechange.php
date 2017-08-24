<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Rechange extends Model
{
    //
    protected $table = 'rechange';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','money','pay_type','state','recharge_sn','created_at'];
    public $timestamps = false;
    /*public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }*/
}
