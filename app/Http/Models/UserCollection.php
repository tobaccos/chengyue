<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UserCollection extends Model
{
    //
    protected $table = 'user_collection';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','pro_id'];
    //public $timestamps = true;
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
