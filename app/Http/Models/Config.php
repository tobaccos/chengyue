<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    //
    protected $table = 'config';
    protected $primaryKey = 'id';
    protected $fillable = ['webname','webemail','weburl','webkeywords',
        'webdescription','wname','wtel','wtel1','waddress','wcopyright',
        'wstatement','scale','intetestrate','wkey','qq_kf'];
    //public $timestamps = true;
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
