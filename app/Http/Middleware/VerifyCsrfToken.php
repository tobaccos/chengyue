<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'admin/product/dels',
        'admin/activity/dels',
        'admin/recommend/dels',
        'admin/pre_buy/dels',
        'home/product/upload/{id}',
        'admin/pro_com/dels',
        'admin/pro_attr/dels',
        'alipay/notify',
        'home/shopping/cart_to_order',
    ];
}
