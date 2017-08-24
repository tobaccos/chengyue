<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = 'pro_type';
    protected $primaryKey = 'id';
    protected $fillable = ['name','state','status','pic','clert'];
    //public $timestamps = true;
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
