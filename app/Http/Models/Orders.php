<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    //
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = ['order_sn','order_fsn','pro_id','pro_attr',
        'thumbnailname','filename','user_id','order_status','pay_name','pro_price',
        'order_amount','pay_amount','addtime','user_note','dis_count','table_type','demand1','demand2'];
        
    public $timestamps = false;
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
