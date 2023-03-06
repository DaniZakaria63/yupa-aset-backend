<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AssetController extends BaseController
{
    public function index()
    {
        //
        return view('page/asset/index.php');
    }
}
