<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ProAttr extends Model
{
    //
    protected $table = 'pro_attr';
    protected $primaryKey = 'id';
    protected $fillable = ['name','clert','state','status'];
    //public $timestamps = true;
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
