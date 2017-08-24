<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class AdPosition extends Model
{
    protected $table = 'ad_position';
    protected $primaryKey = 'id';
    protected $fillable = ['title','alias','state','desc'];
    //public $timestamps = false;
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
