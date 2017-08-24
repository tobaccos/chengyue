<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','phone', 'password','father_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 模型的数据字段的保存格式。
     *
     * @var string
     */
//    protected $dateFormat = 'U';

    const UPDATED_AT='updated_at';
    const CREATED_AT = 'created_at';

    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }

//    public function sendPasswordResetNotification($token)
//    {
//        $data = [ 'url' => url(config('app.url').route('login', $token))];
//        $template = "emails.test";
//        Mail::raw($template, function ($message){
//           $message->from('18931091134@163.com','Laravel test');
//           $message->to($this->email);
//        });
//    }
}
