<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        # before more getting far, this project dont need auth, just use basic authorization header
        return view('page/dashboard/index.php');
    }
}
