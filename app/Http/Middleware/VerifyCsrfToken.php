<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Env;

class VerifyCsrfToken extends Middleware
{
    // protected $urlFron = env('APP_URL');

    protected $except = [];

    public function __construct(Application $app, Encrypter $encrypter)
    {
        parent::__construct($app, $encrypter);

        $this->except[] = "{$this->app->environment('APP_URL')}/api/*";
    }
}
