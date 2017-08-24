<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class OrderInfo extends Model
{
    //
    protected $table = 'orderinfo';
    //protected $primaryKey = 'id';
    protected $fillable = ['order_sn','address','email','shipping_name','shipping_code','shipping_time','comfirm_time','is_distribut','is_delete','ad_update'];
    public $timestamps = false;
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
