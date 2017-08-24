<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['password','usertype','email','remember_token','state','phone','name','father_id','pay_pass'];
    //public $timestamps = true;
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
