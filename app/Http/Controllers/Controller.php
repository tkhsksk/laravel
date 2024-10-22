<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// controllerの作成
// php artisan make:controller ほにゃららController

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
