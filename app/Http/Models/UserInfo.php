<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    //
    protected $table = 'user_info';
    protected $primaryKey = 'user_id';
    protected $fillable = ['QQ','virtualcurrency','alipay','dls_apply','join_address','vip_end_at','pic','rebate_amount','acc_amount','content','code'];
    public $timestamps = false;
    /*public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }*/
}
