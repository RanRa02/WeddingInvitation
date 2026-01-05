<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class marriedController extends Controller
{
    public function index()
    {
        return view('wedding-invitation.index');
    }
}
