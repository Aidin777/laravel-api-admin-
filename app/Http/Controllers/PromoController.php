<?php

namespace App\Http\Controllers;

use App\Models\Promos;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        return Promos::all();
    }

  
}
