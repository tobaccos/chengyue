<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $table = 'ad';
    protected $primaryKey = 'id';
    protected $fillable = ['title','type','pic','url','state','position'];
    public function hasOneAccount()
    {
        return $this->hasOne('ad_position', 'id', 'position');
    }
    //public $timestamps = false;
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
