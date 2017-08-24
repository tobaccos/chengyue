<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ProCombination extends Model
{
    //
    protected $table = 'pro_combination';
    protected $primaryKey = 'id';
    protected $fillable = ['name','clert','state','conbination'];
    //public $timestamps = true;
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
