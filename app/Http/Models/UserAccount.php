<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    //
    protected $table = 'user_account';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','money','bank_name','bank_num','remark','state','is_delete'];
    //public $timestamps = true;
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
