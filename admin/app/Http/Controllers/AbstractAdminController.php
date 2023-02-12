<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbstractAdminController extends Controller
{
    protected $buttonSections = [];
    
    public function __construct()
    {        
        $this->middleware('auth');
        $this->initRoutes();
        $this->initButtons();
    }

    protected function initRoutes()
    {
        //
    }

    protected function initButtons()
    {
        //
    }

}
